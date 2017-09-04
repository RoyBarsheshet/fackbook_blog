<?php
require_once 'app/helpers.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('location: signin.php');
    exit;
}
$title = 'profile Page';

$uid = $_SESSION['user_id'];
$error = ['first name' => '', 'last name' => '', 'email' => ''];
$first_name = '';
$last_name = '';
$email_profile = '';

if (isset($_POST['submit'])) {

    $link = mysqli_connect('localhost', 'root', '', 'fakebook_blog');
    mysqli_query($link, "SET NAMES utf8");

    $first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING);
    $first_name = trim($first_name);

    $last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
    $last_name = trim($last_name);

    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $email = trim($email);
    $email = mysqli_real_escape_string($link, $email);

    $valid = true;

    if (!$first_name || mb_strlen($first_name, 'utf-8') < 2 || mb_strlen($first_name, 'utf-8') > 70) {
        $valid = FALSE;
        $error['first name'] = ' * You Must Enter Name And It Must Be More then 2 characters';
    }
    if (!$last_name || mb_strlen($last_name, 'utf-8') < 2 || mb_strlen($last_name, 'utf-8') > 70) {
        $valid = FALSE;
        $error['last name'] = ' * You Must Enter Last Name And It Must Be More then 2 characters';
    }
    if (!$email) {
        $valid = FALSE;
        $error['email'] = ' * You Must Enter A Valid Email';
    } elseif (email_exist($link, $email)) {
        $valid = FALSE;
        $error['email'] = ' * Email Is Already In Use, Please Sign In! ';
    }
    if ($valid) {
        $first_name = mysqli_real_escape_string($link, $first_name);
        $last_name = mysqli_real_escape_string($link, $last_name);
        $sql = "UPDATE users SET first_name = '$first_name',last_name = '$last_name',email = '$email' WHERE id = $uid";
        $result = mysqli_query($link, $sql);

        if ($result && mysqli_affected_rows($link) == 1) {

            $_SESSION['user_name'] = $first_name;
            $_SESSION['user_last_name'] = $last_name;
            $_SESSION['user_email'] = $email;
            header('location: blog.php?sm=Your account has been updated!');
        }
    }
}
?>
<?php include 'tpl/header.php'; ?>

<div class="text-left ml-5 mt-5">
    <h1 style="font-family:serif "><?= $_SESSION['user_name']; ?>&nbsp;<?= $_SESSION['user_last_name']; ?></h1>
</div>
<div class="ml-5 mb-5 h-100">
    <div class="text-left mb-4">
        <img src="images/<?= $_SESSION['user_avatar']; ?>"  class="rounded img-thumbnail w-25" alt="Profile Picture">
    </div>

    <div class="mb-5">
        <form method="post" action="" enctype="multipart/form-data" >
            <div class="form-group w-25">
                <label for="first_name">First Name</label>
                <input type="text" name="first_name" class="form-control" id="first_name" value="<?= $first_name; ?>" placeholder="<?= $_SESSION['user_name']; ?>"> 
                <span class="error"> <?= $error['first name']; ?></span>
            </div>

            <div class="form-group w-25">
                <label for="last_name">Last Name</label>
                <input type="text" name="last name" class="form-control" id="last_name" value="<?= $last_name; ?>" placeholder="<?= $_SESSION['user_last_name']; ?>"> 
                <span class="error"> <?= $error['last name']; ?></span>
            </div> 
            <div class="form-group w-25">
                <label for="email">Email address</label>
                <input type="text" class="form-control " name="email" id="email" value="<?= $email_profile; ?>" placeholder="<?= $_SESSION['user_email']; ?>" >
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                <span class="error"> <?= $error['email']; ?></span>
            </div>  
            <p><b class="post-info">If you want to change your profile image click <a href="update_avatar.php">here!</a></b></p>
            <input class="click-btn-large" type="submit" name="submit" value="Update Profile">
            <input class="click-btn-large" type="button" value="Cancel"  onclick="window.location = 'blog.php';">
        </form>
    </div>
</div>
<?php include 'tpl/footer.php'; ?>     

