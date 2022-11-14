<?php
    session_start();
    // Mira si és un post provinent de index.php o tanca la sessio
    if (!isset($_POST['method'])) {
        unset($_SESSION['user']);
        unset($_SESSION['time']);
        header('Location: index.php');
    } else {
        // Mira si s'està registrant
        if ($_POST['method'] == 'signup') {
            // Comprova si tots els inputs tenen algun valor
            if (isset($_POST['name']) && isset($_POST['password']) && isset($_POST['email'])) {
                $users = llegeix("users");
                // Comprova que l'usuari existeixi
                if (!in_array( $_POST['email'], array_column($users, "email"))) {
                    // Crea l'usuari i l'escriu al fitxer "users.json"
                    $user['email'] = $_POST['email'];
                    $user['password'] = $_POST['password'];
                    $user['name'] = $_POST['name'];
                    $newUsers = array();
                    $newUsers[] = $user;
                    escriu($newUsers, "users");

                    // Posa l'usuari i el temps a la sessio
                    $user['password'] = md5($user['password']);
                    $_SESSION['user'] = $user;
                    $_SESSION['time'] = time();

                    createConnection($user['email'], "nou-usuari");
                    header('Location: hola.php');
                } else {
                    createConnection($_POST['email'], "creació-fallida");
                    header('Location: index.php');
                }
            } else {
                createConnection($_POST['email'], "creació-fallida");
                header('Location: index.php');
            }
        // Comporva si està fent un inici de sessio
        } else if ($_POST['method'] == 'signin') {
            $users = llegeix("users");
            // Comprova que l'usuari existeixi i que tingui la mateixa contrasenya
            if (in_array( $_POST['email'], array_column($users, "email")) && 
                in_array(md5($_POST['password']), array_column($users, "password"))) {
                $_SESSION['user'] = $users[array_search($_POST['email'], array_column($users, "email"))];
                $_SESSION['time'] = time();
                createConnection($_POST['email'], "correcte");
                header('Location: hola.php');
            } else {
                if (in_array( $_POST['email'], array_column($users, "email"))) {
                    createConnection($_POST['email'], "contrasenya-incorrecte");
                } else {
                    createConnection($_POST['email'], "usuari-incorrecte");
                }
                header('Location: index.php');
            }
        // Per si algú canvia el valor del input hidden
        } else {
            header('Location: index.php');
        }
    }

    /**
     * Afegeix al fitxer 'connections.json' una connexio amb
     * el temps actual, la ip del client, l'email passat per paàmetre
     * i l'status.
     *
     * @param string $email
     * @param string $status
     */
    function createConnection(string $email, string $status) {
        $connection['ip'] = $_SERVER['REMOTE_ADDR'];
        $connection['user'] = $email;
        $connection['time'] = date("Y-m-d h:i:s");
        $connection['status'] = $status;
        $connections = array();
        $connections[] = $connection;
        escriu($connections, "connections");
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
            $dbname = "dwes-obassols-autpdo";
            $username = "dwes-user";
            $pw = "dwes-pass";
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
     * Guarda les dades a la taula de la base de ades
     *
     * @param array $dades
     * @param string $table
     */
    function escriu(array $dades, string $table): void
    {
        try {
            $hostname = "localhost";
            $dbname = "dwes-obassols-autpdo";
            $username = "dwes-user";
            $pw = "dwes-pass";
            $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname","$username","$pw");
        } catch (PDOException $e) {
            echo "Failed to get DB handle: " . $e->getMessage() . "\n";
            exit;
        }

        try {
            if ($table == "users") {
                $query = $pdo->prepare("INSERT INTO $table ( email, password, name) VALUES (:email,MD5(:password),:name)");
                foreach ($dades as $row) {
                    $query->execute($row);
                }
            } else if ($table == "connections") {
                $query = $pdo->prepare("INSERT INTO $table ( ip, user, time, status) VALUES (:ip,:user,:time,:status)");
                foreach ($dades as $row) {
                    $query->execute($row);
                }
            }
        } catch(PDOExecption $e) { 
            print "Error!: " . $e->getMessage() . " Desfem</br>"; 
        }
    }
?>