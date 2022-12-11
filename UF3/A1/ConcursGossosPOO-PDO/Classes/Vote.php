<?php
//Definim la classe Vote
class Vote
{
  //PROPIETATS
  //private: només permet accedir-hi des de la pròpia classe
  private $idSession;
  private $faseId;
  private $idDog;

  //CONSTRUCTOR: s'executa quan es crea l'objecte
  public function __construct($idSession, $faseId, $idDog)
  {
    $this->idSession = $idSession;
    $this->faseId = $faseId;
    $this->idDog = $idDog;
  }

  //MÈTODES
  public function addVote()
  {
    require_once('./Classes/DatabaseController.php');
    $pdo = DatabaseController::getInstance();
    return $pdo->addVote($this);
  }
  
  public function updateVote()
  {
    require_once('./Classes/DatabaseController.php');
    $pdo = DatabaseController::getInstance();
    return $pdo->updateVote($this);
  }
}
?>