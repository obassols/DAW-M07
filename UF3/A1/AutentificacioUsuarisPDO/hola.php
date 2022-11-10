<?php 
    session_start();
    if (!isset($_SESSION['user']) || !isset($_SESSION['time']) || $_SESSION['time'] - time() > 60) {
        header('Location: index.php');
    }

    /**
     * Llegeix les dades de la base de dades. Si la taula no existeix torna un array buit.
     *
     * @param string $table
     * @return array
     */
    function llegeix(string $table) : array
    {
        try {
            $hostname = "localhost";
            $dbname = "dwes_obassols_autpdo";
            $username = "dwes_user";
            $pw = "dwes_pass";
            $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname","$username","$pw");
        } catch (PDOException $e) {
            echo "Failed to get DB handle: " . $e->getMessage() . "\n";
            exit;
        }
        $query = $pdo->prepare("select * FROM $table");
        $query->execute();

        return $query->fetchAll();
    }

    /**
     * Llegeix les connexions del fitxer i retorna les de status 'correcte' o 'nou-usuari' que siguin del usuari.
     *
     * @param string $email - Email de l'usuari
     * @return array - Les connexions correctes de l'usuari
     */
    function getConnections(string $email): array {
        $connections = llegeix("connections");
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
        $users = llegeix("users");
        if (!in_array( $user['email'], array_column($users, "email")) ||
                !in_array(md5($user['password']), array_column($users, "password"))) {
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