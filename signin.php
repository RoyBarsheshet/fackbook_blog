<?php
session_start();
$title = 'Sgin In';

?>
<?php include 'tpl/header.php'; ?>
      <div class="content">
        <h1>Sign In</h1>
        <form method="post" action="">
          <label for="email">Email:</label><br>
          <input type="text" name="email" id="eamil" value="<?= old('email'); ?>">
          
          
        </form>
        
        
      </div>
<?php include 'tpl/footer.php'; ?>     

