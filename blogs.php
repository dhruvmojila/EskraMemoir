<?php
include 'partials/dbconnect.php';
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
  header("location: index.php");
  exit;
}

$username = $_SESSION['username'];
$role = $_SESSION['role'];
if ($role == 'admin') {

?>
  <!doctype html>
  <html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/style.css">
    <script src="blogInput/summernote-bs4.js"></script>
    <link rel="stylesheet" href="css/card.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <title>Welcome - <?php echo $username ?></title>
  </head>

  <body>
    <?php require 'partials/_nav.php' ?>
    <div class="container my-3 w-75">
      <h2 class="my-3">
        Blogs
      </h2>
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
        <?php
        $query = 'SELECT * FROM `blogpost`';
        $result = mysqli_query($conn, $query);
        $num = mysqli_num_rows($result);
        while ($data = mysqli_fetch_assoc($result)) {
        ?>
          <div class="col mb-4">
            <div class="card">
              <img src="<?php echo 'partials/' . $data['cover_image'] ?>" class="card-img-top" alt="cover_page">
              <div class="card-body">
                <h5 class="card-title"><?php echo $data['blog_title'] ?></h5>
                <p class="card-text">Written By : <?php echo $data['username'] ?></p>
                <a href="blog_post.php?id=<?php echo $data['id'] ?>" class="btn btn-outline-primary">Read More</a>
              </div>
            </div>
          </div>
      <?php
        }
      }
      else{
        header("location: index.php");
      }
      ?>
      </div>
    </div>
  </body>

  </html>