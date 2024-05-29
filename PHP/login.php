<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "software_project";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $password = $_POST['password'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT p.name, p.email, m.issued_date AS membership_start_date, m.expiry_date AS membership_end_date, p.password FROM person p JOIN membership m ON p.id = m.person_id WHERE p.name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if name exists
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stored_password = $row['password'];

        // Verify password
        if ($password === $stored_password) {
            // Password is correct, return user data
            echo $row['name'] . "|" . $row['email'] . "|" . $row['membership_start_date'] . "|" . $row['membership_end_date'];
        } else {
            // Password is incorrect
            echo "Invalid password";
        }
    } else {
        // Name does not exist
        echo "No account found with that name";
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
