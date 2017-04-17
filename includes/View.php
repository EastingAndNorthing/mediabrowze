<?php

/*  Simple View class to include php files dynamically.

    Usage:

    $view = new View;
    $view->set('views/user/table.php');

    $view = new View('views/user/table.php');
    $view->assign('foo', array(1,2,3));
    $view->render();

*/

class View {

  private $data = array(); // Stores any variables the view needs
  private $view; // Stores the php file to be included

  public function __construct($file = null){
    // Initialise the View constructor with no view, so we can set one later if we so desire.
    // In case $file is directly passed into the constructor, we can set() it immidiately.
    if($file){ $this->set($file); }
  }

  public function set($file){
    if(file_exists($file)) { // Checks if the php file actuall exists
      $this->view = BASEPATH.$file; // Set the view file, using an absolute reference to the base directory
    } else {
      echo "View '$file' not found!"; // Notify the user in case the view does not exist
    }
  }

  public function assign($variable, $value){
    // Assign a $value to a named $variable in the data array to be used in the view.
    $this->data[$variable] = $value;
  }

  public function render(){
    // Render a view to the page, but first check if the view is actually set
    if(!empty($this->view)){
      // Extract splits the associative array created by assign() into usable single variables
      extract($this->data);
      include($this->view); // Includes the view file.
    }
  }

}
