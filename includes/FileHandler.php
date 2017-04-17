<?php

// FileHandler class; uploads files to our /media directory.

class FileHandler {

  public $uploads_dir = BASEPATH.'media/';
  public $max_upload_size = 500000;

  public function upload($file, $filename){

    // $data will be returned after this function is done.
    // It either contains an error message, or the url of the uploaded file.
    $data = array(
      'errors' => null,
      'uploaded_file' => null
    );

    // Check if the file exists
    if(!empty($file)){
      // See validateImage(); returns true when succesfully validated.
      if($this->validateImage($file)){

        // Convert the filename to a URL friendly format:
        $filename = strtolower($filename);
        $filename = htmlentities($filename);
        $filename = str_replace(' ', '_', $filename);

        // Append (.=) the file extension to the filename
        $filename .= ".{$this->getFileType($file)}";

        if ($file['size'] > $this->max_upload_size) { // Check if the file exceeds the maximum upload size
          $data['errors'] = 'File size is too large.';
        } else {
          if (file_exists($filename)) {
            // If the file already exists in our uploads directory, display an error.
            $data['errors'] = 'The uploaded filename already exists.';
          } else {
            // Move the uploaded file (in $_FILES) to the actual uploads directory
            if(move_uploaded_file($file['tmp_name'], $this->uploads_dir.$filename)) {
              $data['uploaded_file'] = $filename; // Return the name of the uploaded file
            } else {
              // In this case, the server was unable to move the file.
              $data['errors'] = 'Uploading failed.';
            }
          }
        }
      } else {
        $data['errors'] = 'Please upload a valid image.';
      }
    } else {
      $data['errors'] = 'No file specified.';
    }
    return $data;
  }

  public function getFileName($file){
    // Get the filename: uploads directory + the 'basename' of the file (filename without leading directories)
    return $this->uploads_dir . basename($file['name']);
  }

  public function getFileType($file){
    // Get the extension of a file
    return pathinfo($this->getFileName($file), PATHINFO_EXTENSION);
  }

  public function validateImage($file){
    // Check if php is able to extract imagedata from the file; if it fails, the file couldn't be an image.
    if(getimagesize($file['tmp_name'])){

      $file_type = $this->getFileType($file);

      // Check if the extension matches any of our allowed filetypes.
      if($file_type == 'jpg' || $file_type == 'jpeg' || $file_type == 'png' || $file_type == 'gif'){
        return true;
      }
    } else {
      return false;
    }
  }

}
