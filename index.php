<?php
$login = false;
$showError = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  include 'partials/dbconnect.php';
  $username = $_POST["username"];
  $pass = $_POST["password"];
  $password = password_hash(
    $pass,
    PASSWORD_DEFAULT
  );

  $sql = "Select * from `login` where username='$username'";
  $getrole = "Select role from `login` where username='$username'";
  $result = mysqli_query($conn, $sql);
  $role_result = mysqli_query($conn, $getrole);
  while ($roles = mysqli_fetch_array($role_result)) {
    $role = $roles["role"];
  }

  $num = mysqli_num_rows($result);
  $user = mysqli_fetch_array($result);
  if ($num == 1 && password_verify($pass, $user["password"])) {
    $login = true;
    session_start();
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $username;
    $_SESSION['role'] = $role;
    header("location: welcome.php");
  } else {
    $showError = "Invalid Credentials!";
  }
}
?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <title>Login</title>
</head>

<body>
  <?php require 'partials/_nav.php' ?>
  <?php
  if ($login) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Success!</strong> You are logged in!
        </button></div>';
  }
  if ($showError) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Error!</strong> ' . $showError . '.
    </div>';
  }
  ?>
  <div class="container">
    <h1 class="text-center">Login to our website</h1>
    <form action="index.php" method="post">
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp">
        <div id="emailHelp" class="form-text">We'll never share your Username with anyone else.</div>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password">
      </div>
      <button type="submit" class="btn btn-primary">Login</button>
    </form>
  </div>
</body>

</html>