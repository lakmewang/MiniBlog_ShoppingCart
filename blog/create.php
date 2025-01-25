<?php
include '../includes/db.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php'); // Redirect to login page
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $user_id = $_SESSION['user_id'];

    // Validate inputs
    if (empty($title)) {
        $error = "Title is required!";
    } elseif (empty($content)) {
        $error = "Content is required!";
    } else {
        // Insert the blog post into the database
        try {
            $stmt = $pdo->prepare("INSERT INTO posts (user_id, title, content, created_at) VALUES (?, ?, ?, NOW())");
            $stmt->execute([$user_id, $title, $content]);
            header('Location: index.php'); // Redirect to blog index
            exit;
        } catch (PDOException $e) {
            $error = "Error creating post: " . $e->getMessage();
        }
    }
}
?>

<?php include '../includes/header.php'; ?>
<div class="container mt-5">
    <h2 class="text-center mb-4">Create New Blog Post</h2>

    <!-- Error Message -->
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <!-- Create Blog Post Form -->
    <form method="POST">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="<?= htmlspecialchars($_POST['title'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea name="content" id="content" class="form-control" rows="5" required><?= htmlspecialchars($_POST['content'] ?? '') ?></textarea>
        </div>
        <div class="text-end">
            <button type="submit" class="btn" style="background-color: #800000; color: #fff;">Create Post</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </div>

    </form>
</div>
<?php include '../includes/footer.php'; ?>
