<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['is_Admin'] != 1) {
    header("Location: ../../Page/Home/index.php"); 
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Categories</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="../../Style/crud.css">
</head>

<body>
    <div class="container">
        <h2 class="h1 text-bold d-flex justify-content-center bg-white">Categories</h2>
        <a href="../AdminDashboard/adminDashboard.php" class="btn btn-primary d-flex justify-content-center">Back to Admin Dashboard</a>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-6 offset-3">
                <h2>Add Category</h2>
                <form action="showCategories.php" method="post">
                    <label for="title" class="form-label">Category Title:</label>
                    <input type="text" id="title" name="title" class="form-control" required>
                    <button type="submit" class="btn btn-success" name="add_category">Add Category</button>
                </form>
            </div>
        </div>
    </div>

    <div class="parent-container">
        <div class="centered-div">
            <h2>Categories</h2>

            <?php
            require_once '../../Connection/connection.php'; 

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST["add_category"])) {
                    $title = $_POST["title"];
                    $sql = "INSERT INTO categories (title) VALUES (:title)";
                    $stmt = $database->connection->prepare($sql);
                    $stmt->bindParam(":title", $title);

                    if ($stmt->execute()) {
                        echo "<p>Successfully added category.</p>";
                    } else {
                        echo "<p>Error adding category.</p>";
                    }
                } elseif (isset($_POST["delete_category"])) {
                    $category_id = $_POST["delete_category"];
                    $sql = "UPDATE categories SET is_deleted = 1 WHERE id = :id";
                    $stmt = $database->connection->prepare($sql);
                    $stmt->bindParam(":id", $category_id);

                    if ($stmt->execute()) {
                        echo "<p>Category marked as deleted.</p>";
                    } else {
                        echo "<p>Error marking category as deleted.</p>";
                    }
                } elseif (isset($_POST["edit_category"])) {
                    $category_id = $_POST["edit_category"];
                    $new_title = $_POST["new_title"];
                    $sql = "UPDATE categories SET title = :title WHERE id = :id";
                    $stmt = $database->connection->prepare($sql);
                    $stmt->bindParam(":title", $new_title);
                    $stmt->bindParam(":id", $category_id);

                    if ($stmt->execute()) {
                        echo "<p>Category title updated.</p>";
                    } else {
                        echo "<p>Error updating category title.</p>";
                    }
                } elseif (isset($_POST["restore_category"])) {
                    $category_id = $_POST["restore_category"];
                    $sql = "UPDATE categories SET is_deleted = 0 WHERE id = :id";
                    $stmt = $database->connection->prepare($sql);
                    $stmt->bindParam(":id", $category_id);

                    if ($stmt->execute()) {
                        echo "<p>Category restored.</p>";
                    } else {
                        echo "<p>Error restoring category.</p>";
                    }
                }
            }
            ?>

            <table border="1">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Is Deleted</th>
                    <th>Actions</th>
                </tr>
                <?php
                $sql = "SELECT id, title, is_deleted FROM categories";
                $stmt = $database->connection->prepare($sql);
                $stmt->execute();
                $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($categories as $category) {
                    echo "<tr>";
                    echo "<td>" . $category['id'] . "</td>";
                    echo "<td>" . $category['title'] . "</td>";
                    echo "<td>" . ($category['is_deleted'] ? 'Yes' : 'No') . "</td>";
                    echo "<td>";
                    echo "<form method='post' action='showCategories.php'>";
                    echo "<input type='hidden' class='form-control' name='delete_category' value='" . $category['id'] . "'>";
                    echo "<button type='submit' class='btn btn-danger'>Delete</button>";
                    echo "</form>";
                    echo "<form method='post' action='showCategories.php'>";
                    echo "<input type='hidden' class='form-control' name='edit_category' value='" . $category['id'] . "'>";
                    echo "<input type='text' class='form-control' name='new_title' placeholder='New Title' required>";
                    echo "<button type='submit' class='btn btn-warning'>Edit</button>";
                    echo "</form>";
                    if ($category['is_deleted']) {
                        echo "<form method='post' action='showCategories.php'>";
                        echo "<input type='hidden' class='form-control' name='restore_category' value='" . $category['id'] . "'>";
                        echo "<button type='submit' class='btn btn-success'>Restore</button>";
                        echo "</form>";
                    }
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>

</html>
