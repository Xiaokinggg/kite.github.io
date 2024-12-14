<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student_db";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    // In development, you can display the error
    die("Connection failed: " . mysqli_connect_error());
} else {
    // You can log successful connection here or use it for debugging
    // echo "Connected successfully";
}
?>
