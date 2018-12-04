<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Man.ga - Home</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
    crossorigin="anonymous" />
  <link href="../css/main.css" rel="stylesheet" type="text/css" />
  <link href="../css/home.css" rel="stylesheet" type="text/css" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Florian Ernst">
  <meta name="description" content="Man.ga home page - see the most popular mangas, and the recently udpates ones.">
  <meta name="keywords" content="Man.ga,manga,mangas,One Piece,Fairy Tale,Tower of God,Shingeki No Kyojin,Attack On Titan,information">
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
            <input class="form-control mr-sm-2" type="search" placeholder="Search a manga..." aria-label="Search" name="search" />
          </form>
        </div>
        <ul class="nav navbar-nav flex-fill w-100 justify-content-end">
          <li class="nav-item">
            <a class="nav-link" href="profile.php"><img src="../icon/user.svg" class="profile-icon" width="35" alt="Go to your profile"></a>
          </li>
        </ul>
      </div>
    </nav>
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
        <li>
          <h3>One Piece</h3>
          <a href="manga-information.php"><img src="../images/one-piece.png" alt="One Piece cover" /></a>
        </li>
        <li>
          <h3>Shingeki No Kyojin - Attack on Titan</h3>
          <a href="manga-information.php"><img src="../images/attack-on-titan.jpg" alt="Fairy Tail cover" /></a>
        </li>
        <li>
          <h3>Tower of God</h3>
          <a href="manga-information.php"><img src="../images/tower-of-god.jpg" alt="Tower of God cover" /></a>
        </li>
        <li>
          <h3>Shingeki No Kyojin</h3>
          <a href="manga-information.php"><img src="../images/attack-on-titan.jpg" alt="Fairy Tail cover" /></a>
        </li>
        <li>
          <h3>Tower of God</h3>
          <a href="manga-information.php"><img src="../images/tower-of-god.jpg" alt="Tower of God cover" /></a>
        </li>
      </ol>
    </section>

    <section class="manga-display">
      <header>
        <h2>Recently updated</h2>
      </header>
      <ol class="manga-list">
        <li>
          <h3>Tower of God</h3>
          <a href="manga-information.php"><img src="../images/tower-of-god.jpg" alt="Tower of God cover" /></a>
        </li>
        <li>
          <h3>One Piece</h3>
          <a href="manga-information.php"><img src="../images/one-piece.png" alt="One Piece cover" /></a>
        </li>
        <li>
          <h3>Fairy Tail</h3>
          <a href="manga-information.php"><img src="../images/fairy-tail.png" alt="Fairy Tail cover" /></a>
        </li>
        <li>
          <h3>One Piece</h3>
          <a href="manga-information.php"><img src="../images/one-piece.png" alt="One Piece cover" /></a>
        </li>
        <li>
          <h3>Fairy Tail</h3>
          <a href="manga-information.php"><img src="../images/fairy-tail.png" alt="Fairy Tail cover" /></a>
        </li>
      </ol>
    </section>
  </main>

  <footer>
    <a href="info.php">What is Man.ga?</a>
    <a href="contact.php">Contact us</a>
  </footer>

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>
</body>

</html>