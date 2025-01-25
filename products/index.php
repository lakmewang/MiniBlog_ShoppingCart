<?php
include '../includes/db.php';
session_start();

// Fetch products based on search query
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$query = "SELECT * FROM products";
$params = [];

if (!empty($search)) {
    $query .= " WHERE name LIKE :search";
    $params[':search'] = "%$search%";
}

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$products = $stmt->fetchAll();
?>

<?php include '../includes/header.php'; ?>
<div class="container">
    <h2 class="text-center mb-4">Our Products</h2>

    <!-- Search Form -->
    <form method="GET" action="" class="mb-4">
    <div class="input-group">
        <input type="text" name="search" class="form-control" placeholder="Search products..." value="<?= htmlspecialchars($search) ?>">
        <button type="submit" class="btn btn-warning text-dark">Search</button>
    </div>
</form>


    <?php if (!empty($products)): ?>
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow h-100">
                        <img src="../assets/images/<?= $product['image'] ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']) ?>" style="height: 200px; object-fit: cover;">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                            <p class="card-text text-muted">LKR <?= number_format($product['price'], 2) ?></p>
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <form action="../cart/add.php" method="POST">
                                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                    <button type="submit" class="btn" style="background-color: #800000; color: #fff;">Add to Cart</button>
                                </form>

                            <?php else: ?>
                                <p class="text-danger">Login to add to cart</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">No products found for "<?= htmlspecialchars($search) ?>".</div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
