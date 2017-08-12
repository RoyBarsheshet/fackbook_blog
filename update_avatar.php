<?php
require_once 'app/helpers.php';
session_start();

if ( ! verify_user()){
  
  header('location: signin.php');
  exit;
}
$title = 'Update Avatat';

if(isset($_POST['submit'])){
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
         header('location: blog.php?sm=Image Upload successfully');
         exit;
       }
     }
      }
    }
  }
 
}

?>
<?php include 'tpl/header.php'; ?>
      <div class="content">
        <h1>Update profile picture</h1>
        <form method="post" action="" enctype="multipart/form-data">
          <label for="image">Image Profile<label><br><br>
          <input type="file" name="image" id="image"><br><br>
          <input type="submit" name="submit" value="Update Image">
          <input type="button" value="Cancel"  onclick="window.location='blog.php';">
          
        </form>
       
      </div>
<?php include 'tpl/footer.php'; ?>     

