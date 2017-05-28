<?php


class MediaHandler {

  private $db;
  private $filehandler;

  public function __construct($conn, $filehandler){

    // Dependency injection: re-use a PDO database connection object instead of creating a new one

    $this->db = $conn;
    $this->filehandler = $filehandler;

  }

  public function getMedia($order = null, $category = null){

    // This method gets all available media from the database.
    // Optionally, $this->queryMediaOrder() and $this->queryMediaCategory() can sort media based on a get parameter.
    // $order and $category are null by default and contain WHERE/ORDER BY clauses if set.

    if(!$order) { $order = $this->queryMediaOrder(); }
    if(!$category) { $category = $this->queryMediaCategory(); }

    // The PDO MySQL connection is stored in $this->db
    // $sth (Statement Handler) stores a PDOStatement object containing the query.
    // $args can be inserted without escaping, because we're not using actual user input for it.

    $sth = $this->db->query("SELECT media.*, category.* FROM media
      INNER JOIN category ON media.category_id = category.category_id WHERE $category $order");

    // Get all database rows based on the query and return the data

    return $sth->fetchAll();

  }

  public function getCount(){

    // Use the COUNT() function to get the number of media items
    $result = $this->db->query("SELECT COUNT(*) as count FROM media")->fetch();

    return $result['count'];

  }


  public function getMediaById($media_id){

    // Get a specific media item by it's id

    $sth = $this->db->prepare("SELECT * FROM media
      INNER JOIN category ON media.category_id = category.category_id
      WHERE media_id = :media_id LIMIT 1");

    $sth->execute(array(
      'media_id' => $media_id,
    ));

    return $sth->fetch();
  }


  public function searchMedia($query){

    // If the query is not an empty string, let the database run a query for it

    if(!empty($query)){

      $sth = $this->db->prepare("SELECT * FROM media
        INNER JOIN category ON media.category_id = category.category_id
        WHERE media_name LIKE :query");

      $sth->execute(array(
        'query' => "%$query%", // LIKE operator using %...%, matches any string with any character(s) before or after
      ));

      // Return the data from the database

      return $sth->fetchAll();

    } else {

      // Return false if no data has been found

      return false;

    }
  }


  public function queryMediaOrder(){

    // Optionally, we can order media based on a get parameter if it is set.
    // By default, order alphabetically (by media_name);

    $args = 'ORDER BY media.media_name';

    if(isset($_GET['media_orderby'])) {

      // The if-statements below could have used a switch operator; this code is a bit shorter, though.

      if($_GET['media_orderby'] == 'abc'){ $args = 'ORDER BY media.media_name'; }
      if($_GET['media_orderby'] == 'releasedate'){ $args = 'ORDER BY media.release_date'; }
    }

    return $args;

  }


  public function queryMediaCategory($operator = null){

    // Add a WHERE clause to the query for the media category.
    // $operator specifies what operator to use (ie. AND / OR)
    // By default, 'WHERE 1' will always be valid to insert into a query.

    $args = 1;

    if(isset($_GET['category_id'])) {
      $id = intVal($_GET['category_id']);
      $args = "media.category_id = $id";
    }

    return "$operator $args";

  }


  public function getUserMedia($user_id){

    // Get the order and category based on get parameters

    $order = $this->queryMediaOrder();
    $category = $this->queryMediaCategory('AND');

    // Get media of a specific user

    $sth = $this->db->prepare("SELECT media.*, category.* FROM media
      INNER JOIN user_media ON media.media_id = user_media.media_id
      INNER JOIN category ON media.category_id = category.category_id
      INNER JOIN user ON user.user_id = user_media.user_id
      WHERE user.user_id = :user_id $category $order");

    $sth->execute(array(
      'user_id' => $user_id,
    ));

    return $sth->fetchAll();
  }


  public function addUserMedia($user_id, $media_id){

    if(!empty($user_id) && !empty($media_id)) {

      // First check if the media has already been added to the account

      $sth = $this->db->query("SELECT * from user_media WHERE user_id = $user_id AND media_id = $media_id");

      $sth->bindValue('user_id', intval($user_id), PDO::PARAM_INT);
      $sth->bindValue('media_id', intval($media_id), PDO::PARAM_INT);

      $user_media = $sth->fetch();


      if(empty($user_media)) {

        // If no linked media has been found, we can continue:
        // Prepare a query using PDO's prepare function

        $sth = $this->db->prepare("INSERT INTO user_media (user_id, media_id)
          VALUES (:user_id, :media_id)");

        // Bind parameters to be inserted in to the database
        // Because we're using integers, we need to get the intVal() of the input and bind it using PDO::PARAM_INT

        $sth->bindValue('user_id', intval($user_id), PDO::PARAM_INT);
        $sth->bindValue('media_id', intval($media_id), PDO::PARAM_INT);
        $sth->execute();

        return "The media was added to your account.";

      } else {

        return "You have already added this media to your account.";

      }
    }

  }


  public function deleteUserMedia($user_id, $media_id){

    // Prepare a query using PDO's prepare function

    $sth = $this->db->prepare("DELETE FROM user_media WHERE user_id = :user_id AND media_id = :media_id");

    // Bind parameters to be inserted in to the database
    // Because we're using integers, we need to get the intVal() of the input and bind it using PDO::PARAM_INT

    $sth->bindValue('user_id', intval($user_id), PDO::PARAM_INT);
    $sth->bindValue('media_id', intval($media_id), PDO::PARAM_INT);
    $sth->execute();

    return "Media successfully removed from your account.";

  }


  public function createMedia($name, $description, $cover, $release, $category){

    // Check if the user has filled out all required fields

    if(!empty($name) && !empty($cover) && !empty($release) && !empty($category)) {

      // Shorthand if statement (ternary operarator), to quickly set values to NULL if they are actuall empty strings.
      // The operator works like this: (expression)? return if true : return if false;

      $description = empty($description)? null : $description;

      // Let the FileHandler class handle the cover upload.

      $upload = $this->filehandler->upload($cover, $name);

      // If the cover has been successfully uploaded, continue with inserting data.

      if(!empty($upload['uploaded_file'])){

        // Prepare a query using PDO's prepare function

        $sth = $this->db->prepare("INSERT INTO media (media_id, media_name, media_description, media_cover, release_date, category_id, media_created_at)
          VALUES (NULL, :media_name, :media_description, :media_cover, :release_date, :category_id, :media_created_at)");

        // Bind parameters to be inserted in to the database

        $sth->execute(array(
          'media_name' => htmlspecialchars($name), // Escape HTML tags with htmlspecialchars() to prevent XSS attacks
          'media_description' => htmlspecialchars($description),
          'media_cover' => $upload['uploaded_file'],
          'release_date' => $release,
          'category_id' => $category,
          'media_created_at' => date('Y-m-d')
        ));

        // Unset any posted data to clean up sticky forms
        unset($_POST);

        // The upload has been successful.

        return "'$name' was successfully created.";

      } else {
        // Return any errors to the user
        return $upload['errors'];
      }

    } else {
      return 'Please fill in all required fields.';
    }

  }

  public function updateMedia($media_id, $name, $description, $cover, $release, $category){

    // update media in the database based on its ID.
    // We have to bind :media_id in a special way, using PDO::PARAM_INT, so it doesn't get escaped with quotes like a string.

    // Check if the user has filled out all required fields

    if(!empty($media_id) && !empty($name) && !empty($cover) && !empty($release) && !empty($category)) {

      // Shorthand if statement (ternary operarator), to quickly set values to NULL if they are actuall empty strings.
      // The operator works like this: (expression)? return if true : return if false;

      $description = empty($description)? null : $description;

      // Let the FileHandler class handle the cover upload.

      $upload = $this->filehandler->upload($cover, $name);

      // If the cover has been successfully uploaded, continue with inserting data.

      if(!empty($upload['uploaded_file'])){

        // Prepare a query using PDO's prepare function

        $sth = $this->db->prepare("UPDATE media SET media_name = :media_name, media_description = :media_description, media_cover = :media_cover, release_date = :release_date, category_id = :category_id
          WHERE media_id = :media_id");

        // Bind parameters to be inserted in to the database

        $sth->execute(array(
          'media_id' => $media_id,
          'media_name' => htmlspecialchars($name), // Escape HTML tags with htmlspecialchars() to prevent XSS attacks
          'media_description' => htmlspecialchars($description),
          'media_cover' => $upload['uploaded_file'],
          'release_date' => $release,
          'category_id' => $category
        ));

        // The upload has been successful.

        return "'$name' was successfully updated.";

      } else {
        // Return any errors to the user
        return $upload['errors'];
      }

    } else {
      return 'Please fill in all required fields.';
    }

  }

  public function deleteMedia($media_id){

    // Remove media from the database based on its ID.
    // We have to bind :media_id in a special way, using PDO::PARAM_INT, so it doesn't get escaped with quotes like a string.

    $sth = $this->db->prepare("DELETE FROM media WHERE media_id = :media_id");

    $sth->bindValue('media_id', intval($media_id), PDO::PARAM_INT);
    $sth->execute();

    return 'Media deleted.';

  }

}
