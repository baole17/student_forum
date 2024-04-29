<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // If you installed PHPMailer via Composer

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = 0;                      // Disable verbose debug output
        $mail->isSMTP();                           // Set mailer to use SMTP
        $mail->Host       = 'smtp.gmail.com';    // Specify main and backup SMTP servers
        $mail->SMTPAuth   = true;                  // Enable SMTP authentication
        $mail->Username   = 'bao170904@gmail.com'; // SMTP username
        $mail->Password   = 'ukeqfzmvtnkjlgwc';       // SMTP password
        $mail->SMTPSecure = 'tls';                 // Enable TLS encryption, `ssl` also accepted
        $mail->Port       = 587;                   // TCP port to connect to

        // Recipients
        $mail->setFrom('from@example.com', 'Mailer');
        $mail->addAddress('bao170904@gmail.com', 'Admin'); // Add a recipient

        // Content
        $mail->isHTML(true);                       // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = "Name: {$name}<br>Email: {$email}<br>Message: {$message}";
        $mail->AltBody = "Name: {$name}\nEmail: {$email}\nMessage: {$message}";

        $mail->send();
        $feedback = 'Message has been sent';
    } catch (Exception $e) {
        $feedback = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Administrator</title>
    <link rel="stylesheet" href="css/styles.css"> 
</head>
<body>
    <div class="container">
        <h2>Contact Administrator</h2>
        <?php if (!empty($feedback)): ?>
            <p><?php echo $feedback; ?></p>
        <?php endif; ?>
        <form action="contact.php" method="post">
            <label for="name">Your Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Your Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject" required>

            <label for="message">Message:</label>
            <textarea id="message" name="message" required></textarea>

            <input type="submit" name="submit" value="Send Message">
        </form>
        <button onclick="window.location.href='dashboard.php';">Back</button>
    </div>
</body>
</html>
