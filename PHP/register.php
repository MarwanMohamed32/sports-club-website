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

// Process form data and insert into the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Personal details
    $name = $_POST['name'];
    $dateofbirth = $_POST['dateofbirth'];
    $email = $_POST['email'];
    $mobile_number = $_POST['mobile_number'];
    $gender = $_POST['gender'];
    $password = $_POST['password'];

    // Membership details
    $sport = $_POST['sport'];
    $issued_date = $_POST['issued_date'];
    $expiry_date = $_POST['expiry_date'];
    $payment_card_name = $_POST['payment_card_name'];
    $payment_card_number = $_POST['payment_card_number'];
    $payment_card_csv = $_POST['payment_card_csv'];

    // Inserting data into the database
    $sql = "INSERT INTO person (name, dateofbirth, email, mobile_number, gender, password)
            VALUES ('$name', '$dateofbirth', '$email', '$mobile_number', '$gender', '$password')"; // No hashing

    if ($conn->query($sql) === TRUE) {
        $person_id = $conn->insert_id;
        $sql = "INSERT INTO membership (sport, issued_date, expiry_date, payment_card_name, payment_card_number, payment_card_csv, person_id)
                VALUES ('$sport', '$issued_date', '$expiry_date', '$payment_card_name', '$payment_card_number', '$payment_card_csv', '$person_id')";

        if ($conn->query($sql) === TRUE) {
            // Redirect to login page
            header("Location: ../HTML/login.html");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();
