<?php
session_start();
if (!$_SESSION['mdp']) {
    header('Location: admin_login.php');
}
?>
<!DOCTYPE html>
<html>

<head>

    <title>Home</title>
    <meta charset="utf-8">


</head>

<body>
   <a href="membres.php">Afficher tous les membres</a>
   <br>
   <a href="publier-article.php">Publier un nouvel article</a>
   <br>
   <a href="articles.php">Afficher tous les articles</a>
   <br>
</body>

</html>