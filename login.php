<?php
session_start();

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "Lab_5b");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $matric = $_POST['matric'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE matric = '$matric'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user'] = $row['name'];
            header("Location: display.php");
            exit;
        } else {
            $error_message = "Invalid username or password, try <a href='login.php'>login</a> again.";
        }
    } else {
        $error_message = "Invalid username or password, try <a href='login.php'>login</a> again.";
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        .error-message {
            border: 1px solid black;
            padding: 10px;
            margin: 10px 0;
            display: inline-block;
        }
    </style>
</head>
<body>
    <?php if ($error_message): ?>
        <div class="error-message">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        Matric: <input type="text" name="matric" required><br>
        Password: <input type="password" name="password" required><br>
        <input type="submit" value="Login">
    </form>
    <a href="register.php">Register</a> here if you have not.
</body>
</html>
