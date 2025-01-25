<?php include './includes/header.php'; ?>
<div class="jumbotron text-center py-5" style="background-image: url('assets/images/image1.jpg'); background-size: cover; background-position: center; color: white;">
    <h1 class="display-4" style="color: black; font-weight: bold;">Welcome to Mini Blog & Shopping Cart</h1>
    <p class="lead" style="font-weight: bold;">Create blog posts, shop for products, and manage your cart — all in one place.</p>
    <hr class="my-4">
    <a class="btn btn-warning btn-lg text-dark" href="auth/login.php" role="button">Login</a>
    <a class="btn btn-lg" href="auth/register.php" role="button" style="background-color: #800000; color: #fff;">Register</a>
</div>



<div class="row text-center mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body" style="background-color:rgba(128, 0, 0, 0.45); color: black;">
                <h3 class="card-title">Latest Blog Posts</h3>
                <p class="card-text">Read and share your thoughts with the world.</p>
                <a href="blog/index.php" class="btn btn-warning text-dark btn-lg">View Blog Posts</a>

            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-body" style="background-color:rgba(255, 238, 5, 0.48); color: black;">
                <h3 class="card-title">Shop Products</h3>
                <p class="card-text">Browse our selection and start shopping today.</p>
                <a href="products/index.php" class="btn btn-lg" style="background-color: #800000; color: #fff;">Browse Products</a>
            </div>
        </div>
    </div>
</div>

<?php include './includes/footer.php'; ?>
