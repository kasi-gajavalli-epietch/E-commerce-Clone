<?php
$conn = mysqli_connect('localhost','root','admin123','my_shop') or die('connection failed');
$bdd = new PDO('mysql:host=localhost;dbname=my_shop;', 'root', 'admin123');
?>