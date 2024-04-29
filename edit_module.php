<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['module_id'])) {
    $module_id = $_GET['module_id'];
    $sql = "SELECT * FROM modules WHERE module_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$module_id]);
    $module = $stmt->fetch();

    if (!$module) {
        die('Module not found!');
    }
} else {
    die('Module ID not provided!');
}

if (isset($_POST['update_module'])) {
    $new_module_name = $_POST['module_name'];
    $sql = "UPDATE modules SET module_name = ? WHERE module_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$new_module_name, $module_id]);

    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Module</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <h2>Edit Module</h2>
    <form action="" method="post">
        <input type="hidden" name="module_id" value="<?php echo $module['module_id']; ?>">
        <label for="module_name">Module Name:</label>
        <input type="text" name="module_name" value="<?php echo htmlspecialchars($module['module_name']); ?>" required><br>
        <input type="submit" name="update_module" value="Update Module">
    </form>
</body>
</html>
