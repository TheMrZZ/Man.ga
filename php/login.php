<?php
// Initialize the session
session_start();

// Check if the user is already logged in
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
  header("location: profile.php");
  exit;
}

$username_err = $password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Include config file
  require "connect.php";

// Define variables and initialize with empty values
  $username = $password = "";

// Processing form data when form is submitted
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
            $hashed_password = $row["passwd"];

            if (password_verify($password, $hashed_password)) {
              // Password is correct, so start a new session
              session_start();

              // Store data in session variables
              $_SESSION["loggedin"] = true;
              $_SESSION["id"] = $id;
              $_SESSION["username"] = $username;

              // Redirect user to welcome page
              header("location: profile.php");
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

$success_message = "";
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  if (!empty($_GET["new_user"]) && $_GET["new_user"] == true) {
    $success_message = "Your account was successfully created.<br>You can now login to Man.ga!";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Man.ga - Login</title>
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
  <meta name="description" content="Man.ga login page - login to Man.ga to get more features.">
  <meta name="keywords" content="Man.ga,manga,mangas,login,log-in,sign-in,sign-in">
</head>

<body>
<header>
  <?php
  require './navbar.php';
  echo $navbar;
  ?>
</header>

<main>
  <form class="sign" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
    <img class="icon" src="../icon/user.svg" alt="Profile icon"/>
    <h1 class="login">Login</h1>
    <div>
      <p class="label-txt"><label for="username">ENTER YOUR USERNAME</label></p>
      <p class="text-danger"><?php echo $username_err ?></p>
      <input type="text" class="input" name="username" id="username" autofocus required/>
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

  <?php if (!empty($success_message)) {
    echo "
      <div class=\"modal fade\" id=\"success-modal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\">
        <div class=\"modal-dialog\" role=\"document\">
          <div class=\"modal-content\">
            <div class=\"modal-body text-success text-center\" style=\"width:auto;display:inline-block;\">
              $success_message
            </div>
          </div>
        </div>
      </div>
      
      <script>
        $(document).ready(function () {
          const modal = $('#success-modal');
          modal.modal('show');
          setTimeout(() => modal.modal('hide'), 2500);
        });
      </script>
  ";
  } ?>

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
            console.log('h1=', h1);
            h1.classList.toggle('big-contrast');
        }
    }
</script>
</body>

</html>