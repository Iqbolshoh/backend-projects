<?php

$file = "data.php";

// 1. Foydalanuvchi nomi tekshiruvi
if (empty($_GET['username'])) {
    exit("<div class='alert alert-warning'>⚠️ Username ko‘rsatilmagan!</div>");
}

$username = $_GET['username'];

// 2. Fayl mavjudligini tekshirish
if (!file_exists($file)) {
    exit("<div class='alert alert-danger'>🛑 Fayl topilmadi!</div>");
}

// 3. Ma'lumotlarni chaqirish
$data = include($file);

// 4. Foydalanuvchini filtrlash orqali o‘chirish
$data = array_filter($data, fn($user) => $user['username'] !== $username);

// 5. Indekslarni qayta tartibga solish va faylga yozish
$updatedContent = "<?php\nreturn " . var_export(array_values($data), true) . ";\n";
file_put_contents($file, $updatedContent);

// 6. Redirect qilish
header("Location: ./");
exit;
?>