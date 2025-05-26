<?php
$products = include "../data/products.php";

$id = $_GET['id'] ?? null;

if (!isset($products[$id])) {
    echo "Mahsulot topilmadi!";
    exit;
}

$product = $products[$id];
?>
<!DOCTYPE html>
<html lang="uz">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mahsulot tafsilotlari</title>
    <link rel="icon" type="image/x-icon" href="https://iqbolshoh.uz/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        .header {
            background: linear-gradient(90deg, #007bff, #0056b3);
            color: white;
            padding: 3rem 0;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .card:hover {
            transform: scale(1.02);
        }

        .card-img-top {
            height: 300px;
            object-fit: cover;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }

        .btn-success {
            background: #28a745;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
        }

        .btn-success:hover {
            background: #218838;
        }

        .container {
            max-width: 600px;
        }

        h1 {
            font-weight: 800;
            letter-spacing: 1px;
        }

        .card-title {
            font-size: 1.5rem;
        }

        .card-text {
            font-size: 1rem;
            line-height: 1.6;
        }

        .text-primary {
            color: #007bff !important;
        }
    </style>
</head>

<body>
    <header class="header text-center">
        <h1><i class="fas fa-box-open me-2"></i>Mahsulot tafsilotlari</h1>
    </header>
    <div class="container py-5">
        <div class="card">
            <img src="../src/images/product-image/<?= $product['image'] ?>" alt="<?= $product['name'] ?>" class="card-img-top">
            <div class="card-body text-center">
                <h1 class="card-title"><?= $product['name'] ?></h1>
                <p class="card-text text-muted"><?= $product['description'] ?></p>
                <p class="h5 text-primary fw-bold"><?= $product['price'] ?> so'm</p>
                <a href="./products.php" class="btn btn-success mt-3"><i class="fas fa-arrow-left me-2"></i>Ortga
                    qaytish</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>