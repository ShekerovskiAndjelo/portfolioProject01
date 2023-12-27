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
    <title>Authors</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="../../Style/crud.css">
</head>

<body>
    <div class="container">
        <h2 class="h1 text-bold d-flex justify-content-center bg-white">Authors</h2>
        <a href="../AdminDashboard/adminDashboard.php" class="btn btn-primary d-flex justify-content-center">Back to Admin Dashboard</a>
    </div>

    <div class="conteiner">
        <div class="row">
            <div class="col-6 offset-3">
                <h2>Add Author</h2>
                <form action="processAuthors.php" method="post">
                    <label for="first_name" class="form-label">First Name:</label>
                    <input type="text" id="first_name" name="first_name" class="form-control" required><br>

                    <label for="last_name" class="form-label">Last Name:</label>
                    <input type="text" id="last_name" name="last_name" class="form-control" required><br>

                    <label for="bio" class="form-label">Bio:</label>
                    <textarea id="bio" name="bio" class="form-control" required></textarea><br>

                    <button type="submit" class="btn btn-success" name="add_author">Add Author</button>
                </form>
            </div>
        </div>
    </div>


    <div class="parent-container">
        <div class="centered-div">




            <?php
            require_once '../../Connection/connection.php'; 

            if (isset($_GET['message'])) {
                echo "<p class='alert alert-success'>{$_GET['message']}</p>";
            }

            $sql = "SELECT id, first_name, last_name, bio, is_deleted FROM authors";
            $stmt = $database->connection->prepare($sql);
            $stmt->execute();
            $authors = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>

            <table border="1" class="table">
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Bio</th>
                    <th>Is Deleted</th>
                    <th>Actions</th>
                </tr>
                <?php
                foreach ($authors as $author) {
                    echo "<tr>";
                    echo "<td>{$author['id']}</td>";
                    echo "<td>{$author['first_name']}</td>";
                    echo "<td>{$author['last_name']}</td>";
                    echo "<td>{$author['bio']}</td>";
                    echo "<td>" . ($author['is_deleted'] ? 'Yes' : 'No') . "</td>";
                    echo "<td>";

                    if ($author['is_deleted'] == 0) {
                        echo "<form method='post' action='processAuthors.php'>";
                        echo "<input type='hidden' class='form-control' name='delete_author' value='{$author['id']}'>";
                        echo "<button type='submit' class='btn btn-danger'>Delete</button>";
                        echo "</form>";

                        echo "<form method='post'  action='processAuthors.php'>";
                        echo "<input type='hidden' class='form-control' name='edit_author' value='{$author['id']}'>";
                        echo "<input type='text' class='form-control' name='new_first_name' placeholder='New First Name' required>";
                        echo "<input type='text' class='form-control' name='new_last_name' placeholder='New Last Name' required>";
                        echo "<textarea name='new_bio'class='form-control' placeholder='New Bio' required></textarea>";
                        echo "<button type='submit' class='btn btn-secondary'>Edit</button>";
                        echo "</form>";
                    } else {
                        echo "Deleted";

                        echo "<form method='post' action='processAuthors.php'>";
                        echo "<input type='hidden' class='form-control' name='restore_author' value='{$author['id']}'>";
                        echo "<button type='submit' class='btn btn-warning'>Restore</button>";
                        echo "</form>";
                    }

                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </table>


        </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>