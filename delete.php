<?php
session_start();

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include("config.php");

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $student_id = $_GET['id'];

    $delete_student_sql = "DELETE FROM student WHERE id = $student_id";
    
    if ($conn->query($delete_student_sql) === TRUE) {
        $success_message = "Student record deleted successfully!";
    } else {
        $error_message = "Error: " . $conn->error;
    }
} else {
    $error_message = "Invalid student ID.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Student</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #ecf0f1;
        }

        h2 {
            color: #333;
        }

        p {
            margin: 10px 0;
        }

        p a {
            color: #3498db;
            text-decoration: none;
        }

        p a:hover {
            text-decoration: underline;
        }


    </style>
</head>
<body>
    <h2>Delete Student</h2>
    
    <?php if (isset($success_message)) : ?>
        <p style="color: green;"><?php echo $success_message; ?></p>
    <?php endif; ?>

    <?php if (isset($error_message)) : ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <p><a href="admin_dashboard.php">Back to Admin Dashboard</a></p>

</body>
</html>
