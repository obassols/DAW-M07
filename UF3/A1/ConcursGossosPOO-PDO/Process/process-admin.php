<?php
session_start();
// Mira si és un post provinent de admin.php o tanca la sessio
if (!isset($_SESSION['user']) || !isset($_POST['method'])) {
  unset($_SESSION['user']);
  header('Location: ../index.php');
} else {
  require_once('../Classes/AdminUser.php');
  if ($_POST['method'] == 'register') {
    $user = unserialize($_SESSION['user']);
    $result = $user->register($_POST['username'], $_POST['password']);
    if (get_class($result) == 'PDOException') {
      $result = $result->errorInfo;
      $_SESSION['errorMsg'] = $result[2];
    }
    header('Location: ../admin.php');
  }
}
?>