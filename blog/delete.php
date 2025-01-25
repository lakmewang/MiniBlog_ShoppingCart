<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$post_id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM posts WHERE id = ? AND user_id = ?");
$stmt->execute([$post_id, $_SESSION['user_id']]);
header("Location: index.php");
exit();
?>
