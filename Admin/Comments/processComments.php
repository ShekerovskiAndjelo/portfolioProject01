<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    require_once '../../Connection/connection.php'; 

    $database = new Database();

    $bookId = $_POST['book_id'];
    $comment = $_POST['comment'];
    $userId = $_SESSION['user_id'];

    $stmt = $database->connection->prepare("INSERT INTO comments (comment, book_id, user_id, is_approved, pending, is_denied) VALUES (:comment, :book_id, :user_id, 0, 1, 0)");
    $stmt->bindParam(':comment', $comment);
    $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();

    header("Location: ../../Page/Home/book_details.php?id=$bookId");
    exit();
} else {
    echo "Invalid request";
}
?>

