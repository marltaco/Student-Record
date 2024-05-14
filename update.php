<?php
session_start();

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include("config.php");

$student_data = []; // Initialize $student_data variable

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $student_id = $_GET['id'];

    $select_student_sql = "SELECT * FROM student WHERE id = $student_id";
    $result = $conn->query($select_student_sql);

    if ($result->num_rows > 0) {
        $student_data = $result->fetch_assoc();
    } else {
        $error_message = "Student not found.";
    }
} else {
    $error_message = "Invalid student ID.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'update') {
        $name = $_POST['name'];
        $age = $_POST['age'];
        $email = $_POST['email'];
        $gpa = $_POST['gpa'];

        $update_student_sql = "UPDATE student SET name = '$name', age = '$age', email = '$email', gpa = '$gpa' WHERE id = $student_id";
        
        if ($conn->query($update_student_sql) === TRUE) {
            $success_message = "Student details updated successfully!";
        } else {
            $error_message = "Error: " . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        
        h2 {
            text-align: center;
            margin-top: 50px;
        }
        
        form {
            width: 300px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        label {
            display: block;
            margin-bottom: 5px;
        }
        
        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }
        
        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        
        button:hover {
            background-color: #45a049;
        }
        
        p {
            text-align: center;
            color: <?php echo isset($success_message) ? 'green' : 'red'; ?>;
        }
    </style>
</head>
<body>
    <h2>Update Student</h2>
    
    <?php if (isset($success_message) || isset($error_message)) : ?>
        <p><?php echo isset($success_message) ? $success_message : $error_message; ?></p>
    <?php endif; ?>

    <form method="post" action="">
        <input type="hidden" name="action" value="update">
        
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo isset($student_data['name']) ? $student_data['name'] : ''; ?>" required>

        <label for="age">Age:</label>
        <input type="number" id="age" name="age" value="<?php echo isset($student_data['age']) ? $student_data['age'] : ''; ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo isset($student_data['email']) ? $student_data['email'] : ''; ?>" required>

        <label for="gpa">GPA:</label>
        <input type="number" step="0.01" id="gpa" name="gpa" value="<?php echo isset($student_data['gpa']) ? $student_data['gpa'] : ''; ?>" required>

        <button type="submit">Update Student</button>
    </form>

    <p><a href="admin_dashboard.php">Back to Admin Dashboard</a></p>
</body>
</html>
