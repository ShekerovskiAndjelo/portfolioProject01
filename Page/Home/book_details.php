<?php
include '../../Connection/Connection.php';
session_start();

$comments = [];

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $bookId = $_GET['id'];
}

if (isset($_SESSION['user_id'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['submit_comment'])) {
            $commentText = $_POST['comment'];

            $insertQuery = "INSERT INTO comments (book_id, user_id, comment, is_approved, pending, is_denied, is_deleted) VALUES (:book_id, :user_id, :comment, 0, 1, 0, 0)";
            $insertStmt = $database->connection->prepare($insertQuery);
            $insertStmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
            $insertStmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
            $insertStmt->bindParam(':comment', $commentText, PDO::PARAM_STR);

            if ($insertStmt->execute()) {
                echo "<p>Your comment has been submitted and is pending approval.</p>";
            } else {
                echo "<p>Failed to submit your comment.</p>";
            }
        } elseif (isset($_POST['delete_pending_comment'])) {
            $commentId = $_POST['comment_id'];

            $deleteQuery = "UPDATE comments SET is_deleted = 1, pending = 0 WHERE id = :comment_id";
            $deleteStmt = $database->connection->prepare($deleteQuery);
            $deleteStmt->bindParam(':comment_id', $commentId, PDO::PARAM_INT);

            if ($deleteStmt->execute()) {
                echo "<p>Pending comment deleted successfully.</p>";
                header("Location: book_details.php?id=" . $bookId);
                exit;
            } else {
                echo "<p>Failed to delete the pending comment.</p>";
            }
        } elseif (isset($_POST['delete_approved_comment'])) {
            $commentId = $_POST['comment_id'];

            $deleteQuery = "UPDATE comments SET is_deleted = 1, is_approved = 0 WHERE id = :comment_id";
            $deleteStmt = $database->connection->prepare($deleteQuery);
            $deleteStmt->bindParam(':comment_id', $commentId, PDO::PARAM_INT);

            if ($deleteStmt->execute()) {
                echo "<p>Approved comment deleted successfully.</p>";
                header("Location: book_details.php?id=" . $bookId);
                exit;
            } else {
                echo "<p>Failed to delete the approved comment.</p>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Book details - Andjelo's library</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/homepage/2232688.png" rel="icon">
    <link href="assets/img/homepage/2232688.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <link href="assets/css/style.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body>
    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top">
        <div class="container d-flex align-items-center justify-content-between">
            <h1 class="logo"><a href="index.php">Home</a></h1>
            <header id="header" class="fixed-top">
                <div class="container d-flex align-items-center justify-content-between">
                    <a href="index.php" class="logo"><img src="assets/img/homepage/2232688.png" alt="" class="img-fluid" /></a>
                    <nav id="navbar" class="navbar">
                        <ul>
                            <li><a class="nav-link scrollto " href="index.php#hero">Home</a></li>
                            <li><a class="nav-link scrollto" href="index.php#about">About</a></li>
                            <li><a class="nav-link scrollto active" href="index.php#books">Books</a></li>
                            <li><a class="nav-link scrollto" href="index.php#authors">Authors</a></li>
                        </ul>
                        <i class="bi bi-list mobile-nav-toggle"></i>
                    </nav>
                </div>
            </header>
        </div>
    </header>
    <!-- End Header -->

    <main id="main">
        <!-- ======= Breadcrumbs ======= -->
        <section id="breadcrumbs" class="breadcrumbs">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>Book details</h2>
                    <ol>
                        <li><a href="index.php">Home</a></li>
                        <li>Book details</li>
                    </ol>
                </div>
            </div>
        </section>
        <!-- End Breadcrumbs -->

        <!-- ======= Portfolio Details Section ======= -->
        <?php
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $bookId = $_GET['id'];
            $query = "SELECT books.*, authors.first_name AS author_first_name, authors.last_name AS author_last_name, categories.title AS category_title 
                FROM books
                INNER JOIN authors ON books.author_id = authors.id
                INNER JOIN categories ON books.category_id = categories.id
                WHERE books.id = :book_id";

            $stmt = $database->connection->prepare($query);
            $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
            $stmt->execute();
            $book = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($book) {
        ?>
                <section id="portfolio-details" class="portfolio-details">
                    <div class="container">
                        <div class="row gy-4">
                            <div class="col-lg-8">
                                <div class="portfolio-details-slider swiper">
                                    <div class="swiper-wrapper align-items-center">
                                        <div class="swiper-slide">
                                            <img src="<?php echo $book['image_url']; ?>" alt="<?php echo $book['title']; ?>">
                                        </div>
                                    </div>
                                    <div class="swiper-pagination"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="portfolio-info">
                                    <h3>Book Information</h3>
                                    <ul>
                                        <li><strong>Title</strong>: <?php echo $book['title']; ?></li>
                                        <li><strong>Category</strong>: <?php echo $book['category_title']; ?></li>
                                        <li><strong>Author</strong>: <?php echo $book['author_first_name'] . ' ' . $book['author_last_name']; ?></li>
                                        <li><strong>Release Year</strong>: <?php echo $book['release_year']; ?></li>
                                        <li><strong>Pages</strong>: <?php echo $book['pages']; ?></li>
                                    </ul>
                                </div>
                                <div class="portfolio-description"></div>



                                <!-- Comments Form -->
                                <?php
                                if (isset($_SESSION['user_id'])) {
                                    $query = "SELECT COUNT(*) FROM comments WHERE book_id = :book_id AND user_id = :user_id AND (is_approved = 1 OR pending = 1)";
                                    $stmt = $database->connection->prepare($query);
                                    $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
                                    $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
                                    $stmt->execute();
                                    $commentCount = $stmt->fetchColumn();

                                    if ($commentCount == 0) {
                                        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_comment'])) {
                                            $commentText = $_POST['comment'];

                                            $insertQuery = "INSERT INTO comments (book_id, user_id, comment, is_approved, pending, is_denied, is_deleted) VALUES (:book_id, :user_id, :comment, 0, 1, 0, 0)";
                                            $insertStmt = $database->connection->prepare($insertQuery);
                                            $insertStmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
                                            $insertStmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
                                            $insertStmt->bindParam(':comment', $commentText, PDO::PARAM_STR);

                                            if ($insertStmt->execute()) {
                                                echo "<p>Your comment has been submitted and is pending approval.</p>";
                                            } else {
                                                echo "<p>Failed to submit your comment.</p>";
                                            }
                                        } else {
                                ?>
                                            <section id="comment-form" class="comment-form">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <h3>Add a Comment</h3>
                                                            <form action="" method="post">
                                                                <input type="hidden" name="book_id" value="<?php echo $bookId; ?>">
                                                                <div class="form-group">
                                                                    <textarea class="form-control" name="comment" rows="5" placeholder="Your Comment" required></textarea>
                                                                </div>
                                                                <div class="text-center">
                                                                    <button type="submit" name="submit_comment" class="btn btn-primary">Submit Comment</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                        <?php
                                        }
                                    }

                                    $query = "SELECT id, comment FROM comments WHERE user_id = :user_id AND book_id = :book_id AND pending = 1";
                                    $stmt = $database->connection->prepare($query);
                                    $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
                                    $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
                                    $stmt->execute();
                                    $pendingComments = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    if (!empty($pendingComments)) {
                                        ?>
                                        <section id="user-pending-comments" class="user-pending-comments">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <h3>Your Pending Comments</h3>
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Comment</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($pendingComments as $comment) { ?>
                                                                    <tr>
                                                                        <td><?php echo $comment['comment']; ?></td>
                                                                        <td>
                                                                            <form method="POST" action="">
                                                                                <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>">
                                                                                <button type="submit" name="delete_pending_comment">Delete</button>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                <?php
                                    }
                                }
                                ?>


                                <?php
                                $query = "SELECT comments.id, comments.comment, users.username, comments.user_id
FROM comments
INNER JOIN users ON comments.user_id = users.id
WHERE comments.book_id = :book_id
AND comments.is_approved = 1";

                                $stmt = $database->connection->prepare($query);
                                $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
                                $stmt->execute();
                                $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                if (!empty($comments)) {
                                ?>
                                    <section id="comment-list" class="comment-list">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <h3>Approved Comments</h3>
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>User</th>
                                                                <th>Comment</th>
                                                                <?php
                                                                if (isset($_SESSION['user_id'])) {
                                                                ?>
                                                                    <th>Action</th>
                                                                <?php
                                                                }
                                                                ?>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($comments as $comment) { ?>
                                                                <tr>
                                                                    <td><?php echo $comment['username']; ?></td>
                                                                    <td><?php echo $comment['comment']; ?></td>
                                                                    <?php
                                                                    if (isset($_SESSION['user_id'])) {
                                                                    ?>
                                                                        <td>
                                                                            <?php
                                                                            if ($_SESSION['user_id'] == $comment['user_id']) {
                                                                            ?>
                                                                                <form method="POST" action="">
                                                                                    <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>">
                                                                                    <button type="submit" name="delete_approved_comment">Delete</button>
                                                                                </form>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                <?php
                                } else {
                                    echo "<p>No approved comments for this book.</p>";
                                }
                                ?>


                            </div>
                        </div>
                    </div>
                </section>
        <?php
            } else {
                echo "Book not found!";
            }
        } else {
            echo "Invalid book ID!";
        }
        ?>



        <!-- NOTES -->



        <?php
        if (isset($_SESSION['user_id'])) {
            echo '

    




        <!-- Add a section for notes -->
        <div class="container">
        <div class="card">
    <div class="card-header">
    <div class="book-notes">
    <h3 class="d-flex justify-content-center">Your Notes for this Book</h3>
    </div>
    </div>
    <div class="card-body">
    <div class="user-notes ">
    <!-- Notes for the specific book will be displayed here -->
</div>
    </div>
    
  </div>


  <div class="mb-3 d-flex justify-content-center mt-3">
  <textarea id="note-content" class="form-control" placeholder="Add a note"></textarea>
  <button id="add-note-btn" class="btn btn-primary">Add Note</button>

  </div>
            </div>
    ';
        }
        ?>












    </main>
    <!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer">
        <div class="footer-top">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <p>Quote :</p>
                        <p id="quote"></p>
                    </div>
                </div>
                <div class="social-links">
                    <a href="https://twitter.com/" class="twitter"><i class="bx bxl-twitter"></i></a>
                    <a href="https://www.facebook.com/" class="facebook"><i class="bx bxl-facebook"></i></a>
                    <a href="https://www.instagram.com/" class="instagram"><i class="bx bxl-instagram"></i></a>
                    <a href="https://www.linkedin.com/" class="linkedin"><i class="bx bxl-linkedin"></i></a>
                </div>
            </div>
        </div>
    </footer>
    <!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <script src="assets/js/main.js"></script>

    <script>
        function fetchRandomQuote() {
            fetch('http://api.quotable.io/random')
                .then(response => response.json())
                .then(data => {
                    const quoteElement = document.getElementById('quote');
                    quoteElement.textContent = data.content;
                })
                .catch(error => {
                    console.error('Error fetching quote:', error);
                });
        }

        fetchRandomQuote();
    </script>

    <script>
        $(document).ready(function() {
            var urlParams = new URLSearchParams(window.location.search);
            var bookId = urlParams.get('id');

            function loadBookNotes() {
                $.ajax({
                    type: "GET",
                    url: "get_notes.php",
                    data: {
                        book_id: bookId
                    },
                    success: function(response) {
                        $(".user-notes").html(response);
                    }
                });
            }

            function deleteNote(noteId, noteContainer) {
                $.ajax({
                    type: "POST",
                    url: "delete_note.php",
                    data: {
                        note_id: noteId
                    },
                    success: function(response) {
                        noteContainer.hide();
                    }
                });
            }

            loadBookNotes();

            $("#add-note-btn").click(function() {
                var content = $("#note-content").val();

                $.ajax({
                    type: "POST",
                    url: "add_note.php",
                    data: {
                        book_id: bookId,
                        content: content
                    },
                    success: function(response) {
                        loadBookNotes();
                    }
                });
            });

            $(".user-notes").on("click", ".delete-note-btn", function() {
                var noteId = $(this).data("note-id");
                var noteContainer = $(this).closest(".note");
                deleteNote(noteId, noteContainer);
            });
        });
    </script>
</body>

</html>