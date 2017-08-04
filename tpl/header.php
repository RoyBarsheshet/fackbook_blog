<!DOCTYPE html>
<html>
  <head>
    <title><?= $title; ?></title>
    <link href="css/style.css" rel="stylesheet" type="text/css"/>
  </head>
  <body>
    <div class="page-wrapper">
      <div class="header">
        <ul>
          <li><a href="./">FakeBook</a></li>
          <li><a href="about.php">About</a></li>
          <li><a href="blog.php">Blog</a></li>
           <?php if (! isset($_SESSION['user_id']) ): ?>
          <li><a href="signin.php">Sign in</a></li>
          <li><a href="signup.php">Sign up</a></li>
          <?php else:?>
          <li><a href="user_profile.php"><?= $_SESSION['user_name']; ?></a></li>
          <li>
            <a href="user_profile.php">
              <img border="0" width="30" src="images/<?= $_SESSION['user_avatar']; ?>">
            </a>
          </li>
          <li><a href="logout.php">logout</a></li>
          <?php endif;?>
        </ul>  
      </div>