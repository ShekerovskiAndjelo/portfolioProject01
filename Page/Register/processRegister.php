<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../../Connection/connection.php'; 

    $database = new Database();

    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $email = trim($_POST['email']);

    
    if (empty($username) || empty($password) || empty($email)) {
        $message = "All fields are required.";
        header("Location: register.php?message=" . urlencode($message));
        exit();
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format.";
        header("Location: register.php?message=" . urlencode($message));
        exit();
    } else {
        
        $stmt = $database->connection->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $existingUser = $stmt->fetch();

        if ($existingUser) {
            $message = "Username or email already exists.";
            header("Location: register.php?message=" . urlencode($message));
            exit();
        } else {
            // Insert the new user into the database
            try {
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

                $stmt = $database->connection->prepare("INSERT INTO users (username, password, email) VALUES (:username, :password, :email)");
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':password', $hashedPassword);
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                $message = "Registration successful!";
                header("Location: register.php?message=" . urlencode($message));
                exit();
            } catch (PDOException $e) {
                $message = "Error: " . $e->getMessage();
                header("Location: register.php?message=" . urlencode($message));
                exit();
            }
        }
    }
} else {
    echo "Invalid request";
}
?>


