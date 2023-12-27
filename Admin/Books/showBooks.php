<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['is_Admin'] != 1) {
    header("Location: ../../Page/Home/index.php"); 
    exit();
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Books</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="../../Style/crud.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body>

    <div class="container">
        <h2 class="h1 text-bold d-flex justify-content-center bg-white">Books</h2>
        <a href="../AdminDashboard/adminDashboard.php" class="btn btn-primary d-flex justify-content-center">Back to Admin Dashboard</a>
    </div>

    <div class="parent-container">
        <div class="centered-div">
            <?php
            require_once '../../Connection/connection.php';

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST["delete_book"])) {
                    $book_id = $_POST["delete_book"];

                    $sql = "UPDATE books SET is_deleted = 1 WHERE id = :id";
                    $stmt = $database->connection->prepare($sql);
                    $stmt->bindParam(":id", $book_id);

                    if ($stmt->execute()) {
                        echo "<p class='alert alert-success'>Book marked as deleted.</p>";
                    } else {
                        echo "<p class='alert alert-success'>Error marking book as deleted.</p>";
                    }
                } elseif (isset($_POST["restore_book"])) {
                    $book_id = $_POST["restore_book"];

                    $sql = "UPDATE books SET is_deleted = 0 WHERE id = :id";
                    $stmt = $database->connection->prepare($sql);
                    $stmt->bindParam(":id", $book_id);

                    if ($stmt->execute()) {
                        echo "<p class='alert alert-success'>Book restored.</p>";
                    } else {
                        echo "<p class='alert alert-success'>Error restoring book.</p>";
                    }
                }
            }
            ?>

            <?php
            if (isset($_GET["message"])) {
                echo "<p class='alert alert-success'>{$_GET["message"]}</p>";
            }
            ?>

            <table border="1">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Release Year</th>
                    <th>Pages</th>
                    <th>Image URL</th>
                    <th>Category</th>
                    <th>Is Deleted</th>
                    <th>Action</th>
                </tr>
                <?php
                $sql = "SELECT b.id, b.title, CONCAT(a.first_name, ' ', a.last_name) AS author, 
                       b.release_year, b.pages, b.image_url, c.title AS category, b.is_deleted
                FROM books b
                INNER JOIN authors a ON b.author_id = a.id
                INNER JOIN categories c ON b.category_id = c.id";
                $stmt = $database->connection->prepare($sql);
                $stmt->execute();
                $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($books as $book) {
                    echo "<tr>";
                    echo "<td>{$book['id']}</td>";
                    echo "<td>{$book['title']}</td>";
                    echo "<td>{$book['author']}</td>";
                    echo "<td>{$book['release_year']}</td>";
                    echo "<td>{$book['pages']}</td>";
                    echo "<td>{$book['image_url']}</td>";
                    echo "<td>{$book['category']}</td>";
                    echo "<td>{$book['is_deleted']}</td>";
                    echo "<td>";

                    if ($book['is_deleted'] == 0) {
                        echo "<form method='post' action='showBooks.php'>";
                        echo "<input type='hidden' name='delete_book' value='{$book['id']}'>";
                        echo "<button type='button' class='btn btn-danger delete-book' data-book-id='{$book['id']}'>Delete</button>";
                        echo "</form>";
                        // Add Edit button
                        echo "<a href='editBook.php?id={$book['id']}' class='btn btn-primary'>Edit</a>";
                    } else {
                        echo "<form method='post' action='showBooks.php'>";
                        echo "<input type='hidden' name='restore_book' value='{$book['id']}'>";
                        echo "<button type='button' class='btn btn-warning restore-book' data-book-id='{$book['id']}'>Restore</button>";
                        echo "</form>";
                    }
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </table>

  
    <h2>Add Book</h2>
    <form action="processBooks.php" method="post">
        <label for="title" class="form-label">Title:</label>
        <input type="text" id="title" name="title" class="form-control" required><br>

        <label for="author_id" class="form-label">Author:</label>
        <select id="author_id" name="author_id" class="form-control" required>
            <?php
            $sql = "SELECT id, CONCAT(first_name, ' ', last_name) AS full_name FROM authors";
            $stmt = $database->connection->prepare($sql);
            $stmt->execute();
            $authors = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($authors as $author) {
                echo "<option value='{$author['id']}'>{$author['full_name']}</option>";
            }
            ?>
        </select><br>

        <label for="release_year" class="form-label">Release Year:</label>
        <input type="text" id="release_year" name="release_year" class="form-control" required><br>

        <label for="pages" class="form-label">Pages:</label>
        <input type="text" id="pages" name="pages" class="form-control" required><br>

        <label for="image_url" class="form-label">Image URL:</label>
        <input type="text" id="image_url" name="image_url" class="form-control" required><br>

        <label for="category_id" class="form-label">Category:</label>
        <select id="category_id" name="category_id" class="form-control" required>
            <?php
            $sql = "SELECT id, title FROM categories";
            $stmt = $database->connection->prepare($sql);
            $stmt->execute();
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($categories as $category) {
                echo "<option value='{$category['id']}'>{$category['title']}</option>";
            }
            ?>
        </select><br>

        <button type="submit" name="add_book" class="btn btn-success">Add Book</button>
    </form>
    </div>
   </div>


   <script>
    document.addEventListener("DOMContentLoaded", function () {
        // Add an event listener for the delete buttons
        const deleteButtons = document.querySelectorAll(".delete-book");
        deleteButtons.forEach((button) => {
            button.addEventListener("click", function () {
                const bookId = button.getAttribute("data-book-id");

                // Show SweetAlert confirmation
                Swal.fire({
                    title: "Are you sure?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        // If confirmed, submit the form to delete the book
                        const form = document.createElement("form");
                        form.method = "post";
                        form.action = "showBooks.php";
                        const input = document.createElement("input");
                        input.type = "hidden";
                        input.name = "delete_book";
                        input.value = bookId;
                        form.appendChild(input);
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        });
    });


    document.addEventListener("DOMContentLoaded", function () {
        // Add an event listener for the restore buttons
        const restoreButtons = document.querySelectorAll(".restore-book");
        restoreButtons.forEach((button) => {
            button.addEventListener("click", function () {
                const bookId = button.getAttribute("data-book-id");

                // Show SweetAlert confirmation
                Swal.fire({
                    title: "Restore Book",
                    text: "Are you sure you want to restore this book?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, restore it!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        // If confirmed, submit the form to restore the book
                        const form = document.createElement("form");
                        form.method = "post";
                        form.action = "showBooks.php";
                        const input = document.createElement("input");
                        input.type = "hidden";
                        input.name = "restore_book";
                        input.value = bookId;
                        form.appendChild(input);
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        });
    });
</script>

</body>

</html>