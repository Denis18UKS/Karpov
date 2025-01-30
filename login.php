<?php
session_start();
include 'includes/nav.php';
include 'settings.php';
?>

<div class="container">
    <h2>Вход</h2>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $login = mysqli_real_escape_string($connect, $_POST['login']);
        $password = mysqli_real_escape_string($connect, $_POST['password']);

        $query = "SELECT * FROM users WHERE login = '$login'";
        $result = mysqli_query($connect, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            // Проверяем правильность пароля
            if (password_verify($password, $user['password'])) {
                // Успешный вход, сохраняем данные пользователя в сессии
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['fio'];
                $_SESSION['role'] = $user['role'];

                if ($user['role'] === 'admin') {
                    header("Location: admin_panel.php"); // Перенаправление на админ-панель после входа для администратора
                } else if ($user['role'] === 'user') {
                    header("Location: profile.php"); // Перенаправление в профиль пользователя после входа
                }
                exit();
            } else {
                echo "<p style='color:red;'>Неверный пароль!</p>";
            }
        } else {
            echo "<p style='color:red;'>Пользователь не найден!</p>";
        }
    }
    ?>

    <form method="POST">
        <label for="login">Логин:</label>
        <input type="text" name="login" required>

        <label for="password">Пароль:</label>
        <input type="password" name="password" required>

        <button type="submit">Войти</button>
    </form>
    <center>
        <p>Нет аккаунта? <i><a href="register.php">Регистрация</a></i></p>
    </center>
</div>