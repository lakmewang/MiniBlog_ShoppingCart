<?php
include '../includes/db.php';
session_start();

// Fetch all blog posts with their authors
$stmt = $pdo->prepare("
    SELECT posts.*, users.name AS author 
    FROM posts 
    JOIN users ON posts.user_id = users.id 
    ORDER BY posts.created_at DESC
");
$stmt->execute();
$posts = $stmt->fetchAll();
?>

<?php include '../includes/header.php'; ?>
<h2 class="text-center mb-4">All Blog Posts</h2>

<!-- Create Post Button for Logged-in Users -->
<?php if (isset($_SESSION['user_id'])): ?>
    <div class="mb-4 text-end">
        <!-- Button with Yellow Color -->
        <a href="create.php" class="btn" style="background-color:#800000; color: #fff;">Create New Post</a>
    </div>
<?php endif; ?>

<?php if (!empty($posts)): ?>
    <div class="row">
        <?php foreach ($posts as $post): ?>
            <div class="col-md-6 mb-4">
                <div class="card shadow">
                    <div class="card-body">
                        <!-- Increase Font Size for the Title -->
                        <h5 class="card-title" style="font-size: 1.8rem;"><?= htmlspecialchars($post['title']) ?></h5>
                        <!-- Decrease Font Size for the Card Subtitle -->
                        <h6 class="card-subtitle mb-2 text-muted" style="font-size: 0.9rem;">
                            By <?= htmlspecialchars($post['author']) ?> on <?= $post['created_at'] ?>
                        </h6>
                        <p class="card-text"><?= nl2br(htmlspecialchars(substr($post['content'], 0, 100))) ?>...</p>
                        <div class="d-flex justify-content-between">
                            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $post['user_id']): ?>
                                <a href="edit.php?id=<?= $post['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="delete.php?id=<?= $post['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                            <?php endif; ?>
                            <a href="view.php?id=<?= $post['id'] ?>" class="btn btn-sm" style="background-color: #800000; color: white;">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="alert alert-info text-center">No blog posts found. Be the first to create one!</div>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>
