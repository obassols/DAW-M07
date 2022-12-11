<?php
session_start();
// Mira si és un post provinent de admin.php o tanca la sessio
if (!isset($_POST['method'])) {
  unset($_SESSION['user']);
  header('Location: ../index.php');
} else {
  if ($_POST['method'] == 'logoff') {
    unset($_SESSION['user']);
    header('Location: ../login.php');
  } else if ($_POST['method'] == 'login') {
    require_once('../Classes/AdminUser.php');
    $user = new AdminUser($_POST['username'], $_POST['password']);
    if (count($user->login()) > 0) {
      $_SESSION['user'] = serialize($user);
      header('Location: ../admin.php');
    } else {
      header('Location: ../login.php');
    }
  }
}
?>