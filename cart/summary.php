<?php
require '../config.php';
require '../functions.php';
redirect_if_not_logged_in();

$order_id = $_GET['order_id'];

$stmt = $pdo->prepare("SELECT users.name, orders.total_price, orders.created_at 
                      FROM orders 
                      JOIN users ON orders.user_id = users.id 
                      WHERE orders.id = ?");
$stmt->execute([$order_id]);
$order = $stmt->fetch();

$stmt = $pdo->prepare("SELECT products.name, order_items.quantity, order_items.price 
                      FROM order_items 
                      JOIN products ON order_items.product_id = products.id 
                      WHERE order_items.order_id = ?");
$stmt->execute([$order_id]);
$items = $stmt->fetchAll();
?>

<h2>Order Summary</h2>
<p>Customer: <?= htmlspecialchars($order['name']); ?></p>
<p>Total Price: $<?= number_format($order['total_price'], 2); ?></p>
<p>Order Date: <?= $order['created_at']; ?></p>

<table border="1">
    <tr>
        <th>Product</th>
        <th>Quantity</th>
        <th>Price</th>
    </tr>
    <?php foreach ($items as $item): ?>
        <tr>
            <td><?= htmlspecialchars($item['name']); ?></td>
            <td><?= $item['quantity']; ?></td>
            <td>$<?= number_format($item['price'], 2); ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<a href="../index.php">Return to Home</a>
