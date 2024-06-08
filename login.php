<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'Lab_7');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['login'])) {
    $matric = $_POST['matric'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE matric='$matric' AND password='$password'");

    if ($result->num_rows > 0) {
        $_SESSION['loggedin'] = true;
        $_SESSION['matric'] = $matric;
        header('Location: display.php');
        exit;
    } else {
        $error = "Invalid username or password, try login again.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h1>Welcome to the Login Page</h1>
    <form action="login.php" method="post">
        <label for="matric">Matric:</label><br>
        <input type="text" id="matric" name="matric" required><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" name="login" value="Login">
        <p><a href="register.php">Register</a> here if you have not</p>
    </form>
    <?php
    if (isset($error)) {
        echo "<p style='color:red;'>$error</p>";
    }
    ?>
</body>
</html>
