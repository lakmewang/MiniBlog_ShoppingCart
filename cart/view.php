<?php
include '../includes/db.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch cart items for the logged-in user
$stmt = $pdo->prepare("
    SELECT cart.id AS cart_id, products.name, products.price, cart.quantity, 
           (products.price * cart.quantity) AS total 
    FROM cart 
    JOIN products ON cart.product_id = products.id 
    WHERE cart.user_id = ?
");
$stmt->execute([$user_id]);
$cart_items = $stmt->fetchAll();

// Initialize total cost
$total_cost = 0;
foreach ($cart_items as $item) {
    $total_cost += $item['total'];
}
?>

<?php include '../includes/header.php'; ?>
<h2 class="text-center mb-4">Your Shopping Cart</h2>

<?php if (!empty($cart_items)): ?>
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cart_items as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td>LKR <?= number_format($item['price'], 2) ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td>LKR <?= number_format($item['total'], 2) ?></td>
                    <td>
                        <form action="remove.php" method="POST" style="display: inline-block;">
                            <input type="hidden" name="cart_id" value="<?= $item['cart_id'] ?>">
                            <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <h3 class="text-end">Total Cost: LKR <?= number_format($total_cost, 2) ?></h3>
    <div class="d-flex justify-content-between mt-4">
    <a href="../products/index.php" class="btn btn-secondary">Continue Shopping</a>
    <a href="checkout.php" class="btn btn-warning text-dark">Checkout</a>
</div>

<?php else: ?>
    <div class="alert alert-info text-center">Your cart is empty. Start adding products!</div>
    <div class="text-center mt-4">
        <a href="../products/index.php" class="btn btn-primary">Shop Products</a>
    </div>
<?php endif; ?>
<?php if (!empty($items)): ?>
    <a href="../products/index.php" class="btn" style="background-color: #800000; color: #fff;">Shop Products</a>
<?php else: ?>
<?php endif; ?>



<?php include '../includes/footer.php'; ?>
