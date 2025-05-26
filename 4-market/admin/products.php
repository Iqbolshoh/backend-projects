<?php $products = include "../data/products.php"; ?>
<!DOCTYPE html>
<html lang="uz">

<head>
    <meta charset="UTF-8">
    <title>Mahsulotlar</title>
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
            overflow: hidden;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: scale(1.03);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .btn-primary {
            background: #007bff;
            border: none;
            border-radius: 10px;
        }

        .btn-primary:hover {
            background: #0056b3;
        }

        .btn-outline-warning,
        .btn-outline-danger {
            border-radius: 10px;
        }

        .btn-outline-warning:hover {
            background: #ffc107;
            color: white;
        }

        .btn-outline-danger:hover {
            background: #dc3545;
            color: white;
        }

        .btn-group {
            gap: 0.5rem;
        }

        .container {
            max-width: 1200px;
        }

        h1 {
            font-weight: 800;
            letter-spacing: 1px;
        }

        .card-title {
            font-size: 1.2rem;
        }

        .card-text {
            font-size: 0.9rem;
            line-height: 1.6;
        }

        .text-primary {
            color: #007bff !important;
        }
    </style>
</head>

<body>
    <header class="header text-center">
        <h1><i class="fas fa-box-open me-2"></i>Mahsulotlar ro'yxati</h1>
    </header>
    <div class="container py-5">
        <a href="./create.php" class="btn btn-outline-primary mb-4 rounded-pill"><i class="fas fa-plus me-2"></i>Yangi
            mahsulot</a>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php foreach ($products as $index => $product): ?>
                <div class="col">
                    <div class="card h-100">
                        <img src="../src/images/product-image/<?= $product['image'] ?>" class="card-img-top" alt="<?= $product['name'] ?>">
                        <div class="card-body">
                            <h5 class="card-title fw-bold"><?= $product['name'] ?></h5>
                            <p class="card-text text-muted"><?= $product['description'] ?></p>
                            <p class="text-primary fw-bold mb-3"><?= $product['price'] ?> so'm</p>
                            <div class="btn-group d-flex">
                                <a href="product-details.php?id=<?= $index ?>" class="btn btn-primary btn-sm flex-grow-1"><i
                                        class="fas fa-eye me-2"></i>Batafsil</a>
                                <a href="edit-product.php?id=<?= $index ?>" class="btn btn-outline-warning btn-sm"><i
                                        class="fas fa-edit"></i></a>
                                <a href="delete-product.php?id=<?= $index ?>" class="btn btn-outline-danger btn-sm"
                                    onclick="return confirm('Aniq o‘chirasizmi?');">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>