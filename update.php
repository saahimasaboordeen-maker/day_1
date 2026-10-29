<?php
include 'config.php';

$id = isset($_GET['id'])
    ? (int) $_GET['id']
    : (int) ($_POST['id'] ?? 0);

// Check whether a valid ID is provided
if ($id <= 0) {
    exit("Invalid student ID.");
}

// Update student details ONLY when Update button is clicked
if (isset($_POST['update'])) {

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    // Check empty fields
    if (empty($name) || empty($email) || empty($phone)) {
        exit("All fields are required!");
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        exit("Invalid email format!");
    }

    // Validate phone number: exactly 10 digits
    if (!preg_match('/^[0-9]{10}$/', $phone)) {
        exit("Phone number must contain exactly 10 digits!");
    }

    // Update database
    $stmt = $conn->prepare(
        "UPDATE students SET name = ?, email = ?, phone = ? WHERE id = ?"
    );

    $stmt->bind_param("sssi", $name, $email, $phone, $id);

    if ($stmt->execute()) {
        header("Location: view.php");
        exit;
    } else {
        echo "Error updating record: " . $stmt->error;
    }
}

// Fetch existing student details
$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    exit("Student not found.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Update Student</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <h2 class="mb-4">Update Student</h2>

    <form method="POST" action="update.php?id=<?php echo $id; ?>">

        <input type="hidden" name="id"
               value="<?php echo $id; ?>">

        <div class="mb-3">
            <label class="form-label">Name</label>

            <input
                type="text"
                name="name"
                class="form-control"
                value="<?php echo htmlspecialchars($row['name']); ?>"
                required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>

            <input
                type="email"
                name="email"
                class="form-control"
                value="<?php echo htmlspecialchars($row['email']); ?>"
                required>
        </div>

        <div class="mb-3">
            <label class="form-label">Phone</label>

            <input
                type="text"
                name="phone"
                class="form-control"
                value="<?php echo htmlspecialchars($row['phone']); ?>"
                pattern="[0-9]{10}"
                maxlength="10"
                required>
        </div>

        <button type="submit" name="update"
                class="btn btn-success">
            Update Student
        </button>

        <a href="view.php" class="btn btn-secondary">
            Cancel
        </a>

    </form>

</div>

</body>
</html>
