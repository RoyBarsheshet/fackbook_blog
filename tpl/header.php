<!DOCTYPE html>
<html>
  <head>
     <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
          <li><a href="user_profile.php"><?= htmlentities($_SESSION['user_name']); ?></a></li>
          <li>
            <a href="user_profile.php">
              <img border="0" width="30" src="images/<?= $_SESSION['user_avatar']; ?>">
            </a>
          </li>
          <li><a href="logout.php">logout</a></li>
          <?php endif;?>
        </ul>  
      </div>
       <?php if( isset($_GET['sm']) ): ?>
      <div id="sm-box">
        <p><?= $_GET['sm']; ?></p>
      </div>
      <?php endif; ?>