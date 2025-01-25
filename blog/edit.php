<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$post_id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ? AND user_id = ?");
$stmt->execute([$post_id, $_SESSION['user_id']]);
$post = $stmt->fetch();

if (!$post) {
    echo "Post not found.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $stmt = $pdo->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ? AND user_id = ?");
    $stmt->execute([$title, $content, $post_id, $_SESSION['user_id']]);
    header("Location: index.php");
    exit();
}
?>

<?php include '../includes/header.php'; ?>
<h2>Edit Blog Post</h2>
<form method="POST">
    <div class="form-group">
        <label>Title</label>
        <input type="text" name="title" class="form-control" value="<?= $post['title'] ?>" required>
    </div>
    <div class="form-group">
        <label>Content</label>
        <textarea name="content" class="form-control" rows="5" required><?= $post['content'] ?></textarea>
    </div>
    <button type="submit" class="btn" style="background-color: #800000; color: #fff;">Update</button>

</form>
<?php include '../includes/footer.php'; ?>
