<?php
require_once 'app/helpers.php';
session_start();

if (verify_user()) {
    header('location: blog.php');
    exit;
}

$title = 'Sgin In';
$error = '';

if (isset($_POST['submit'])) {
    if (isset($_POST['token']) && isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token']) {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $email = trim($email);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $password = trim($password);
        if (!$email) {
            $error = '  * A valid email is required';
        } elseif (!$password || strlen($password) < 6 || strlen($password) > 10) {
            $error = ' * A valid password is required ';
        } else {
            $link = mysqli_connect('localhost', 'root', '', 'fakebook_blog');
            $email = mysqli_real_escape_string($link, $email);
            $password = mysqli_real_escape_string($link, $password);
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($link, $sql);
            if ($result && mysqli_num_rows($result) > 0) {
                $user = mysqli_fetch_assoc($result);
                if (password_verify($password, $user['password'])) {
                    $_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR'];
                    $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
                    $_SESSION['user_name'] = $user['first_name'];
                    $_SESSION['user_last_name'] = $user['last_name'];
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_avatar'] = $user['avatar'];
                    $_SESSION['user_email'] = $user['email'];
                    header('location: blog.php?sm=Welcome Back ' . $user['first_name'] . '!');
                    exit;
                } else {
                    $error = ' *Wrong email and password combination1';
                }
            } else {
                $error = ' *Wrong email and password combination';
            }
        }
    }
    $token = csrf_token();
} else {
    $token = csrf_token();
}
?>
<?php include 'tpl/header.php'; ?>

<div class="text-left m-5">
    <h1 style="font-family:serif ">SIGN IN</h1>
</div>
<div class="row no-gutters ">
   <div class="m-5 bg-light col-3 col-md-3 align-items-center">
        <form method="post" action="" >
            <div class="form-group ">
                <input type="hidden" name="token" value="<?= $token; ?>">
                <label for="email">Email address</label>
                 <!--<input type="text" name="email" id="eamil" value="<?= old('email'); ?>">-->
                <input type="text" class="form-control w-10" name="email" id="email" aria-describedby="emailHelp" placeholder="Enter email" value="<?= old('email'); ?>">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>
            <div class="form-group">
                <label for="Password">Password</label>
                <input type="password" name="password" class="form-control w-10" id="Password" placeholder="Password">
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input">
                    Remember me
                </label>
            </div>
            <input class="click-btn-large" type="submit" name="submit" value="Sign In">
            <span class="error"> <?= $error; ?></span>
        </form>
    </div>
    <div class="col-8 col-sm-8 col-md-8 text-center ">

        <p class="post-info">
            <img class="img-fluid rounded" style="border-radius:16.25rem!important" alt="Responsive image" src="images/about_us.jpg"><br><br>
            <b class="form-text text-muted">The Fakebook Page celebrates how our friends inspire us, support us,
                and help us discover the world when we connect.</b>
        </p>
    </div> 
</div>
<?php include 'tpl/footer.php'; ?>     

