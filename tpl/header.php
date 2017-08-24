<!DOCTYPE html>
<html>
  <head>
     <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $title; ?></title>
    <!--<link href="css/bootstrap-4.0.0-beta/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>-->
    
<!--       <script src="css/bootstrap-4.0.0-beta/assets/js/vendor/jquery-slim.min.js" type="text/javascript"></script>
       <script src="css/bootstrap-4.0.0-beta/assets/js/vendor/popper.min.js" type="text/javascript"></script>
       <script src="css/bootstrap-4.0.0-beta/dist/js/bootstrap.min.js" type="text/javascript"></script>-->
    <link href="css/style.css" rel="stylesheet" type="text/css"/>
  </head>
  <body>
    <div class="page-wrapper">
      <div class="header">
        <ul>
          <li><a class="btn-5" href="blog.php">FakeBook</a></li>
          <li><a  class="btn-5" href="about.php">About</a></li>
          <li><a class="btn-5" href="blog.php">Blog</a></li>
           <?php if (! isset($_SESSION['user_id']) ): ?>
          <li><a class="btn-5" href="signin.php">Sign in</a></li>
          <li><a class="btn-5" href="signup.php">Sign up</a></li>
          <?php else:?>
          <li><a class="btn-5" href="user_profile.php"><?= htmlentities($_SESSION['user_name']); ?></a></li>
          <li>
            <a class="btn-5" href="update_avatar.php">
              <img border="0" width="30" src="images/<?= $_SESSION['user_avatar']; ?>">
            </a>
          </li>
          <li class="btn-5"><a href="logout.php">logout</a></li>
          <?php endif;?>
        </ul>  
      </div>
       <?php if( isset($_GET['sm']) ): ?>
      <div id="sm-box">
        <p><?= $_GET['sm']; ?></p>
      </div>
      <?php endif; ?>