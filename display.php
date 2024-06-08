<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'Lab_7');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['delete'])) {
    $matric = $_GET['delete'];
    $conn->query("DELETE FROM users WHERE matric='$matric'");
    header('Location: display.php');
}

if (isset($_POST['update'])) {
    $matric = $_POST['matric'];
    $name = $_POST['name'];
    $role = $_POST['role'];
    $conn->query("UPDATE users SET name='$name', role='$role' WHERE matric='$matric'");
    header('Location: display.php');
}

$sql = "SELECT matric, name, role FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<div style='text-align:center;'>"; 
    echo "<table border='1' style='width: 50%; background-color: lightblue;'>"; 
    echo "<tr style='background-color: rgb(0, 0, 0); color: white;'><th>Matric</th><th>Name</th><th>Level</th><th>Action</th></tr>";
    $count = 0;
    while($row = $result->fetch_assoc()) {
        $count++;
        $bgcolor = ($count % 2 == 0) ? 'lightgray' : 'white'; 
        echo "<tr style='background-color: $bgcolor;'><td>" . $row["matric"]. "</td><td>" . $row["name"]. "</td><td>" . $row["role"]. "</td>";
        echo "<td><a href='update.php?matric=" . $row["matric"] . "'>Update</a> | <a href='display.php?delete=" . $row["matric"] . "'>Delete</a></td></tr>";
    }
    echo "</table>";
    echo "</div>";
} else {
    echo "0 results";
}
$conn->close();
?>
