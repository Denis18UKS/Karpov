<?php
include 'includes/nav.php';
include 'settings.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fio = trim($_POST['fio']);
    $telephone = trim($_POST['telephone']);
    $email = trim($_POST['email']);
    $login = trim($_POST['login']);
    $password = trim($_POST['password']);
    $role = 'user'; // Роль по умолчанию

    // Валидация ФИО (только кириллица и пробелы)
    if (!preg_match('/^[А-Яа-яЁё\s]+$/u', $fio)) {
        $errors[] = "ФИО должно содержать только буквы кириллицы и пробелы.";
    }

    // Валидация телефона (+7(XXX)-XXX-XX-XX)
    if (!preg_match('/^\+7\(\d{3}\)-\d{3}-\d{2}-\d{2}$/', $telephone)) {
        $errors[] = "Телефон должен быть в формате +7(XXX)-XXX-XX-XX.";
    }

    // Валидация email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Некорректный формат email.";
    }

    // Проверка длины пароля
    if (strlen($password) < 6) {
        $errors[] = "Пароль должен содержать минимум 6 символов.";
    }

    if (empty($errors)) {
        $fio = mysqli_real_escape_string($connect, $fio);
        $telephone = mysqli_real_escape_string($connect, $telephone);
        $email = mysqli_real_escape_string($connect, $email);
        $login = mysqli_real_escape_string($connect, $login);
        $password = password_hash($password, PASSWORD_BCRYPT);

        // Проверка существования email
        $checkEmailQuery = "SELECT * FROM users WHERE email = '$email'";
        $emailResult = mysqli_query($connect, $checkEmailQuery);

        // Проверка существования логина
        $checkLoginQuery = "SELECT * FROM users WHERE login = '$login'";
        $loginResult = mysqli_query($connect, $checkLoginQuery);

        if (mysqli_num_rows($emailResult) > 0) {
            $errors[] = "Пользователь с таким email уже существует.";
        } elseif (mysqli_num_rows($loginResult) > 0) {
            $errors[] = "Пользователь с таким логином уже существует.";
        } else {
            $query = "INSERT INTO users (fio, telephone, email, login, password, role) 
                      VALUES ('$fio', '$telephone', '$email', '$login', '$password', '$role')";
            if (mysqli_query($connect, $query)) {
                echo "<p style='color:green;'>Регистрация прошла успешно.</p>";
            } else {
                echo "Ошибка регистрации: " . mysqli_error($connect);
            }
        }
    }
}
?>

<div class="container">
    <h2>Регистрация</h2>
    
    <?php if (!empty($errors)): ?>
        <div style="color:red;">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST">
        <label for="fio">ФИО:</label>
        <input type="text" name="fio" value="<?= htmlspecialchars($_POST['fio'] ?? '') ?>" required>

        <label for="telephone">Телефон:</label>
        <input type="text" name="telephone" placeholder="+7(XXX)-XXX-XX-XX" value="<?= htmlspecialchars($_POST['telephone'] ?? '') ?>" required>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>

        <label for="login">Логин:</label>
        <input type="text" name="login" value="<?= htmlspecialchars($_POST['login'] ?? '') ?>" required>

        <label for="password">Пароль:</label>
        <input type="password" name="password" required>

        <button type="submit">Зарегистрироваться</button>
    </form>
</div>
