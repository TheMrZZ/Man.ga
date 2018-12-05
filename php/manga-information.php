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

<?php
require "./connect.php";

$id = $_GET['id'];

$statement = $conn->prepare('SELECT * FROM manga WHERE id=:id');
$statement->bindParam(':id', $id, PDO::PARAM_INT);

$statement->execute();
$manga = $statement->fetch();

if (empty($manga)) {
  header('Location: 404.html');
}

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
      <img src="../images/one-piece.png" alt="One Piece cover">
      <dl class="information-panel">
        <dt>Title</dt>
        <dd>Eichiiro Oda</dd>
        <dt>Type</dt>
        <dd>Shonen</dd>
        <dt>Genre</dt>
        <dd>Action</dd>
        <dt>Rating</dt>
        <dd>
          <p title="Average Rating">&star; 4.67</p>
          <p title="Number of votes"> &#128483; 104</p>
        </dd>
        <dt>Your Rating</dt>
        <dd>
          <span class="star"></span><span class="star"></span><span class="star"></span><span
              class="star"></span><span
              class="star"></span>
          (Not rated yet)
        </dd>

        <dt>Publication Status</dt>
        <dd>Ongoing</dd>
        <dt>Description</dt>
        <dd>
          The manga focuses on Monkey D. Luffy, a young man who,
          inspired by his childhood idol and
          powerful pirate "Red Haired"
          Shanks, sets off on a journey from the East Blue Sea to
          find the famed treasure One Piece and
          proclaim himself the King of the Pirates.
        </dd>
      </dl>
    </div>
  </section>

  <section>
    <header>
      <h2>Comments</h2>
    </header>
    <ul class="comments">
      <li class="comment">
        <header class="comment-header">
          <p>JaneDoe - 18 Jan 2018 at 6:56PM</p>
          <p>Rating: 9&starf;</p>
        </header>
        <p>One of the best manga you'll find. Epic actions, incredible battles, and the
          protagonists are juste the best.<br/>
          Luffy is dumb sometimes, but this manga will show you what real friendship is, and
          make you wish you were a pirate.</p>
      </li>
      <li class="comment">
        <header class="comment-header">
          <p>JohnDoe (<strong>You</strong>) - 15 Oct 2015 at 11:12AM</p>
          <p>Rating: None</p>
        </header>
        <p>I must take some time to read it!</p>
      </li>

      <?php
      $dirFiles = $_SERVER['DOCUMENT_ROOT'];
      $arrFiles = scandir($dirFiles);
      $arrFiles2 = array_slice($arrFiles, 2);
      print_r($arrFiles2);

      foreach ($arrFiles2 as $file) {
        echo "<br>$file<br>";
      }
      ?>
    </ul>
  </section>
</main>

<footer>
  <a href="info.php">What is Man.ga?</a>
  <a href="contact.php">Contact us</a>
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
</body>

</html>