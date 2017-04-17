<?php

class User {

  public $id;
  public $uname;
  public $fname;
  public $lname;
  public $admin = 0;

  public function __construct($userdata){
    // When creating a new object, this method is auto-invoked.
    $this->id         = $userdata['id'];
    $this->uname      = $userdata['uname'];
    $this->fname      = $userdata['fname'];
    $this->lname      = $userdata['lname'];
    $this->admin      = $userdata['admin'];

    // Assign this user object to our $_SESSION to access it on all pages.
    $_SESSION['user'] = $this;
  }

}
