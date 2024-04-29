<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];
    $image_path = "";

    if (!empty($_FILES['image']['name'])) {
        $target_directory = "uploads/";
        $file_name = basename($_FILES["image"]["name"]);
        $target_file = $target_directory . $file_name;
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        $image_path = $target_file;
    }

    $sql = "INSERT INTO posts (user_id, title, content, image_path) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $success = $stmt->execute([$user_id, $title, $content, $image_path]);

    // If the insert was successful, redirect to the dashboard.
    if ($success) {
        header("Location: dashboard.php");
        exit;
    } else {
        // Handle the error case here, perhaps showing a message to the user.
        echo "There was a problem creating the post.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Post</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <h1>Create New Post</h1>
    <form action="create_post.php" method="post" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" name="title" required><br>
        <label for="content">Content:</label>
        <textarea name="content" required></textarea><br>
        <label for="image">Image (optional):</label>
        <input type="file" name="image"><br>
        <input type="submit" name="submit" value="Post">
    </form>
</body>
</html>


