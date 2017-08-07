<?php
require_once 'app/helpers.php';
session_start();

if(!isset($_SESSION['user_id'])){
  header('location: signin.php');
  exit;
}
$title ='profile Page' ;

$uid = $_SESSION['user_id'];

$first_name='';
$last_name= '';
$email_profile= '';

if(isset($_POST['submit'])){
$link = mysqli_connect('localhost', 'root', '', 'fakebook_blog'); 
// Check connection
//if (!$link) {
//    die("Connection failed: " . mysqli_connect_error());
//}

$sql = "UPDATE users VALUES ('',$first_name','$last_name','$email_profile','','','','$uid')";
$result = mysqli_query($link, $sql);

 if ($result) {
    echo '<script language="javascript">';
    echo 'alert("Profile updated successfully")';
    echo '</script>';
} else {
     echo '<script language="javascript">';
     echo 'alert("Error updating Profile")';
     echo '</script>';
}

}

?>
<?php include 'tpl/header.php'; ?>
      <div class="content">
        <h1><?= $_SESSION['user_name']; ?>&nbsp;<?= $_SESSION['user_last_name']; ?></h1>
        <p><img border="0" width="400" src="images/<?= $_SESSION['user_avatar']; ?>"></p><br><br>
          <label for="first_name">First Name:</label><br>
          <input type="text" name="first_name" id="first_name" value="<?= $first_name; ?>" placeholder="<?= $_SESSION['user_name'];?>"><br><br>
          <label for="last_name">Last Name:</label><br>
          <input type="text" name="last_name" id="last_name" value="<?= $last_name; ?>" placeholder="<?= $_SESSION['user_last_name'];?>"><br><br>
          <label for="email">Email:</label><br>
          <input type="text" name="email" id="eamil" value="<?= $email_profile; ?>" placeholder="<?= $_SESSION['user_email'];?>" ><br><br>
          <input type="submit" name="submit" value="Update Profile">
      </div>
<?php include 'tpl/footer.php'; ?>     

