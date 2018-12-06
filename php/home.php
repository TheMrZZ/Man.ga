<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <title>Man.ga - Home</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous"/>
  <link href="../css/main.css" rel="stylesheet" type="text/css"/>
  <link href="../css/home.css" rel="stylesheet" type="text/css"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <meta name="author" content="Florian Ernst"/>
  <meta name="description" content="Man.ga home page - see the most popular mangas, and the recently udpates ones."/>
  <meta name="keywords"
        content="Man.ga,manga,mangas,One Piece,Fairy Tale,Tower of God,Shingeki No Kyojin,Attack On Titan,information"/>
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
    <h1>Home</h1>
  </header>
  <section class="manga-display">
    <header>
      <h2>Most popular</h2>
    </header>
    <ol class="manga-list">
      <?php
      require './connect.php';
      $mangaIDsByRating = $conn->query('SELECT mangaID FROM average_rating ORDER BY avgRating LIMIT 5')->fetchAll();

      foreach ($mangaIDsByRating as $mangaID) {
        $manga = $conn->query("SELECT id, name FROM manga WHERE manga.id = " . $mangaID['mangaID'])->fetch();

        echo "
            <li>
              <h3>" . $manga['name'] . "</h3>
              <a href=\"manga-information.php?id=" . $manga['id'] . "\">
                <img src=\"../images/" . $manga['id'] . ".png\" alt=\"" . $manga['name'] . " cover\" />
              </a>
            </li>
        ";
      }
      ?>
    </ol>
  </section>

  <section class="manga-display">
    <header>
      <h2>Recently updated</h2>
    </header>
    <ol class="manga-list">
      <?php
      $mangasByDate = $conn->query('SELECT id, name FROM mangabydate LIMIT 5')->fetchAll();

      foreach ($mangasByDate as $manga) {
        echo "
          <li>
            <h3>" . $manga['name'] . "</h3>
            <a href=\"manga-information.php?id=" . $manga['id'] . "\">
              <img src=\"../images/" . $manga['id'] . ".png\" alt=\"" . $manga['name'] . " cover\"/>
            </a>
          </li>
        ";
      }
      ?>
    </ol>
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
    }
</script>
</body>

</html>