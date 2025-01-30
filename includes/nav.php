<?php
session_start();
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
}
require "database/db.php"
?>
<nav>
    <ul>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
            <li><a href="admin_panel.php">Панель администратора</a></li>
        <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] == 'user'): ?>
            <li><a href="index.php">Главная</a></li>
            <li><a href="profile.php">Мой профиль</a></li>
            <li><a href="create_application.php">Создать заявку</a></li>
        <?php endif; ?>

        <?php if (isset($userId)): ?>
            <? $sql = "SELECT login FROM users WHERE id = '$userId'";
            $query = mysqli_query($connect, $sql);
            $fetch = mysqli_fetch_assoc($query);
            $login = $fetch['login'];
            ?>
            <li>Привет, <?php echo htmlspecialchars($login); ?>!</li>
            <li><a href="logout.php">Выход</a></li>
        <?php else: ?>
            <li><a href="/">Главная</a></li>
            <li><a href="login.php">Войти</a></li>
            <li><a href="register.php">Регистрация</a></li>
        <?php endif; ?>
    </ul>
</nav>