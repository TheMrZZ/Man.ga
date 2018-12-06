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
  <?php
  require './navbar.php';
  echo $navbar;
  ?>
</header>

<div class="main">
  <nav class="filters">
    <header>
      <h2>Filters</h2>
    </header>
    <form method="GET" class="filter-form">
      <div class="input">
        <label class="label" for="filter-type">Types</label><br>
        <select name="type" id="filter-type">
          <option value="any">Any</option>
          <option value="shonen">Shonen</option>
          <option value="shojo">Shojo</option>
          <option value="seinen">Seinen</option>
          <option value="josei">Josei</option>
          <option value="kodomomuke">Kodomomuke</option>
        </select>
      </div>

      <div class="input">
        <label class="label" for="filter-genre">Genres</label><br>
        <select name="genre" id="filter-genre">
          <option value="any">Any</option>
          <option value="action">Action</option>
          <option value="adventure">Adventure</option>
          <option value="comedy">Comedy</option>
          <option value="drama">Drama</option>
          <option value="slice of life">Slice of Life</option>
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
        <p> At least <label>
            <input class="min-rating" name="rating" type="number" min="0" max="5" value="0">
          </label> stars </p>
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
    </header>

    <div id="list-wrapper">
      <label id="label-sort">Sort by &nbsp;
        <select name="sort" id="manga-sort" onchange="updateAscDesc()">
          <option value="votes" class="sort" data-sort="name" id="sort-votes">Title</option>
          <option value="rating" class="sort" data-sort="rating" id="sort-rating">Rating</option>
          <option value="chapters" class="sort" data-sort="chapters" id="sort-chapters">Number of chapters</option>
        </select>
      </label>

      <ul class="manga-list">
        <?php
        require './connect.php';

        $query = 'SELECT id, name, author, typeID, status, description, chapters, last_update FROM manga';
        $whereOrAnd = "WHERE";

        if (!empty($_GET['search'])) {
          $name = '%' . strtolower($_GET['search']) . '%';
          $query .= " $whereOrAnd name LIKE :name";
          $whereOrAnd = "AND";
        }

        if (!empty($_GET['type']) && $_GET['type'] !== "any") {
          $type = strtolower($_GET['type']);
          $statement = $conn->prepare('SELECT id FROM type WHERE name = :name');
          $statement->bindParam(':name', $type);
          $statement->execute();
          $typeID = $statement->fetch()['id'];
          $query .= " $whereOrAnd typeID = :typeID";
          $whereOrAnd = "AND";
        }

        if (!empty($_GET['genre']) && $_GET['genre'] !== "any") {
          $genre = strtolower($_GET['genre']);
          echo "Genre is $genre";
          $statement = $conn->prepare('SELECT id FROM genre WHERE name = :name');
          $statement->bindParam(':name', $genre);
          $statement->execute();
          $genreID = $statement->fetch()['id'];
          $query .= " $whereOrAnd manga.id IN (SELECT mg.mangaID FROM mangagenre AS mg WHERE mg.genreID = :genreID)";
          $whereOrAnd = "AND";
        }

        if (!empty($_GET['status']) && $_GET['status'] !== "all") {
          $status = strtolower($_GET['status']);
          $query .= " $whereOrAnd manga.status = :status";
          $whereOrAnd = "AND";
        }

        if (!empty($_GET['rating'])) {
          $rating = strtolower($_GET['rating']);
          $query .= " $whereOrAnd :rating < (SELECT avgRating FROM average_rating WHERE mangaID = manga.id)";
          $whereOrAnd = "AND";
        }

        // User must be logged to get his favourites
        if (!empty($_GET['favorite']) && $_GET['favorite'] !== 'all' && isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
          $favorite = strtolower($_GET['favorite']);
          if ($favorite == 'only') {
            $query .= " $whereOrAnd id IN (SELECT mangaID FROM favorite WHERE userID = " . $_SESSION['id'] . ")";
            $whereOrAnd = "AND";
          }
          if ($favorite == 'none') {
            $query .= " $whereOrAnd id NOT IN (SELECT mangaID FROM favorite WHERE userID = " . $_SESSION['id'] . ")";
            $whereOrAnd = "AND";
          }
        }

        $statement = $conn->prepare($query);
        if (!empty($name)) $statement->bindParam(':name', $name);
        if (!empty($typeID)) $statement->bindParam(':typeID', $typeID);
        if (!empty($genreID)) $statement->bindParam(':genreID', $genreID);
        if (!empty($status)) $statement->bindParam(':status', $status);
        if (!empty($rating)) $statement->bindParam(':rating', $rating);
        $statement->execute();
        $mangaList = $statement->fetchAll();

        foreach ($mangaList as $manga) {
          $type = ucwords($conn->query('SELECT name FROM type WHERE id = ' . $manga['typeID'])->fetch()['name']);
          $genresArray = $conn->query('SELECT name FROM genre WHERE id IN (SELECT genreID as id FROM mangagenre WHERE mangaID = ' . $manga['id'] . ')')->fetchAll();
          $genres = join(", ", array_map(function ($el) {
            return ucwords($el['name']);
          }, $genresArray));

          $rating = round($conn->query('SELECT avgRating FROM average_rating WHERE mangaID = ' . $manga['id'])->fetch()['avgRating'], 1);

          $isFavorite = false;
          if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
            $query = $conn->query('SELECT id FROM favorite WHERE mangaID =' . $manga['id'] . ' AND userID = ' . $_SESSION['id']);
            $result = $query->fetch();
            if ($result !== false) {
              $isFavorite = true;
            }
          }

          echo "
          <li>
            <ul class=\"manga\">
              <li class=\"cover\"><a href=\"manga-information.php?id=" . $manga['id'] . "\">
                <img src=\"../images/" . $manga['id'] . ".png\" alt=\"" . $manga['name'] . " cover\"></a>
              </li>
              <li class=\"info\">
                <p class=\"name\">" . $manga['name'] . "</p>
                <p class=\"chapters\">" . $manga['chapters'] . " chapters</p>
              </li>
              <li class=\"type\">
                <p>" . $type . "</p>
                <p>" . $genres . "</p>
              </li>
              <li class=\"rating\"> &star; " . $rating . "</li>
              <li class=\"last-update\">" . $manga['last_update'] . "</li>
              <li id='star" . $manga['id'] . "' class=\"favorite " . ($isFavorite ? 'is-favorite' : '') . "\" onclick='toggleFavorite(" . $manga['id'] . ")'> &starf;</li>
            </ul>
          </li>
        ";
        }
        ?>
      </ul>
    </div>
  </main>
</div>

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

<script src="https://cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js"></script>

<script>
    let options = {
        valueNames: ["rating", "chapters", "name"],
        listClass: "manga-list",
    };

    new List('list-wrapper', options);

    function updateAscDesc() {
        $('.sort.asc').parent().parent().addClass('asc').removeClass('desc');
        $('.sort.desc').parent().parent().addClass('desc').removeClass('asc');
    }

    document.getElementById('sort-votes').onclick = updateAscDesc;
    document.getElementById('sort-rating').onclick = updateAscDesc;
    document.getElementById('sort-chapters').onclick = updateAscDesc;

    $.ready(updateAscDesc);

    function toggleFavorite(mangaID) {
      let id = 'star' + mangaID;
      let star = document.getElementById(id);

      star.classList.toggle('is-favorite');
    }
</script>

</body>

</html>