<?php
  //Definim la classe Dog
  class Dog {
    //PROPIETATS
    //private: només permet accedir-hi des de la pròpia classe
    private $name;
    private $image;
    private $owner;
    private $breed;
    
    //CONSTRUCTOR: s'executa quan es crea l'objecte
    public function __construct($name, $image, $owner, $breed)
    {
        $this->name = $name;
        $this->image = $image;
        $this->owner = $owner;
        $this->breed = $breed;
    }
    
    //MÈTODES
    public function getName()
    {
      return $this->name;
    }
    public function getImage()
    {
      return $this->image;
    }
    public function getOwner()
    {
      return $this->owner;
    }
    public static function getDatabaseDogs()
    {
      require_once('./Classes/DatabaseController.php');
      $pdo = DatabaseController::getInstance();
      return $pdo->getDogs();
    }
  }
?>