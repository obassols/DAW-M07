<?php
//Definim la classe AdminUser
class AdminUser
{
  //PROPIETATS
  //private: només permet accedir-hi des de la pròpia classe
  private $name;
  private $password;

  //CONSTRUCTOR: s'executa quan es crea l'objecte
  public function __construct($name, $password)
  {
    $this->name = $name;
    $this->password = $password;
  }

  //MÈTODES
  public function getName()
  {
    return $this->name;
  }
  public function getPassword()
  {
    return $this->password;
  }
  public function login()
  {
    require_once('DatabaseController.php');
    $pdo = DatabaseController::getInstance();
    return $pdo->loginUser($this->name, $this->password);
  }
  public function register($name, $password)
  {
    require_once('DatabaseController.php');
    $pdo = DatabaseController::getInstance();
    return $pdo->registerUser($name, $password);
  }
}
?>