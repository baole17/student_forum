<?php
session_start();
require 'config.php';

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch all modules from the database
try {
    $sql = "SELECT * FROM modules ORDER BY module_name ASC";
    $stmt = $pdo->query($sql);
    $modules = $stmt->fetchAll();
} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
}

// Handle delete module request
if (isset($_POST['delete_module']) && isset($_POST['module_id'])) {
    $module_id = $_POST['module_id'];

    // Additional logic can be added here to prevent deletion if the module is in use by posts

    $sql = "DELETE FROM modules WHERE module_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$module_id]);

    header("Location: manage_modules.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Modules</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <h2>Manage Modules</h2>
    <a href="add_module.php">Add New Module</a>
    <?php foreach ($modules as $module): ?>
        <div class="module">
            <span><?php echo htmlspecialchars($module['module_name']); ?></span>
            <a href="edit_module.php?module_id=<?php echo $module['module_id']; ?>">Edit</a>
            <form action="manage_modules.php" method="post" onsubmit="return confirm('Are you sure you want to delete this module?');">
                <input type="hidden" name="module_id" value="<?php echo $module['module_id']; ?>">
                <input type="submit" name="delete_module" value="Delete">
            </form>
        </div>
    <?php endforeach; ?>
</body>
</html>
