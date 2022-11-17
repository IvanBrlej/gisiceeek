<?php
session_start();
require 'connection.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin prihlasenie</title>
    <link rel="stylesheet" type="text/css" href="adminPrihlasenie.css">
</head>
<body>
<nav>
    <ul>
        <li><a href="uvodnaStranka.php" class="active">Domov</a></li>
        <li><a href="kategoria.php">Kategória</a></li>
        <li><a href="vybratieKategorieNaVlozenieOtazky.php">Pridanie otázky</a></li>
        <li><a href="vybratieFormularu.php">Vyplnenie formuláru</a></li>
        <li><a href="adminPrihlasenie.php" class="hover">Admin Prihlásenie</a></li>
    </ul>
</nav>
<form action="prihlasovaciHandler.php" method="post">
    <input  name="meno" placeholder="meno" class="box1"><br><br>
    <input  type="password"  name="heslo" placeholder="heslo" class="box2"><br><br>
    <button type="submit"  class="btn" name="prihlasovaciButton">Prihlásiť</button>
</form>
</body>
</html>