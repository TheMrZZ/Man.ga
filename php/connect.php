<?php
$host = "localhost:3306";
$db = "man.ga";
$user = "root";
$pass = "";
$dsn = "mysql:host=$host;dbname=$db";
$conn = new PDO($dsn, $user, $pass);
?>