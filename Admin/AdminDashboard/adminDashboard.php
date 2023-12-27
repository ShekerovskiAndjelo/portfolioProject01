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
  <title>Admin panel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <link rel="stylesheet" href="../../Style/adminDashboardStyle.css">
</head>

<body>


<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
  <?php
            
            if (isset($_SESSION['user_id']) && $_SESSION['is_Admin'] == 1) {
              echo '<li><a class="navbar-brand" href="#">Welcome, ' . $_SESSION['username'] . '</a></li>';
              echo '<li><a class="getstarted navbar-brand btn btn-danger" href="../../Page/Login/logout.php">Logout</a></li>';
            }
            ?>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="../Comments/showComments.php">Comments</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../Authors/showAuthors.php">Authors</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="../Books/showBooks.php">Books</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="../Categories/showCategories.php">Categories</a>
        </li>
        
        
      </ul>
    </div>
  </div>
</nav>





  <!-- center -->
  <div class="container mt-5">
    <div class="row row-cols-1 row-cols-md-2 g-4">
      <div class="col">
      <a href="../Comments/showComments.php"><div class="card">
          <img src="../../Images/brooke-cagle-g1Kr4Ozfoac-unsplash-min.jpg" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title colorTextTwo d-flex justify-content-center">COMMENTS</h5>
          </div>
        </div></a>
        
      </div>
      <div class="col">
        <a href="../Authors/showAuthors.php"><div class="card ">
          <img src="../../Images/kenny-eliason-EtH7EQgxD4A-unsplash-min.jpg" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title colorTextTwo d-flex justify-content-center">AUTHORS</h5>
           
          </div></a>
        
        </div>
      </div>
      <div class="col">
        <a href="../Books/showBooks.php"><div class="card">
          <img src="../../Images/gulfer-ergin-LUGuCtvlk1Q-unsplash-min.jpg" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title colorTextTwo d-flex justify-content-center">BOOKS</h5>
           
          </div></a>
        
        </div>
      </div>
      <div class="col">
        <a href="../Categories/showCategories.php"><div class="card ">
          <img src="../../Images/gabriel-sollmann-Y7d265_7i08-unsplash-min.jpg" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title colorTextTwo d-flex justify-content-center">CATEGORIES</h5>
            
          </div></a>
        
        </div>
      </div>
    </div>
  </div>


  <div class="container-fluid colorThree mt-5">
    <div class="row pt-2">
      <p class="d-flex justify-content-center colorOneT">Admin panel</p>
    </div>
  </div>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>