<?php
require_once 'app/helpers.php';
session_start();
$title = 'Sgin In';
$error = '';

if(isset($_POST['submit'])){
  
  $email = !empty($_POST['email']) ? trim($_POST['email']) : '';
  $password = !empty($_POST['password']) ? trim($_POST['password']) :'';
  $emailRegexp = "/";
  
  if(! $email){
    $error = '  * A valid email is required';
  }elseif ( !preg_match($emailRegexp, $email)) {
    $error = '  * Email must be a valid email format addrass';
  }
}
?>
<?php include 'tpl/header.php'; ?>
      <div class="content">
        <h1>Sign In</h1>
        <form method="post" action="">
          <label for="email">Email:</label><br>
          <input type="text" name="email" id="eamil" value="<?= old('email'); ?>"><br><br>
          <label for="password">Password:<label><br> 
              <input type="password" name="password" id="password"><br><br>
              <input type="submit" name="submit" value="Sign In">
              <span class="error"> <?= $error; ?></span>
        </form>
        
        
      </div>
<?php include 'tpl/footer.php'; ?>     

