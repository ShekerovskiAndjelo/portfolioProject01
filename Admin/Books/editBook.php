<?php
// Include necessary files and initialize database connection
require_once '../../Connection/connection.php';

// Check if book ID is provided in the URL parameter
if (isset($_GET['id'])) {
    $bookId = $_GET['id'];

    // Fetch book information from the database using $bookId
    $sql = "SELECT * FROM books WHERE id = :id";
    $stmt = $database->connection->prepare($sql);
    $stmt->bindParam(":id", $bookId);
    $stmt->execute();
    $book = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$book) {
        // Handle the case where the book with the given ID does not exist
        // You can redirect or display an error message
        // For simplicity, we'll redirect to the showBooks.php page
        header("Location: showBooks.php?message=Book not found");
        exit();
    }
} else {
    // Handle the case where the book ID is not provided in the URL
    // You can redirect or display an error message
    // For simplicity, we'll redirect to the showBooks.php page
    header("Location: showBooks.php?message=Book ID not provided");
    exit();
}

// Check if the form is submitted to update book details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_book"])) {
    // Retrieve form data
    $newTitle = $_POST["title"];
    $newAuthorId = $_POST["author_id"];
    $newReleaseYear = $_POST["release_year"];
    $newPages = $_POST["pages"];
    $newImageUrl = $_POST["image_url"];
    $newCategoryId = $_POST["category_id"];

    // Update book details in the database
    $updateSql = "UPDATE books SET title = :title, author_id = :author_id, release_year = :release_year, 
                  pages = :pages, image_url = :image_url, category_id = :category_id WHERE id = :id";

    $updateStmt = $database->connection->prepare($updateSql);
    $updateStmt->bindParam(":id", $bookId);
    $updateStmt->bindParam(":title", $newTitle);
    $updateStmt->bindParam(":author_id", $newAuthorId);
    $updateStmt->bindParam(":release_year", $newReleaseYear);
    $updateStmt->bindParam(":pages", $newPages);
    $updateStmt->bindParam(":image_url", $newImageUrl);
    $updateStmt->bindParam(":category_id", $newCategoryId);

    if ($updateStmt->execute()) {
        // Redirect to the showBook.php page with a success message
        header("Location: showBooks.php?message=Book updated successfully");
        exit();
    } else {
        // Handle the case where the update query fails
        echo "<p class='alert alert-danger'>Error updating book details.</p>";
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="../../Style/crud.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body>

    <div class="container">
        <h2 class="h1 text-bold d-flex justify-content-center bg-white">Edit Book</h2>
        <a href="showBooks.php" class="btn btn-primary d-flex justify-content-center">Back to Books</a>
    </div>

    <div class="parent-container">
        <div class="centered-div">
            <form action="editBook.php?id=<?php echo $book['id']; ?>" method="post">
                <div class="mb-3">
                    <label for="title" class="form-label">Title:</label>
                    <input type="text" id="title" name="title" class="form-control" required value="<?php echo $book['title']; ?>">
                </div>

                <div class="mb-3">
                    <label for="author_id" class="form-label">Author:</label>
                    <select id="author_id" name="author_id" class="form-control" required>
                        <!-- Populate the author options based on your database -->
                        <?php
                        $sql = "SELECT id, CONCAT(first_name, ' ', last_name) AS full_name FROM authors";
                        $stmt = $database->connection->prepare($sql);
                        $stmt->execute();
                        $authors = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($authors as $author) {
                            $selected = ($author['id'] == $book['author_id']) ? 'selected' : '';
                            echo "<option value='{$author['id']}' $selected>{$author['full_name']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="release_year" class="form-label">Release Year:</label>
                    <input type="text" id="release_year" name="release_year" class="form-control" required value="<?php echo $book['release_year']; ?>">
                </div>

                <div class="mb-3">
                    <label for="pages" class="form-label">Pages:</label>
                    <input type="text" id="pages" name="pages" class="form-control" required value="<?php echo $book['pages']; ?>">
                </div>

                <div class="mb-3">
                    <label for="image_url" class="form-label">Image URL:</label>
                    <input type="text" id="image_url" name="image_url" class="form-control" required value="<?php echo $book['image_url']; ?>">
                </div>

                <div class="mb-3">
                    <label for="category_id" class="form-label">Category:</label>
                    <select id="category_id" name="category_id" class="form-control" required>
                        <!-- Populate the category options based on your database -->
                        <?php
                        $sql = "SELECT id, title FROM categories";
                        $stmt = $database->connection->prepare($sql);
                        $stmt->execute();
                        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($categories as $category) {
                            $selected = ($category['id'] == $book['category_id']) ? 'selected' : '';
                            echo "<option value='{$category['id']}' $selected>{$category['title']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <button type="submit" name="update_book" class="btn btn-success">Update Book</button>
            </form>
        </div>
    </div>

    <script>
        // JavaScript code for SweetAlert confirmation dialogs
        // ...
    </script>

</body>

</html>
