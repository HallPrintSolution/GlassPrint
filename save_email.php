<?php
$servername = "localhost";
$username = "kzmpurvh_idm_dvz";
$password = "HallPrint2024!";
$dbname = "kzmpurvh_idm_cqm";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $company = filter_var($_POST['company'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmt = $conn->prepare("INSERT INTO emails (company, email) VALUES (?, ?)");
        $stmt->bind_param("ss", $company, $email);

        if ($stmt->execute()) {
            echo "Company and email saved successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Invalid email format.";
    }
}

$conn->close();
?>
