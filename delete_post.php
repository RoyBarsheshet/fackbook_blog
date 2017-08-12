<?php
require_once 'app/helpers.php';
session_start();

if ( ! verify_user()){
  
  header('location: signin.php');
  exit;
}
$title = 'Delete Post';

 $pid = filter_input(INPUT_GET, 'pid', FILTER_SANITIZE_STRING);
 $pid = trim($pid);
 
 
 // if user trys to change the query string to someone else post id
if ($pid && is_numeric($pid) ){
   $uid = $_SESSION['user_id'];
   $link = mysqli_connect('localhost', 'root', '', 'fakebook_blog'); 
   $pid = mysqli_real_escape_string($link,$pid);
   $sql = "SELECT * FROM posts WHERE id = $pid AND user_id = $uid";
    $result = mysqli_query($link, $sql);
    
    if ($result && mysqli_affected_rows($link) == 0){
      echo '<script>alert("THIS IS NOT YOUR POST BILY THE KID!!");</script>';
     header('location: blog.php');
      exit;
    }
}

if(isset($_POST['submit'])){
 $pid = filter_input(INPUT_GET, 'pid', FILTER_SANITIZE_STRING);
 $pid = trim($pid);
 if ($pid && is_numeric($pid) ){
   $uid = $_SESSION['user_id'];
   $link = mysqli_connect('localhost', 'root', '', 'fakebook_blog'); 
   $pid = mysqli_real_escape_string($link,$pid);
   $sql = "DELETE FROM posts WHERE id = $pid AND user_id = $uid";
    $result = mysqli_query($link, $sql);
    
    if ($result && mysqli_affected_rows($link) == 1){
      header('location: blog.php?sm=Post Deleted!');
      exit;
    }
 }
}
?>
<?php include 'tpl/header.php'; ?>
      <div class="content">
        <h1>Are you sure you want to delete this post?</h1>
        <form method="post" action="">
         
          <input class="click-btn-large" type="submit" name="submit" value="Delete">
          <input class="click-btn-large" type="button" value="Cancel"  onclick="window.location='blog.php';">
          
        </form>
       
      </div>
<?php include 'tpl/footer.php'; ?>     

