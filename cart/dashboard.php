<?php
require 'config.php';
require 'functions.php';
redirect_if_not_logged_in();

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll();
?>

<h2>My Orders</h2>
<table border="1">
    <tr>
        <th>Order ID</th>
        <th>Total Price</th>
        <th>Date</th>
        <th>Details</th>
    </tr>
    <?php foreach ($orders as $order): ?>
        <tr>
            <td><?= $order['id']; ?></td>
            <td>$<?= number_format($order['total_price'], 2); ?></td>
            <td><?= $order['created_at']; ?></td>
            <td><a href="cart/summary.php?order_id=<?= $order['id']; ?>">View</a></td>
        </tr>
    <?php endforeach; ?>
</table>

<a href="logout.php">Logout</a>
