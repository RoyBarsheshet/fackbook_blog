<?php
require_once 'app/helpers.php';
session_start();

if ( verify_user() ) {
  
  header('location: blog.php');
  exit;
}

$title = 'Sgin In';
$error = '';

if(isset($_POST['submit'])){
  
  if(isset($_POST['token']) && isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token'] ){
  
  $email = filter_input(INPUT_POST,'email', FILTER_VALIDATE_EMAIL);
  $email = trim($email);
  
  $password = filter_input(INPUT_POST,'password',  FILTER_SANITIZE_STRING);
  $password = trim($password);
  
  
  if(! $email){
    $error = '  * A valid email is required';
 
  }elseif (!$password || strlen($password) < 6 || strlen($password) > 10) {
    $error = ' * A valid password is required ';
    
  }else{
    
   $link = mysqli_connect('localhost', 'root', '', 'fakebook_blog'); 
   $email = mysqli_real_escape_string($link, $email);
   $password = mysqli_real_escape_string($link, $password);
   $sql = "SELECT * FROM users WHERE email = '$email'";
   
   $result = mysqli_query($link, $sql);
   
   if($result && mysqli_num_rows($result) > 0){
     
     $user = mysqli_fetch_assoc($result);
     
     if( password_verify($password, $user['password']) ){
     $_SESSION['user_ip']= $_SERVER['REMOTE_ADDR'];
     $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
     $_SESSION['user_name'] = $user['first_name'];
     $_SESSION['user_last_name'] = $user['last_name'];
     $_SESSION['user_id']= $user['id'];
     $_SESSION['user_avatar'] = $user['avatar'];
     $_SESSION['user_email']= $user['email'];
     header('location: blog.php?sm=Welcome Back '. $user['first_name'].'!');
//     print_r($user);
     exit;
       
     } else {
       $error =' *Wrong email and password combination1'; 
     }
     
    
     
   } else {
   $error =' *Wrong email and password combination';  
   }
  }
  }
  $token = csrf_token();
} else {
  $token = csrf_token();
}
//print_r($user);
?>
<?php include 'tpl/header.php'; ?>

<div class="text-left m-5">
    <h1 style="font-family:serif ">SIGN IN</h1>
</div>
<div class="m-5 bg-light">
     
<form method="post" action="">
  <div class="form-group">
      <input type="hidden" name="token" value="<?= $token; ?>">
          
    <label for="email">Email address</label>
     <!--<input type="text" name="email" id="eamil" value="<?= old('email'); ?>">-->
    <input type="text" class="form-control w-25" name="email" id="email" aria-describedby="emailHelp" placeholder="Enter email" value="<?= old('email'); ?>">
    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
  </div>
    
  <div class="form-group">
    <label for="Password">Password</label>
    <input type="password" name="password" class="form-control w-25" id="Password" placeholder="Password">
  </div>
    
  <div class="form-check">
    <label class="form-check-label">
      <input type="checkbox" class="form-check-input">
      Remember me
    </label>
  </div>
  <input class="click-btn-large" type="submit" name="submit" value="Sign In">
  <span class="error"> <?= $error; ?></span>
</form>

</div>



<!--
      <div class="content">
        <h1>Sign In</h1>
        <form method="post" action="">
          <input type="hidden" name="token" value="<?= $token; ?>">
          <label for="email">Email:</label><br>
          <input type="text" name="email" id="eamil" value="<?= old('email'); ?>"><br><br>
          <label for="password">Password:</label><br> 
      <input type="password" name="password" id="password"><br><br>
      <input class="click-btn-large" type="submit" name="submit" value="Sign In">
      <span class="error"> <?= $error; ?></span>
        </form>
        
        
      </div>-->
<?php include 'tpl/footer.php'; ?>     

