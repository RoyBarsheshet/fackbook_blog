<?php
require_once 'app/helpers.php';
session_start();

if (!verify_user()) {

    header('location: signin.php');
    exit;
}

$title = 'Update Profile Image';
$error = '';

if (isset($_POST['submit'])) {
    if (!empty($_FILES['image']['name'])) {
        define('MAX_UPLOAD_SIZE', 1024 * 1024 * 5);
        $ex = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];
        if (is_uploaded_file($_FILES['image']['tmp_name'])) {
            if ($_FILES['image']['error'] == 0 && $_FILES['image']['size'] <= MAX_UPLOAD_SIZE) {
                $fileinfo = pathinfo($_FILES['image']['name']);
                if (in_array(strtolower($fileinfo['extension']), $ex)) {
                    $file_name = date('Y.m.d.H.i.s') . '-' . $_FILES['image']['name'];

                    move_uploaded_file($_FILES['image']['tmp_name'], 'images/' . $file_name);
                    $uid = $_SESSION['user_id'];
                    $link = mysqli_connect('localhost', 'root', '', 'fakebook_blog');
                    mysqli_query($link, "SET NAMES utf8");
                    $sql = "UPDATE users SET avatar = '$file_name' WHERE id = $uid";
                    $result = mysqli_query($link, $sql);

                    if ($result && mysqli_affected_rows($link) == 1) {
                        $_SESSION['user_avatar'] = $file_name;
                        header('location: blog.php?sm=Image Upload successfully');
                        exit;
                    }
                }
            }
        }if ($_FILES['image']['error'] == 1) {
            $error = '* Image size exceeds the upload max filesize!';
        }
    }
}
?>
<?php include 'tpl/header.php'; ?>
<div class="text-center m-5">
    <h1 style="font-family:serif ">Upload Profile Picture</h1>
</div>
<div class="text-center">
    <img src="images/<?= $_SESSION['user_avatar']; ?>"  class="rounded img-thumbnail w-50" alt="Profile Picture">
</div>
<div class="text-center mb-5 h-100">
    <form method="post" action="" enctype="multipart/form-data" >
        <div class="btn btn-secondary text-center w-50">      
            <input type="file" name="image" id="image" class="form-control">
        </div>
        <div class="m-5">
            <input class="click-btn-large" type="submit" name="submit" value="Update Image">
            <input class="click-btn-large" type="button" value="Cancel"  onclick="window.location = 'blog.php';"><br>
            <span class="error"> <?= $error; ?></span>
        </div>
    </form>
</div>

<?php include 'tpl/footer.php'; ?>     

