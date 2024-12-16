<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "Lab_5b");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$matric = "";
$name = "";
$role = "";

if (isset($_GET['matric'])) {
    $matric = $_GET['matric'];
    $sql = "SELECT * FROM users WHERE matric = '$matric'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $role = $row['role'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matric = $_POST['matric'];
    $name = $_POST['name'];
    $role = $_POST['role'];

    $sql = "UPDATE users SET name = '$name', role = '$role' WHERE matric = '$matric'";
    if ($conn->query($sql) === TRUE) {
        header("Location: display.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            max-width: 500px;
        }
        h2 {
            margin-bottom: 20px;
        }
        form {
            border: 1px solid #ccc;
            padding: 20px;
        }
        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin: 5px 0 15px 0;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        a {
            color: purple;
            text-decoration: none;
            margin-left: 10px;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h2>Update User</h2>
    <form method="POST" action="">
        Matric <input type="text" name="matric" value="<?php echo $matric; ?>" readonly><br>
        Name <input type="text" name="name" value="<?php echo $name; ?>"><br>
        Access Level <input type="text" name="role" value="<?php echo $role; ?>"><br>
        <input type="submit" value="Update">
        <a href="display.php">Cancel</a>
    </form>
</body>
</html>
<?php $conn->close(); ?> 