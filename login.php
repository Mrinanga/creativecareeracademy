<?php
session_start();

// Redirect to the dashboard if the user is already logged in
if (isset($_SESSION['role']) && isset($_SESSION['username'])) {
    if ($_SESSION['role'] === 'admin') {
        header('Location: admindashboard.php');
    } elseif ($_SESSION['role'] === 'teacher') {
        header('Location: teachersdashboard.php');
    } elseif ($_SESSION['role'] === 'student') {
        header('Location: studentdashboard.php');
    }
    exit();
}

// Database configuration
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'creativecareeracademy';

// Create connection
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $role = $_POST['role'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch user credentials from the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE role = ? AND username = ?");
    $stmt->bind_param("ss", $role, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($user['password'] == $password) {
            $_SESSION['role'] = $role;
            $_SESSION['username'] = $username;

            // Redirect based on the role
            if ($role === 'admin') {
                header('Location: admindashboard.php');
            } elseif ($role === 'teacher') {
                header('Location: teachersdashboard.php');
            } elseif ($role === 'student') {
                header('Location: studentdashboard.php');
            }

            exit();
        } else {
            echo 'Invalid credentials';
        }
    } else {
        echo 'Invalid credentials';
    }

    $stmt->close();
}
?>