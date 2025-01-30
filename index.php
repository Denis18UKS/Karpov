<?php
require 'settings.php'; // Настройка
include 'includes/nav.php'; // Навигация
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Клининговые услуги "Мой Не Сам"</title>
</head>
<body>

    <!-- Контент главной страницы -->
    <section class="hero">
        <div class="hero-content">
            <h1>Добро пожаловать на портал клининговых услуг "Мой Не Сам"</h1>
            <p>Уборка жилых и производственных помещений с гарантией качества!</p>
            
            <?php if (!isset($_SESSION['user_id'])): ?>
                <a href="register.php" class="btn">Зарегистрироваться</a>
                <a href="login.php" class="btn">Войти</a>
            <?php endif; ?>
        </div>
    </section>

    <!-- Информация о сервисах -->
    <section class="services">
        <h2>Наши услуги</h2>
        <div class="service-cards">
            <div class="service-card">
                <h3>Общий клининг</h3>
                <p>Уборка квартир и домов.</p>
            </div>
            <div class="service-card">
                <h3>Генеральная уборка</h3>
                <p>Полная уборка с уклоном на все детали.</p>
            </div>
            <div class="service-card">
                <h3>Послестроительная уборка</h3>
                <p>Очистка помещений после ремонта.</p>
            </div>
            <div class="service-card">
                <h3>Химчистка</h3>
                <p>Химчистка ковров и мебели.</p>
            </div>
        </div>
    </section>

    <!-- Описание преимуществ -->
    <section class="advantages">
        <h2>Почему выбирают нас?</h2>
        <ul>
            <li>Профессионализм и опыт</li>
            <li>Гарантия качества</li>
            <li>Удобство онлайн-заявок</li>
            <li>Доступные цены</li>
        </ul>
    </section>

    <!-- Контактная информация -->
    <section class="contact-info">
        <h2>Контакты</h2>
        <p>Если у вас есть вопросы, свяжитесь с нами:</p>
        <ul>
            <li>Телефон: +7(XXX)-XXX-XX-XX</li>
            <li>Email: info@mykleaning.com</li>
        </ul>
    </section>

</body>
</html>
