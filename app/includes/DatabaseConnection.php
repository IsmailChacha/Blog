<?php 
$dsn = 'mysql:host=localhost;dbname=Blog;charset = utf8';
$user = 'root';
$pass = '';

$pdo = new PDO($dsn, $user, $pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// DISPLAYING STUFF TEMPORARILY
function display($data)
{
  echo "<pre>", print_r($data, true), "</pre>";
  die();
}
