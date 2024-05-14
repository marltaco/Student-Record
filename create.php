<?php
session_start();

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $gpa = $_POST['gpa'];

    $insert_student_sql = "INSERT INTO student (name, age, email, gpa) VALUES ('$name', '$age', '$email', '$gpa')";
    
    if ($conn->query($insert_student_sql) === TRUE) {
        $success_message = "Student details added successfully!";
    } else {
        $error_message = "Error: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/form.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <style>
    </style>
</head>
<body>
    <h2>Welcome, Admin!</h2>
    
    <?php if (isset($success_message)) : ?>
        <p style="color: green;"><?php echo $success_message; ?></p>
    <?php endif; ?>

    <?php if (isset($error_message)) : ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <h3>Add Student Details</h3>
    <form method="post" action="">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="age">Age:</label>
        <input type="number" id="age" name="age" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="gpa">GPA:</label>
        <input type="number" step="0.01" id="gpa" name="gpa" required>

        <button type="submit">Add Student</button>
    </form>

    <a href="admin_dashboard.php">Back to Admin Dashboard</a>


</body>
</html>
