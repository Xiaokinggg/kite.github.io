<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login if not logged in
}

include 'config.php';

// Initialize success and error message variables
$success_message = '';
$error_message = '';

// Create a student
if (isset($_POST['add_student'])) {
    $fullname = $_POST['fullname'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];

    $sql = "INSERT INTO students (fullname, address, contact) VALUES ('$fullname', '$address', '$contact')";
    if (mysqli_query($conn, $sql)) {
        // Set the success message if insertion is successful
        $success_message = "Student added successfully!";
    } else {
        // Optionally, handle errors if needed
        $error_message = "Error adding student: " . mysqli_error($conn);
    }
}

// Update a student
if (isset($_POST['update_student'])) {
    $id = $_POST['id'];
    $fullname = $_POST['fullname'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];

    $sql = "UPDATE students SET fullname='$fullname', address='$address', contact='$contact' WHERE id='$id'";
    if (mysqli_query($conn, $sql)) {
        $success_message = "Student information updated successfully!";
    } else {
        $error_message = "Error updating student: " . mysqli_error($conn);
    }
}

// Delete a student
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $sql = "DELETE FROM students WHERE id='$id'";
    if (mysqli_query($conn, $sql)) {
        $success_message = "Student deleted successfully!";
    } else {
        $error_message = "Error deleting student: " . mysqli_error($conn);
    }
}

$result = mysqli_query($conn, "SELECT * FROM students");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student CRUD</title>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google Fonts for better typography -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Custom CSS for styling -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
        }

        .container {
            width: 85%;
            max-width: 1200px;
            background-color: #fff;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        h3 {
            color: #4CAF50;
            margin-bottom: 20px;
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
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .btn-delete {
            background-color: #e74c3c;
        }

        .btn-delete:hover {
            background-color: #c0392b;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 16px;
            color: #555;
        }

        .form-group input, .form-group textarea {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ddd;
            box-sizing: border-box;
        }

        .form-group textarea {
            resize: vertical;
            height: 100px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        .table th, .table td {
            padding: 12px 15px;
            text-align: left;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        .table th {
            background-color: #4CAF50;
            color: white;
        }

        .table td {
            color: #333;
        }

        .table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .table tr:hover {
            background-color: #f1f1f1;
        }

        .actions a {
            margin: 0 10px;
            color: #3498db;
            text-decoration: none;
        }

        .actions a:hover {
            text-decoration: underline;
        }

        .error-msg {
            color: red;
            text-align: center;
            margin-bottom: 20px;
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
        <h2>Welcome, <?php echo $_SESSION['user_id']; ?> | <a href="logout.php" class="btn">Logout</a></h2>

        <!-- Display success message -->
        <?php if ($success_message): ?>
            <div class="success-msg"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <!-- Display error message if any -->
        <?php if ($error_message): ?>
            <div class="error-msg"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <h3>Student List</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Address</th>
                    <th>Contact</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['fullname']; ?></td>
                        <td><?php echo $row['address']; ?></td>
                        <td><?php echo $row['contact']; ?></td>
                        <td class="actions">
                            <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn"><i class="fas fa-edit"></i> Edit</a>
                            <a href="index.php?delete_id=<?php echo $row['id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete?')"><i class="fas fa-trash"></i> Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h3>Add Student</h3>
        <form method="POST">
            <div class="form-group">
                <label for="fullname">Full Name</label>
                <input type="text" name="fullname" id="fullname" required>
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <textarea name="address" id="address" required></textarea>
            </div>

            <div class="form-group">
                <label for="contact">Contact</label>
                <input type="text" name="contact" id="contact" required pattern="\d+" title="Please enter only numbers.">
            </div>

            <input type="submit" name="add_student" value="Add Student" class="btn">
        </form>
    </div>

</body>
</html>
