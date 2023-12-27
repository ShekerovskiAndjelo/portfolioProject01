<?php
session_start();

require_once '../../Connection/connection.php'; 

if (!isset($_SESSION['user_id'])) {
    die("Access denied.");
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['book_id'])) {
    $user_id = $_SESSION['user_id'];
    $book_id = $_GET['book_id'];

    try {
        $database = new Database();
        $pdo = $database->connection;

        $stmt = $pdo->prepare("SELECT id, content, is_deleted FROM notes WHERE user_id = ? AND book_id = ?");
        $stmt->execute([$user_id, $book_id]);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row['is_deleted'] == 0) {
                echo '<div class="note">';
                echo htmlspecialchars($row['content']);
                echo '<button class="delete-note-btn" data-note-id="' . $row['id'] . '">Delete</button>';
                echo '</div>';
            }
        }
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}
?>
