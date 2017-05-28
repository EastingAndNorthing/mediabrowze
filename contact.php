<?php

$currentpage = 'contact';

require_once('loader.php');
require_once('views/header.php');

// If the form is submitted, let $contacthandler->sendMail() handle the form.
// The function returns a message to indicate success or faillure.
if(isset($_POST['contact_submit'])) {
  $contact_msg = $contacthandler->sendMail($_POST['contact_email'], $_POST['contact_subject'], $_POST['contact_message']);
}


?>

<div class="max width">
  <h1>Contact</h1>
  <form action="" method="post">
    <input name="contact_email" type="email" placeholder="E-mail">
    <input name="contact_subject" type="text" placeholder="Subject">
    <textarea name="contact_message" rows="6" placeholder="Your message"></textarea>
    <input type="submit" name="contact_submit" value="Send">
  </form>
  <br>
  <?php
    // If there are any errors, print them so the user can see what went wrong.
    if(isset($contact_msg)){ echo $contact_msg; }
  ?>
</div>


<?php

require_once('views/footer.php');
