<?php
require_once '../../Connection/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add_book"])) {
        $title = $_POST["title"];
        $author_id = $_POST["author_id"];
        $release_year = $_POST["release_year"];
        $pages = $_POST["pages"];
        $image_url = $_POST["image_url"];
        $category_id = $_POST["category_id"];

        $sql = "INSERT INTO books (title, author_id, release_year, pages, image_url, category_id) 
                VALUES (:title, :author_id, :release_year, :pages, :image_url, :category_id)";
        $stmt = $database->connection->prepare($sql);
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":author_id", $author_id);
        $stmt->bindParam(":release_year", $release_year);
        $stmt->bindParam(":pages", $pages);
        $stmt->bindParam(":image_url", $image_url);
        $stmt->bindParam(":category_id", $category_id);

        if ($stmt->execute()) {
            $message = "Book added successfully.";
        } else {
            $message = "Error adding book.";
        }

        header("Location: showBooks.php?message=" . urlencode($message));
        exit();
    } elseif (isset($_POST["delete_book"])) {
        $book_id = $_POST["delete_book"];
        
        $sql = "UPDATE books SET is_deleted = 1 WHERE id = :id";
        $stmt = $database->connection->prepare($sql);
        $stmt->bindParam(":id", $book_id);

        if ($stmt->execute()) {
            $message = "Book marked as deleted.";
        } else {
            $message = "Error marking book as deleted.";
        }

        header("Location: showBooks.php?message=" . urlencode($message));
        exit();
    } elseif (isset($_POST["restore_book"])) {
        $book_id = $_POST["restore_book"];
        
        $sql = "UPDATE books SET is_deleted = 0 WHERE id = :id";
        $stmt = $database->connection->prepare($sql);
        $stmt->bindParam(":id", $book_id);

        if ($stmt->execute()) {
            $message = "Book restored.";
        } else {
            $message = "Error restoring book.";
        }

        header("Location: showBooks.php?message=" . urlencode($message));
        exit();
    }
}
?>




