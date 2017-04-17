<?php

// Refer to these global variables, set in loader.php

global $userhandler;
global $mediahandler;
global $categoryhandler;

// Get all numbers

$num_users = $userhandler->getCount();
$num_media = $mediahandler->getCount();
$num_categories = $categoryhandler->getCount();

echo "<h2>Stats</h2>";
echo "<p>We currently have $num_users users, $num_media media items and $num_categories categories.</p>";
