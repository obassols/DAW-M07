<?php
    session_start();
    if (isset($_GET['data'])) {
        $date = $_GET['data'];
    } else {
        $date = date('Y-m-d h:i:s', time());
    }
    require_once('./Classes/DatabaseController.php');
    $pdo = DatabaseController::getInstance();
    $actualFase = $pdo->getActualFase($date);
    if (get_class($actualFase) != 'PDOException') {
        if (!isset($_SESSION['fase']) || $actualFase['id'] != $_SESSION['fase']) {
            unset($_SESSION['vote']);
            $_SESSION['fase'] = $actualFase['id'];
        }
    }
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votació popular Concurs Internacional de Gossos d'Atura 2023</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="wrapper">
    <header>Votació popular del Concurs Internacional de Gossos d'Atura 2023- FASE <span> 1 </span></header>
    <p class="info"> Podeu votar fins el dia 01/02/2023</p>

    <?php if (isset($_SESSION['vote'])) {
        echo '<p class="warning"> Ja has votat al gos ' . $_SESSION['vote'] . '. Es modificarà la teva resposta</p>';
    }?>
    <div class="poll-area">
        <form id="voteFrom" action="./Process/process-vote.php" method="post">
            <?php
                require_once('./Classes/Viewer.php');
                echo printDogsInput()
            ?>
        </form>
    </div>

    <p> Mostra els <a href="resultats.php">resultats</a> de les fases anteriors.</p>
</div>

</body>
</html>