<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Man.ga - One Piece</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous"/>
  <link href="../css/main.css" rel="stylesheet" type="text/css">
  <link href="../css/manga-information.css" rel="stylesheet" type="text/css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Florian Ernst">
  <meta name="description" content="Man.ga manga information - get the latest information on the manga One Piece.">
  <meta name="keywords" content="Man.ga,manga,mangas,latest,information,one,piece,One Piece">
</head>

<body>
<header>
  <?php
  require './navbar.php';
  echo $navbar;
  ?>
</header>

<?php
require "./connect.php";

$id = $_GET['id'];
$statement = $conn->prepare('SELECT id, name, author, typeID, status, description FROM manga WHERE id = :id');
$statement->bindParam(':id', $id);

$statement->execute();
$manga = $statement->fetch();

if (empty($manga)) {
  header('Location: 404.html');
}

$type = ucwords($conn->query('SELECT name FROM type WHERE id = ' . $manga['typeID'])->fetch()['name']);


$genresArray = $conn->query('SELECT name FROM genre WHERE id IN (SELECT genreID as id FROM mangagenre WHERE mangaID = ' . $manga['id'] . ')')->fetchAll();
$genres = join(", ", array_map(function ($el) {
  return ucwords($el['name']);
}, $genresArray));


$rating = round($conn->query('SELECT avgRating FROM average_rating WHERE mangaID = ' . $manga['id'])->fetch()['avgRating'], 1);

$number = $conn->query('SELECT votes FROM average_rating WHERE mangaID = ' . $manga['id'])->fetch()['votes'];

$yourRating = 'Log in to rate this manga!';
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
  $query = $conn->query('SELECT rating from rating WHERE mangaID = ' . $manga['id'] . ' AND userID = ' . $_SESSION['id']);
  if ($query == false) {
    $yourRating = 'Not rated yet!';
  } else {
    $yourRating = $query->fetch()['rating'];
  }
}

$comArray = $conn->query('SELECT comment, userID FROM comment WHERE mangaID = ' . $manga['id'])->fetchall();

$imageID = $manga['id'];
?>

<main>
  <header>
    <h1>Manga Information</h1>
  </header>
  <section>
    <header>
      <h2><?php echo $manga['name'] ?></h2>
    </header>
    <div class="manga-wrapper">
      <?php echo "<img src='../images/" . $imageID . ".png' alt='" . $manga['name'] . "'>";
      ?>
      <dl class="information-panel">
        <dt>Author</dt>
        <dd><?php echo $manga['author'] ?></dd>
        <dt>Type</dt>
        <dd><?php echo $type ?></dd>
        <dt>Genre</dt>
        <dd><?php echo $genres ?></dd>
        <dt>Rating</dt>
        <dd>
          <p title="Average Rating">&star; <?php echo $rating ?></p>
          <p title="Number of votes"> &#128483; <?php echo $number ?></p>
        </dd>
        <dt>Your Rating</dt>
        <dd>
          <span class="star"></span><span class="star"></span><span class="star"></span><span
              class="star"></span><span
              class="star"></span>

          <?php

          if (empty($yourRating)) {
            echo "(Not rated yet)";
          } else {
            echo $yourRating;
          }
          ?>
        </dd>

        <dt>Publication Status</dt>
        <dd><?php echo ucwords($manga['status']) ?></dd>
        <dt>Description</dt>
        <dd><?php echo $manga['description'] ?></dd>
      </dl>
    </div>
  </section>

  <section>
    <header>
      <h2>Comments</h2>
    </header>
    <?php
    foreach ($comArray as $com) {
      echo "<br>";
      $userID = $com  ['userID'];
      $userName = $conn->query("SELECT username FROM user WHERE id = $userID")->fetch()['username'];
      $userRating = $conn->query("SELECT rating FROM rating WHERE userID = $userID AND mangaID = " . $manga['id'])->fetch()['rating'];

      $star = '&starf;';
      if (empty($userRating)) {
        $userRating = "(Not Rated)";
        $star = '';
      }
      echo "
          <ul class=\"comments\">
            <li class=\"comment\">
              <header class=\"comment-header\">
                <p> $userName </p>
                <p>Rating: $userRating $star </p>
              </header>
              <p>
              " . $com['comment'] . "<br>" . "
              </p>
            </li>
          </ul>
          ";
    }

    ?>

  </section>
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
        let h1s = document.getElementsByTagName('h1');
        for (const h1 of h1s) {
            h1.classList.toggle('big-contrast');
        }
    }
</script>
</body>

</html>