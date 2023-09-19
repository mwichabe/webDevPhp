<?php
$host = "localhost";
$username = "mwichabe";
$password = "Avator@2";
$database = "MyDataBase";

$conn = new mysqli($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "Connected successfully";
}
