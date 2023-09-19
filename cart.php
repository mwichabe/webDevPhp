<?php
session_start();
require_once('db.php');

if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
    $item_ids = implode(",", $_SESSION['cart']);
    $sql = "SELECT * FROM items WHERE id IN ($item_ids)";
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Shopping Cart</title>
</head>

<body>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="cart.php">Shopping Cart</a></li>
        </ul>
    </nav>
    <h1>Your Shopping Cart</h1>
    <ul>
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<li>";
            echo "<h2>" . $row['item_name'] . "</h2>";
            echo "<p>Price: $" . $row['price'] . "</p>";
            echo "</li>";
        }
        ?>
    </ul>
</body>

</html>