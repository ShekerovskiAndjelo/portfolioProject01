<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once '../../Connection/connection.php'; 

    $title = $_POST["title"];

    $sql = "INSERT INTO categories (title) VALUES (:title)";
    $stmt = $database->connection->prepare($sql);
    $stmt->bindParam(":title", $title);

    if ($stmt->execute()) {
        echo "Category added successfully.";
    } else {
        echo "Error adding category.";
    }
}
?>

