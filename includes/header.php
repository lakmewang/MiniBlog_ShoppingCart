<?php @session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <title>Mini Blog & Shopping Cart</title>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            background: linear-gradient(135deg,rgb(179, 179, 180),rgb(71, 71, 71));
        }
        .navbar-brand {
        font-weight: bold;
        color:rgb(255, 255, 255) !important; /* Maroon color */
        font-size: 1.8rem;
        }
        .navbar-nav .nav-link {
            color: #fff !important;
            font-size: 1.1rem;
            transition: 0.3s;
        }
        .navbar-nav .nav-link:hover {
            color: #ffd700 !important;
        }
        .hero {
            background: url('https://source.unsplash.com/1600x600/?shopping,blog') no-repeat center center/cover;
            color: #fff;
            padding: 5rem 0;
            text-align: center;
        }
        .hero h1 {
            font-size: 3rem;
            font-weight: bold;
        }
        .hero p {
            font-size: 1.4rem;
            max-width: 700px;
            margin: auto;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="/mini-blog-cart/"><i class="bi bi-shop"></i> Mini Blog & Cart</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item"><a class="nav-link" href="/mini-blog-cart/blog/index.php"><i class="bi bi-journal-text"></i> Blog</a></li>
                    <li class="nav-item"><a class="nav-link" href="/mini-blog-cart/products/index.php"><i class="bi bi-basket"></i> Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="/mini-blog-cart/cart/view.php"><i class="bi bi-cart"></i> Cart</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i> Account
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item text-danger" href="/mini-blog-cart/auth/logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="/mini-blog-cart/auth/login.php"><i class="bi bi-box-arrow-in-right"></i> Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="/mini-blog-cart/auth/register.php"><i class="bi bi-person-plus"></i> Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>



<div class="container mt-4">
