<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $price = $_POST['price'] ?? '';
    $description = $_POST['description'] ?? '';
    $imagePath = '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $tmpName = $_FILES['image']['tmp_name'];

        $uploadDir = '../src/images/product-image/';
        $imageName = uniqid('product_') . '_' . md5(time() . rand()) . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $fullPath = $uploadDir . $imageName;

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        if (move_uploaded_file($tmpName, $fullPath)) {
            $imagePath = $imageName;
        } else {
            die("Rasmni saqlashda xato yuz berdi!");
        }
    } else {
        die("Rasm tanlanmadi yoki xato yuz berdi.");
    }

    $new_entry = [
        'name' => $name,
        'price' => $price,
        'description' => $description,
        'image' => $imagePath,
    ];

    $file_path = "../data/products.php";
    $old_data = [];

    if (file_exists($file_path)) {
        $old_data = include($file_path);
        if (!is_array($old_data)) {
            $old_data = [];
        }
    }

    $old_data[] = $new_entry;

    $new_content = "<?php\nreturn " . var_export($old_data, true) . ";\n";
    file_put_contents($file_path, $new_content);

    header("Location: ./products.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="uz">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mahsulot qo'shish</title>
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

        .btn-outline-primary {
            border-radius: 10px;
        }

        .btn-outline-primary:hover {
            background: #007bff;
            color: white;
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
    </style>
</head>

<body>
    <header class="header text-center">
        <h1><i class="fas fa-box-open me-2"></i>Mahsulot qo'shish</h1>
    </header>
    <div class="container py-5">
        <div class="card">
            <div class="card-body">
                <h2 class="text-center mb-4"><i class="fas fa-plus-circle me-2"></i>Yangi mahsulot</h2>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="name" class="form-label"><i class="fas fa-box me-2"></i>Mahsulot nomi:</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label"><i class="fas fa-money-bill me-2"></i>Narxi:</label>
                        <input type="number" class="form-control" id="price" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label"><i
                                class="fas fa-align-left me-2"></i>Tavsifi:</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label"><i class="fas fa-image me-2"></i>Rasm:</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100"><i
                            class="fas fa-check me-2"></i>Qo'shish</button>
                </form>
                <div class="mt-3 text-center">
                    <a href="./" class="btn btn-outline-primary"><i class="fas fa-home me-2"></i>Bosh sahifa</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>