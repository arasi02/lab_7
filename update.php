<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'lab_7');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$row = [];

if (isset($_GET['matric'])) {
    $matric = $_GET['matric'];
    $result = $conn->query("SELECT * FROM users WHERE matric='$matric'");
    $row = $result->fetch_assoc();
}

if (isset($_POST['update'])) {
    $matric = $_POST['matric'];
    $name = $_POST['name'];
    $role = $_POST['role'];
    $conn->query("UPDATE users SET name='$name', role='$role' WHERE matric='$matric'");
    header('Location: display.php');
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update User</title>
</head>
<body>
    <form action="update.php" method="post">
        <label for="matric">Matric</label><br>
        <input type="text" id="matric" name="matric" value="<?php echo isset($row['matric']) ? $row['matric'] : ''; ?>" required><br>
        <label for="name">Name</label><br>
        <input type="text" id="name" name="name" value="<?php echo isset($row['name']) ? $row['name'] : ''; ?>" required><br>
        <label for="role">Role</label><br>
        <select id="role" name="role" required>
            <option value="student" <?php if (isset($row['role']) && $row['role'] == 'student') echo 'selected'; ?>>Student</option>
            <option value="lecturer" <?php if (isset($row['role']) && $row['role'] == 'lecturer') echo 'selected'; ?>>Lecturer</option>
        </select><br><br>
        <input type="submit" name="update" value="Update">
        <a href="display.php">Cancel</a>
    </form>
</body>
</html>
