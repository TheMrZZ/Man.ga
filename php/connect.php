<?php
$host = "localhost:8889";
$db = "man.ga";
$user = "root";
$pass = "";
$dsn = "mysql:host=$host;dbname=$db";
$con = new PDO($dsn, $user, $pass);
?>