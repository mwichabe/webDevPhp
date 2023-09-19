<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];

    // Validate and sanitize input data

    // Send email to site owner
    $to = "your@email.com";
    $headers = "From: $email";
    $message = "Name: $name\nEmail: $email\nSubject: $subject\nMessage:\n$message";

    if (mail($to, $subject, $message, $headers)) {
        echo "Message sent successfully!";
    } else {
        echo "Message sending failed.";
    }
}
?>

<!-- HTML form for user to enter contact information -->
<!DOCTYPE html>
<html>

<head>
    <title>Contact Us</title>
</head>

<body>
    <h1>Contact Us</h1>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="cart.php">Shopping Cart</a></li>
            <li><a href="purchase.php">Purchase</a></li>
        </ul>
    </nav>
    <form method="post" action="">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="subject">Subject:</label>
        <input type="text" id="subject" name="subject" required><br>

        <label for="message">Message:</label>
        <textarea id="message" name="message" rows="4" required></textarea><br>

        <input type="submit" value="Submit">
    </form>
</body>

</html>