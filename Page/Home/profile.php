<?php
session_start(); // Start the session if it's not already started

// Check if the user is logged in (you should have a way to check this)
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page or handle authentication as needed
    header("Location: login.php"); // Replace 'login.php' with your login page
    exit();
}

// Include the database connection file
require_once '../../Connection/connection.php'; // Assuming your database connection file is named 'database.php'

try {
    // Create a new instance of the Database class to establish a connection
    $database = new Database();
    $conn = $database->connection;

    $userId = $_SESSION['user_id']; // Assuming you store the user ID in the session

    // Fetch the user's information from the database based on their user ID
    $sql = "SELECT email, username FROM users WHERE id = :id";

    // Prepare and execute the query using the PDO object
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $userId, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch the user's information
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    // Assign the email and username to variables
    $userEmail = $userData['email'];
    $username = $userData['username'];

    // Initialize the passwordChangeMessage variable
    $passwordChangeMessage = '';

    // Check if the form was submitted to change the password
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $currentPassword = $_POST["currentPassword"];
        $newPassword = $_POST["newPassword"];

        // Verify the current password
        $verifySql = "SELECT password FROM users WHERE id = :id";
        $stmt = $conn->prepare($verifySql);
        $stmt->bindParam(":id", $userId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (password_verify($currentPassword, $result['password'])) {
            // Hash the new password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Update the password in the database
            $updateSql = "UPDATE users SET password = :password WHERE id = :id";
            $stmt = $conn->prepare($updateSql);
            $stmt->bindParam(":password", $hashedPassword);
            $stmt->bindParam(":id", $userId, PDO::PARAM_INT);
            $stmt->execute();

            // Set a success message
            $passwordChangeMessage = '<div class="alert alert-success">Password changed successfully.</div>';
        } else {
            $passwordChangeMessage = '<div class="alert alert-danger">Password change failed. Please check your current password.</div>';
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

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
                            <li><a class="nav-link scrollto" href="index.php#books">Books</a></li>
                            <li><a class="nav-link scrollto" href="index.php#authors">Authors</a></li>
                        </ul>
                        <i class="bi bi-list mobile-nav-toggle"></i>
                    </nav>
                </div>
            </header>
        </div>
    </header>

    <section class="vh-100" style="background-color: #f4f5f7;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-lg-6 mb-4 mb-lg-0">
                    <div class="card mb-3" style="border-radius: .5rem;">
                        <div class="row g-0">
                            <div class="col-md-4 gradient-custom text-center text-white" style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
                                <img src="../../Images/open-book-icon-2048x2048-wuklhx59.png" alt="Avatar" class="img-fluid my-5" style="width: 80px;" />
                                <i class="far fa-edit mb-5"></i>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body p-4">
                                    <h6>Information</h6>
                                    <hr class="mt-0 mb-4">
                                    <div class="row pt-1">
                                        <div class="col-6 mb-3">
                                            <h6>Email</h6>
                                            <p class="text-muted"><?php echo $userEmail; ?></p>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <h6>Username</h6>
                                            <p class="text-muted"><?php echo $username; ?></p>
                                        </div>
                                        <!-- Password change form -->
                                        <h6>Change password</h6>
                                        <hr>
                                        <form method="post">
                                            <div class="row pt-1">
                                                <div class="col-6 mb-3">
                                                    <h6>Current password</h6>
                                                    <input type="password" class="form-control" id="currentPassword" name="currentPassword" required>
                                                </div>
                                                <div class="col-6 mb-3">
                                                    <h6>New password</h6>
                                                    <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Change Password</button>
                                            <?php echo $passwordChangeMessage; ?>
                                        </form>
                                        <div id="passwordChangeMessage"></div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

</body>

</html>