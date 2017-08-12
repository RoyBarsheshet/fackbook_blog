<?php
require_once 'app/helpers.php';
session_start();

if ( ! verify_user()){
  
  header('location: signin.php');
  exit;
}
$title = 'Add Post';
$error = '';
$post_title='';

if(isset($_POST['submit'])){
  $post_title = filter_input(INPUT_POST, 'title' , FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
  $post_title = trim($post_title);
  $article = filter_input(INPUT_POST, 'article' , FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
  $article = trim($article);
  
  if( ! $post_title){
    
    $error = ' * Title is required';
  } elseif (! $article) {
    
    $error = ' * Articale is required';
  
} else {
$link = mysqli_connect('localhost', 'root', '', 'fakebook_blog'); 
$post_title = mysqli_real_escape_string($link, $post_title);
$article = mysqli_real_escape_string($link, $article);

mysqli_query($link, "SET NAMES utf8");
$uid = $_SESSION['user_id'];
   $sql = "INSERT INTO posts VALUES('','$post_title','$article',NOW(),$uid)";
   $result = mysqli_query($link, $sql);  
   
   if($result && mysqli_affected_rows($link) > 0){
    header('location: blog.php?sm=Your Post has been seved');
  exit;
   }
}     
 
}
?>
<?php include 'tpl/header.php'; ?>
      <div class="content">
        <h1>Add your post</h1>
        <form method="post" action="">
          <label for="title">Title:</label><br>
          <input type="text" name="title" value="<?= old('title');?>"><br><br>
          <label for="article">Article:</label><br>
          <textarea  rows="10" cols="50" name="article"><?= old('article'); ?></textarea><br><br>
          <input class="click-btn-large" type="submit" name="submit" value="Save Post">
          <input class="click-btn-large" type="button" value="Cancel"  onclick="window.location='blog.php';">
          <span class="error"><?= $error; ?></span>
        </form>
       
      </div>
<?php include 'tpl/footer.php'; ?>     

