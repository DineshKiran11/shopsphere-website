<?php
session_start();
include 'includes/db.php';

// Fetch products from database
$stmt = $conn->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopSphere - Online Store</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Poppins',sans-serif;
        }

        body{
            background:#f5f7fb;
        }

        /* HEADER */

        header{
            background:linear-gradient(135deg,#1e3c72,#2a5298);
            padding:18px 8%;
            position:sticky;
            top:0;
            z-index:1000;
            box-shadow:0 4px 10px rgba(0,0,0,0.15);
        }

        .header-container{
            display:flex;
            justify-content:space-between;
            align-items:center;
            flex-wrap:wrap;
        }

        .logo{
            color:#fff;
            font-size:32px;
            font-weight:700;
        }

        nav{
            display:flex;
            gap:15px;
            align-items:center;
        }

        nav a{
            color:#fff;
            text-decoration:none;
            padding:10px 15px;
            border-radius:8px;
            transition:0.3s;
            font-weight:500;
        }

        nav a:hover{
            background:rgba(255,255,255,0.15);
        }

        .logout-button{
            background:#ff4d4d;
            border:none;
            color:#fff;
            padding:10px 18px;
            border-radius:8px;
            cursor:pointer;
            font-weight:600;
        }

        /* HERO */

        .hero{
            height:420px;
            background:
            linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)),
            url('https://images.unsplash.com/photo-1523381210434-271e8be1f52b?q=80&w=1600&auto=format&fit=crop');

            background-size:cover;
            background-position:center;

            display:flex;
            justify-content:center;
            align-items:center;
            text-align:center;
            color:#fff;
        }

        .hero-content h1{
            font-size:55px;
            margin-bottom:15px;
        }

        .hero-content p{
            font-size:20px;
            margin-bottom:25px;
        }

        .shop-btn{
            background:#ff9800;
            color:#fff;
            text-decoration:none;
            padding:14px 28px;
            border-radius:30px;
            font-size:18px;
            font-weight:600;
            transition:0.3s;
        }

        .shop-btn:hover{
            background:#ff5722;
        }

        /* MAIN */

        .main-container{
            width:90%;
            margin:auto;
            padding:60px 0;
        }

        .section-title{
            text-align:center;
            font-size:38px;
            color:#1e3c72;
            margin-bottom:50px;
        }

        .section-title::after{
            content:'';
            width:100px;
            height:4px;
            background:#ff9800;
            display:block;
            margin:12px auto;
            border-radius:10px;
        }

        /* PRODUCTS */

        .product-list{
            display:flex;
            justify-content:center;
            align-items:center;
            flex-wrap:wrap;
            gap:35px;
        }

        .product{
            width:320px;
            background:#fff;
            border-radius:20px;
            overflow:hidden;
            box-shadow:0 8px 25px rgba(0,0,0,0.1);
            transition:0.4s;
            text-align:center;
            padding-bottom:20px;
        }

        .product:hover{
            transform:translateY(-10px);
            box-shadow:0 15px 35px rgba(0,0,0,0.2);
        }

        .product-image{
            width:100%;
            height:260px;
            object-fit:cover;
            background:#f4f4f4;
        }

        .product-content{
            padding:20px;
        }

        .product h3{
            font-size:24px;
            color:#1e3c72;
            margin-bottom:10px;
        }

        .price{
            color:#ff5722;
            font-size:26px;
            font-weight:700;
            margin-bottom:12px;
        }

        .description{
            color:#666;
            font-size:15px;
            line-height:1.6;
            margin-bottom:20px;
            min-height:50px;
        }

        .add-to-cart-button{
            width:85%;
            padding:14px;
            border:none;
            border-radius:10px;
            background:linear-gradient(135deg,#ff9800,#ff5722);
            color:#fff;
            font-size:16px;
            font-weight:600;
            cursor:pointer;
            transition:0.3s;
        }

        .add-to-cart-button:hover{
            transform:scale(1.03);
        }

        /* FOOTER */

        footer{
            background:#1e3c72;
            color:#fff;
            text-align:center;
            padding:22px;
            margin-top:50px;
        }

        /* RESPONSIVE */

        @media(max-width:768px){

            .hero-content h1{
                font-size:38px;
            }

            nav{
                margin-top:15px;
                flex-wrap:wrap;
                justify-content:center;
            }

        }

    </style>

</head>

<body>

<!-- HEADER -->

<header>

    <div class="header-container">

        <div class="logo">
            <i class="fa-solid fa-bag-shopping"></i>
            ShopSphere
        </div>

        <nav>

            <a href="index.php">
                <i class="fa-solid fa-house"></i>
                Home
            </a>

            <a href="pages/login.php">
                <i class="fa-solid fa-right-to-bracket"></i>
                Login
            </a>

            <a href="pages/register.php">
                <i class="fa-solid fa-user-plus"></i>
                Register
            </a>

            <a href="pages/cart.php">
                <i class="fa-solid fa-cart-shopping"></i>
                Cart
            </a>

            <form method="POST">

                <button type="submit"
                        name="logout"
                        class="logout-button">

                    Logout

                </button>

            </form>

        </nav>

    </div>

</header>

<!-- HERO -->

<section class="hero">

    <div class="hero-content">

        <h1>Discover Amazing Products</h1>

        <p>
            Best Quality • Best Prices • Fast Delivery
        </p>

        <a href="#products" class="shop-btn">
            Shop Now
        </a>

    </div>

</section>

<!-- PRODUCTS -->

<div class="main-container">

    <h2 class="section-title" id="products">
        Featured Products
    </h2>

    <div class="product-list">

        <?php if(empty($products)) : ?>

            <p>No products available.</p>

        <?php else : ?>

            <?php foreach($products as $product) : ?>

                <div class="product">

                    <?php if(!empty($product['image'])) : ?>

                        <img src="images/<?= htmlspecialchars($product['image']); ?>"
                             alt="<?= htmlspecialchars($product['name']); ?>"
                             class="product-image">

                    <?php else : ?>

                        <img src="https://via.placeholder.com/320x260"
                             class="product-image">

                    <?php endif; ?>

                    <div class="product-content">

                        <h3>
                            <?= htmlspecialchars($product['name']); ?>
                        </h3>

                        <div class="price">
                            $<?= number_format($product['price'],2); ?>
                        </div>

                        <p class="description">
                            <?= htmlspecialchars($product['description']); ?>
                        </p>

                        <form method="POST"
                              action="pages/cart.php">

                            <input type="hidden"
                                   name="product_id"
                                   value="<?= $product['id']; ?>">

                            <button type="submit"
                                    name="add_to_cart"
                                    class="add-to-cart-button">

                                <i class="fa-solid fa-cart-plus"></i>
                                Add to Cart

                            </button>

                        </form>

                    </div>

                </div>

            <?php endforeach; ?>

        <?php endif; ?>

    </div>

</div>

<!-- FOOTER -->

<footer>

    <p>
        © <?= date('Y'); ?> ShopSphere.
        All Rights Reserved.
    </p>

</footer>

</body>
</html>