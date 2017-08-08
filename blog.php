<?php
require_once 'app/helpers.php';
session_start();

if(!isset($_SESSION['user_id'])){
  header('location: signin.php');
  exit;
}
$title = 'Fakebook Blog';
$posts = [];
$link = mysqli_connect('localhost', 'root', '', 'fakebook_blog'); 
mysqli_query($link, "SET NAMES utf8");
   $sql = "SELECT u.first_name,u.last_name,p.id,p.user_id,p.title,p.article,DATE_FORMAT(p.date,'%d/%m/%Y') date FROM posts p "
        . " JOIN users u ON u.id = p.user_id "
        . " ORDER BY p.date DESC";
   $result = mysqli_query($link, $sql); 
   
  if( $result && mysqli_num_rows($result) > 0 ){
  $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
//   print_r($posts);
?>
<?php include 'tpl/header.php'; ?>
      <div class="content">
        <h1>Fakebook blog</h1>
        <p><input type="button" value="+ Add Your Post" onclick="window.location='add_post.php';"></p>
       <?php if ($posts) : ?>
        <?php foreach ($posts as $post): ?>
        <div class="post-box">
          <h3><?= htmlentities($post['title']); ?></h3>
          <p><?= htmlentities($post['article']); ?></p>
          <hr>
          <p><b>Writen by:</b> <?= htmlentities($post['first_name']);?> <?= htmlentities($post['last_name']);?> <b>On date:</b> <?= $post['date'];?></p>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
      </div>
<?php include 'tpl/footer.php'; ?>     

