<?php
session_start();
include 'includes/nav.php';
include 'settings.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$query = "SELECT *, fio, name FROM applications 
JOIN users ON applications.user_id = users.id
LEFT JOIN services ON applications.type_service_id = services.id WHERE user_id = '$user_id'";
$result = mysqli_query($connect, $query);
?>


<h2>Мои заявки</h2>
<table border="1">
    <tr>
        <th>Адрес</th>
        <th>Тип услуги</th>
        <th>Назначенная дата</th>
        <th>Назначенное время</th>
        <th>Тип оплаты</th>
        <th>Статус</th>
        <th>Причина отклонения</th>
    </tr>
    <?php while ($application = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $application['address'] ?></td>
            <td>
                <?php
                if (trim($application['name'] ?? '')) {
                    echo htmlspecialchars($application['name']);
                } else if (trim($application['custom_service'] ?? '')) {
                    echo htmlspecialchars("Иная услуга: " . `<br>` . $application['custom_service']);
                }
                ?>
            </td>

            <td><?= date("d.m.Y", strtotime($application['date_get_service'])) ?></td>
            <td><?= htmlspecialchars($application['time_get_service']) ?></td>
            <td><?= htmlspecialchars($application['type_payment']) ?></td>
            <td><?= $application['status_provision'] ?></td>
            <td>
                <?php if ($application['status_provision'] == 'услуга отменена' && !empty($application['reason_reject'])): ?>
                    <?= htmlspecialchars($application['reason_reject']) ?>
                <?php else: ?>
                    -
                <?php endif; ?>
            </td>
        </tr>
    <?php } ?>
</table>

<a href="create_application.php">Создать новую заявку</a>