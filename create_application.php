<?php
session_start();
include 'includes/nav.php';
include 'settings.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $address = mysqli_real_escape_string($connect, $_POST['address']);
    $contact_data = mysqli_real_escape_string($connect, $_POST['contact_data']);
    
    // Проверяем, выбран ли чекбокс "Иная услуга"
    if (isset($_POST['other_service_checkbox']) && $_POST['other_service_checkbox'] == 'on') {
        $type_service_id = NULL;  // Присваиваем NULL, если выбрана иная услуга
    } else {
        // Проверяем, существует ли ключ 'type_service_id' в POST
        $type_service_id = isset($_POST['type_service_id']) ? intval($_POST['type_service_id']) : NULL;
    }

    $custom_service = mysqli_real_escape_string($connect, $_POST['custom_service']);
    $date_get_service = $_POST['date_get_service'];
    $time_get_service = $_POST['time_get_service'];
    $type_payment = $_POST['type_payment'];

    // SQL-запрос с корректной обработкой типа услуги
    $query = "INSERT INTO applications (user_id, address, contact_data, type_service_id, custom_service, date_get_service, time_get_service, type_payment, status_provision) 
              VALUES ('$user_id', '$address', '$contact_data', " . ($type_service_id !== NULL ? $type_service_id : "NULL") . ", '$custom_service', '$date_get_service', '$time_get_service', '$type_payment', 'новая заявка')";

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
    <h2>Создание заявки</h2>

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
        <label for="address">Адрес:</label><br>
        <input type="text" name="address" required><br>

        <label for="contact_data">Контактные данные (телефон):</label><br>
        <input type="text" name="contact_data" placeholder="+7(XXX)-XXX-XX-XX" required><br>

        <label for="type_service_id">Тип услуги:</label><br>
        <select name="type_service_id" id="serviceSelect" required>
            <?php while ($service = mysqli_fetch_assoc($result)) { ?>
                <option value="<?= $service['id'] ?>"><?= $service['name'] ?></option>
            <?php } ?>
        </select><br>

        <label for="other_service_checkbox">
            <input type="checkbox" id="other_service_checkbox" name="other_service_checkbox"> Иная услуга
        </label><br>

        <div id="customServiceField" style="display: none;">
            <label for="custom_service">Опишите услугу:</label><br>
            <input type="text" name="custom_service"><br>
        </div>

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

<script>
    document.getElementById('other_service_checkbox').addEventListener('change', function() {
        var customField = document.getElementById('customServiceField');
        var serviceSelect = document.getElementById('serviceSelect');

        if (this.checked) {
            customField.style.display = 'block';
            serviceSelect.disabled = true; // Отключаем выпадающий список
        } else {
            customField.style.display = 'none';
            serviceSelect.disabled = false; // Восстанавливаем доступность выпадающего списка
        }
    });
</script>
