<?php
require_once 'app/helpers.php';
session_start();

if ( ! verify_user()){
  
  header('location: signin.php');
  exit;
}
$pid= filter_input(INPUT_GET,'pid',FILTER_SANITIZE_STRING);
$pid = trim($pid);
$uid = $_SESSION['user_id'];


if($pid && is_numeric($pid)){
  $link = mysqli_connect('localhost', 'root', '', 'fakebook_blog');
  mysqli_query($link, "SET NAMES utf8");
  $pid = mysqli_real_escape_string($link,$pid);
  $sql = "SELECT * FROM posts WHERE id = $pid AND user_id = $uid";
  $result = mysqli_query($link, $sql);
//  print_r($result);
   if( $result && mysqli_num_rows($result) == 1 ){
    $post = mysqli_fetch_assoc($result);
  //  print_r($post);
  } else {
    header('location: blog.php');
    exit;
  }
} else {
  header('location: blog.php');
  exit;
}

$title = 'Edit Post';
$error = '';


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
$post_title = mysqli_real_escape_string($link, $post_title);
$article = mysqli_real_escape_string($link, $article);


   $sql = "UPDATE posts SET title = '$post_title', article = '$article' WHERE id = '$pid'";
   $result = mysqli_query($link, $sql);  
   
   if($result ){
    header('location: blog.php?sm=Post Updated!');
  exit;
   }
}     
 
}
?>
<?php include 'tpl/header.php'; ?>
  
      <div class="text-left m-5">
    <h1 style="font-family:serif ">Edit Your Post</h1>
</div>
        <div class="m-5">
        <form method="post" action="" enctype="multipart/form-data" >
            <div class="form-group w-25">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control" id="title" value="<?= $post['title']; ?>">
            </div>
<!--      <label for="title">Title:</label><br>
      <input type="text" name="title" value="<?= $post['title']; ?>"><br><br>-->
      <label for="article">Article:</label><br>
      <textarea rows="10" cols="50" name="article"><?= $post['article']; ?></textarea><br><br>
      <input class="click-btn-large" type="submit" name="submit" value="Update post">
      <input class="click-btn-large" type="button" value="Cancel" onclick="window.location='blog.php';">
      <span class="error"><?= $error; ?></span>
    </form>
  </div>
<?php include 'tpl/footer.php'; ?>

