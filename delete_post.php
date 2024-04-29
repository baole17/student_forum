<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['delete']) && isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];

    // Verify that the user deleting the post is the author
    $sql = "DELETE FROM posts WHERE post_id = ? AND user_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$post_id, $_SESSION['user_id']]);

    echo "Post deleted successfully!";
    header("Location: dashboard.php");
    exit;
} else {
    echo "Invalid request.";
}
?>
