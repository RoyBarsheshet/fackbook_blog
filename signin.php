<?php
require_once 'app/helpers.php';
session_start();

if(isset($_SESSION['user_id'])){
  header('location: blog.php');
  exit;
}
$title = 'Sgin In';
$error = '';

if(isset($_POST['submit'])){
  $email = filter_input(INPUT_POST,'email', FILTER_VALIDATE_EMAIL);
  $email = trim($email);
  
  $password = filter_input(INPUT_POST,'password', FILTER_VALIDATE_STRING);
  $password = trim($password);
  
  
  if(! $email){
    $error = '  * A valid email is required';
 
  }elseif (!$password || strlen($password) < 6 || strlen($password) > 10) {
    $error = ' * A valid password is required ';
    
  }else{
    
   $link = mysqli_connect('localhost', 'root', '', 'fakebook_blog'); 
   $email = mysqli_real_escape_string($link, $email);
   $password = mysqli_real_escape_string($link, $password);
   $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
   
   $result = mysqli_query($link, $sql);
   
   if($result && mysqli_num_rows($result) > 0){
     
     $user = mysqli_fetch_assoc($result);
     
     $_SESSION['user_name'] = $user['first_name'];
     $_SESSION['user_last_name'] = $user['last_name'];
     $_SESSION['user_gender'] = $user['gender'];
     $_SESSION['user_id']= $user['id'];
     $_SESSION['user_avatar'] = $user['avatar'];
     $_SESSION['user_email']= $user['email'];
     header('location: blog.php');
//     print_r($user);
     exit;
     
   } else {
   $error =' *Wrong email and password combination';  
   }
  }
  $token = csrf_token();
} else {
  $token = csrf_token();
}
?>
<?php include 'tpl/header.php'; ?>
      <div class="content">
        <h1>Sign In</h1>
        <form method="post" action="">
          <input type="hidden" name="token" value="<?= $token; ?>">
          <label for="email">Email:</label><br>
          <input type="text" name="email" id="eamil" value="<?= old('email'); ?>"><br><br>
          <label for="password">Password:<label><br> 
      <input type="password" name="password" id="password"><br><br>
      <input type="submit" name="submit" value="Sign In">
      <span class="error"> <?= $error; ?></span>
        </form>
        
        
      </div>
<?php include 'tpl/footer.php'; ?>     

