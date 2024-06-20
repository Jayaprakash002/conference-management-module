<?php
// MySQL database credentials
$servername = "localhost"; // Replace with your database server name
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "conference"; // Replace with your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process the form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $conferenceName = $_POST["conference_name"];
    $title = $_POST["title"];
    $institution = $_POST["institution"];
    $address = $_POST["address"];
    $authorEmail = $_POST["author_email"];
    $authorPhone = $_POST["author_phone"];
    $paperTitle = $_POST["paper_title"];
    $paperType = $_POST["paper_type"];
    
    // File upload
    $targetDirectory = "uploads/"; // Directory where attachments will be stored
    $targetFile = $targetDirectory . basename($_FILES["attachment"]["tmp_name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if file is a valid document
    if ($fileType !== "pdf") {
        echo "Only PDF files are allowed.";
        $uploadOk = 0;
    }

    // Move uploaded file to target directory
    if ($uploadOk == 1 && move_uploaded_file($_FILES["attachment"]["tmp_name"], $targetFile)) {
        // File uploaded successfully, now insert data into database
        $sql = "INSERT INTO submissions (id,conference_name, title, institution, address, author_email, author_phone, paper_title, paper_type, attachment)
                VALUES (null,'$conferenceName', '$title', '$institution', '$address', '$authorEmail', '$authorPhone', '$paperTitle', '$paperType', '$targetFile')";

        if ($conn->query($sql) === TRUE) {
            echo "Submission successful.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error uploading file.";
    }
}

// Close the connection
$conn->close();
?>
