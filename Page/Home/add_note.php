<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Access denied.");
}

require_once '../../Connection/connection.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $book_id = $_POST['book_id'];
    $content = $_POST['content'];

    try {
        $database = new Database();
        $pdo = $database->connection;

        $stmt = $pdo->prepare("INSERT INTO notes (user_id, book_id, content) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $book_id, $content]);

        echo "Note added successfully.";
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}
?>
