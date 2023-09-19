<?php
session_start();
require_once('db.php');

// Function to calculate the total amount based on cart items
function calculateTotalAmount($conn, $cartItems)
{
    $totalAmount = 0;

    if (!empty($cartItems)) {
        $itemIds = implode(",", $cartItems);
        $sql = "SELECT SUM(price) AS total FROM items WHERE id IN ($itemIds)";
        $result = $conn->query($sql);

        if ($result && $row = $result->fetch_assoc()) {
            $totalAmount = $row['total'];
        }
    }

    return $totalAmount;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize user inputs (you should add more validation as needed)
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $creditCard = mysqli_real_escape_string($conn, $_POST['credit_card']);
    $cartItems = $_SESSION['cart'];

    // Calculate the total amount based on the items in the cart
    $totalAmount = calculateTotalAmount($conn, $cartItems);

    // Insert the order into the purchase_orders table
    $sql = "INSERT INTO purchase_orders (user_id, total_amount) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("id", $_SESSION['user_id'], $totalAmount);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Clear the cart after a successful purchase
        $_SESSION['cart'] = [];

        // Redirect to a thank you page or display a success message
        header("Location: thank_you.php");
        exit();
    } else {
        // Handle the case where the order insertion failed
        echo "Failed to complete the purchase. Please try again.";
    }

    // Close the prepared statement
    $stmt->close();
}

// Display the form to collect user information
?>

<!DOCTYPE html>
<html>

<head>
    <title>Checkout</title>
</head>

<body>
    <nav>
        <ul>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="cart.php">Shopping Cart</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </nav>
        </ul>
    </nav>
    <h1>Checkout</h1>
    <form method="POST" action="purchaseComplete.php">
        <label for="name">Name:</label>
        <input type="text" name="name" required><br><br>

        <label for="address">Address:</label>
        <input type="text" name="address" required><br><br>

        <label for="credit_card">Credit Card:</label>
        <input type="text" name="credit_card" required><br><br>

        <!-- Display selected items for confirmation -->
        <h2>Items in Your Cart:</h2>
        <ul>
            <?php
            foreach ($_SESSION['cart'] as $itemId) {
                // Fetch and display item details based on the item ID from the database
                $sql = "SELECT item_name, price FROM items WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $itemId);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result && $row = $result->fetch_assoc()) {
                    echo "<li>Item Name: " . $row['item_name'] . "</li>";
                    echo "<li>Price: $" . $row['price'] . "</li>";
                }
                $stmt->close();
            }
            ?>
        </ul>

        <input type="submit" value="Place Order">
    </form>
</body>

</html>