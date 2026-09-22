<?php
include '../auth/admin-check.php';
include '../config/db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $stmt = $conn->prepare("UPDATE trip_plans SET status = 'Completed' WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: current-plans.php");
exit();
?>