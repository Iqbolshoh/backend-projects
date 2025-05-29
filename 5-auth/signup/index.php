<?php
session_start();

include "../config.php";
$db = new Database();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    if ($_SESSION['user']['role'] === 'admin') {
        header('Location: ../admin/');
        exit;
    } elseif ($_SESSION['user']['role'] === 'user') {
        header('Location: ../');
        exit;
    } else {
        exit("Bunday role mavjud emas!");
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    $name = trim($_POST['name'] ?? '');
    $username = strtolower(trim($_POST['username'] ?? ''));
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty(trim($name)) || empty(trim($username)) || empty(trim($password))) {
        echo json_encode([
            'success' => false,
            'title' => '⚠️ Diqqat!',
            'message' => "Iltimos, barcha maydonlarni to‘ldiring!"
        ]);
        exit;
    }

    if ($password !== $confirm_password) {
        echo json_encode([
            'success' => false,
            'title' => '❌ Parollar mos emas!',
            'message' => "Parollar bir xil bo‘lishi kerak!"
        ]);
        exit;
    }

    $existingUser = $db->select('users', '*', "username = ?", [$username], 's');
    if (!empty($existingUser)) {
        echo json_encode([
            'success' => false,
            'title' => '❌ Username band!',
            'message' => "Bu username allaqachon mavjud, boshqa tanlang!"
        ]);
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $role = 'user';

    $id = $db->insert('users', [
        'name' => $name,
        'username' => $username,
        'password' => $hashedPassword,
        'role' => $role
    ]);

    if ($id) {
        $_SESSION['loggedin'] = true;
        $_SESSION['user'] = [
            'id' => $id,
            'name' => $name,
            'username' => $username,
            'role' => $role,
        ];

        echo json_encode([
            'success' => true,
            'title' => '✅ Muvaffaqiyat!',
            'message' => "Ro'yxatdan o'tdingiz!",
            'redirect' => $role === 'admin' ? '../admin/' : '../'
        ]);
        exit;
    } else {
        echo json_encode([
            'success' => false,
            'title' => '❌ Xatolik yuz berdi!',
            'message' => "Ma'lumotlar bazasiga yozishda muammo."
        ]);
        exit;
    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Sign Up Page</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow">
                    <div class="card-body p-4">
                        <h2 class="text-center mb-4">Sign Up</h2>

                        <form id="signupForm" method="POST">
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter full name" />
                            </div>

                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username"
                                    placeholder="Enter username" />
                            </div>

                            <div class="mb-3 position-relative">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" id="password" class="form-control" name="password"
                                        placeholder="Enter password" />
                                    <button class="btn btn-outline-secondary" type="button"
                                        onclick="togglePassword('password')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-3 position-relative">
                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <div class="input-group">
                                    <input type="password" id="confirm_password" class="form-control"
                                        name="confirm_password" placeholder="Confirm password" />
                                    <button class="btn btn-outline-secondary" type="button"
                                        onclick="togglePassword('confirm_password')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Sign Up</button>
                        </form>

                        <p class="text-center mt-3">
                            Already have an account? <a href="../login/">Login</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function togglePassword(fieldId) {
            const input = document.getElementById(fieldId);
            const button = input.nextElementSibling;
            const icon = button.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        document.getElementById('signupForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        Swal.fire({
                            icon: 'success',
                            title: result.title,
                            text: result.message,
                            confirmButtonText: 'OK',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            if (result.redirect) {
                                window.location.href = result.redirect;
                            }
                        });
                    } else if (result.redirect) {
                        window.location.href = result.redirect;
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: result.title,
                            text: result.message
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: '❌ Tarmoq xatosi',
                        text: 'Server bilan bog‘lanishda muammo yuz berdi.'
                    });
                    console.error('Fetch error:', error);
                });
        });
    </script>
</body>

</html>