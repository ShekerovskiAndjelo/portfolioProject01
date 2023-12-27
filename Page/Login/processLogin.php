<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../../Connection/connection.php'; 

    $database = new Database();

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $database->connection->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['is_Admin'] = $user['is_Admin'];

        if ($user['is_Admin'] == 1) {
            header("Location: ../../Admin/AdminDashboard/adminDashboard.php"); 
        } else {
            header("Location: ../Home/index.php"); 
        }
        exit();
    } else {
        $message = "Invalid credentials.";
        header("Location: login.php?message=" . urlencode($message));
        exit();
    }
} else {
    echo "Invalid request";
}
?>

