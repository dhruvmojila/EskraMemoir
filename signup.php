<?php
$showAlert = false;
$showError = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'partials/dbconnect.php';
    $username = $_POST["username"];
    $pass = $_POST["password"];
    $password = password_hash($pass, PASSWORD_DEFAULT);
    $cpassword = $_POST["cpassword"];

    if (isset($_POST['signup_as_admin'])) {
        $role = "admin";
    } else if (isset($_POST['signup_as_user'])) {
        $role = "user";
    }

    $exists = false;
    $existsSql = "Select * from `login` where username='$username'";
    $result = mysqli_query($conn, $existsSql);
    $numRows = mysqli_num_rows($result);
    if ($numRows > 0) {
        // $exists = true;
        $showError = "Username is already Exists!";
    } else {
        // $exists = false;
        if (($pass == $cpassword) && ($pass != null)) {
            $sql = "INSERT INTO `login` (`username`, `password`, `role`, `dt`) VALUES ('$username', '$password', '$role', current_timestamp())";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $showAlert = true;
            }
        } else {
            $showError = "Passwords do not match!";
        }
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
    <title>Signup</title>
</head>

<body>
    <?php require 'partials/_nav.php' ?>
    <?php
    if ($showAlert) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Success!</strong> Your account is now created and now you can Login.
        </div>';
    }
    if ($showError) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Error!</strong> ' . $showError . '.
   </div>';
    }
    ?>
    <div class="container">
        <h1 class="text-center">Signup to our website</h1>
        <form action="/EskraMemoir/signup.php" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">We'll never share your Username with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="mb-3">
                <label for="cpassword" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="cpassword" name="cpassword">
                <div id="emailHelp" class="form-text">Make sure to type same password.</div>
            </div>
            <button type="submit" name="signup_as_admin" class="btn btn-primary">Signup as Admin</button>
            <button type="submit" name="signup_as_user" class="btn btn-primary">Signup as User</button>
        </form>
    </div>
</body>

</html>