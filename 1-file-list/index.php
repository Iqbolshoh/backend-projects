<?php
if (!file_exists("data.php")) {
    echo "
    <script>
        Swal.fire({
            icon: 'error',
            title: '❌ Fayl mavjud emas!',
            text: 'Data fayli topilmadi.',
            showConfirmButton: true
        });
    </script>";
    exit;
}

$data = include("data.php");
?>

<!DOCTYPE html>
<html lang="uz">

<head>
    <meta charset="UTF-8">
    <title>Foydalanuvchilar ro'yxati</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="https://iqbolshoh.uz/favicon.ico">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white text-center">
                <h4><i class="bi bi-people-fill"></i> Foydalanuvchilar ro'yxati</h4>
            </div>
            <div class="card-footer text-center">
                <a href="./create.php" class="btn btn-outline-primary">
                    <i class="bi bi-person-plus-fill"></i> Foydalanuvchi yaratish
                </a>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>№</th>
                            <th>Ism</th>
                            <th>Familiya</th>
                            <th>Yosh</th>
                            <th>Username</th>
                            <th>Amallar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $index => $person): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($person['first_name']) ?></td>
                                <td><?= htmlspecialchars($person['last_name']) ?></td>
                                <td><?= htmlspecialchars($person['age']) ?></td>
                                <td><?= htmlspecialchars($person['username']) ?></td>
                                <td>
                                    <a href="edit.php?username=<?= urlencode($person['username']) ?>"
                                        class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil-square"></i> Tahrirlash
                                    </a>
                                    <a href="javascript:void(0);" class="btn btn-sm btn-danger"
                                        onclick="confirmDelete('<?= urlencode($person['username']) ?>')">
                                        <i class="bi bi-trash3-fill"></i> O‘chirish
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function confirmDelete(username) {
            Swal.fire({
                title: 'O‘chirishni tasdiqlaysizmi?',
                text: username + ' foydalanuvchisini o‘chirishni istaysizmi?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ha, o‘chirish',
                cancelButtonText: 'Yo‘q, bekor qilish',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'delete.php?username=' + username;
                }
            });
        }
    </script>
</body>

</html>