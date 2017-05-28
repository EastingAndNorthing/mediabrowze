<!doctype html>
<html lang="nl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="css/main.css">

  <title>Eindopdracht PHP / SQL</title>
  <meta name="author" content="Mark Oosting">
  <meta name="description" content="">
  <meta name="keywords" content="">
</head>

<body>
  <header>
    <div class="max width">
      <a href="index.php">Mediabrowze</a>
      <nav class="floatright">

        <a class="<?php if($currentpage == 'contact') echo 'active'; ?>" href="contact.php">Contact</a><span> | </span>

          <?php
          // $currentpage is set in the file which includes the header
          global $currentpage;

          if(isset($_SESSION['user'])):

            // If a user is logged in, display the account and logout link.
            // If a user is an administrator, show the admin link.
            // Otherwise, we'll just display a login link.

            if($_SESSION['user']->admin): ?>

              <a class="<?php if($currentpage == 'admin') echo 'active'; ?>" href='admin.php'>Admin</a><span> | </span>

            <?php endif; ?>

            <a class="<?php if($currentpage == 'account') echo 'active'; ?>" href='account.php'>My account</a>
            <span> | </span>
            <a href='logout.php'>Log out</a>

          <?php else: ?>

            <a class="<?php if($currentpage == 'login') echo 'active'; ?>" href='login.php'>Log in</a>

          <?php endif; ?>

        <a href="search.php"> | <i class="fa fa-search" aria-hidden="true"></i></a>

      </nav>
    </div>
  </header>

<main>
