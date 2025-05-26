<?php
$products = include "data.php";

$id = $_GET['id'] ?? null;

if (!isset($products[$id])) {
    echo "❌ Mahsulot topilmadi!";
    exit;
}

$product = $products[$id];

$imagePath = $product['image'];
if (file_exists($imagePath)) {
    unlink($imagePath); 
}

unset($products[$id]);

file_put_contents('data.php', '<?php return ' . var_export($products, true) . ';');

echo "✅ Mahsulot o‘chirildi!";
header("Location: ./");
exit;
?>