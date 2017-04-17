<?php

global $categoryhandler; // Refer to this global variable, set in loader.php

$categories = $categoryhandler->getCategories();

// Get the current URL and remove any get parameters by 'exploding' the url after '?'.
// The first index of the returned array contains the base url (ie. admin.php / user.php)

$url = explode('?', $_SERVER['REQUEST_URI']);
$base_url = $url[0];

// Create a dropdown for all the categories in the database.
// By default the dropdown contains categories and their ID's as values.
// It's also possible to create a dropdown with direct links ($directlink), which sets a get url parameter when an option is clicked.

if(isset($directlink)): ?>

  <label for="category_id">Category: </label>
  <select id="category-select" onclick="location = this.value;">
    <option value="<?php echo $base_url; ?>">Alles</option>
    <?php foreach($categories as $category): ?>
      <option value="<?php echo $base_url.'?category_id='.$category['category_id']; ?>"><?php echo $category['category_name']; ?></option>
    <?php endforeach; ?>
  </select>

<?php else: ?>

  <label for="category_id">Category: </label>
  <select id="category-select" name="category_id">
    <?php foreach($categories as $category): ?>
      <option value="<?php echo $category['category_id']; ?>"><?php echo $category['category_name']; ?></option>
    <?php endforeach; ?>
  </select>

<?php endif; ?>
