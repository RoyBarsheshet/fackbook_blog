<?php
require_once 'app/helpers.php';
session_start();

if ( verify_user() ) {
  
  header('location: blog.php');
  exit;
}

$title = 'Sgin Up';
$error = ['first name' =>'','last name' =>'','email'=>'','password'=>'','confirm_password'=>''];

if(isset($_POST['submit'])){
  
  if(isset($_POST['token']) && isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token'] ){
  
    $link = mysqli_connect('localhost', 'root', '', 'fakebook_blog'); 
    mysqli_query($link, "SET NAMES utf8");
  
    $first_name = filter_input(INPUT_POST,'first_name',  FILTER_SANITIZE_STRING);
  $first_name = trim($first_name);
  
  $last_name = filter_input(INPUT_POST,'last_name',  FILTER_SANITIZE_STRING);
  $last_name = trim($last_name);  
    
  $email = filter_input(INPUT_POST,'email', FILTER_VALIDATE_EMAIL);
  $email = trim($email);
  $email = mysqli_real_escape_string($link, $email);
  
  $password = filter_input(INPUT_POST,'password',  FILTER_SANITIZE_STRING);
  $password = trim($password);
  
   $cpassword = filter_input(INPUT_POST,'confirm_password',  FILTER_SANITIZE_STRING);
  $cpassword = trim($cpassword);
  
  $valid = true;
  
  if(! $first_name || mb_strlen($first_name , 'utf-8') < 2 || mb_strlen($first_name, 'utf-8') > 70) {
    $valid=FALSE;
    $error['first name'] = ' * You Must Enter Name And It Must Be More then 2 characters';
  }
  if(! $last_name || mb_strlen($last_name, 'utf-8') < 2 || mb_strlen($last_name, 'utf-8') > 70) {
    $valid=FALSE;
    $error['last name'] = ' * You Must Enter Last Name And It Must Be More then 2 characters';
  }
  if(! $email) {
    $valid=FALSE;
    $error['email'] = ' * You Must Enter A Valid Email';
 
  }elseif ( email_exist($link, $email)) {
      $valid =FALSE;
      $error['email'] = ' * Email Is Already In Use, Please Sign In! ';
    }
  if( ! $password || strlen($password) <6 || strlen($password) > 10){
    $valid=FALSE;
    $error['password'] = ' * You Must Enter A Password with at list 6 characters and less then 10 characters';
  }elseif ( $password != $cpassword) {
      $valid=FALSE;
      $error['password'] = ' * Password\'s Must Match';
    }
  if ($valid){
    $first_name = mysqli_real_escape_string($link,$first_name);
    $last_name = mysqli_real_escape_string($link,$last_name);
    $password = mysqli_real_escape_string($link,$password);
    $password = password_hash($password, PASSWORD_BCRYPT);  
    $sql = "INSERT INTO users VALUES ('' , '$first_name','$last_name','$email','$password','default.jpg',NOW())";
    $result = mysqli_query($link, $sql);
    if ($result && mysqli_affected_rows($link) == 1){
       $_SESSION['user_ip']= $_SERVER['REMOTE_ADDR'];
     $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
     $_SESSION['user_name'] = $first_name;
     $_SESSION['user_last_name'] = $last_name;
     $_SESSION['user_id']= mysqli_insert_id($link);
     $_SESSION['user_avatar'] = 'default.jpg';
     $_SESSION['user_email']= $email;
     header('location: blog.php?sm=Your account created, you are now logedin');
//     print_r($user);
     exit;
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
      <div class="content">
        <h1>Create New Account</h1>
        <form method="post" action="">
          <input type="hidden" name="token" value="<?= $token; ?>">
           <label for="first_name">First Name:</label><br>
          <input type="text" name="first name" id="first_name" value="<?= old('name'); ?>">
          <span class="error"> <?= $error['first name']; ?></span><br><br>
           <label for="last_name">Last Name:</label><br>
          <input type="text" name="last name" id="last_name" value="<?= old('name'); ?>">
          <span class="error"> <?= $error['last name']; ?></span><br><br>
          
          <label for="email">Email:</label><br>
          <input type="text" name="email" id="eamil" value="<?= old('email'); ?>">
          <span class="error"> <?= $error['email']; ?></span><br><br>
          
          <label for="password">Password:<label><br> 
      <input type="password" name="password" id="password">
      <span class="error"> <?= $error['password']; ?></span><br><br>
      
       <label for="confirm_Password">Confirm Password:<label><br> 
      <input type="password" name="confirm_password" id="confirm_Password">
      <span class="error"> <?= $error['confirm_password']; ?></span><br><br>
      
      <input type="submit" name="submit" value="Sign Up">
     
        </form>
        
        
      </div>
<?php include 'tpl/footer.php'; ?>     

