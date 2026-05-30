<?php
include '../includes/db.php';
session_start();

// Check admin login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$successMessage = "";
$errorMessage = "";

// Add Product
if (isset($_POST['add_product'])) {

    $name = trim($_POST['name']);
    $price = trim($_POST['price']);
    $description = trim($_POST['description']);

    // Image Upload
    $image = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];

    // Create unique image name
    $imageExtension = pathinfo($image, PATHINFO_EXTENSION);
    $newImageName = time() . "_" . rand(1000,9999) . "." . $imageExtension;

    // Upload path
    $uploadPath = "../images/" . $newImageName;

    // Allowed image types
    $allowedTypes = ['jpg', 'jpeg', 'png', 'webp'];

    if (in_array(strtolower($imageExtension), $allowedTypes)) {

        if (move_uploaded_file($tmp_name, $uploadPath)) {

            // Insert product into database
            $stmt = $conn->prepare("
                INSERT INTO products(name, price, description, image)
                VALUES (?, ?, ?, ?)
            ");

            $stmt->execute([
                $name,
                $price,
                $description,
                $newImageName
            ]);

            $successMessage = "✅ Product Added Successfully!";

        } else {
            $errorMessage = "❌ Failed to upload image.";
        }

    } else {
        $errorMessage = "❌ Only JPG, PNG, JPEG, WEBP images are allowed.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Add Product</title>

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
            background:linear-gradient(135deg,#1e3c72,#2a5298);
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            padding:40px 20px;
        }

        .container{
            width:100%;
            max-width:700px;
            background:#fff;
            border-radius:20px;
            padding:40px;
            box-shadow:0 15px 40px rgba(0,0,0,0.2);
        }

        .title{
            text-align:center;
            margin-bottom:30px;
        }

        .title h2{
            font-size:36px;
            color:#1e3c72;
        }

        .title p{
            color:#666;
            margin-top:8px;
        }

        form{
            display:flex;
            flex-direction:column;
            gap:20px;
        }

        .input-group{
            display:flex;
            flex-direction:column;
        }

        label{
            margin-bottom:8px;
            font-weight:600;
            color:#444;
        }

        input,
        textarea{
            padding:14px;
            border:1px solid #ccc;
            border-radius:10px;
            font-size:15px;
            transition:0.3s;
        }

        input:focus,
        textarea:focus{
            border-color:#2a5298;
            outline:none;
            box-shadow:0 0 8px rgba(42,82,152,0.2);
        }

        textarea{
            resize:none;
            height:120px;
        }

        input[type="file"]{
            padding:10px;
            background:#f9f9f9;
        }

        .image-preview{
            width:100%;
            height:250px;
            border-radius:12px;
            object-fit:cover;
            border:2px dashed #ccc;
            display:none;
        }

        .submit-btn{
            background:linear-gradient(135deg,#ff9800,#ff5722);
            color:#fff;
            border:none;
            padding:16px;
            border-radius:12px;
            font-size:17px;
            font-weight:600;
            cursor:pointer;
            transition:0.3s;
        }

        .submit-btn:hover{
            transform:translateY(-3px);
            box-shadow:0 10px 20px rgba(0,0,0,0.15);
        }

        .message{
            margin-top:20px;
            padding:15px;
            border-radius:10px;
            text-align:center;
            font-weight:600;
        }

        .success{
            background:#e7f9ed;
            color:#1c7c3c;
        }

        .error{
            background:#ffe5e5;
            color:#c0392b;
        }

        .back-link{
            margin-top:25px;
            text-align:center;
        }

        .back-link a{
            text-decoration:none;
            color:#2a5298;
            font-weight:600;
            transition:0.3s;
        }

        .back-link a:hover{
            color:#ff5722;
        }

        @media(max-width:768px){

            .container{
                padding:25px;
            }

            .title h2{
                font-size:28px;
            }

        }

    </style>
</head>

<body>

<div class="container">

    <div class="title">
        <h2><i class="fa-solid fa-plus"></i> Add New Product</h2>
        <p>Add beautiful products to your online store</p>
    </div>

    <form method="POST" enctype="multipart/form-data">

        <div class="input-group">
            <label>Product Name</label>
            <input type="text"
                   name="name"
                   placeholder="Enter product name"
                   required>
        </div>

        <div class="input-group">
            <label>Price ($)</label>
            <input type="number"
                   step="0.01"
                   name="price"
                   placeholder="Enter product price"
                   required>
        </div>

        <div class="input-group">
            <label>Description</label>
            <textarea name="description"
                      placeholder="Write product description..."
                      required></textarea>
        </div>

        <div class="input-group">
            <label>Upload Product Image</label>
            <input type="file"
                   name="image"
                   id="imageInput"
                   accept="image/*"
                   required>

            <!-- Image Preview -->
            <img id="previewImage"
                 class="image-preview">
        </div>

        <button type="submit"
                name="add_product"
                class="submit-btn">

            <i class="fa-solid fa-upload"></i>
            Add Product

        </button>

    </form>

    <!-- Success Message -->
    <?php if(!empty($successMessage)) : ?>

        <div class="message success">
            <?= $successMessage; ?>
        </div>

    <?php endif; ?>

    <!-- Error Message -->
    <?php if(!empty($errorMessage)) : ?>

        <div class="message error">
            <?= $errorMessage; ?>
        </div>

    <?php endif; ?>

    <div class="back-link">
        <a href="manage_products.php">
            <i class="fa-solid fa-arrow-left"></i>
            Back to Manage Products
        </a>
    </div>

</div>

<!-- Image Preview Script -->
<script>

    const imageInput = document.getElementById('imageInput');
    const previewImage = document.getElementById('previewImage');

    imageInput.addEventListener('change', function(){

        const file = this.files[0];

        if(file){

            const reader = new FileReader();

            reader.onload = function(e){

                previewImage.src = e.target.result;
                previewImage.style.display = "block";

            }

            reader.readAsDataURL(file);

        }

    });

</script>

</body>
</html>