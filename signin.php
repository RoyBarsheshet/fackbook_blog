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
  
  $email = !empty($_POST['email']) ? trim($_POST['email']) : '';
  $password = !empty($_POST['password']) ? trim($_POST['password']) :'';
  $emailRegexp = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';
  
  if(! $email){
    $error = '  * A valid email is required';
  }elseif ( !preg_match($emailRegexp, $email)) {
    $error = '  * Email must be a valid email format addrass';
  }elseif (!$password ) {
    $error = ' * A valid password is required ';
    
  }else{
   $link = mysqli_connect('localhost', 'root', '', 'fakebook_blog'); 
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

