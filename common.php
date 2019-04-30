<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=maxime;charset=utf8', 
               'root', 
               '',
               array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // permet d'afficher les erreurs SQL et à supprimer en production 
                     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC));

$bytes = random_bytes(8);
$randomBytes = bin2hex($bytes);
?>