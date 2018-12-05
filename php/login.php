<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Man.ga - Login</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous"/>
  <link href="../css/form.css" rel="stylesheet" type="text/css"/>
  <link href="../css/main.css" rel="stylesheet" type="text/css"/>
  <link href="../css/home.css" rel="stylesheet" type="text/css"/>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Florian Ernst">
  <meta name="description" content="Man.ga login page - login to Man.ga to get more features.">
  <meta name="keywords" content="Man.ga,manga,mangas,login,log-in,signin,sign-in">
</head>

<body>
<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
  header("location: welcome.php");
  exit;
}

// Include config file
require "connect.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  echo "IN POST";
  // Check if username is empty
  if (empty(trim($_POST["username"]))) {
    $username_err = "Please enter a username.";
  } else {
    $username = trim($_POST["username"]);
  }

  // Check if password is empty
  if (empty(trim($_POST["password"]))) {
    $password_err = "Please enter your password.";
  } else {
    $password = trim($_POST["password"]);
  }

  // Validate credentials
  if (empty($username_err) && empty($password_err)) {
    // Prepare a select statement
    $sql = "SELECT id, username, passwd FROM user WHERE username = :username";

    if ($stmt = $conn->prepare($sql)) {
      // Bind variables to the prepared statement as parameters
      $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);

      // Set parameters
      $param_username = trim($_POST["username"]);

      if ($stmt->execute()) {
        // Check if username exists, if yes then verify password
        if ($stmt->rowCount() == 1) {
          if ($row = $stmt->fetch()) {
            $id = $row["id"];
            $username = $row["username"];
            $hashed_password = $row["password"];
            if (password_verify($password, $hashed_password)) {
              // Password is correct, so start a new session
              session_start();

              // Store data in session variables
              $_SESSION["loggedin"] = true;
              $_SESSION["id"] = $id;
              $_SESSION["username"] = $username;

              // Redirect user to welcome page
              header("location: welcome.php");
            } else {
              // Display an error message if password is not valid
              $password_err = "The password you entered was not valid.";
            }
          }
        } else {
          // Display an error message if username doesn't exist
          $username_err = "No account found with that username.";
        }
      } else {
        echo "Something went wrong.";
      }
    }
  }
}
?>

<header>
  <nav class="navbar navbar-expand-lg navbar-light main-nav fixed-top">
    <a class="navbar-brand" href="home-not-logged-in.php">Man.ga</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse flex-fill w-100 flex-nowrap" id="navbarSupportedContent">
      <ul class="nav navbar-nav flex-fill w-100 flex-nowrap">
        <li class="nav-item">
          <a class="nav-link" href="manga-list.php">Manga list</a>
        </li>
      </ul>
      <div class="searchbar nav navbar-nav flex-fill justify-content-center">
        <form class="form-inline" action="manga-list.php" method="GET">
          <input class="form-control mr-sm-2" type="search" placeholder="Search a manga..."
                 aria-label="Search" name="search"/>
        </form>
      </div>
      <ul class="nav navbar-nav flex-fill w-100 justify-content-end">
        <li class="nav-item">
          <a class="nav-link" href="login.php">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="register.php">Register</a>
        </li>
      </ul>
    </div>
  </nav>
</header>

<main>
  <form class="sign" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
    <img class="icon" src="../icon/user.svg" alt="Profile icon"/>
    <h1 class="login">Login</h1>
    <div>
      <p class="label-txt"><label for="username">ENTER YOUR USERNAME</label></p>
      <p class="text-danger"><?php echo $username_err ?></p>
      <input type="text" class="input" name="username" id="username" required/>
      <div class="line-box">
        <div class="line"></div>
      </div>
    </div>
    <div>
      <p class="label-txt"><label for="password">ENTER YOUR PASSWORD</label></p>
      <p class="text-danger"><?php echo $password_err ?></p>
      <input type="password" class="input" name="password" id="password" required/>
      <div class="line-box">
        <div class="line"></div>
      </div>
    </div>
    <button type="submit" name="login" id="submit" class="submit">Submit</button>

  </form>
  <div class="link">
    <p class="link">
      <a class="link" href="forgot-password.php">Forgot password ?</a>
      /
      <a class="link" href="register.php">No account ? Create one here</a>
    </p>
  </div>
</main>
<footer>
  <a href="info.php">What is Man.ga?</a>
  <a href="contact.php">Contact us</a>
  <button id="contrast-button" onclick="bigContrast()">Big Contrast</button>
</footer>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
<script>
    function bigContrast() {
        let body = document.body;
        body.classList.toggle('big-contrast');
    }
</script>

<script>
    $(document).ready(function () {
        let input = $('input');
        input.focus(function () {
            $(this).parent().find(".label-txt").addClass('label-active');
        });
        input.focusout(function () {
            if ($(this).val() === '') {
                $(this).parent().find(".label-txt").removeClass('label-active');
            }
        });
    });
</script>
</body>

</html>