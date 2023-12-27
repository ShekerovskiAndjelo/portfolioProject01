<?php
session_start();

require_once '../../Connection/connection.php'; 

if (!isset($_SESSION['user_id'])) {
    die("Access denied.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['note_id'])) {
    $user_id = $_SESSION['user_id'];
    $note_id = $_POST['note_id'];

    try {
        $database = new Database();
        $pdo = $database->connection;

        $pdo->beginTransaction();

        $stmt = $pdo->prepare("UPDATE notes SET is_deleted = 1 WHERE id = ? AND user_id = ?");
        $stmt->execute([$note_id, $user_id]);

        $pdo->commit();

        echo "Note deleted successfully.";
    } catch (PDOException $e) {
        $pdo->rollBack();

        error_log("Database error: " . $e->getMessage(), 0); 

        die("Database error: " . $e->getMessage());
    }
}
?>
