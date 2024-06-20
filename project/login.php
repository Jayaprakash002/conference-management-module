<?php
// Database configuration
$host = "localhost";
$username = "root";
$password = "";
$database = "my_database";

// Create a database connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Sign up form submission
if (isset($_POST['signup'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Insert user data into the database
    $sql = "INSERT INTO users (firstName, lastName, mobile, email, password) VALUES ('$firstName', '$lastName', '$mobile', '$email', '$password')";
    
    if (mysqli_query($conn, $sql)) {
        header("Location:conf.html");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Login form submission
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
   
    // Check if the user exists in the database
    $sql = "SELECT * FROM users WHERE email = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);
    
    if ($count == 1) {
        header("Location:conf.html");
    } else {
        echo "Invalid username or password!";
    }
}

// Close the database connection
mysqli_close($conn);
?>
