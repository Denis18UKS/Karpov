<?php
session_start();
include 'settings.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = (int)$_POST['id'];
    $action = $_POST['action'];

    if ($action === 'accept') {
        $status = "в работе";
        $query = "UPDATE applications SET status_provision = ?, reason_reject = NULL WHERE id = ?";
        $stmt = $connect->prepare($query);
        $stmt->bind_param("si", $status, $id);
    } elseif ($action === 'reject' && isset($_POST['reason'])) {
        $status = "услуга отменена";
        $reason = trim($_POST['reason']);
        if (empty($reason)) {
            die("Ошибка: Причина отклонения не может быть пустой!");
        }
        $query = "UPDATE applications SET status_provision = ?, reason_reject = ? WHERE id = ?";
        $stmt = $connect->prepare($query);
        $stmt->bind_param("ssi", $status, $reason, $id);
    } elseif ($action === 'complete') {
        $status = "услуга оказана";
        $query = "UPDATE applications SET status_provision = ? WHERE id = ?";
        $stmt = $connect->prepare($query);
        $stmt->bind_param("si", $status, $id);
    }


    // ВАЖНО: Выполняем запрос
    if (!$stmt->execute()) {
        die("Ошибка выполнения запроса: " . $stmt->error);
    }

    // Перенаправление обратно в панель
    header("Location: admin_panel.php");
    exit;
}
