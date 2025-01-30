<?php
session_start();
include 'includes/nav.php';
include 'settings.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $address = mysqli_real_escape_string($connect, $_POST['address']);
    $contact_data = mysqli_real_escape_string($connect, $_POST['contact_data']);
    $type_service_id = $_POST['type_service_id'];
    $custom_service = mysqli_real_escape_string($connect, $_POST['custom_service']);
    $date_get_service = $_POST['date_get_service'];
    $time_get_service = $_POST['time_get_service'];
    $type_payment = $_POST['type_payment'];

    $query = "INSERT INTO applications (user_id, address, contact_data, type_service_id, custom_service, date_get_service, time_get_service, type_payment, status_provision) 
              VALUES ('$user_id', '$address', '$contact_data', '$type_service_id', '$custom_service', '$date_get_service', '$time_get_service', '$type_payment', 'новая заявка')";

    if (mysqli_query($connect, $query)) {
        echo "Заявка успешно создана.";
    } else {
        echo "Ошибка создания заявки: " . mysqli_error($connect);
    }
}

$query = "SELECT * FROM services";
$result = mysqli_query($connect, $query);
?>



<div class="container">
    <form method="POST">
        <label for="address">Адрес:</label><br>
        <input type="text" name="address" required><br>

        <label for="contact_data">Контактные данные:</label><br>
        <input type="text" name="contact_data" required><br>

        <label for="type_service_id">Тип услуги:</label><br>
        <select name="type_service_id" required>
            <?php while ($service = mysqli_fetch_assoc($result)) { ?>
                <option value="<?= $service['id'] ?>"><?= $service['name'] ?></option>
            <?php } ?>
        </select><br>

        <label for="custom_service">Иная услуга:</label><br>
        <input type="text" name="custom_service"><br>

        <label for="date_get_service">Дата получения услуги:</label><br>
        <input type="date" name="date_get_service" required><br>

        <label for="time_get_service">Время получения услуги:</label><br>
        <input type="time" name="time_get_service" required><br>

        <label for="type_payment">Тип оплаты:</label><br>
        <select name="type_payment" required>
            <option value="наличными">Наличными</option>
            <option value="банковская карта">Банковская карта</option>
        </select><br>

        <button type="submit">Создать заявку</button>
    </form>
</div>