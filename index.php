<?php
require_once('db.php');

// Fetch items from the database
$sql = "SELECT * FROM items";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Online Store</title>
</head>

<body>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="cart.php">Shopping Cart</a></li>
        </ul>
    </nav>
    <h1>Welcome to our Online Store</h1>
    <ul>
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<li>";
            echo "<h2>" . $row['item_name'] . "</h2>";
            echo "<p>" . $row['description'] . "</p>";
            echo "<p>Price: $" . $row['price'] . "</p>";
            echo "<a href='add_to_cart.php?item_id=" . $row['id'] . "'>Add to Cart</a>";
            echo "</li>";
        }
        ?>
    </ul>
</body>

</html>