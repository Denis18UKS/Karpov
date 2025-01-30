<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'Karpov_18Jan';

// Подключение к базе данных
$connect = mysqli_connect($host, $username, $password, $dbname);

if (!$connect) {
    die("Ошибка подключения: " . mysqli_connect_error());
}
