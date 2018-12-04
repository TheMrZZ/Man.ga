<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Man.ga - One Piece</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous"/>
  <link href="../css/main.css" rel="stylesheet" type="text/css"/>
  <link href="../css/manga-list.css" rel="stylesheet" type="text/css"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Florian Ernst">
  <meta name="description" content="Man.ga manga list - discover, rate and choose mangas in our informative list.">
  <meta name="keywords" content="Man.ga,manga,mangas,list,discover,rate,choose,informative">
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
          <input class="form-control mr-sm-2" type="search" placeholder="Search a manga..." aria-label="Search"
                 name="search"/>
        </form>
      </div>
      <ul class="nav navbar-nav flex-fill w-100 justify-content-end">
        <li class="nav-item">
          <a class="nav-link" href="profile.php"><img src="../icon/user.svg" class="profile-icon" width="35"
                                                      alt="Go to your profile"></a>
        </li>
      </ul>
    </div>
  </nav>
</header>

<div class="main">
  <nav class="filters">
    <header>
      <h2>Filters</h2>
    </header>
    <form method="GET" class="filter-form">
      <div class="input">
        <label class="label" for="filter-type">Types</label><br>
        <select name="type" id="filter-type" multiple>
          <option value="shonen">Shonen</option>
          <option value="shojo">Shojo</option>
          <option value="seinen">Seinen</option>
          <option value="josei">Josei</option>
          <option value="kodomomuke">Kodomomuke</option>
        </select>
      </div>

      <div class="input">
        <label class="label" for="filter-genre">Genres</label><br>
        <select name="genre" id="filter-genre" multiple>
          <option value="action">Action</option>
          <option value="adventure">Adventure</option>
          <option value="comedy">Comedy</option>
          <option value="drama">Drama</option>
          <option value="slice-of-life">Slice of Life</option>
          <option value="fantasy">Fantasy</option>
          <option value="magic">Magic</option>
          <option value="supernatural">Supernatural</option>
          <option value="horror">Horror</option>
          <option value="mystery">Mystery</option>
          <option value="psychological">Psychological</option>
          <option value="romance">Romance</option>
          <option value="scifi">SciFi</option>
        </select>
      </div>

      <div class="input">
        <p class="label">Status</p>
        <label for="status-all">All</label>
        <input type="radio" name="status" id="status-all" value="all"><br/>

        <label for="status-ongoing">Ongoing</label>
        <input type="radio" name="status" id="status-ongoing" value="Ongoing"><br/>

        <label for="status-completed">Completed</label>
        <input type="radio" name="status" id="status-completed" value="Completed">
      </div>

      <div class="input">
        <p class="label">Rating</p>
        <p> At least <input class="min-rating" type="number" min="0" max="5" value="0"> stars </p>
      </div>

      <div class="input">
        <p class="label">Favorites</p>
        <label for="favorite-all">All:</label>
        <input type="radio" name="favorite" id="favorite-all" value="all"><br>

        <label for="favorite-only">Favorites Only</label>
        <input type="radio" name="favorite" id="favorite-only" value="only"><br>

        <label for="favorite-none">Hide Favorites</label>
        <input type="radio" name="favorite" id="favorite-none" value="none"><br>
      </div>

      <div class="submit-wrapper">
        <button class="filter-submit" type="submit">Search</button>
      </div>
    </form>
  </nav>

  <main>
    <header>
      <h2>Manga List</h2>
      <form>
        <label>Sort by &nbsp;
          <select name="sort">
            <option value="popularity">Popularity</option>
            <option value="votes">Number of votes</option>
            <option value="data">Date of last update</option>
          </select>
        </label>
      </form>
    </header>

    <ul class="manga-list">
      <?php
      require './connect.php';
      $statement = $conn->prepare('SELECT * FROM manga');
      // TODO: bind params

      $statement->execute();
      $mangaList = $statement->fetchAll();

      foreach ($mangaList as $manga) {
        $type = $conn->query('SELECT name FROM type WHERE id = ' . $manga['typeID'])->fetch()['name'];
        $genresArray = $conn->query('SELECT name FROM genre WHERE id IN (SELECT genreID FROM mangagenre WHERE mangaID = ' . $manga['id'] . ')')->fetchAll();
        $genres = "";
        foreach ($genresArray as $genre) {
          $genres .= ", ";
        }

        echo "
          <li>
            <ul class=\"manga\">
              <li class=\"cover\"><a href=\"manga-information.php\"><img src=\"../images/" . $manga['id'] . ".png\"
                                                                     alt=\"" . $manga['name'] . " cover\"></a></li>
              <li class=\"info\">
                <p class=\"name\">" . $manga['name'] . "</p>
                <p>925 chapters</p>
              </li>
              <li class=\"type\">
                <p>" . $type . "</p>
                <p>" . $genres . "</p>
              </li>
              <li class=\"rating\"> &star; 4.67</li>
              <li class=\"last-update\"> 9 hours ago</li>
              <li class=\"favorite is-favorite\" style=\"color:yellow\"> &starf;</li>
            </ul>
          </li>
        ";
      }
      ?>

      <li>
        <ul class="manga">
          <li class="cover"><a href="manga-information.php"><img src="../images/one-piece.png"
                                                                 alt="One Piece cover"></a></li>
          <li class="info">
            <p class="name">One Piece</p>
            <p>925 chapters</p>
          </li>
          <li class="type">
            <p>Shonen</p>
            <p>Action, Adventure, Fantasy</p>
          </li>
          <li class="rating"> &star; 4.67</li>
          <li class="last-update"> 9 hours ago</li>
          <li class="favorite is-favorite" style="color:yellow"> &starf;</li>
        </ul>
      </li>

      <li>
        <ul class="manga">
          <li class="cover"><img src="../images/attack-on-titan.jpg" alt="Attack on Titan cover"></li>
          <li class="info">
            <p class="name">Shingeki No Kyojin - Attack on Titan</p>
            <p>542 chapters</p>
          </li>
          <li class="type">
            <p>Seinen</p>
            <p>Action, Horror, Fantasy</p>
          </li>
          <li class="rating"> &star; 4.3</li>
          <li class="last-update"> 2 days ago</li>
          <li class="favorite"> &star;</li>
        </ul>
      </li>
      <li>
        <ul class="manga">
          <li class="cover"><img src="../images/tower-of-god.jpg" alt="Tower of God cover"></li>
          <li class="info">
            <p class="name">Tower of God</p>
            <p>650 chapters</p>
          </li>
          <li class="type">
            <p>Shonen</p>
            <p>Action, Fantasy, Magic, Mystery</p>
          </li>
          <li class="rating"> &star; 4.1</li>
          <li class="last-update"> 1 week ago</li>
          <li class="favorite" style="color:yellow"> &starf;</li>
        </ul>
      </li>
      <li>
        <ul class="manga">
          <li class="cover"><img src="../images/fairy-tail.png" alt="Fairy Tail cover"></li>
          <li class="info">
            <p class="name">Fairy Tail</p>
            <p>12 chapters</p>
          </li>
          <li class="type">
            <p>Shojo</p>
            <p>Comedy, Fantasy, Magic, Romance</p>
          </li>
          <li class="rating"> &star; 1.2</li>
          <li class="last-update"> 1 year ago</li>
          <li class="favorite"> &star;</li>
        </ul>
      </li>
      <li>
        <ul class="manga">
          <li class="cover"><img src="../images/fairy-tail.png" alt="Fairy Tail cover"></li>
          <li class="info">
            <p class="name">Fairy Tail</p>
            <p>12 chapters</p>
          </li>
          <li class="type">
            <p>Shojo</p>
            <p>Comedy, Fantasy, Magic, Romance</p>
          </li>
          <li class="rating"> &star; 1.2</li>
          <li class="last-update"> 1 year ago</li>
          <li class="favorite"> &star;</li>
        </ul>
      </li>
      <li>
        <ul class="manga">
          <li class="cover"><img src="../images/fairy-tail.png" alt="Fairy Tail cover"></li>
          <li class="info">
            <p class="name">Fairy Tail</p>
            <p>12 chapters</p>
          </li>
          <li class="type">
            <p>Shojo</p>
            <p>Comedy, Fantasy, Magic, Romance</p>
          </li>
          <li class="rating"> &star; 1.2</li>
          <li class="last-update"> 1 year ago</li>
          <li class="favorite"> &star;</li>
        </ul>
      </li>
    </ul>
  </main>
</div>

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