<?php
//Definim la classe Fase
class Fase
{
  //PROPIETATS
  //private: només permet accedir-hi des de la pròpia classe
  private $id;
  private $dateStart;
  private $dateEnd;

  //CONSTRUCTOR: s'executa quan es crea l'objecte
  public function __construct($id, $dateStart, $dateEnd)
  {
    $this->id = $id;
    $this->dateStart = $dateStart;
    $this->dateEnd = $dateEnd;
  }

  //MÈTODES
  public function getId()
  {
    return $this->id;
  }
  public function getDateStart()
  {
    return $this->dateStart;
  }
  public function getDateEnd()
  {
    return $this->dateEnd;
  }
  public function saveFase()
  {
    require_once('./Classes/DatabaseController.php');
    $pdo = DatabaseController::getInstance();
    return $pdo->saveFase($this);
  }
}
?>