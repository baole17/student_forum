<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];
    $sql = "SELECT * FROM posts WHERE post_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$post_id]);
    $post = $stmt->fetch();

    // Make sure the user editing the post is the author
    if ($post && $_SESSION['user_id'] == $post['user_id']) {
        // Display the form with post data
?>
        <link rel="stylesheet" type="text/css" href="css/styles.css">
        <form action="update_post.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
            <label for="title">Title:</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required><br>
            <label for="content">Content:</label>
            <textarea name="content" required><?php echo htmlspecialchars($post['content']); ?></textarea><br>
            <input type="submit" name="update" value="Update Post">
        </form>
<?php
    } else {
        echo "You do not have permission to edit this post.";
    }
}

if (isset($_POST['update'])) {
    // Handle the post request to update the post
    $post_id = $_POST['post_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    $sql = "UPDATE posts SET title = ?, content = ? WHERE post_id = ? AND user_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$title, $content, $post_id, $_SESSION['user_id']]);

    echo "Post updated successfully!";
    // Redirect back to the dashboard or the updated post
    header("Location: dashboard.php");
    exit;
}
?>
