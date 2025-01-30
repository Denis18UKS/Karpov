<?php
include 'includes/nav.php';
include 'settings.php';
?>

<div class="container">
    <h2>Регистрация</h2>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $fio = mysqli_real_escape_string($connect, $_POST['fio']);
        $telephone = mysqli_real_escape_string($connect, $_POST['telephone']);
        $email = mysqli_real_escape_string($connect, $_POST['email']);
        $login = mysqli_real_escape_string($connect, $_POST['login']);
        $password = mysqli_real_escape_string($connect, $_POST['password']);
        $role = 'user'; // По умолчанию роль пользователя "user"

        // Валидация данных
        if (strlen($password) >= 6 && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Проверяем, существует ли уже пользователь с таким email
            $checkEmailQuery = "SELECT * FROM users WHERE email = '$email'";
            $emailResult = mysqli_query($connect, $checkEmailQuery);

            if (mysqli_num_rows($emailResult) > 0) {
                echo "<p style='color:red;'>Пользователь с таким email уже существует!</p>";
            } else {
                $password = password_hash($password, PASSWORD_BCRYPT); // Хэшируем пароль
                $query = "INSERT INTO users (fio, telephone, email, login, password, role) 
                          VALUES ('$fio', '$telephone', '$email', '$login', '$password', '$role')";
                if (mysqli_query($connect, $query)) {
                    echo "<p style='color:green;'>Регистрация прошла успешно.</p>";
                } else {
                    echo "Ошибка регистрации: " . mysqli_error($connect);
                }
            }
        } else {
            echo "<p style='color:red;'>Неверные данные!</p>";
        }
    }
    ?>

    <form method="POST">
        <label for="fio">ФИО:</label>
        <input type="text" name="fio" required>

        <label for="telephone">Телефон:</label>
        <input type="text" name="telephone" required>

        <label for="email">Email:</label>
        <input type="email" name="email" required>

        <label for="login">Логин:</label>
        <input type="text" name="login" required>

        <label for="password">Пароль:</label>
        <input type="password" name="password" required>

        <button type="submit">Зарегистрироваться</button>
    </form>
</div>
