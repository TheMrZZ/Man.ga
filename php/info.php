<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Man.ga - Information</title>
  <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
      crossorigin="anonymous"
  />
  <link href="../css/info.css" rel="stylesheet" type="text/css"/>
  <link href="../css/main.css" rel="stylesheet" type="text/css"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Florian Ernst">
  <meta name="description" content="Man.ga informations page about our website.">
  <meta name="keywords" content="Man.ga,manga,mangas,informations,about our website, what is Man.ga ?">
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
    <h1>What is Man.ga ?</h1>
  </header>

  <p>
    Man.ga is a site that gathers the main information on many mangas.
    You can find on this site, the most popular mangas of the moment such as one piece or Shingeki No Kyojin as well as
    the main information about these mangas like their author, their type, their gender, their status and even a short
    description of the book.
    You can register on the site to access the management of your favorite manga and thus have faster access to titles
    that you are most interested in.
    In addition, registration gives you access to the scoring system that allows you to assign a score from 1 to 10 to
    mangas according to your preferences with regard to them.<br/><br/>

    We wish you a pleasant visit on our website.
  </p>
</main>

<footer>
  <a href="info.php">What is Man.ga?</a>
  <a href="contact.php">Contact us</a>
  <button id="contrast-button" onclick="bigContrast()">Big Contrast</button>
</footer>
<script
    src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"
></script>
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"
></script>
<script
    src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"
></script>

<script>
    function bigContrast() {
        let body = document.body;
        body.classList.toggle('big-contrast');
    }
</script>

</body>

</html>