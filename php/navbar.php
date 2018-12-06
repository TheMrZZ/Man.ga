<?php
$navbar = '';

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

// If user is logged in, show the "logged in navbar"
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
  $navbar = '
    <nav class="navbar navbar-expand-lg navbar-light main-nav fixed-top">
    <a class="navbar-brand" href="home.php">Man.ga</a>
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
          <a class="nav-link" href="logout.php">Logout</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="profile.php"><img src="../icon/user.svg" class="profile-icon" width="35"
                                                      alt="Go to your profile"></a>
        </li>
      </ul>
    </div>
  </nav>
  ';
} else {
  $navbar = '  
  <nav class="navbar navbar-expand-lg navbar-light main-nav fixed-top">
    <a class="navbar-brand" href="home.php">Man.ga</a>
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
          <a class="nav-link" href="login.php">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="register.php">Register</a>
        </li>
      </ul>
    </div>
  </nav>
  ';
}
?>