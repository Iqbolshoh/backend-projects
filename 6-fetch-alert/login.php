<?php
header('Content-Type: application/json');

// 1. Method tekshirish
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'title' => 'Xato method 🚫',
        'message' => 'Faqat POST methodga ruxsat berilgan!'
    ]);
    exit;
}

// 2. Malumotlarni olish
$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

// 3. Hamma maydonlar to‘ldirilganmi?
if (empty($username) || empty($password)) {
    echo json_encode([
        'success' => false,
        'title' => 'Bo‘sh maydonlar bor 😐',
        'message' => 'Foydalanuvchi nomi va parolni to‘ldiring!'
    ]);
    exit;
}

// 4. Parol uzunligi tekshiruvi
if (strlen($password) < 8) {
    echo json_encode([
        'success' => false,
        'title' => 'Parol juda qisqa 🛑',
        'message' => 'Parol kamida 8 ta belgidan iborat bo‘lishi kerak!'
    ]);
    exit;
}

// 5. Foydalanuvchi mavjudligini tekshirish (bu yerda oddiy)
if ($username === 'admin' && $password === '12345678') {
    echo json_encode([
        'success' => true,
        'title' => 'Kirish muvaffaqiyatli ✅',
        'message' => 'Assalomu alaykum, ' . $username . '! 👋'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'title' => 'Kirish muvaffaqiyatsiz ❌',
        'message' => 'Login yoki parol noto‘g‘ri!'
    ]);
}
