<?php
//Definim la classe Dog
class DatabaseController
{
  //CONSTANTS
  const HOST = 'localhost';
  const DATABASE = 'dwes_obassols_concurs_gossos';
  const USERNAME = 'dwes_user';
  const PASSWORD = 'dwes_pass';

  //PROPIETATS
  //private: només permet accedir-hi des de la pròpia classe
  private static $pdo;
  private static $instances = [];

  //Singletons no han de tenir constructor
  protected function __construct() { }
  //Singletons no s'han de poder clonar
  protected function __clone() { }
  //Singletons no es poden restaurar a partir de strings
  public function __wakeup()
  {
      throw new \Exception("Cannot unserialize a singleton.");
  }

  //Crea una instancia si no n'hi ha cap, sino retorna la instancia existent
  public static function getInstance(): DatabaseController
  {
      $cls = static::class;
      if (!isset(self::$instances[$cls])) {
        self::$instances[$cls] = new static();
        try {
          self::$pdo = new PDO("mysql:host=" . self::HOST . ";dbname=" . self::DATABASE, self::USERNAME, self::PASSWORD);
        } catch (PDOException $e) {
          echo "Failed to get DB handle: " . $e->getMessage() . "\n";
          exit;
        }
      }

      return self::$instances[$cls];
  }

  //MÈTODES
  public function getDogs() {
    try {
      $query = self::$pdo->prepare("SELECT * FROM dog");
      $query->execute();
      return $query->fetchAll();
    } catch (PDOException $e) {
      return $e;
    }
  }

  public function getFase()
  {
    try {
      $query = self::$pdo->prepare("SELECT * FROM fase");
      $query->execute();
      return $query->fetchAll();
    } catch (PDOException $e) {
      return $e;
    }
  }

  public function getActualFase($date)
  {
    try {
      $query = self::$pdo->prepare("SELECT * FROM fase WHERE dateStart < ? AND dateEnd > ?");
      $query->execute();
      return $query->fetchAll();
    } catch (PDOException $e) {
      return $e;
    }
  }

  public function loginUser($name, $password) {
    try {
      $query = self::$pdo->prepare("SELECT * FROM adminusers WHERE name = ? AND password = MD5(?)");
      $query->execute(array($name, $password));
      return $query->fetchAll();
    } catch (PDOException $e) {
      return $e;
    }
  }

  public function registerUser($name, $password) {
    try {
      $query = self::$pdo->prepare("INSERT INTO adminusers VALUES (?, MD5(?))");
      $query->execute(array($name, $password));
    } catch (PDOException $e) {
      return $e;
    }
  }

  public function saveFase($fase) {
    try {
      $query = self::$pdo->prepare("SELECT * FROM fase WHERE id = ?");
      $query->execute(array($fase['id']));
      return $query->fetchAll();
    } catch (PDOException $e) {
      return $e;
    }
  }

  public function addVote($vote) {
    try {
      $query = self::$pdo->prepare("INSERT INTO vote VALUES (?, ?, ?)");
      $query->execute(array($vote['idSession'], $vote['faseId'], $vote['idDog']));
    } catch (PDOException $e) {
      return $e;
    }
  }

  public function updateVote($vote) {
    try {
      $query = self::$pdo->prepare("UPDATE vote SET idDog = ? WHERE idSession = ? AND faseId = ?");
      $query->execute(array($vote['idDog'], $vote['idSession'], $vote['faseId']));
    } catch (PDOException $e) {
      return $e;
    }
  }
}
?>