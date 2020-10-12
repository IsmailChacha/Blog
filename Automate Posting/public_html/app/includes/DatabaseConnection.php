<?php 
$dsn = 'mysql:host=localhost;dbname=thelinux_Blog;charset = utf8';
$user = 'thelinux_thelinuxpost';
$pass = 'ismail34389988';

$pdo = new PDO($dsn, $user, $pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// DISPLAYING STUFF TEMPORARILY
function display($data)
{
  echo "<pre>", print_r($data, true), "</pre>";
  die();
}
