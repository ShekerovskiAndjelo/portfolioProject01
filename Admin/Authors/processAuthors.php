<?php
require_once '../../Connection/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add_author"])) {
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $bio = $_POST["bio"];

        $sql = "INSERT INTO authors (first_name, last_name, bio) VALUES (:first_name, :last_name, :bio)";
        $stmt = $database->connection->prepare($sql);
        $stmt->bindParam(":first_name", $first_name);
        $stmt->bindParam(":last_name", $last_name);
        $stmt->bindParam(":bio", $bio);

        if ($stmt->execute()) {
            header("Location: showAuthors.php?message=Successfully added author.");
            exit;
        } else {
            header("Location: showAuthors.php?message=Error adding author.");
            exit;
        }
    } elseif (isset($_POST["delete_author"])) {
        $author_id = $_POST["delete_author"];
        
        $sql = "UPDATE authors SET is_deleted = 1 WHERE id = :id";
        $stmt = $database->connection->prepare($sql);
        $stmt->bindParam(":id", $author_id);

        if ($stmt->execute()) {
            header("Location: showAuthors.php?message=Author marked as deleted.");
            exit;
        } else {
            header("Location: showAuthors.php?message=Error marking author as deleted.");
            exit;
        }
    } elseif (isset($_POST["edit_author"])) {
        $author_id = $_POST["edit_author"];
        $new_first_name = $_POST["new_first_name"];
        $new_last_name = $_POST["new_last_name"];
        $new_bio = $_POST["new_bio"];
        
        $sql = "UPDATE authors SET first_name = :first_name, last_name = :last_name, bio = :bio WHERE id = :id";
        $stmt = $database->connection->prepare($sql);
        $stmt->bindParam(":id", $author_id);
        $stmt->bindParam(":first_name", $new_first_name);
        $stmt->bindParam(":last_name", $new_last_name);
        $stmt->bindParam(":bio", $new_bio);

        if ($stmt->execute()) {
            header("Location: showAuthors.php?message=Author details updated.");
            exit;
        } else {
            header("Location: showAuthors.php?message=Error updating author details.");
            exit;
        }
    } elseif (isset($_POST["restore_author"])) {
        $author_id = $_POST["restore_author"];
        
        $sql = "UPDATE authors SET is_deleted = NULL WHERE id = :id";
        $stmt = $database->connection->prepare($sql);
        $stmt->bindParam(":id", $author_id);

        if ($stmt->execute()) {
            header("Location: showAuthors.php?message=Author restored.");
            exit;
        } else {
            header("Location: showAuthors.php?message=Error restoring author.");
            exit;
        }
    }
}
?>
