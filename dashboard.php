<?php
session_start();
require 'config.php';

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch all posts and modules from the database
try {
    $stmt = $pdo->prepare("SELECT p.post_id, p.title, p.content, p.image_path, u.username FROM posts p JOIN users u ON p.user_id = u.user_id WHERE u.user_id = ? ORDER BY p.post_id DESC");
    $stmt->execute([$_SESSION['user_id']]);
    $posts = $stmt->fetchAll();

    // Fetching modules
    $module_stmt = $pdo->query("SELECT * FROM modules ORDER BY module_name ASC");
    $modules = $module_stmt->fetchAll();
} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>Student Dashboard</h1>
        <nav>
            <a href="create_post.php">Create New Post</a> |
            <a href="contact.php">Contact Admin</a> |
            <a href="logout.php">Logout</a>
        </nav>
    </header>
    <div class="container">
        <div class="dashboard-columns">
            <section id="posts" class="dashboard-column">
                <h2>Your Posts</h2>
                    <div id="posts">
                        <?php foreach ($posts as $post): ?>
                            <div class="post">
                <h2><?php echo htmlspecialchars($post['title']); ?></h2>
                <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                <?php if ($post['image_path']): ?>
                    <img src="<?php echo htmlspecialchars($post['image_path']); ?>" alt="Post Image" style="max-width: 200px;">
                <?php endif; ?>
                <p>Posted by: <?php echo htmlspecialchars($post['username']); ?></p>
                <a href="update_post.php?post_id=<?php echo $post['post_id']; ?>">Edit</a>
                <form action="delete_post.php" method="post">
                    <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
                    <input type="submit" name="delete" value="Delete" onclick="return confirm('Are you sure you want to delete this post?');">
                </form>
            </div>
        <?php endforeach; ?>
    </div>
            </section>
            <section id="modules" class="dashboard-column">
                <h2>Manage Modules</h2>
                <a href="add_module.php" class="button">Add New Module</a>
            <ul class="module-list">
                <?php foreach ($modules as $module): ?>
                    <li class="module">
                        <span><?php echo htmlspecialchars($module['module_name']); ?></span>
                        <a href="edit_module.php?module_id=<?php echo $module['module_id']; ?>" class="button">Edit</a>
                        <form action="delete_module.php" method="post" onsubmit="return confirm('Are you sure you want to delete this module?');">
                            <input type="hidden" name="module_id" value="<?php echo $module['module_id']; ?>">
                            <input type="submit" name="delete_module" value="Delete" class="button">
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
            </section>
        </div>
    </div>
</body>
</html>

