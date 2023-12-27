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
    <title>Comments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="../../Style/crud.css">
</head>

<body>
    <div class="container">
        <h2 class="h1 text-bold d-flex justify-content-center bg-white">Categories</h2>
        <a href="../AdminDashboard/adminDashboard.php" class="btn btn-primary d-flex justify-content-center">Back to Admin Dashboard</a>
    </div>

    <div class="parent-container">
        <div class="centered-div">
            <h1>Comments</h1>
            <table border="1" class='table'>
                <tr>
                    <th>ID</th>
                    <th>Comment</th>
                    <th>User</th>
                    <th>Book</th>
                    <th>Deleted by User</th>
                    <th>Action</th>
                </tr>

                <?php
                require_once '../../Connection/connection.php';

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    try {
                        $database = new Database();
                        $conn = $database->connection;

                        if (isset($_POST["comment_id"])) {
                            $commentId = $_POST["comment_id"];
                            $action = $_POST["action"];

                            if ($action === "approve") {
                                $updateSql = "UPDATE comments SET is_approved = 1, pending = 0, is_denied = 0 WHERE id = :id";
                            } elseif ($action === "deny") {
                                $updateSql = "UPDATE comments SET is_approved = 0, pending = 0, is_denied = 1 WHERE id = :id";
                            } elseif ($action === "reset") {
                                $updateSql = "UPDATE comments SET is_approved = 0, pending = 1, is_denied = 0 WHERE id = :id";
                            } elseif ($action === "reset_to_pending") {
                                $updateSql = "UPDATE comments SET is_deleted = 0, pending = 1 WHERE id = :id";
                            }

                            $stmt = $conn->prepare($updateSql);
                            $stmt->bindParam(":id", $commentId, PDO::PARAM_INT);
                            $stmt->execute();
                        }
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                }

                try {
                    $database = new Database();
                    $conn = $database->connection;

                    $sql = "SELECT c.id, c.comment, u.username, b.title, c.is_approved, c.pending, c.is_denied, c.is_deleted
                            FROM comments c
                            INNER JOIN users u ON c.user_id = u.id
                            INNER JOIN books b ON c.book_id = b.id";
                    $result = $conn->query($sql);

                    if ($result->rowCount() > 0) {
                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>" . $row["id"] . "</td>";
                            echo "<td>" . $row["comment"] . "</td>";
                            echo "<td>" . $row["username"] . "</td>";
                            echo "<td>" . $row["title"] . "</td>";
                            echo "<td>" . ($row["is_deleted"] ? 'Yes' : 'No') . "</td>";
                            echo "<td>";
                            if ($row["is_deleted"] == 1) {
                                // Display a "Reset to Pending" button for comments with is_deleted = 1
                                echo "<form method='post'>";
                                echo "<input type='hidden' name='comment_id' value='" . $row["id"] . "'>";
                                echo "<input type='hidden' name='action' value='reset_to_pending'>";
                                echo "<input type='submit' class='btn btn-info' value='Reset to Pending'>";
                                echo "</form>";
                            } elseif ($row["is_approved"] == 0 && $row["is_denied"] == 0) {
                                // Display approve and deny buttons for pending comments
                                echo "<form method='post'>";
                                echo "<input type='hidden' name='comment_id' value='" . $row["id"] . "'>";
                                echo "<input type='hidden' name='action' value='approve'>";
                                echo "<input type='submit' class='btn btn-success' value='Approve Comment'>";
                                echo "</form>";

                                echo "<form method='post'>";
                                echo "<input type='hidden' name='comment_id' value='" . $row["id"] . "'>";
                                echo "<input type='hidden' name='action' value='deny'>";
                                echo "<input type='submit' class='btn btn-danger' value='Deny Comment'>";
                                echo "</form>";
                            } elseif ($row["is_approved"] == 1 && $row["is_denied"] == 0) {
                                // Display reset button for approved comments
                                echo "Approved";
                                echo "<form method='post'>";
                                echo "<input type='hidden' name='comment_id' value='" . $row["id"] . "'>";
                                echo "<input type='hidden' name='action' value='reset'>";
                                echo "<input type='submit' class='btn btn-warning' value='Reset'>";
                                echo "</form>";
                            } elseif ($row["is_approved"] == 0 && $row["is_denied"] == 1) {
                                // Display reset button for denied comments
                                echo "Denied";
                                echo "<form method='post'>";
                                echo "<input type='hidden' name='comment_id' value='" . $row["id"] . "'>";
                                echo "<input type='hidden' name='action' value='reset'>";
                                echo "<input type='submit' class='btn btn-warning' value='Reset'>";
                                echo "</form>";
                            }
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No comments found</td></tr>";
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                ?>
            </table>
        </div>
    </div>
</body>

</html>
