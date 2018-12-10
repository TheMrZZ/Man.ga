<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$old_password_err = $password_err = $confirm_password_err = "";
$old_email_password_err = $old_email_err = $email_err = "";

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  require './connect.php';

  // Password change form
  if ($_POST['form'] == 'change-password') {
    // Validate old password
    if (empty(trim($_POST["old-password"]))) {
      $old_password_err = "Please enter a password.";
    } else {
      $given_old_password = $_POST['old-password'];
      $old_hash = $conn->query('SELECT passwd FROM user WHERE id = ' . $_SESSION['id'])->fetch()['passwd'];
      if (!password_verify($given_old_password, $old_hash)) {
        $old_password_err = "Password is incorrect.";
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
    if (empty($old_password_err) && empty($password_err) && empty($confirm_password_err)) {
      // Prepare an insert statement
      $sql = "UPDATE user SET passwd = :password WHERE id = " . $_SESSION['id'];

      if ($stmt = $conn->prepare($sql)) {
        // Set parameters
        $param_password = password_hash($password, PASSWORD_BCRYPT); // Creates a password hash

        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
          // Redirect to login page
          header("location: profile.php?password_changed=true");
        } else {
          echo "Something went wrong. Please try again later.";
        }
      }
    }
  }

  // Email change form
  if ($_POST['form'] == 'change-email') {

    // Validate old password
    if (empty(trim($_POST["old-password"]))) {
      $old_email_password_err = "Please enter a password.";
    } else {
      $given_old_password = $_POST['old-password'];
      $old_hash = $conn->query('SELECT passwd FROM user WHERE id = ' . $_SESSION['id'])->fetch()['passwd'];
      if (!password_verify($given_old_password, $old_hash)) {
        $old_email_password_err = "Password is incorrect.";
      }
    }

    // Validate email
    if (empty(trim($_POST["old-email"]))) {
      $password_err = "Please enter an email address.";
    } else {
      $old_email = trim($_POST["old-email"]);
      $real_email = $conn->query('SELECT email FROM user WHERE id =' . $_SESSION['id'])->fetch()['email'];
      if ($old_email != $real_email) {
        $old_email_err = "Email is incorrect.";
      }
    }

    // Validate new email
    if (empty(trim($_POST["email"]))) {
      $confirm_password_err = "Please enter an email address.";
    } else {
      $email = trim($_POST["email"]);
    }

    // Check input errors before inserting in database
    if (empty($old_email_err) && empty($old_email_password_err) && empty($email_err)) {
      // Prepare an insert statement
      $sql = "UPDATE user SET email = :email WHERE id = " . $_SESSION['id'];

      if ($stmt = $conn->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
          // Redirect to login page
          header("location: profile.php?email_changed=true");
        } else {
          echo "Something went wrong. Please try again later.";
        }
      }
    }
  }
}

$success_message = "";
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  if (!empty($_GET['email_changed']) && $_GET['email_changed'] == true) {
    $success_message = "Successfully changed email!";
  } elseif (!empty($_GET['password_changed']) && $_GET['password_changed'] == true) {
    $success_message = "Successfully changed email!";
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Man.ga - Profile</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous"/>
  <link href="../css/main.css" rel="stylesheet" type="text/css"/>
  <link href="../css/form.css" rel="stylesheet" type="text/css"/>
  <link href="../css/profile.css" rel="stylesheet" type="text/css"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Florian Ernst">
  <meta name="description" content="Man.ga profile page - check your information, change your password and your email.">
  <meta name="keywords" content="Man.ga,manga,mangas,profile,password,email">

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
          integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
          crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
          integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
          crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
          integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
          crossorigin="anonymous"></script>

</head>

<body>
<header>
  <?php
  require './navbar.php';
  echo $navbar;
  ?>
</header>

<main>
  <header>
    <h1>Your Profile</h1>
  </header>

  <p>Username: <?php echo $_SESSION['username']; ?></p>
  <p>Email: <?php
    require './connect.php';

    echo $conn->query("SELECT email FROM user WHERE id = " . $_SESSION['id'])->fetch()['email'];
    ?></p>

  <form class="sign" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
    <h1 class="login">Change your password</h1>
    <div>
      <p class="label-txt"><label for="password">ENTER YOUR CURRENT PASSWORD</label></p>
      <p class="text-danger"><?php echo $old_password_err ?></p>
      <input type="password" class="input" name="old-password" id="password" autocomplete="off" required/>
      <div class="line-box">
        <div class="line"></div>
      </div>
    </div>
    <div>
      <p class="label-txt"><label for="new-password">ENTER YOUR NEW PASSWORD</label></p>
      <p class="text-danger"><?php echo $password_err ?></p>
      <input type="password" class="input" name="password" id="new-password" autocomplete="off" required/>
      <div class="line-box">
        <div class="line"></div>
      </div>
    </div>
    <div>
      <p class="label-txt"><label for="confirm-password">CONFIRM YOUR NEW PASSWORD</label></p>
      <p class="text-danger"><?php echo $confirm_password_err ?></p>
      <input type="password" class="input" name="confirm" id="confirm-password" autocomplete="off" required/>
      <div class="line-box">
        <div class="line"></div>
      </div>
    </div>

    <!--suppress HtmlFormInputWithoutLabel -->
    <input type="text" name="form" value="change-password" hidden>
    <button type="submit" name="change-password" id="submit-password" class="submit">Confirm</button>
  </form>

  <form class="sign" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
    <h1 class="login">Change your email</h1>
    <div>
      <p class="label-txt"><label for="password">ENTER YOUR CURRENT PASSWORD</label></p>
      <p class="text-danger"><?php echo $old_email_password_err ?></p>
      <input type="password" class="input" name="old-password" id="password" autocomplete="off" required/>
      <div class="line-box">
        <div class="line"></div>
      </div>
    </div>
    <div>
      <p class="label-txt"><label for="old-email">ENTER YOUR CURRENT EMAIL</label></p>
      <p class="text-danger"><?php echo $old_email_err ?></p>
      <input type="email" class="input" name="old-email" id="old-email" autocomplete="off" required/>
      <div class="line-box">
        <div class="line"></div>
      </div>
    </div>
    <div>
      <p class="label-txt"><label for="email">ENTER YOUR NEW EMAIL</label></p>
      <p class="text-danger"><?php echo $email_err ?></p>
      <input type="email" class="input" name="email" id="email" autocomplete="off" required/>
      <div class="line-box">
        <div class="line"></div>
      </div>
    </div>

    <!--suppress HtmlFormInputWithoutLabel -->
    <input type="text" name="form" value="change-email" hidden>
    <button type="submit" name="submit-email" id="submit-email" class="submit">Confirm</button>
  </form>

  <?php if (!empty($success_message)) {
    echo "
      <div class=\"modal fade\" id=\"success-modal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\">
        <div class=\"modal-dialog modal-sm\" role=\"document\">
          <div class=\"modal-content\">
            <div class=\"modal-body text-success\">
              $success_message
            </div>
          </div>
        </div>
      </div>
      
      <script>
        $(document).ready(function () {
          const modal = $('#success-modal');
          modal.modal('show');
          setTimeout(() => modal.modal('hide'), 1500);
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