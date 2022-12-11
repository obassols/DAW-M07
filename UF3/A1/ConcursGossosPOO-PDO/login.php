<?php
  session_start();
  if (isset($_SESSION['user'])) {
    header('Location: admin.php');
  }
?>

<!DOCTYPE html>
<html lang="ca">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Votació popular Concurs Internacional de Gossos d'Atura 2023</title>
  <link rel="stylesheet" href="loginStyle.css">
</head>

<body>
    <div class="modal">
      <form class="modal-content" action="./Process/process-login.php" method="post">
        <input type="hidden" name="method" value="login" />
        <div class="container">
          <label for="username"><b>Username</b></label>
          <input type="text" placeholder="Enter Username" name="username" required>
    
          <label for="password"><b>Password</b></label>
          <input type="password" placeholder="Enter Password" name="password" required>
    
          <button type="submit">Login</button>
        </div>
      </form>
    </div>
</body>
</html>