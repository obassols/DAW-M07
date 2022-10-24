<?php 
    session_start();
    if (!isset($_SESSION['user']) || !isset($_SESSION['time']) || $_SESSION['time'] - time() > 60) {
        header('Location: index.php');
    }
    /**
     * Llegeix les dades del fitxer. Si el document no existeix torna un array buit.
     *
     * @param string $file
     * @return array
     */
    function llegeix(string $file) : array
    {
        $var = [];
        if ( file_exists($file) ) {
            $var = json_decode(file_get_contents($file), true);
        }
        return $var;
    }

    /**
     * Llegeix les connexions del fitxer i retorna les de status 'correcte' o 'nou-usuari' que siguin del usuari.
     *
     * @param string $email - Email de l'usuari
     * @return array - Les connexions correctes de l'usuari
     */
    function getConnections(string $email): array {
        $connections = llegeix("./JSON/connections.json");
        $userConnections = array();
        foreach ($connections as $connection) {
            if ($connection['user'] == $email && ($connection['status'] == 'correcte' || $connection['status'] == 'nou-usuari')) {
                $userConnections[] = $connection;
            }
        }
        return $userConnections;
    }

    /**
     * Agafa les connexions de l'array i les pasa a un string HTML.
     *
     * @param array $userConnections - Totes les connexions que volem llistar
     * @return string - String amb les connexions com a HTML
     */
    function printConnections(array $userConnections): string {
        $connectionHtml = "";
        foreach ($userConnections as $connection) {
            $connectionHtml .= "Connexió des de " . $connection['ip'] . " amb data " . $connection['time'];
            $connectionHtml .= "<br>";
        }
        $connectionHtml .= "";
        return $connectionHtml;
    }

    if (!isset($_SESSION['user'])) {
        header('Location: index.php');
    } else {
        $user = $_SESSION['user'];
        $users = llegeix("./JSON/users.json");
        if (!isset($users[$user['email']]) || $users[$user['email']]['password'] !== $user['password']) {
            header('Location: index.php');
        } else  {
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <title>Benvingut</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">

</head>
<body>
<div class="container noheight" id="container">
    <div class="welcome-container">
        <h1>Benvingut!</h1>
        <div>Hola <?php echo $user['name'] ?>, les teves darreres connexions són:</div>
        <div class="connections">
        <?php
            $connections = getConnections($user['email']);
            echo printConnections($connections);
        ?>
        </div>
        <form action="process.php">
            <button>Tanca la sessió</button>
        </form>
    </div>
</div>
</body>
<?php }} ?>
</html>