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

// Handle Delete
if (isset($_GET['delete'])) {
    $matric = $_GET['delete'];
    $sql = "DELETE FROM users WHERE matric = '$matric'";
    $conn->query($sql);
    header("Location: display.php");
    exit;
}

$sql = "SELECT matric, name, role FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>User List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            max-width: 800px;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        a {
            color: blue;
            text-decoration: none;
            margin-right: 10px;
        }
        a:hover {
            text-decoration: underline;
        }
        .logout {
            float: right;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <a href="logout.php" class="logout">Logout</a>
    <h2>User List</h2>
    <table>
        <tr>
            <th>Matric</th>
            <th>Name</th>
            <th>Level</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["matric"] . "</td>
                        <td>" . $row["name"] . "</td>
                        <td>" . $row["role"] . "</td>
                        <td>
                            <a href='update.php?matric=" . $row["matric"] . "'>Update</a>
                            <a href='display.php?delete=" . $row["matric"] . "'>Delete</a>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No records found</td></tr>";
        }
        ?>
    </table>
</body>
</html>
<?php $conn->close(); ?>
