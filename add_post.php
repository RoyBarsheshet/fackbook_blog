<?php
require_once 'app/helpers.php';
session_start();

if(!isset($_SESSION['user_id'])){
  header('location: signin.php');
  exit;
}
$title = 'Fakebook Blog';

?>
<?php include 'tpl/header.php'; ?>
      <div class="content">
        <h1>Fakebook blog</h1>
        <p><input type="button" value="+ Add Your Post"></p>
       
      </div>
<?php include 'tpl/footer.php'; ?>     

