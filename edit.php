<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
}

include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM students WHERE id='$id'");
    $student = mysqli_fetch_assoc($result);
}

if (isset($_POST['update_student'])) {
    $fullname = $_POST['fullname'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];

    $sql = "UPDATE students SET fullname='$fullname', address='$address', contact='$contact' WHERE id='$id'";
    if (mysqli_query($conn, $sql)) {
        // Set a session message for successful update
        $_SESSION['success_message'] = "Student information updated successfully!";
    } else {
        // Handle potential errors if needed
        $_SESSION['error_message'] = "Error updating student: " . mysqli_error($conn);
    }

    // Redirect to index.php after update
    header('Location: index.php');
    exit(); // Make sure no further code is executed after redirect
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google Fonts for better typography -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Custom CSS for styling -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
        }

        .container {
            width: 80%;
            max-width: 600px;
            background-color: #fff;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            margin-top: 50px;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 16px;
            color: #555;
        }

        input[type="text"], textarea {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
            height: 100px;
        }

        .btn {
            padding: 12px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
            color: #fff;
            background-color: #4CAF50;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s ease;
        }

        .btn i {
            margin-right: 8px;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .btn-cancel {
            background-color: #e74c3c;
        }

        .btn-cancel:hover {
            background-color: #c0392b;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .actions {
            text-align: center;
        }

        .success-msg {
            color: green;
            text-align: center;
            margin-bottom: 20px;
        }

    </style>
</head>
<body>

    <div class="container">
        <h2>Edit Student</h2>

        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $student['id']; ?>">

            <div class="form-group">
                <label for="fullname"><i class="fas fa-user"></i> Full Name</label>
                <input type="text" name="fullname" value="<?php echo $student['fullname']; ?>" required>
            </div>

            <div class="form-group">
                <label for="address"><i class="fas fa-home"></i> Address</label>
                <textarea name="address" required><?php echo $student['address']; ?></textarea>
            </div>

            <div class="form-group">
                <label for="contact"><i class="fas fa-phone"></i> Contact</label>
                <input type="text" name="contact" value="<?php echo $student['contact']; ?>" required>
            </div>

            <div class="actions">
                <input type="submit" name="update_student" value="Update Student" class="btn">
                <a href="index.php" class="btn btn-cancel"><i class="fas fa-times"></i> Cancel</a>
            </div>
        </form>
    </div>

</body>
</html>
