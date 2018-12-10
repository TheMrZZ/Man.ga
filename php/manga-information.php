<?php
require "./connect.php";

session_start();

$id = 0;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id = $_POST['id'];
}
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $id = $_GET['id'];
}

$statement = $conn->prepare('SELECT id, name, author, typeID, status, description FROM manga WHERE id = :id');
$statement->bindParam(':id', $id);

$statement->execute();
$manga = $statement->fetch();
/*
if (empty($manga)) {
  header('Location: 404.html');
}
*/

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


if ($_SERVER["REQUEST_METHOD"] == "POST") {
//Comment form
  if ($_POST['form'] == 'send-comment') {
    $stmt = $conn->prepare("INSERT INTO comment (userID, mangaID, comment) VALUES (:usid, :manid , :com)");

    $usid = $_SESSION['id'];
    $manid = $id;
    $com = $_POST['content'];

    $stmt->bindParam(':usid', $_SESSION['id']);
    $stmt->bindParam(':manid', $id);
    $stmt->bindParam(':com', $com);

    if ($stmt->execute()) {
      header("location: manga-information.php?id=" . $manga['id']);
    } else {
      echo "Something went wrong. Please try again later.<br>";
      echo "Error " . $stmt->errorCode() . ":<br>";
      var_dump($stmt->errorInfo());
      exit();
    }
  }
}

?>

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
  <section id=put_comment>
    <form class="sign" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
      <h2 class="login">Let your comment</h2>
      <!--
      <div>
        <p class="label-txt"><label for="subject">RATING</label></p>
        <p>
          <label>
            <input class="min-rating" name="rating" type="number" min="0" max="5" value="0">
          </label> stars
        </p>
      </div>
    -->
      <div>
        <p class="label-txt"><label for="content">ENTER YOUR CONTENT</label></p>
        <textarea name="content" id="content" rows="15" cols="10" placeholder="Write here" required></textarea><br/>
      </div>
      <!--suppress HtmlFormInputWithoutLabel -->
      <input type="number" value="<?php echo $manga['id']; ?>" name="id" hidden>
      <!--suppress HtmlFormInputWithoutLabel -->
      <input type="text" name="form" value="send-comment" hidden>
      <button type="submit" id="submit" class="submit">Send</button>
    </form>
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