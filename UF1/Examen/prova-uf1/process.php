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
                $users = llegeix("./JSON/users.json");
                // Comprova que l'usuari existeixi
                if (!isset($users[$_POST['email']])) {
                    // Crea l'usuari i l'escriu al fitxer "users.json"
                    $user['email'] = $_POST['email'];
                    $user['password'] = $_POST['password'];
                    $user['name'] = $_POST['name'];
                    $users[$user['email']] = $user;
                    escriu($users, "./JSON/users.json");

                    // Posa l'usuari i el temps a la sessio
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
            $users = llegeix("./JSON/users.json");
            // Comprova que l'usuari existeixi i que tingui la mateixa contrasenya
            if (isset($users[$_POST['email']]) && $users[$_POST['email']]['password'] == $_POST['password']) {
                $_SESSION['user'] = $users[$_POST['email']];
                $_SESSION['time'] = time();
                createConnection($_POST['email'], "correcte");
                header('Location: hola.php');
            } else {
                if (isset($users[$_POST['email']])) {
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
        $connections = llegeix("./JSON/connections.json");
        $connections[] = $connection;
        escriu($connections, "./JSON/connections.json");
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
     * Guarda les dades a un fitxer
     *
     * @param array $dades
     * @param string $file
     */
    function escriu(array $dades, string $file): void
    {
        file_put_contents($file,json_encode($dades, JSON_PRETTY_PRINT));
    }
?>