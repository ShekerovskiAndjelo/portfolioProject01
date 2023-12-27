<?php
include '../../Connection/connection.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />

  <title>Andjelo's library</title>
  <meta content="" name="description" />
  <meta content="" name="keywords" />

  <!-- Favicons -->
  <link href="assets/img/homepage/2232688.png" rel="icon" />
  <link href="assets/img/homepage/2232688.png" rel="apple-touch-icon" />

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet" />

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet" />
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet" />
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet" />




  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet" />

</head>

<body>


  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center justify-content-between">
      <!-- <h1 class="logo"><a href="index.html">Andjelo's library</a></h1> -->
      <a href="index.php" class="logo"><img src="assets/img/homepage/2232688.png" alt="" class="img-fluid" /></a>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
          <li><a class="nav-link scrollto" href="#about">About</a></li>
          <li><a class="nav-link scrollto" href="#books">Books</a></li>
          <li><a class="nav-link scrollto" href="#authors">Authors</a></li>

          <?php
            session_start();
            if (isset($_SESSION['user_id'])) {
              echo '<li><a class="getstarted" href="./profile.php">' . $_SESSION['username'] . '</a></li>';
              echo '<li><a class="getstarted" href="../Login/logout.php">Logout</a></li>';
            } else {
              echo '<li><a class="getstarted" href="../Login/login.php">Login</a></li>';
            }
            ?>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav>
    </div>
  </header>
  <!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 pt-5 pt-lg-0 order-2 order-lg-1 d-flex flex-column justify-content-center">
          <h1>WELCOME</h1>
          <h2>
            "Books are like keys that open doors to worlds we never knew
            existed."
          </h2>
          <div class="d-flex"></div>
        </div>
        <div class="col-lg-6 order-1 order-lg-2 hero-img">
          <img src="assets/img/homepage/gulfer-ergin-LUGuCtvlk1Q-unsplash.jpg" class="img-fluid animated rounded-5" alt="" />
        </div>
      </div>
    </div>
  </section>
  <!-- End Hero -->

  <main id="main">
    <!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 ">
            <img src="assets/img/homepage/gabriel-sollmann-Y7d265_7i08-unsplash.jpg" class="img-fluid animated rounded-5" alt="" />
          </div>
          <div class="col-lg-6 pt-4 pt-lg-0 content">
            <h3>
              Exploring the Enchantment of Libraries and the Magic of Books
            </h3>
            <p class="fst-italic">
              Within the library's embrace, shelves transform into enchanted
              forests of imagination, each book a portal to uncharted realms.
              The scent of aged pages hangs in the air like ancient secrets,
              inviting exploration. Here, whispers of the past and dreams of
              the future converge, painting a symphony of human thought. The
              library is a sanctuary where knowledge dances and stories take
              flight, a timeless haven for curious souls.
            </p>
            <hr />
            <p class="fst-italic">
              In a world often racing forward, books stand as timeless
              anchors, offering refuge for those who seek solace, knowledge,
              and adventure. Within their pages, words transcend mere text,
              becoming vessels of emotion, wisdom, and imagination. Each book
              is a journey, an invitation to explore new perspectives and live
              myriad lives. They hold the power to shape minds, inspire
              change, and connect souls across time and space. In a book, one
              can find a steadfast companion, a devoted teacher, and an
              eternal source of wonder.
            </p>
          </div>
        </div>
      </div>
    </section>
    <!-- End About Section -->

    <!-- ======= Counts Section ======= -->
    <section id="counts" class="counts">
      <div class="container">
        <div class="row counters">
          <div class="col-lg-3 col-6 text-center">
            <?php
            $query = "SELECT COUNT(id) AS user_count FROM users";
            $stmt = $database->connection->prepare($query);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $userCount = $result['user_count'];
            ?>

            <span data-purecounter-start="0" data-purecounter-end="<?php echo $userCount; ?>" data-purecounter-duration="1" class="purecounter"></span>
            <p>Registered users</p>
          </div>


          <div class="col-lg-3 col-6 text-center">
    <?php

    $query = "SELECT COUNT(id) AS book_count FROM books";
    $stmt = $database->connection->prepare($query);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $bookCount = $result['book_count'];
    ?>

    <span data-purecounter-start="0" data-purecounter-end="<?php echo $bookCount; ?>" data-purecounter-duration="1" class="purecounter"></span>
    <p>Books</p>
</div>


<div class="col-lg-3 col-6 text-center">
    <?php

    $query = "SELECT COUNT(id) AS author_count FROM authors";
    $stmt = $database->connection->prepare($query);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $authorCount = $result['author_count'];
    ?>

    <span data-purecounter-start="0" data-purecounter-end="<?php echo $authorCount; ?>" data-purecounter-duration="1" class="purecounter"></span>
    <p>Authors</p>
</div>


<div class="col-lg-3 col-6 text-center">
    <?php

    $query = "SELECT COUNT(id) AS approved_comment_count FROM comments WHERE is_approved = 1";
    $stmt = $database->connection->prepare($query);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $approvedCommentCount = $result['approved_comment_count'];
    ?>

    <span data-purecounter-start="0" data-purecounter-end="<?php echo $approvedCommentCount; ?>" data-purecounter-duration="1" class="purecounter"></span>
    <p> Comments</p>
</div>


        </div>
      </div>
    </section>
    <!-- End Counts Section -->

    <!-- ======= Portfolio Section ======= -->
    <section id="books" class="portfolio">
      <div class="container">
        <div class="section-title">
          <span>Books</span>
          <h2>Books</h2>
          <p>Books categories</p>
        </div>

        <div class="row">
          <div class="col-lg-12 d-flex justify-content-center">
            <ul id="portfolio-flters">
              <li data-filter="*" class="filter-active">All</li>
              <?php
              

              $query = "SELECT id, title FROM categories WHERE is_deleted = 0";
              $result = $database->connection->query($query);

              $categories = $result->fetchAll(PDO::FETCH_ASSOC);

              foreach ($categories as $category) {
                $categoryId = $category['id'];
                $categoryName = $category['title'];
                echo '<li data-filter=".filter-' . $categoryId . '">' . $categoryName . '</li>';
              }
              ?>
            </ul>
          </div>
        </div>

        <div class="row portfolio-container" style="display: flex; flex-wrap: wrap;">
          <?php
          $query = "SELECT id, title, author_id, release_year, pages, image_url, category_id, is_deleted FROM books WHERE is_deleted = 0 ORDER BY id DESC"; // Change the ORDER BY clause as needed
          $result = $database->connection->query($query);

          $books = $result->fetchAll(PDO::FETCH_ASSOC);

          foreach ($books as $book) {
            $bookCategoryId = $book['category_id'];
            $bookTitle = $book['title'];
            $bookImageUrl = $book['image_url'];
            echo '<div class="col-lg-4 col-md-6 portfolio-item filter-app filter-' . $bookCategoryId . '">';
            echo '<img src="' . $bookImageUrl . '" class="img-fluid" alt="' . $bookTitle . '" />';
            echo '<div class="portfolio-info">';
            echo '<h4>' . $bookTitle . '</h4>';
            echo '<a href="book_details.php?id=' . $book['id'] . '" class="details-link" title="More Details"><i class="bx bx-link"></i></a>';
            echo '</div>';
            echo '</div>';
          }
          ?>
        </div>
      </div>
    </section>


    <!-- End Portfolio Section -->

    <!-- ======= AUTHORS ======= -->
    <section id="authors" class="testimonials section-bg">
      <div class="container">
        <div class="section-title">
          <span>Authors</span>
          <h2>Authors</h2>
          <p>About authors</p>
        </div>

        <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="100">
          <div class="swiper-wrapper">
            <?php
            $query = "SELECT first_name, last_name, bio FROM authors WHERE is_deleted = 0";
            $stmt = $database->connection->prepare($query);
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              echo '<div class="swiper-slide">';
              echo '<div class="testimonial-item">';
              echo '<p>';
              echo '<i class="bx bxs-quote-alt-left quote-icon-left"></i>';
              echo $row['bio'];
              echo '<i class="bx bxs-quote-alt-right quote-icon-right"></i>';
              echo '</p>';
              echo '<h3>' . $row['first_name'] . ' ' . $row['last_name'] . '</h3>';
              echo '</div>';
              echo '</div>';
            }
            ?>
          </div>
        </div>
      </div>
    </section>



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


    <!-- ======= Cta Section ======= -->
    <section id="cta" class="cta">
    <div class="container">
        <div class="text-center">
            <?php if (!isset($_SESSION['user_id'])) { ?>
                <h3>Unlock the full experience! Register now to dive into a world of endless possibilities and exclusive content. Join us today!</h3>
                <a class="cta-btn" href="../Register/register.php">Register</a>
            <?php } else { ?>
                <h3>Your profile</h3>
                <a class="cta-btn" href="./profile.php">Profile</a>
            <?php } ?>
        </div>
    </div>
</section>

    <!-- End Cta Section -->
  </main>
  <!-- End #main -->



  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>





    $(document).ready(function() {
      var $container = $('.portfolio-container').isotope({
        itemSelector: '.portfolio-item',
        layoutMode: 'fitRows'
      });

      $('#portfolio-flters').on('click', 'li', function() {
        var filterValue = $(this).attr('data-filter');
        $container.isotope({
          filter: filterValue
        });
      });

      $('#portfolio-flters li').on('click', function() {
        $('#portfolio-flters li').removeClass('filter-active');
        $(this).addClass('filter-active');
      });
    });


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
</body>

</html>