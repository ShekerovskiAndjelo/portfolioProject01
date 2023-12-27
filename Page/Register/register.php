<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="../../Style/register.css">
</head>

<body>
    <div class="parent-container">
        <div class="centered-div">
            
    <?php
    if (isset($_GET['message'])) {
        echo '<p class="alert alert-danger">' . $_GET['message'] . '</p>';
    }
    ?>

    <form method="post" action="processRegister.php">
        <label for="username" class="form-label">Username:</label>
        <input type="text" name="username" class="form-control" required><br>

        <label for="password" class="form-label">Password:</label>
        <input type="password" name="password" class="form-control" required><br>

        <label for="email" class="form-label">Email:</label>
        <input type="email" name="email" class="form-control" required><br>

        <button type="submit" class="btn btn-primary">Register</button>
    </form>

    <a href="../Login/login.php" class="btn btn-success mt-2">Already have an account?</a>
        </div>
    </div>
    


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>