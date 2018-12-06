<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Man.ga - Forgot Password</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous"/>
  <link href="../css/main.css" rel="stylesheet" type="text/css"/>
  <link href="../css/form.css" rel="stylesheet" type="text/css"/>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Florian Ernst">
  <meta name="description" content="Man.ga password recovery page - get a new password.">
  <meta name="keywords" content="Man.ga,manga,mangas,forgot,password,recovery">
</head>

<body>
<header>
  <?php
  require './navbar.php';
  echo $navbar;
  ?>
</header>

<main>

  <form class="sign">
    <img class="icon" alt="lock icon" src="../icon/lock.svg"/>
    <h1 class="password">Forgotten Password</h1>
    <div>
      <p class="label-txt"><label for="username">ENTER YOUR USERNAME</label></p>
      <input type="text" class="input" name="username" id="username" autocomplete="off" required/>
      <div class="line-box">
        <div class="line"></div>
      </div>
    </div>
    <div>
      <p class="label-txt"><label for="email">ENTER YOUR EMAIL</label></p>
      <input type="email" class="input" name="email" id="email" autocomplete="off" required/>
      <div class="line-box">
        <div class="line"></div>
      </div>
    </div>
    <button type="submit" name="send" id="submit" class="submit">Send</button>
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
    }
</script>
</body>

</html>