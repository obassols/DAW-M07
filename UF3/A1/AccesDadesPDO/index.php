<?php
  //connexió dins block try-catch:
  //  prova d'executar el contingut del try
  //  si falla executa el catch
  try {
    $hostname = "localhost";
    $dbname = "gringottsDB";
    $username = "u_gringot";
    $pw = "gringo";
    $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname","$username","$pw");
  } catch (PDOException $e) {
    echo "Failed to get DB handle: " . $e->getMessage() . "\n";
    exit;
  }
  
  //preparem la consulta
  $sql = "select goblin_name, password, last_login FROM goblins";
  
  //anem agafant les fileres d'amb una amb una
  foreach ($pdo->query($sql) as $row) {
    echo $row['goblin_name'] . " - " . $row['password'] . " - " . $row['last_login'] . "<br>";
  }

  //eliminem els objectes per alliberar memòria 
  unset($pdo); 
  unset($query)
 
?>