<?php

class UserHandler {

  private $db;

  public function __construct($conn){

    // Start the session
    session_start();

    // Dependency injection: re-use a PDO database connection object instead of creating a new one
    $this->db = $conn;

  }

  public function getUsers(){

    // Get all users from the database

    $sth = $this->db->query('SELECT * from user');

    $users = $sth->fetchAll();

    return $users;

  }

  public function login($uname, $password){

    // The login function.
    // PDO's prepare function will set up a statement with placeholders.
    // Variables like ':username' is 'parameter binding': no user input will be directly inserted into the query.

    $sth = $this->db->prepare('SELECT user_id from user WHERE username = :username LIMIT 1');

    // PDO's execute function sends the actual user input to be inserted into the database
    // SQL injection is prevented: user input was not interpolated into the query, but simply assigned.

    $sth->execute(array(
      'username' => $uname
    ));

    // Get the resulting user_id from the query above

    $user = $sth->fetch();

    $userdata = $this->getUserData($user['user_id']);

    if (password_verify($password, $userdata['password'])) {

      // password_verify() takes the given password and compares it to the encrypted password in the database
      // If the password is verified, create a new User object and populate it with userdata
      // See User.php for more info.

      new User(array(
        'id'    => $userdata['user_id'],
        'uname' => $userdata['username'],
        'fname' => $userdata['firstname'],
        'lname' => $userdata['lastname'],
        'admin' => $userdata['is_admin']
      ));

      return 'Login sucessful.';
    }

    // Feedback for the user if their credentials do not match a user in the database.

    return 'Wrong username or password.';

  }

  public function logout(){

    unset($_SESSION['user']); // Unset or 'delete' the current user

    session_destroy(); // End the session

  }

  public function register($uname, $pass, $pass2, $fname, $lname){

    if($pass == $pass2) {

      // After checking if the passwords match, check if the username already exists in the databse.

      $sth = $this->db->prepare('SELECT user_id from user WHERE username = :username LIMIT 1');

      $sth->execute(array(
        'username' => $uname
      ));

      $user = $sth->fetch();

      // If no conflicting user has been found, continue with registering the new user.

      if(empty($user)) {

        // Generate a bcrypt password from the user input

        $pass = password_hash($pass, PASSWORD_BCRYPT);

        // Prepare the query

        $sth = $this->db->prepare("INSERT INTO user (user_id, username, password, firstname, lastname, is_admin)
          VALUES (NULL, :username, :pass, :fname, :lname, :admin)");

        // Bind values to the PDO statement handler ($sth)
        // Use htmlspecialchars to escape any html tags, to prevent users inserting malicous code.

        $sth->execute(array(
          'username' => htmlspecialchars($uname),
          'pass' => htmlspecialchars($pass),
          'fname' => htmlspecialchars($fname),
          'lname' => htmlspecialchars($lname),
          'admin' => 0
        ));

        return 'Your account has been created.';

      } else {
        return 'Username already exists.';
      }

    } else {
      return 'Passwords do not match.';
    }

  }

  public function toggleAdmin($user_id, $admin){

    if(isset($user_id) && isset($admin)) {

      $sth = $this->db->prepare("UPDATE user SET is_admin = :admin
        WHERE user_id = :user_id");

      // Bind parameters to be updated in the database

      $sth->bindValue('user_id', intval($user_id), PDO::PARAM_INT);
      $sth->bindValue('admin', intval(!$admin), PDO::PARAM_INT);
      $sth->execute();

      return 'User successfully updated.';

    }

  }

  public function getCount(){

    // Use the COUNT() function to get the number of users
    $result = $this->db->query("SELECT COUNT(*) as count FROM user")->fetch();

    return $result['count'];

  }

  public function getUserData($id){

    // Get user data for a specific user

    $sth = $this->db->prepare('SELECT * from user WHERE user_id = :user_id LIMIT 1');

    // Bind a given user_id to the statement handler

    $sth->execute(array(
      'user_id' => $id
    ));

    // PDO's fetch() function will return us a single result

    $userdata = $sth->fetch();

    return $userdata;

  }


  public function deleteUser($user_id){

    // Remove a category from the database based on its ID.
    // We have to bind :media_id in a special way, using PDO::PARAM_INT, so it doesn't get escaped with quotes like a string.

    $sth = $this->db->prepare("DELETE FROM user WHERE user_id = :user_id");

    $sth->bindValue('user_id', intval($user_id), PDO::PARAM_INT);
    $sth->execute();

    return 'User deleted.';

  }

  public function authRedirect($redirect, $admin = false) {

    if(isset($_SESSION['user'])){

      // Check if a user is logged in ($user is stored in $_SESSION)
      // If a user is not an admin and $admin == true (defaults to false), redirect to a given page

      if(!$_SESSION['user']->admin && $admin){

        header("Location: $redirect");

      }

    } else {

      // If the user is not logged in, redirect to a given page

      header("Location: $redirect");

    }
  }


}
