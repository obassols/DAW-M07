<?php 
    function printLetters(): string {
        if (!isset($_SESSION['letters']) || !isset($_SESSION['date']) || $_SESSION['date'] != $_SESSION['last-date']) generateLetters();
        $letters_html = "";
        for($i = 0; $i < 7; $i++) {
            $letters_html .= '<li class="hex"><div class="hex-in"><a class="hex-link" data-lletra="' . $_SESSION['letters'][$i] . '" draggable="false" ';
            if($i == 3) $letters_html .= 'id="center-letter"';
            $letters_html .= '><p>' . $_SESSION['letters'][$i] . '</p></a></div>';
        }
        return $letters_html;
    }
    function generateLetters() {
        $alphabet = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
        if(!isset($_GET['data'])) {
            $_SESSION['date'] = floor(time() / (60*60*24));
        }
        $time = $_SESSION['date'];
        srand($_SESSION['date']);

        // Agafem totes les funcions i les reduim a les que tenen 7 lletres diferents com a màxim
        $allFunctions = get_defined_functions();
        $allFunctions = $allFunctions['internal'];
        $allFunctions = decreaseFunctions($allFunctions);

        $_SESSION['correct_answers'] = array();
        $_SESSION['all_answers'] = array();
        do {
            $_SESSION['letters'] = array();
            for($i = 0; $i < 7; $i++) {
                do {
                    $letter = $alphabet[rand(0,count($alphabet)-1)];
                } while(in_array($letter,$_SESSION['letters']));
                $_SESSION['letters'][] = $letter;
            }
        } while (checkMinimumFunctions(10, $allFunctions));
        $_SESSION['last-date'] = $_SESSION['date'];
        $_SESSION['all_answers'] = getAllAnswers();
    }

    function checkMinimumFunctions(int $num, array $allFunctions ): bool {
        $countFunctions = 0;
        $numAllFunctions = count($allFunctions);
        $letters = strtolower(implode($_SESSION['letters']));
        $regex = "/^[". $letters ."]*[" . $letters[3] . "]+[". $letters ."]*$/";
        $possible_answers = array();
        for($i = 0;$countFunctions < $num && $i < $numAllFunctions; $i++) {
            if(preg_match($regex ,$allFunctions[$i])) {
                $possible_answers[] = $allFunctions[$i];
                $countFunctions++;
            }
        }
        return $countFunctions < $num;
    }

    function decreaseFunctions(array $allFunctions) {
        $decreasedFunctions = array();
        for($i = 0; $i < count($allFunctions); $i++) {
            if(count(count_chars($allFunctions[$i], 1)) < 7) {
                $decreasedFunctions[] = $allFunctions[$i];
            }
        }
        return $decreasedFunctions;
    }

    function getCountAnswers() {
        if(isset($_SESSION['correct_answers'])) {
            return count($_SESSION['correct_answers']);
        } else {
            return 0;
        }
    }

    function getCorrectAnswers() {
        if(isset($_SESSION['correct_answers'])) {
            return implode(", ", $_SESSION['correct_answers']);
        } else {
            return "";
        }
    }

    function getAllAnswers() {
        $allFunctions = get_defined_functions();
        $allFunctions = $allFunctions['internal'];
        $allFunctions = decreaseFunctions($allFunctions);

        $letters = strtolower(implode($_SESSION['letters']));
        $regex = "/^[". $letters ."]*[" . $letters[3] . "]+[". $letters ."]*$/";

        foreach($allFunctions as $function) {
            if(preg_match($regex ,$function)) {
                $all_answers[] = $function;
            }
        }
        return $all_answers;
    }

    session_start();
    if (!isset($_SESSION['last-date'])) $_SESSION['last-date'] = floor(time() / (60*60*24));
    if($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (isset($_GET['data'])) {
            $date = strtotime($_GET['data']);
            $_SESSION['date'] = floor($date / (60*60*24));
        }
        if (isset($_GET['sol'])) {
            printLetters();
            $_SESSION['correct_answers'] = $_SESSION['all_answers'];
        }
        if(isset($_GET['neteja'])) {
            $_SESSION['correct_answers'] = array();
        }
        $_SESSION['url'] = $_SERVER['REQUEST_URI'];
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        //Processar les dades
        $_SESSION['test-word'] = strtolower($_POST['test-word']);
        header('Location: process.php');
    } else {
        //Pintar el formulari
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <title>PHPògic</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Juga al PHPògic.">
    <link href="//fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
<form action="" method="post" id="myform" name="myform">
    <div class="main">
        <h1>
            <a href=""><img src="logo.png" height="54" class="logo" alt="PHPlògic"></a>
        </h1>
        <div class="container-notifications">
            <p class="hide" id="message" style="<?php if(!isset($_SESSION['error_msg'])) echo "visibility: hidden" ?>"><?php if(isset($_SESSION['error_msg'])) echo $_SESSION['error_msg']; ?></p>
        </div>
        <div class="cursor-container">
            <p id="input-word"><span name="test-word" id="test-word"></span><span id="cursor">|</span></p>
            <input type="hidden" value="" name="test-word" id="test-word-input">
        </div>
        <div class="container-hexgrid">
            <ul id="hex-grid"> <?php echo printLetters(false) ?> 
            </ul>
        </div>
        <div class="button-container">
            <button id="delete-button" type="button" title="Suprimeix l'última lletra" onclick="suprimeix()"> Suprimeix</button>
            <button id="shuffle-button" type="button" class="icon" aria-label="Barreja les lletres" title="Barreja les lletres">
                <svg width="16" aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 512 512">
                    <path fill="currentColor"
                        d="M370.72 133.28C339.458 104.008 298.888 87.962 255.848 88c-77.458.068-144.328 53.178-162.791 126.85-1.344 5.363-6.122 9.15-11.651 9.15H24.103c-7.498 0-13.194-6.807-11.807-14.176C33.933 94.924 134.813 8 256 8c66.448 0 126.791 26.136 171.315 68.685L463.03 40.97C478.149 25.851 504 36.559 504 57.941V192c0 13.255-10.745 24-24 24H345.941c-21.382 0-32.09-25.851-16.971-40.971l41.75-41.749zM32 296h134.059c21.382 0 32.09 25.851 16.971 40.971l-41.75 41.75c31.262 29.273 71.835 45.319 114.876 45.28 77.418-.07 144.315-53.144 162.787-126.849 1.344-5.363 6.122-9.15 11.651-9.15h57.304c7.498 0 13.194 6.807 11.807 14.176C478.067 417.076 377.187 504 256 504c-66.448 0-126.791-26.136-171.315-68.685L48.97 471.03C33.851 486.149 8 475.441 8 454.059V320c0-13.255 10.745-24 24-24z"></path>
                </svg>
            </button>
            <button id="submit-button" type="submit" title="Introdueix la paraula">Introdueix</button>
        </div>
        <div class="scoreboard">
            <div>Has trobat 
                <span id="letters-found"><?php echo getCountAnswers() ?></span>
                <span id="found-suffix"><?php if(getCountAnswers() == 1) { echo "funcio"; } else { echo "functions"; } ?></span>
                <span id="discovered-text">. <?php echo getCorrectAnswers() ?></span>
            </div>
            <div id="score"></div>
            <div id="level"></div>
        </div>
    </div>
</form>
<?php
    }
    unset($_SESSION['error_msg']);
?>
<script>
    
    function amagaError(){
        if(document.getElementById("message"))
            document.getElementById("message").style.opacity = "0"
    }
    function afegeixLletra(lletra){
        document.getElementById("test-word").innerHTML += lletra;
        document.getElementById("test-word-input").value += lletra;
    }
    function suprimeix(){
        element = document.getElementById("test-word");
        element.innerHTML = element.innerHTML.slice(0, -1);

        element = document.getElementById("test-word-input");
        element.value = element.value.slice(0, -1);
    }
    window.onload = () => {
        // Afegeix funcionalitat al click de les lletres
        Array.from(document.getElementsByClassName("hex-link")).forEach((el) => {
            el.onclick = ()=>{afegeixLletra(el.getAttribute("data-lletra"))}
        });
        setTimeout(amagaError, 2000);
        //Anima el cursor
        let estat_cursor = true;
        setInterval(()=>{
            document.getElementById("cursor").style.opacity = estat_cursor ? "1": "0";
            estat_cursor = !estat_cursor;
        }, 500)
    }
</script>
</body>
</html>