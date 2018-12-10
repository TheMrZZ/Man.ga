<?php

session_start();
require './connect.php';

$email = "";
if (!empty($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
  $email = $conn->query("SELECT email FROM user WHERE id = " . $_SESSION['id'])->fetch()['email'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  echo "Inside POST<br>";
  $email = $_POST['email'];
  $subject = $_POST['subject'];
  $content = $_POST['content'];

  $stmt = $conn->prepare("INSERT INTO message (email, subject, content) VALUES (:email, :subject, :content)");
  $stmt->bindParam(':email', $email);
  $stmt->bindParam(':subject', $subject);
  $stmt->bindParam(':content', $content);

  if (!$stmt->execute()) {
    echo "Something went wrong :(<br>Try again later!<br>";
    echo "Error " . $stmt->errorCode() . ' :<br>';
    var_dump($stmt->errorInfo());
    exit();
  }

  header('Location: ' . $_SERVER['PHP_SELF'] . '?success=true');
}

$success = false;
$success_message = "Your message was successfully sent to our team!<br>Thanks for contacting us, and have a nice time in Man.ga!";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $success = !empty($_GET['success']) && $_GET['success'] == true;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Man.ga - Contact Us</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous"/>
  <link href="../css/main.css" rel="stylesheet" type="text/css"/>
  <link href="../css/form.css" rel="stylesheet" type="text/css"/>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Florian Ernst">
  <meta name="description" content="Man.ga contact page - contact the creator of the website.">
  <meta name="keywords" content="Man.ga,manga,mangas,contact,message">
</head>

<body>
<header>
  <?php
  require './navbar.php';
  echo $navbar;
  ?>
</header>
<main>
  <form class="sign" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
    <img class="icon" alt="icon discuss" src="../icon/discuss.svg"/>
    <h1 class="login">Contact us</h1>
    <div>
      <p class="label-txt"><label for="email">ENTER YOUR EMAIL</label></p>
      <input type="email" class="input" name="email" id="email" autocomplete="on" value="<?php echo $email ?>"
          <?php if (empty($email)) {
            echo "autofocus";
          } ?> required maxlength="200"/>
      <div class="line-box">
        <div class="line"></div>
      </div>
    </div>
    <div>
      <p class="label-txt"><label for="subject">ENTER YOUR SUBJECT</label></p>
      <input type="text" class="input" name="subject" id="subject" autocomplete="off"
          <?php if (!empty($email)) {
            echo "autofocus";
          } ?> required maxlength="200"/>
      <div class="line-box">
        <div class="line"></div>
      </div>
    </div>
    <div>
      <p class="label-txt"><label for="content">ENTER YOUR MESSAGE</label></p>
      <textarea name="content" id="content" rows="15" cols="10" placeholder="Write here" required
                maxlength="20000"></textarea><br/>
    </div>
    <button type="submit" name="send" id="submit" class="submit">Send</button>
  </form>


  <?php if ($success) {
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
          setTimeout(() => modal.modal('hide'), 5000);
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

<script>/*text label animation */
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