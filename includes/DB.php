<?php

class DB {

  // Set up our database connection and options

  private $host = 'localhost';
  private $dbname = 'school_eindopdracht';
  private $dbuser = 'root';
  private $dbpass = 'root';
  private $options = array(
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Enable error handling
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Return associative arrays by default
  );

  public $conn;

  function __construct() {
    try {
      // Initialize PDO, connect to the database and set options
      // Save to $this->conn to be accessed by other classes
      $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname;charset=utf8", $this->dbuser, $this->dbpass, $this->options);
    }
    catch(PDOException $e) {
      // If the 'try' block above fails, display the PDO error and terminate the script.
      die($e->getMessage());
    }
  }
}
