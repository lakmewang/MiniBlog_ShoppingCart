<?php
// Include database connection
include '../includes/db.php';

// Get the post ID from the URL
$post_id = $_GET['id'];

// Fetch the post from the database
$stmt = $pdo->prepare("SELECT posts.*, users.name AS author FROM posts JOIN users ON posts.user_id = users.id WHERE posts.id = :id");
$stmt->execute([':id' => $post_id]);
$post = $stmt->fetch();

if (!$post) {
    echo "Post not found.";
    exit;
}
?>

<?php include '../includes/header.php'; ?>

<div class="container mt-5">
    <!-- Post Card -->
    <div class="card shadow-lg rounded">
        <div class="card-body">
            <!-- Post Title with updated style (black and bold) -->
            <h2 class="card-title text-center text-dark font-weight-bold"><?= htmlspecialchars($post['title']) ?></h2>

            <!-- Post Author and Date -->
            <p class="text-center text-muted">
                <small>By <strong><?= htmlspecialchars($post['author']) ?></strong> on <?= date('F j, Y', strtotime($post['created_at'])) ?></small>
            </p>

            <!-- Post Content -->
            <div class="content mt-4">
                <p class="lead"><?= nl2br(htmlspecialchars($post['content'])) ?></p>
            </div>
        </div>
    </div>

    <!-- Back to Posts Button -->
    <div class="text-center mt-4">
        <a href="/mini-blog-cart/blog/index.php" class="btn btn-lg" style="background-color: #800000; color: #fff;">
            <i class="bi bi-arrow-left-circle"></i> Back to Posts
        </a>
    </div>

</div>

<?php include '../includes/footer.php'; ?>
