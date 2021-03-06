<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title><?= $title; ?></title>

        <link rel="shortcut icon" href="https://m.facebook.com/apple-touch-icon.png?refsrc=https%3A%2F%2Ffacebook.com%2F&_rdr" type="image/x-icon" />
        <link href="css/bootstrap-4.0.0-beta/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <script src="css/bootstrap-4.0.0-beta/assets/js/vendor/jquery-slim.min.js" type="text/javascript"></script>
        <script src="css/bootstrap-4.0.0-beta/assets/js/vendor/popper.min.js" type="text/javascript"></script>
        <script src="css/bootstrap-4.0.0-beta/dist/js/bootstrap.min.js" type="text/javascript"></script>
        <link href="css/style.css" rel="stylesheet" type="text/css"/>
    </head>
    <body class="bg-light" > 
        <ul class="nav nav-tabs m-1 bg-white">
            <li class="nav-item bg-light">
                <a class="nav-link active bg-light" style="font-weight: bolder" href="blog.php">FakeBook</a>
            </li>
            <?php if (!isset($_SESSION['user_id'])): ?>
                <li class="nav-item">
                    <a class="nav-link" href="signin.php">Sign in</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="signup.php">Sign up</a>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="blog.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="user_profile.php"><?= htmlentities($_SESSION['user_name']); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="update_avatar.php">
                        <img border="0" width="30" src="images/<?= $_SESSION['user_avatar']; ?>">
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="logout.php">logout</a>
                </li>
            <?php endif; ?>
        </ul>
        <?php if (isset($_GET['sm'])): ?>
            <div id="myModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content" id="sm-box">
                        <p class="mt-3"><?= $_GET['sm']; ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>