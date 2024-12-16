<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "Lab_5b");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $matric = $_POST['matric'];
    $name = $_POST['name'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];

    $sql = "INSERT INTO users (matric, name, password, role) VALUES ('$matric', '$name', '$password', '$role')";
    if ($conn->query($sql) === TRUE) {
        echo "Registration successful.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>

<form method="POST" action="">
    Matric: <input type="text" name="matric" required><br>
    Name: <input type="text" name="name" required><br>
    Password: <input type="password" name="password" required><br>
    Role: 
    <select name="role">
        <option value="Lecturer">Lecturer</option>
        <option value="Student">Student</option>
    </select><br>
    <button type="submit">Register</button>
</form>
