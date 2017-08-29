<?php
require_once 'app/helpers.php';
session_start();

if(!isset($_SESSION['user_id'])){
  header('location: signin.php');
  exit;
}
$title = 'Fakebook Blog';
$posts = [];
$uid = $_SESSION['user_id'];
$link = mysqli_connect('localhost', 'root', '', 'fakebook_blog'); 
mysqli_query($link, "SET NAMES utf8");
   $sql = "SELECT u.first_name,u.avatar,u.last_name,p.id,p.user_id,p.title,p.article,DATE_FORMAT(p.date,'%d/%m/%Y') date FROM posts p "
        . " JOIN users u ON u.id = p.user_id "
        . " ORDER BY p.date DESC";
   mysqli_query($link, "SET NAMES utf8");
   $result = mysqli_query($link, $sql); 
   
  if( $result && mysqli_num_rows($result) > 0 ){
  $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
 
}
  //print_r($posts);
?>
<?php include 'tpl/header.php'; ?>
<div class="text-left m-5">
    <h1 style="font-family:serif ">Fakebook</h1>
            <p><input class="click-btn-large" type="button" value="Add New Post" onclick="window.location='add_post.php';"></p>

    
</div>
<div class="bg-light">
       
        <!--<p><input class="click-btn-large" type="button" value="Add New Post" onclick="window.location='add_post.php';"></p>-->
        <?php if ($posts) : ?>
        <?php foreach ($posts as $post): ?>
<ul class="list-unstyled m-5 pt-3">
  <li class="media">
      <img class="d-flex mr-3 img-thumbnail rounded" width="60" src="images/<?= $post['avatar'];?>" alt="Generic placeholder image">
   
    <div class="media-body lead">
      <h5 class="mt-0 mb-1"><?= htmlentities($post['title']); ?></h5>
      <?= str_replace("\n", '<br>',htmlentities($post['article'])); ?>
       <hr>
       
      <div class="d-flex justify-content-start">
  <div class="p-2"> <b class="post-info text-primary m-2">Writen by:</b>
 <?= htmlentities($post['first_name']);?> <?= htmlentities($post['last_name']);?> </div>
  <div class="p-2"><b class="post-info text-primary m-2">On date:</b> <?= $post['date'];?></div>
  <?php if($post['user_id'] == $uid) : ?>
  <div class="ml-auto p-2"><a class="post-btn" href="update_post.php?pid=<?= $post['id']; ?>">Edit</a></div>
  <div class="ml-2 p-2"><a class="post-btn" href="delete_post.php?pid=<?= $post['id']; ?>">Delete</a></div>
  <?php endif; ?>
</div> 
       
       
       
       
       
       
       
<!--       <div class="row no-gutters">
  <div class="col-12 col-sm-6 col-md-8">
      <b class="post-info text-primary m-2">Writen by:</b>
 <?= htmlentities($post['first_name']);?> <?= htmlentities($post['last_name']);?> 
      <b class="post-info text-primary m-2">On date:</b> <?= $post['date'];?>
</div>
  <div class="col-4 col-md-4">
  <?php if($post['user_id'] == $uid) : ?>
            <span class="right">
              <a class="post-btn" href="update_post.php?pid=<?= $post['id']; ?>">Edit</a>
              <a class="post-btn" href="delete_post.php?pid=<?= $post['id']; ?>">Delete</a>
            </span>
            <?php endif; ?>
  </div>
</div>-->
          
<!--          <b class="post-info text-primary m-2">Writen by:</b> <?= htmlentities($post['first_name']);?> <?= htmlentities($post['last_name']);?> <b class="post-info text-primary m-2">On date:</b> <?= $post['date'];?>
            <?php if($post['user_id'] == $uid) : ?>
            <span class="right">
              <a class="post-btn" href="update_post.php?pid=<?= $post['id']; ?>">Edit</a>
              <a class="post-btn" href="delete_post.php?pid=<?= $post['id']; ?>">Delete</a>
            </span>
            <?php endif; ?>
         -->
        </div>
     </li>
</ul>
     <?php endforeach; ?>
        <?php endif; ?>
   
 
 </div>
<!--      <div class="content">
        <h1>Fakebook blog</h1>
        <p><input class="click-btn-large" type="button" value="Add New Post" onclick="window.location='add_post.php';"></p>
       <?php if ($posts) : ?>
        <?php foreach ($posts as $post): ?>
        <div class="post-box">
          <h2 class="post-info"><?= htmlentities($post['title']); ?></h2>
          <p><?= str_replace("\n", '<br>',htmlentities($post['article'])); ?></p>
          <hr>
          <p>
            <b class="post-info">Writen by:</b> <?= htmlentities($post['first_name']);?> <?= htmlentities($post['last_name']);?> <b class="post-info">On date:</b> <?= $post['date'];?>
            <?php if($post['user_id'] == $uid) : ?>
            <span class="right">
              <a class="post-btn" href="update_post.php?pid=<?= $post['id']; ?>">Edit</a>
              <a class="post-btn" href="delete_post.php?pid=<?= $post['id']; ?>">Delete</a>
            </span>
            <?php endif; ?>
          </p>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
      </div>-->
<?php include 'tpl/footer.php'; ?>     

