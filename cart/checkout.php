<?php
require '../config.php';  // Include the database configuration

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch cart items for the logged-in user
$stmt = $pdo->prepare("SELECT p.id, p.name, p.price, c.quantity 
                      FROM cart c 
                      JOIN products p ON c.product_id = p.id 
                      WHERE c.user_id = ?");
$stmt->execute([$user_id]);
$items = $stmt->fetchAll();

// Calculate total price
$total_price = 0;
foreach ($items as $item) {
    $total_price += $item['price'] * $item['quantity'];
}

// Handle checkout process
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pdo->beginTransaction();
    
    // Insert new order record
    $stmt = $pdo->prepare("INSERT INTO orders (user_id, total_price) VALUES (?, ?)");
    $stmt->execute([$user_id, $total_price]);
    $order_id = $pdo->lastInsertId();

    // Insert items into order_items table
    $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    foreach ($items as $item) {
        $stmt->execute([$order_id, $item['id'], $item['quantity'], $item['price']]);
    }

    // Clear the cart after checkout
    $pdo->prepare("DELETE FROM cart WHERE user_id = ?")->execute([$user_id]);

    $pdo->commit();

    // Redirect to order summary page
    header("Location: summary.php?order_id=$order_id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                <div class="card-header text-white text-center" style="background-color: #800000;">
                    <h3>Checkout</h3>
                </div>

                    <div class="card-body">
                        <h5 class="mb-4">Your Cart Summary</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price (LKR)</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($items as $item): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($item['name']); ?></td>
                                        <td><?= number_format($item['price'], 2); ?></td>
                                        <td><?= $item['quantity']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <p class="text-end fw-bold">Total Price: LKR <?= number_format($total_price, 2); ?></p>
                        <form method="POST">
                            <button type="submit" class="btn btn-warning text-dark w-100">Place Order</button>
                        </form>

                        <div class="text-center mt-3">
                            <a href="view.php" class="btn btn-secondary">Back to Cart</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
