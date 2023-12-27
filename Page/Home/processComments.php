<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    if (isset($_POST['delete_pending_comment'])) {
        $commentIdToDelete = $_POST['comment_id'];

        $deleteQuery = "UPDATE comments SET is_deleted = 1, pending = 0 WHERE id = :comment_id AND user_id = :user_id";
        $deleteStmt = $database->connection->prepare($deleteQuery);
        $deleteStmt->bindParam(':comment_id', $commentIdToDelete, PDO::PARAM_INT);
        $deleteStmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        
        if ($deleteStmt->execute()) {
            header('Location: book_details.php?book_id=' . $bookId);
            exit();
        } else {
            echo "Error deleting the comment.";
        }
    } elseif (isset($_POST['delete_approved_comment'])) {
        $commentIdToDelete = $_POST['comment_id'];
        $userId = $_SESSION['user_id'];

        $checkOwnershipQuery = "SELECT id FROM comments WHERE id = :comment_id AND user_id = :user_id";
        $checkOwnershipStmt = $database->connection->prepare($checkOwnershipQuery);
        $checkOwnershipStmt->bindParam(':comment_id', $commentIdToDelete, PDO::PARAM_INT);
        $checkOwnershipStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $checkOwnershipStmt->execute();
        $commentOwner = $checkOwnershipStmt->fetch(PDO::FETCH_ASSOC);

        if ($commentOwner) {
            $deleteQuery = "UPDATE comments SET is_deleted = 1, is_approved = 0 WHERE id = :comment_id";
            $deleteStmt = $database->connection->prepare($deleteQuery);
            $deleteStmt->bindParam(':comment_id', $commentIdToDelete, PDO::PARAM_INT);

            if ($deleteStmt->execute()) {
                header('Location: book_details.php?book_id=' . $bookId);
                exit();
            } else {
                echo "Error deleting the comment.";
            }
        } else {
            echo "You do not have permission to delete this comment.";
        }
    } else {
    }
} else {
}
?>
