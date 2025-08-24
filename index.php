<?php 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sweet cravings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Satisfy&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
    <style>
        /* Your existing CSS here unchanged */
        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5e1da;
        }

        .card {
            background-color: #ffffff;
            color: #000;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Hero Carousel Custom Styling */
        #heroCarousel .carousel-inner img {
            height: 90vh;
        }

        .carousel-caption h1 {
            font-family: 'Pacifico', cursive;
            font-size: 3rem;
            color: #fff8f2;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.6);
        }

        .carousel-caption h3 {
            font-family: 'Playfair Display', serif;
            font-weight: 400;
            color: #ffecd2;
            font-size: 1.5rem;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.4);
            margin-bottom: 1rem;
        }

        /* Order Now Button */
        .carousel-caption .btn-warning {
            background-color: #ffc107;
            border: none;
            color: #4e342e;
            font-weight: 600;
            padding: 12px 30px;
            font-size: 1.1rem;
            border-radius: 30px;
            box-shadow: 0 4px 15px rgba(255, 193, 7, 0.4);
        }

        .carousel-caption .btn-warning:hover {
            background-color: #e0a800;
        }

        .product-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
            height: 100%;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .btn-outline-danger {
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .btn-outline-danger:hover {
            background-color: #d63333;
            color: #fff;
            border-color: #d63333;
        }

        .product-card img {
            height: 200px;
            object-fit: cover;
            border-radius: 4px;
        }

        footer {
            background-color: #f7efe3;
            padding: 30px 0;
            text-align: center;
        }

        .navbar {
            background-color: #3d342a !important;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
        }

        .navbar.scrolled {
            background-color: #2b241d !important;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
        }

        .navbar-nav .nav-link {
            color: #F5F0E1 !important;
        }

        .navbar-nav .nav-link:hover {
            background-color: #3C2F20;
            border-radius: 5px;
            color: #ffffff !important;
        }

        .navbar-brand {
            font-family: 'Satisfy', cursive;
            font-size: 1.9rem;
            color: white;
        }

        .navbar-brand img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #fff;
        }

        /* Cart sidebar styles */
        #cartSidebar {
            position: fixed;
            right: 0;
            top: 56px;
            /* below navbar */
            width: 320px;
            height: calc(100% - 56px);
            background: #fff;
            box-shadow: -3px 0 10px rgba(0, 0, 0, 0.2);
            overflow-y: auto;
            padding: 15px;
            z-index: 1050;
            transform: translateX(100%);
            transition: transform 0.3s ease-in-out;
        }

        #cartSidebar.open {
            transform: translateX(0);
        }

        #cartSidebar h5 {
            margin-bottom: 15px;
            font-weight: 700;
        }

        #cartSidebar .cart-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            border-bottom: 1px solid #eee;
            padding-bottom: 8px;
        }

        #cartToggleBtn {
            position: fixed;
            top: 70px;
            right: 340px;
            background: #ffc107;
            border: none;
            padding: 8px 12px;
            border-radius: 30px;
            cursor: pointer;
            font-weight: 600;
            color: #4e342e;
            box-shadow: 0 4px 15px rgba(255, 193, 7, 0.4);
            z-index: 1100;
        }

        #cartToggleBtn:hover {
            background-color: #e0a800;
        }

        .footer-link {
            color: black !important;
        }

        .footer-link:hover {
            color:red !important;
            /* subtle darker shade on hover */
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <img src="images/logo.jpg" alt="Bakery Logo" width="30" height="30" class="me-2">
                Sweet Cravings
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="product.html">Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="cart.php">Cart</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.html">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>


    <!-- Hero Section -->
    <section id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="4000">
        <div class="carousel-inner">
            <!-- (carousel items unchanged) -->
            <div class="carousel-item active">
                <img src="images/image1.jpg"
                    class="d-block w-100" style="height: 90vh; object-fit: cover;" alt="Slide 1">
                <div class="carousel-caption d-flex flex-column justify-content-center align-items-center h-100">
                    <h1 class="display-4 fw-bold">Sweet Cravings.</h1>
                    <h3>Smell The Sweetness!!</h3>
                    <a href="product.html" class="btn btn-warning btn-lg mt-3">Order Now</a>
                </div>
            </div>
            <!-- other slides unchanged... -->
            <div class="carousel-item">
                <img src="images/image2.jpg"
                    class="d-block w-100" style="height: 90vh; object-fit: cover;" alt="Slide 2">
                <div class="carousel-caption d-flex flex-column justify-content-center align-items-center h-100">
                    <h1 class="display-4 fw-bold">Best Taste</h1>
                    <h3>Feel The Taste you Love.</h3>
                    <a href="product.html" class="btn btn-warning btn-lg mt-3">Order Now</a>
                </div>
            </div>
            <div class="carousel-item">
                <img src="images/image3.jpg"
                    class="d-block w-100" style="height: 90vh; object-fit: cover;" alt="Slide 3">
                <div class="carousel-caption d-flex flex-column justify-content-center align-items-center h-100">
                    <h1 class="display-4 fw-bold">Taste The joy.</h1>
                    <h3>Sweet Taste For Sweet Life.</h3>
                    <a href="product.html" class="btn btn-warning btn-lg mt-3">Order Now</a>
                </div>
            </div>
            <div class="carousel-item">
                <img src="images/image4.jpg"
                    class="d-block w-100" style="height: 90vh; object-fit: cover;" alt="Slide 3">
                <div class="carousel-caption d-flex flex-column justify-content-center align-items-center h-100">
                    <h1 class="display-4 fw-bold">Enjoyy Lifee.</h1>
                    <h3>Eat Cake.</h3>
                    <a href="product.html" class="btn btn-warning btn-lg mt-3">Order Now</a>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </section>
    <!-- About Us Section -->
    <section class="py-5" id="about">
        <div class="container">
            <h2 class="text-center mb-4" style="font-family: 'Satisfy', cursive; font-size: 2.5rem;">About Sweet
                Cravings</h2>
            <p class="text-center mx-auto"
                style="max-width: 800px; font-family: 'Open Sans', sans-serif; font-size: 1rem; line-height: 1.6;">
                At <strong>Sweet Cravings</strong>, we believe in making every bite a memory. Our passion for baking
                brings you the finest cakes, pastries, and breads — all handcrafted with love and the freshest
                ingredients. Whether you're celebrating a milestone or just satisfying a sweet tooth, we're here to
                deliver joy one dessert at a time.
            </p>

        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <h2 class="fw-bold text-center mb-4">Featured Delights</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card product-card p-3 text-center">
                        <img src="images/bread.jpg" class="card-img-top" alt="Bread">
                        <div class="card-body">
                            <h5 class="card-title">Classic Sourdough Bread</h5>
                            <p class="card-text">Golden crust and fluffy inside — a customer favorite.</p>
                            <a href="product.html" class="btn btn-outline-danger mt-2">View Product</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card product-card p-3 text-center">
                        <img src="images/chococake.jpg" class="card-img-top" alt="Chocolate Cake">
                        <div class="card-body">
                            <h5 class="card-title">Chocolate Dream Cake</h5>
                            <p class="card-text">Rich, moist, and topped with heavenly ganache.</p>
                            <a href="product.html" class="btn btn-outline-danger mt-2">View Product</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card product-card p-3 text-center">
                        <img src="images/crossiant.jpg" class="card-img-top" alt="Croissant">
                        <div class="card-body">
                            <h5 class="card-title">Buttery Croissants</h5>
                            <p class="card-text">Crispy on the outside, soft and flaky inside.</p>
                            <a href="product.html" class="btn btn-outline-danger mt-2">View Product</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <footer class="bg-light text-center text-dark py-4">
        <div class="container">
            <p class="mb-1 fw-bold">© 2025 Sweet Cravings. All rights reserved.</p>
            <p>
                <a href="mailto:contact@sweetcravings.com"
                    class="text-decoration-none me-3 footer-link">contact@sweetcravings.com</a>
                <a href="#" class="text-decoration-none me-3 footer-link">Instagram</a>
                <a href="#" class="text-decoration-none footer-link">Facebook</a>
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <button onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
        style="position:fixed;bottom:20px;right:20px;z-index:1000;" class="btn btn-warning rounded-circle shadow">
        ↑
    </button>

</body>

</html>