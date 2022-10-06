<!DOCTYPE html>
<html lang="ca">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>Calculadora</title>
</head>
<?php $result = 0; ?>
<body>
    <div class="container">
        <form action="" method="post" name="calc" class="calculator">
            <input type="text" name ="total_value" class="value" readonly value="<?php echo showCalc() ?>" />
            <span class="num"><input name ="value" type ="submit" value="("></span>
            <span class="num"><input name ="value" type ="submit" value=")"></span>
            <span class="num"><input name ="value" type ="submit" value="SIN"></span>
            <span class="num"><input name ="value" type ="submit" value="COS"></span>
            <span class="num clear"><input name ="value" type ="submit" value="C"></span>
            <span class="num"><input name ="value" type ="submit" value="/"></span>
            <span class="num"><input name ="value" type ="submit" value="*"></span>
            <span class="num"><input name ="value" type ="submit" value="7"></span>
            <span class="num"><input name ="value" type ="submit" value="8"></span>
            <span class="num"><input name ="value" type ="submit" value="9"></span>
            <span class="num"><input name ="value" type ="submit" value="-"></span>
            <span class="num"><input name ="value" type ="submit" value="4"></span>
            <span class="num"><input name ="value" type ="submit" value="5"></span>
            <span class="num"><input name ="value" type ="submit" value="6"></span>
            <span class="num plus"><input name ="value" type ="submit" value="+"></span>
            <span class="num"><input name ="value" type ="submit" value="1"></span>
            <span class="num"><input name ="value" type ="submit" value="2"></span>
            <span class="num"><input name ="value" type ="submit" value="3"></span>
            <span class="num"><input name ="value" type ="submit" value="0"></span>
            <span class="num"><input name ="value" type ="submit" value="00"></span>
            <span class="num"><input name ="value" type ="submit" value="."></span>
            <span class="num equal"><input name ="value" type ="submit" value="="></span>
            <input type="hidden" name="result" value="<?php echo $result ?>">
        </form>
    </div>
    <?php
    /**
     * Agafa l'input que has fet submit, calcula el que ha de fer i et retorna el resultat.
     * @author Oriol_Bassols
     * @return string Retorna un string amb numeros, operacions, ERROR o INF.
     */
    function showCalc() {
        global $result;
        if(isset($_POST["value"]) && isset($_POST["total_value"])) {
            if ($_POST["value"] == 'C') {
                $answer = "";
            } elseif ($_POST["value"] == 'SIN' || $_POST["value"] == "COS") {
                $answer = $_POST["value"] . "(" . $_POST["total_value"] . ")";
            } elseif ($_POST["value"] == '=') {
                $operation = $_POST['total_value'];
                $regex = "/^[0-9()+\-\*(SIN)(COS)\.\/]+$/";
                if (preg_match($regex,$operation)) {
                    try {
                        eval("\$answer = $operation;");
                        $answer = round($answer, 4);
                        $result = 1;
                    } catch (DivisionByZeroError $e) {
                        $answer = "INF";
                    } catch (Error $e) {
                        $answer = "ERROR";
                    }
                } else {
                    $answer = "ERROR";
                }
            } else {
                if ($_POST["result"] == 1) {
                    $answer = $_POST["value"];
                    $result = 0;
                } else {
                    $answer = $_POST["total_value"] . $_POST["value"];
                }
            }
        } else {
            $answer = "";
        }
        return $answer;
    }
    ?>
</body>