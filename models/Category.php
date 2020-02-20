<?php

class Category {
  // DB Stuff
  private $conn;
  private $table = 'categories';

  // Post properties
  public $id;
  public $name;
  public $created_at;

  // Constructor with DB
  public function __construct($db) {
    $this->conn = $db;
  }

  // Get Categories
  public function read() {
    $query = 'SELECT
              *
              FROM '.$this->table.'
              ORDER BY
                created_at DESC';

    $stmt = $this->conn->prepare($query);

    $stmt->execute();

    return $stmt;
  }

  // Get single category
  public function read_single() {
    $query = 'SELECT
              *
              FROM '.$this->table.'
              WHERE
                id = ?
              LIMIT 0,1';
    
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->id);
    $stmt->execute();
    
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $this->name = $row['name'];
    $this->created_at = $row['created_at'];
  }

  // Create categories
  public function create() {
    $query = 'INSERT INTO ' .$this->table. '
              SET
                name = :name
    ';

    $stmt = $this->conn->prepare($query);

    $this->name = htmlspecialchars(strip_tags($this->name));

    $stmt->bindParam(':name', $this->name);

    if ($stmt->execute()){
      return true;
    }

    printf("Error: %s.\n", $stmt->error);

    return false;
  }

  // Update categories

  // Delete categories


}