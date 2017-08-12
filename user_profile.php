<?php
require_once 'app/helpers.php';
session_start();

if(!isset($_SESSION['user_id'])){
  header('location: signin.php');
  exit;
}
$title ='profile Page' ;

$uid = $_SESSION['user_id'];
$error=['first name' =>'','last name' =>'','email'=>''];
$first_name= '';
$last_name = '';
$email_profile= '';

if(isset($_POST['submit']) ){
//  
//   if(! $first_name || mb_strlen($first_name , 'utf-8') < 2 || mb_strlen($first_name, 'utf-8') > 70) {
//    $valid=FALSE;
//    $error['first name'] = ' * You Must Enter Name And It Must Be More then 2 characters';
//  }
//  if(! $last_name || mb_strlen($last_name, 'utf-8') < 2 || mb_strlen($last_name, 'utf-8') > 70) {
//    $valid=FALSE;
//    $error['last name'] = ' * You Must Enter Last Name And It Must Be More then 2 characters';
//  }
//  if(! $email_profile) {
//    $valid=FALSE;
//    $error['email'] = ' * You Must Enter A Valid Email';
// 
//  }elseif ( email_exist($link, $email)) {
//      $valid =FALSE;
//      $error['email'] = ' * Email Is Already In Use! ';
//    }
//  if ($valid){
//    
//   $first_name = filter_input(INPUT_POST, 'title' , FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
//  $first_name = trim($first_name);
//  $last_name= filter_input(INPUT_POST, 'article' , FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
//  $last_name = trim($last_name);
//  
//  
//  $first_name = mysqli_real_escape_string($link, $first_name);
//$last_name = mysqli_real_escape_string($link, $last_name);
//  
//$link = mysqli_connect('localhost', 'root', '', 'fakebook_blog');
//  $sql = "UPDATE posts SET first_name = '$first_name', last_name = '$last_name' WHERE id = $uid";
//   $result = mysqli_query($link, $sql);  
//   echo print_r($result);
// if ($result && mysqli_num_rows($result) > 0) {
//   $_SESSION['first name'] = $first_name;
//   $_SESSION['last_name'] = $last_name;
//   $_SESSION['email'] = $email;
//         
//} else {
//  $error = ' * Cannot Update Empty Fileds!';
//}
 if ( !empty($_FILES['image']['name'])){
    define('MAX_UPLOAD_SIZE', 1024 *1024 *5);
    $ex = ['jpg','jpeg','png','gif','bmp'];
    
    if (is_uploaded_file($_FILES['image']['tmp_name'])){
      if ($_FILES['image']['error'] == 0 && $_FILES['image']['size'] <= MAX_UPLOAD_SIZE){
     $fileinfo = pathinfo($_FILES['image']['name']);
     if (in_array( strtolower($fileinfo['extension']), $ex)){
       $file_name = date('Y.m.d.H.i.s'). '-'. $_FILES['image']['name'];
       
       move_uploaded_file($_FILES['image']['tmp_name'], 'images/' . $file_name);
       $uid = $_SESSION['user_id'];
       $link = mysqli_connect('localhost', 'root', '', 'fakebook_blog');
       mysqli_query($link, "SET NAMES utf8");
       $sql="UPDATE users SET avatar = '$file_name' WHERE id = $uid";
       $result = mysqli_query($link, $sql);
       
       if($result && mysqli_affected_rows($link) == 1){
         $_SESSION['user_avatar'] = $file_name;
        header('location: blog.php?sm=Profile Updated successfully');
         exit;
       }
     }
      }
    }
  }
 
}
//}



?>
<?php include 'tpl/header.php'; ?>
      <div class="content">
        
        <h1><?= $_SESSION['user_name']; ?>&nbsp;<?= $_SESSION['user_last_name']; ?></h1>
        <p><img border="0"  class="img-thumbnail" src="images/<?= $_SESSION['user_avatar']; ?>"></p><br><br>
        <form method="post" action="" enctype="multipart/form-data">
          <label for="image">Image profile:</label><br>
          <input type="file" name="image" id="image"><br><br>
          <label for="first_name">First Name:</label><br>
          <input type="text" name="first_name" id="first_name" value="<?= $first_name; ?>" placeholder="<?= $_SESSION['user_name'];?>"><span class="error"> <?= $error['first name']; ?></span><br><br>
          <label for="last_name">Last Name:</label><br>
          <input type="text" name="last_name" id="last_name" value="<?= $last_name; ?>" placeholder="<?= $_SESSION['user_last_name'];?>"><span class="error"> <?= $error['last name']; ?></span><br><br>
          <label for="email">Email:</label><br>
          <input type="text" name="email" id="eamil" value="<?= $email_profile; ?>" placeholder="<?= $_SESSION['user_email'];?>" ><span class="error"> <?= $error['email']; ?></span><br><br>
          <input type="submit" name="submit" value="Update Image">
          <input type="button" value="Cancel"  onclick="window.location='blog.php';">
          
        </form>
      </div>
<?php include 'tpl/footer.php'; ?>     

