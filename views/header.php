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
        <?php
          if(isset($_SESSION['user'])) {
            // If a user is an administrator, show the admin link.
            if($_SESSION['user']->admin){
              echo "<a href='admin.php'>Admin</a>";
              echo "<span> | </span>";
            }
            // If a user is logged in, display a 'my account' and logout link.
            echo "<a href='account.php'>My account</a>";
            echo "<span> | </span>";
            echo "<a href='logout.php'>Log out</a>";
          } else {
            // Otherwise, show a login button.
            echo "<a href='login.php'>Log in</a>";
          }
        ?>
        <a href="search.php"> | <i class="fa fa-search" aria-hidden="true"></i></a>
      </nav>
    </div>
  </header>
