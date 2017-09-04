<?php
require_once 'app/helpers.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('location: signin.php');
    exit;
}
$title = 'Fakebook';
$posts = [];
$uid = $_SESSION['user_id'];
$link = mysqli_connect('localhost', 'root', '', 'fakebook_blog');
mysqli_query($link, "SET NAMES utf8");
$sql = "SELECT u.first_name,u.avatar,u.last_name,p.id,p.user_id,p.title,p.article,DATE_FORMAT(p.date,'%d/%m/%Y') date FROM posts p "
        . " JOIN users u ON u.id = p.user_id "
        . " ORDER BY p.date DESC";
mysqli_query($link, "SET NAMES utf8");
$result = mysqli_query($link, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>
<?php include 'tpl/header.php'; ?>
<div class="text-left m-5">
    <h1 style="font-family:serif ">Fakebook</h1>
    <p><input class="click-btn-large" type="button" value="Add New Post" onclick="window.location = 'add_post.php';"></p>
</div>
<div class="bg-light h-100 mb-5">
    <?php if ($posts) : ?>
        <?php foreach ($posts as $post): ?>
            <ul class="list-unstyled m-5 pt-3">
                <li class="media">
                    <img class="d-flex mr-3 img-thumbnail rounded" width="60" src="images/<?= $post['avatar']; ?>" alt="Generic placeholder image">
                    <div class="media-body lead">
                        <h5 class="mt-0 mb-1"><?= htmlentities($post['title']); ?></h5>
                        <?= str_replace("\n", '<br>', htmlentities($post['article'])); ?>
                        <hr>
                        <div class="d-flex justify-content-start">
                            <div class="p-2"> <b class="post-info text-primary m-2">Written by:</b>
                                <?= htmlentities($post['first_name']); ?> <?= htmlentities($post['last_name']); ?> </div>
                            <div class="p-2"><b class="post-info text-primary m-2">On date:</b> <?= $post['date']; ?></div>
                            <?php if ($post['user_id'] == $uid) : ?>
                                <div class="ml-auto p-2"><a class="post-btn" href="update_post.php?pid=<?= $post['id']; ?>">Edit</a></div>
                                <div class="ml-2 p-2"><a class="post-btn" href="delete_post.php?pid=<?= $post['id']; ?>">Delete</a></div>
                            <?php endif; ?>
                        </div> 
                    </div>
                </li>
            </ul>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include 'tpl/footer.php'; ?>     

