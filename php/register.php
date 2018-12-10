<?php

// Check if the user is already logged in
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
  header("location: profile.php");
  exit;
}

$username_err = $password_err = $confirm_password_err = $email_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  require './connect.php';

  // Validate username
  if (empty(trim($_POST["username"]))) {
    $username_err = "Please enter a username.";
  } else {
    // Prepare a select statement
    $sql = "SELECT id FROM user WHERE username = :username";

    if ($stmt = $conn->prepare($sql)) {
      // Set parameters
      $param_email = trim($_POST["username"]);

      // Bind variables to the prepared statement as parameters
      $stmt->bindParam(":username", $param_email, PDO::PARAM_STR);

      // Attempt to execute the prepared statement
      if ($stmt->execute()) {
        if ($stmt->rowCount() == 1) {
          $username_err = "This username is already taken.";
        } else {
          $username = trim($_POST["username"]);
        }
      } else {
        echo "Oops! Something went wrong. Please try again later.";
      }
    }
  }

  // Validate email
  if (empty(trim($_POST["email"]))) {
    $username_err = "Please enter an email address.";
  } else {
    // Prepare a select statement
    $sql = "SELECT id FROM user WHERE email = :email";

    if ($stmt = $conn->prepare($sql)) {
      // Set parameters
      $param_email = trim($_POST["email"]);

      // Bind variables to the prepared statement as parameters
      $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);

      // Attempt to execute the prepared statement
      if ($stmt->execute()) {
        if ($stmt->rowCount() == 1) {
          $email_err = "This mail address is already linked to an account.";
        } else {
          $email = trim($_POST["email"]);
        }
      } else {
        echo "Oops! Something went wrong. Please try again later.";
      }
    }
  }

  // Validate password
  if (empty(trim($_POST["password"]))) {
    $password_err = "Please enter a password.";
  } elseif (strlen(trim($_POST["password"])) < 6) {
    $password_err = "Password must have at least 6 characters.";
  } else {
    $password = trim($_POST["password"]);
  }

  // Validate confirm password
  if (empty(trim($_POST["confirm"]))) {
    $confirm_password_err = "Please confirm password.";
  } else {
    $confirm_password = trim($_POST["confirm"]);
    if (empty($password_err) && ($password != $confirm_password)) {
      $confirm_password_err = "Password did not match.";
    }
  }

  // Check input errors before inserting in database
  if (empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err)) {
    // Prepare an insert statement
    $sql = "INSERT INTO user (username, email, passwd) VALUES (:username, :email, :password)";

    if ($stmt = $conn->prepare($sql)) {
      // Set parameters
      $param_username = $username;
      $param_email = $email;
      $param_password = password_hash($password, PASSWORD_BCRYPT); // Creates a password hash

      // Bind variables to the prepared statement as parameters
      $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
      $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
      $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);

      // Attempt to execute the prepared statement
      if ($stmt->execute()) {
        // Redirect to login page
        header("location: login.php?new_user=true");
      } else {
        echo "Something went wrong. Please try again later.";
      }
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Man.ga - Register</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous"/>
  <link href="../css/main.css" rel="stylesheet" type="text/css"/>
  <link href="../css/form.css" rel="stylesheet" type="text/css"/>
  <link href="../css/home.css" rel="stylesheet" type="text/css"/>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Florian Ernst">
  <meta name="description" content="Man.ga register page - register to Man.ga to get more features.">
  <meta name="keywords" content="Man.ga,manga,mangas,register,sign-up">
</head>

<body>
<header>
  <?php
  require './navbar.php';
  echo $navbar;
  ?>
</header>

<main>
  <form class="sign" method="POST" action="<?php echo $_SERVER["PHP_SELF"] ?>">
    <img class="icon" alt="register icon" src="../icon/register.svg"/>
    <h1 class="login">Register</h1>
    <div>
      <p class="label-txt"><label for="username">ENTER YOUR USERNAME</label></p>
      <p class="text-danger"><?php echo $username_err ?></p>
      <input type="text" class="input" name="username" id="username" autocomplete="off" autofocus required/>
      <div class="line-box">
        <div class="line"></div>
      </div>
    </div>
    <div>
      <p class="label-txt"><label for="email">ENTER YOUR EMAIL</label></p>
      <p class="text-danger"><?php echo $email_err ?></p>
      <input type="email" class="input" name="email" id="email" autocomplete="off" required/>
      <div class="line-box">
        <div class="line"></div>
      </div>
    </div>
    <div>
      <p class="label-txt"><label for="password">ENTER YOUR PASSWORD</label></p>
      <p class="text-danger"><?php echo $password_err ?></p>
      <input type="password" class="input" name="password" id="password" autocomplete="off" required/>
      <div class="line-box">
        <div class="line"></div>
      </div>
    </div>
    <div>
      <p class="label-txt"><label for="confirmation">CONFIRM YOUR PASSWORD</label></p>
      <p class="text-danger"><?php echo $confirm_password_err ?></p>
      <input type="password" class="input" name="confirm" id="confirmation" autocomplete="off" required/>
      <div class="line-box">
        <div class="line"></div>
      </div>
    </div>
    <button type="submit" name="register" id="submit" class="submit">Register</button>
  </form>
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

    function bigContrast() {
        let body = document.body;
        body.classList.toggle('big-contrast');
        let h1s = document.getElementsByTagName('h1');
        for (const h1 of h1s) {
            h1.classList.toggle('big-contrast');
        }
    }
</script>
</body>

</html>