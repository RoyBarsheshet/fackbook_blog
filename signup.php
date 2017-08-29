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
  }elseif ( $password != $cpassword || strlen($cpassword) <= 0) {
      $valid=FALSE;
      $error['confirm_password'] = ' * Password\'s Must Match';
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
     <div class="text-left m-5">
    <h1 style="font-family:serif ">Create New Account</h1>
</div>
<div class="row no-gutters ">
<div class="ml-5 mr-5 bg-light col-3 col-md-3 align-items-center">
        <form method="post" action="">
          <input type="hidden" name="token" value="<?= $token; ?>">
          
          
          
<!--           <label for="first_name">First Name:</label><br>
          <input type="text" name="first name" id="first_name" value="<?= old('name'); ?>">
          <span class="error"> <?= $error['first name']; ?></span><br><br>-->
          
           <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" name="first name" class="form-control w-10" id="first_name" placeholder="First Name" value="<?= old('name'); ?>"> 
      <span class="error"> <?= $error['first name']; ?></span><br>
       </div>
        
<!--           <label for="last_name">Last Name:</label><br>
          <input type="text" name="last name" id="last_name" value="<?= old('name'); ?>">
          <span class="error"> <?= $error['last name']; ?></span><br><br>-->
          
          <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" name="last name" class="form-control w-10" id="last_name" placeholder="Last Name" value="<?= old('name'); ?>"> 
      <span class="error"> <?= $error['last name']; ?></span><br>
       </div>
         
         <div class="form-group ">
                <label for="email">Email address</label>
                 <!--<input type="text" name="email" id="eamil" value="<?= old('email'); ?>">-->
                <input type="text" class="form-control w-10" name="email" id="email" aria-describedby="emailHelp" placeholder="Enter email" value="<?= old('email'); ?>">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
           <span class="error"> <?= $error['email']; ?></span><br>
         </div>
          
          <div class="form-group">
                <label for="Password">Password</label>
                <input type="password" name="password" class="form-control w-10" id="Password" placeholder="Password">
      <span class="error"> <?= $error['password']; ?></span><br>
       </div>
          
         <div class="form-group">
                <label for="confirm_Password">Confirm Password:</label>
                <input type="password" name="confirm_password" class="form-control w-10" id="confirm_Password" placeholder="Confirm Password">
           <span class="error"> <?= $error['confirm_password']; ?></span><br><br>
         </div>  
<!--       <label for="confirm_Password">Confirm Password:</label><br> 
      <input type="password" name="confirm_password" id="confirm_Password">-->
      
      
      
      
      
      <input class="click-btn-large" type="submit" name="submit" value="Sign Up">
     
        </form>
        
        
      </div>
 <div class="col-8 col-sm-8 col-md-8 text-center ">

        <p class="post-info">
            <img class="img-fluid rounded" style="border-radius:16.25rem!important" alt="Responsive image" src="images/about_us.jpg"><br><br>
            <b class="form-text text-muted">The Fakebook Page celebrates how our friends inspire us, support us,
                and help us discover the world when we connect.</b>
        </p>
    </div> 
    </div>
<?php include 'tpl/footer.php'; ?>     

