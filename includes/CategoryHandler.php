<?php


class CategoryHandler {

  private $db;

  public function __construct($conn){

    // Dependency injection: re-use a PDO database connection object instead of creating a new one

    $this->db = $conn;

  }

  public function getCategories(){

    // Get all available media from the database.
    // The PDO MySQL connection is stored in $this->db
    // $sth (Statement Handler) stores a PDOStatement object containing the query.

    $sth = $this->db->query("SELECT * FROM category");

    // Get all database rows based on the query and return the data

    return $sth->fetchAll();

  }


  public function getCount(){

    // Use the COUNT() function to get the number of users
    $result = $this->db->query("SELECT COUNT(*) as count FROM category")->fetch();

    return $result['count'];

  }


  public function createCategory($name, $color){

    // Check if the user has filled out all required fields

    if(!empty($name) && !empty($color)) {

      // $color will be sent as a hexadecimal number, with a '#' before it. (browser specific)
      // The database only stores the actual value, without it.
      // If the '#' does exists, preg_replace will use a simple regular expression to remove it.

      $color = preg_replace('/#/', '', $color);

      // Prepare a query using PDO's prepare function

      $sth = $this->db->prepare("INSERT INTO category (category_id, category_name, category_color)
        VALUES (NULL, :category_name, :category_color)");

      // Bind parameters to be inserted in to the database

      $sth->execute(array(
        'category_name' => htmlspecialchars($name), // Escape HTML tags to prevent XSS attacks
        'category_color' => $color,
      ));

      return "'$name' was successfully created.";

    }
  }

  public function updateMedia($media_id, $values){

    $sth = $this->db->prepare("UPDATE media SET media_name = 'updated' WHERE media_id = :media_id");
    $sth->bindValue('media_id', intval($media_id), PDO::PARAM_INT);
    $sth->execute();

  }

  public function deleteCategory($category_id){

    // Remove a category from the database based on its ID.
    // We have to bind :media_id in a special way, using PDO::PARAM_INT, so it doesn't get escaped with quotes like a string.

    $sth = $this->db->prepare("DELETE FROM category WHERE category_id = :category_id");

    $sth->bindValue('category_id', intval($category_id), PDO::PARAM_INT);
    $sth->execute();

    return 'Category deleted.';

  }

}
