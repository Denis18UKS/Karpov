<?php
session_start();
include 'includes/nav.php';
include 'settings.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

$query = "SELECT applications.*, users.fio, services.name 
          FROM applications 
          JOIN users ON applications.user_id = users.id
          LEFT JOIN services ON applications.type_service_id = services.id";

$result = mysqli_query($connect, $query);
?>

<h2>Панель администратора</h2>
<table border="1">
    <tr>
        <th>ФИО</th>
        <th>Адрес</th>
        <th>Тип услуги</th>
        <th>Назначенная дата</th>
        <th>Назначенное время</th>
        <th>Тип оплаты</th>
        <th>Статус</th>
        <th>Причина отклонения</th>
        <th>Действие</th>
    </tr>
    <?php while ($application = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= htmlspecialchars($application['fio']) ?></td>
            <td><?= htmlspecialchars($application['address']) ?></td>
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
            <td><?= htmlspecialchars($application['status_provision'] ?? '') ?></td>
            <td>
                <?php if ($application['status_provision'] == 'услуга отменена' && !empty($application['reason_reject'])): ?>
                    <?= htmlspecialchars($application['reason_reject']) ?>
                <?php else: ?>
                    -
                <?php endif; ?>
            </td>

            <td>
                <?php if (($application['status_provision'] ?? '') === 'новая заявка') { ?>
                    <form method="POST" action="update_status.php">
                        <input type="hidden" name="id" value="<?= $application['id'] ?>">
                        <button type="submit" name="action" value="accept">Принять</button>
                        <button type="button" class="reject-button" data-id="<?= $application['id'] ?>">Отклонить</button>
                    </form>
                <?php } elseif (($application['status_provision'] ?? '') === 'в работе') { ?>
                    <form method="POST" action="update_status.php">
                        <input type="hidden" name="id" value="<?= $application['id'] ?>">
                        <button type="submit" name="action" value="complete">Завершить</button>
                    </form>
                <?php } ?>
            </td>
        </tr>
    <?php } ?>
</table>

<!-- Модальное окно для ввода причины отклонения -->
<div id="reject-modal" style="display:none;">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h3>Введите причину отклонения заявки:</h3>
        <form id="reject-form" method="POST" action="../update_status.php">
            <input type="hidden" name="id" id="reject-id">
            <textarea name="reason" required></textarea><br>
            <button type="submit" name="action" value="reject">Отклонить заявку</button>
        </form>
    </div>
</div>

<script>
    // Открытие и закрытие модального окна
    document.querySelectorAll('.reject-button').forEach(button => {
        button.addEventListener('click', function() {
            document.getElementById('reject-id').value = this.getAttribute('data-id');
            document.getElementById('reject-modal').style.display = 'block';
        });
    });

    document.querySelector('.close-modal').addEventListener('click', function() {
        document.getElementById('reject-modal').style.display = 'none';
    });

    window.onclick = function(event) {
        if (event.target == document.getElementById('reject-modal')) {
            document.getElementById('reject-modal').style.display = 'none';
        }
    }
</script>

<style>
    /* Стили для модального окна */
    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 400px;
        position: relative;
    }

    .close-modal {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .close-modal:hover,
    .close-modal:focus {
        color: black;
        text-decoration: none;
    }
</style>