<?php
require_once 'app/helpers.php';
session_start();

if(!isset($_SESSION['user_id'])){
  header('location: signin.php');
  exit;
}
$title ='profile Page' ;

?>
<?php include 'tpl/header.php'; ?>
      <div class="content">
        <h1><?= $_SESSION['user_name']; ?>&nbsp;<?= $_SESSION['user_last_name']; ?></h1>
        <p><img border="0" width="400" src="images/<?= $_SESSION['user_avatar']; ?>"></p>
      </div>
<?php include 'tpl/footer.php'; ?>     

