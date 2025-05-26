<?php
$products = include "data.php";

$id = $_GET['id'] ?? null;

if (!isset($products[$id])) {
    echo "Mahsulot topilmadi!";
    exit;
}

$product = $products[$id];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imageFile = $_FILES['image'] ?? null;
    $imagePath = $product['image'];

    if ($imageFile && $imageFile['error'] === UPLOAD_ERR_OK) {
        if (file_exists($imagePath)) {
            unlink($imagePath);  // Old imageni o'chirish
        }

        $uploadDir = 'product-image/';
        $newImageName = uniqid('product_') . md5(time() . rand()) . '.' . pathinfo($imageFile['name'], PATHINFO_EXTENSION);
        $imagePath = $uploadDir . $newImageName;

        if (!move_uploaded_file($imageFile['tmp_name'], $imagePath)) {
            echo "Yangi rasmni yuklashda xato yuz berdi.";
        }
    }

    // Mahsulotni yangilash
    $products[$id]['name'] = $_POST['name'];
    $products[$id]['description'] = $_POST['description'];
    $products[$id]['price'] = $_POST['price'];
    $products[$id]['image'] = $imagePath;

    // Yangi ma'lumotlarni faylga saqlash
    file_put_contents('data.php', '<?php return ' . var_export($products, true) . ';');

    header("Location: ./");
    exit;
}
?>

<!DOCTYPE html>
<html lang="uz">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mahsulotni tahrirlash</title>
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

        .form-control,
        .form-select {
            border-radius: 10px;
        }

        .btn-success {
            background: #28a745;
            border: none;
            border-radius: 10px;
            padding: 10px;
        }

        .btn-success:hover {
            background: #218838;
        }

        .btn-danger {
            border-radius: 10px;
            padding: 10px;
        }

        .btn-danger:hover {
            background: #c82333;
        }

        .container {
            max-width: 600px;
        }

        h2 {
            font-weight: 800;
            letter-spacing: 1px;
        }

        label {
            font-weight: 600;
        }

        .img-preview {
            max-width: 200px;
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <header class="header text-center">
        <h1><i class="fas fa-box-open me-2"></i>Mahsulotni tahrirlash</h1>
    </header>
    <div class="container py-5">
        <div class="card">
            <div class="card-body">
                <h2 class="text-center mb-4"><i class="fas fa-edit me-2"></i>Tahrirlash formasi</h2>
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="name" class="form-label"><i class="fas fa-box me-2"></i>Mahsulot nomi</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="<?= htmlspecialchars($product['name']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label"><i class="fas fa-align-left me-2"></i>Tavsif</label>
                        <textarea class="form-control" id="description" name="description" rows="4"
                            required><?= htmlspecialchars($product['description']) ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label"><i class="fas fa-money-bill me-2"></i>Narxi</label>
                        <input type="number" class="form-control" id="price" name="price"
                            value="<?= $product['price'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label"><i class="fas fa-image me-2"></i>Yangi rasm
                            yuklash</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        <div class="mt-2">
                            <img src="<?= $product['image'] ?>" alt="<?= htmlspecialchars($product['name']) ?>"
                                class="img-preview img-fluid">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success w-100"><i
                            class="fas fa-check me-2"></i>Yangilash</button>
                </form>
                <div class="mt-3 text-center">
                    <a href="delete_product.php?id=<?= $id ?>" class="btn btn-danger w-100"
                        onclick="return confirm('Mahsulotni o\'chirmoqchimisiz? Ushbu amal qaytarib bo\'lmaydi!');"><i
                            class="fas fa-trash me-2"></i>Mahsulotni o'chirish</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>