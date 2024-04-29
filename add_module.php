<?php
session_start();
require 'config.php';

// Ensure only authenticated users can add a module
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['add_module'])) {
    $module_name = $_POST['module_name'];

    $sql = "INSERT INTO modules (module_name) VALUES (?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$module_name]);

    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Module</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <h2>Add Module</h2>
    <form action="add_module.php" method="post">
        <label for="module_name">Module Name:</label>
        <input type="text" name="module_name" required><br>
        <input type="submit" name="add_module" value="Add Module">
    </form>
</body>
</html>
