<?php

if (isset($_GET['first_name']) && isset($_GET['last_name']) && isset($_GET['age']) && isset($_GET['username']) && isset($_GET['password'])) {
    $first_name = htmlspecialchars($_GET['first_name']);
    $last_name = htmlspecialchars($_GET['last_name']);
    $age = (int) $_GET['age'];
    $username = htmlspecialchars($_GET['username']);
    $password_old = $_GET['password'];
    $password = password_hash($password_old, PASSWORD_DEFAULT);

    $data = include("data.php");
    foreach ($data as $person) {
        if ($person['username'] == $username) {
            ?>
            <div
                style="max-width: 400px; margin: 30px auto; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                <div
                    style="background-color: #ffe5e5; color: #d32f2f; padding: 15px; border: 1px solid #ff9999; border-radius: 6px; margin-bottom: 20px; text-align: center;">
                    <strong style="font-weight: 600;"><?= $username ?></strong> Bu username mavjud!
                </div>
                <div style="background: #ffffff; padding: 25px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                    <form action="" style="display: flex; flex-direction: column; gap: 15px;">
                        <input type="text" name="first_name" placeholder="Ismni kiriting" required value="<?= $first_name ?>"
                            style="padding: 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 16px; outline: none; transition: border-color 0.2s; width: 100%; box-sizing: border-box;">
                        <input type="text" name="last_name" placeholder="Familiya kiriting" required value="<?= $last_name ?>"
                            style="padding: 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 16px; outline: none; transition: border-color 0.2s; width: 100%; box-sizing: border-box;">
                        <input type="number" name="age" placeholder="Yoshni kiriting" required value="<?= $age ?>"
                            style="padding: 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 16px; outline: none; transition: border-color 0.2s; width: 100%; box-sizing: border-box;">
                        <input type="text" name="username" placeholder="Username kiriting" required
                            style="padding: 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 16px; outline: none; transition: border-color 0.2s; width: 100%; box-sizing: border-box;">
                        <input type="password" name="password" placeholder="Parolni kiriting" required value="<?= $password_old ?>"
                            style="padding: 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 16px; outline: none; transition: border-color 0.2s; width: 100%; box-sizing: border-box;">
                        <button type="submit"
                            style="padding: 12px; background-color: #2563eb; color: white; border: none; border-radius: 6px; font-size: 16px; font-weight: 500; cursor: pointer; transition: background-color 0.2s;">Yuborish</button>
                    </form>
                </div>
            </div>
            <?php
            exit;
        }
    }

    $new_entry = [
        'first_name' => $first_name,
        'last_name' => $last_name,
        'age' => $age,
        'username' => $username,
        'password' => $password,
    ];

    $file_path = "data.php";
    $old_data = [];

    if (file_exists($file_path)) {
        $old_data = include($file_path);
    }

    $old_data[] = $new_entry;

    $new_content = "<?php\nreturn " . var_export($old_data, true) . ";\n";

    file_put_contents($file_path, $new_content);

    header("Location: ./");
    exit;
} else {
    echo "Ma'lumotlar to'liq emas!";
}
?>