<?php

mysqli_report(MYSQLI_REPORT_OFF);

require_once __DIR__ . '/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';

    if ($name == '' || $email == '' || $phone == '') {
        die("Error: All fields are required!");
    }

    $stmt = $conn->prepare(
        "INSERT INTO students (name, email, phone) VALUES (?, ?, ?)"
    );

    if (!$stmt) {
        die("SQL Error: " . $conn->error);
    }

    $stmt->bind_param("sss", $name, $email, $phone);

    if ($stmt->execute()) {

        echo '<div class="alert alert-success" role="alert">
        Entry submitted successfully!
        </div>';

    } else {

        echo "Insert Error: " . $stmt->error;

    }

    $stmt->close();
    $conn->close();

} else {

    echo "Please submit the form first.";

}

?>
