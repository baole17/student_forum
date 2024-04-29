<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['delete_module']) && isset($_POST['module_id'])) {
    $module_id = $_POST['module_id'];

    $sql = "DELETE FROM modules WHERE module_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$module_id]);

    header("Location: dashboard.php");
    exit;
} else {
    die('Invalid request.');
}
?>
