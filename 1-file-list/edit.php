<?php
if (!file_exists("data.php")) {
    echo "<div class='alert alert-danger'><i class='bi bi-x-circle-fill'></i> Fayl topilmadi!</div>";
    exit;
}

$data = include("data.php");

if (!isset($_GET['username'])) {
    echo "<div class='alert alert-warning'><i class='bi bi-exclamation-triangle-fill'></i> Username ko‘rsatilmagan!</div>";
    exit;
}

$username = $_GET['username'];
$personToEdit = null;

foreach ($data as $index => $person) {
    if ($person['username'] === $username) {
        $personToEdit = $person;
        $personIndex = $index;
        break;
    }
}

if (!$personToEdit) {
    echo "<div class='alert alert-danger'><i class='bi bi-person-x-fill'></i> Foydalanuvchi topilmadi!</div>";
    exit;
}

if (isset($_GET['first_name'], $_GET['last_name'], $_GET['age'])) {
    $data[$personIndex]['first_name'] = htmlspecialchars($_GET['first_name']);
    $data[$personIndex]['last_name'] = htmlspecialchars($_GET['last_name']);
    $data[$personIndex]['age'] = (int) $_GET['age'];

    $phpCode = "<?php return " . var_export($data, true) . ";";
    file_put_contents("data.php", $phpCode);

    echo "<div class='alert alert-success'><i class='bi bi-check-circle-fill'></i> GET orqali ma'lumotlar yangilandi!</div>";

    header("Location: ./");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Tahrirlash</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="https://iqbolshoh.uz/favicon.ico">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light p-4">

    <div class="container">
        <h2 class="mb-4 text-primary"><i class="bi bi-pencil-square"></i> GET orqali tahrirlash:
            <strong><?= $personToEdit['username'] ?></strong>
        </h2>
        <form method="get" class="bg-white p-4 rounded shadow-sm">
            <input type="hidden" name="username" value="<?= $personToEdit['username'] ?>">

            <div class="mb-3">
                <label class="form-label">Ism:</label>
                <input type="text" name="first_name" value="<?= $personToEdit['first_name'] ?>" class="form-control"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">Familiya:</label>
                <input type="text" name="last_name" value="<?= $personToEdit['last_name'] ?>" class="form-control"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">Yosh:</label>
                <input type="number" name="age" value="<?= $personToEdit['age'] ?>" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success"><i class="bi bi-save2-fill"></i> Saqlash</button>
            <a href="./" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Orqaga</a>
        </form>
    </div>

</body>

</html>