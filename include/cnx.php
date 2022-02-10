<?php

$dsn = 'mysql:localhost;
dbname=monblog';
$user="root";
$pwd="password";

try {
    $cnx = new PDO($dsn, $user, $pwd);
} catch (PDOException $e) {
    echo 'Une erreur de connexion est intervenue';
}
