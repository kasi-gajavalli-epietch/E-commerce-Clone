<?php
session_start();
$bdd = new PDO('mysql:host=127.0.0.1;dbname=my_shop;', 'root', '');
if (!$_SESSION['mdp']) {
    header('Location: connexion.php');
}
if (isset($_POST['envoi'])) {
    if (!empty($_POST['name']) AND !empty($_POST['price']) AND !empty($_POST['description']) and !empty($_FILES['image'])) {
        $name = htmlspecialchars($_POST['name']);
        $price = nl2br(htmlspecialchars($_POST['price']));
        $description = nl2br(htmlspecialchars($_POST['description']));

        $image = $_FILES['image']['name'];
        $image_size = $_FILES['image']['size'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = 'uploaded_img/' . $image;
        $img_ex = pathinfo($image, PATHINFO_EXTENSION);
        $img_ex_lc = strtolower($img_ex);
        $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
        $img_upload_path = 'uploaded_img/' . $new_img_name;
        move_uploaded_file($tmp_name, $img_upload_path);
        
        $insererArticle = $bdd->prepare('SELECT * FROM products');
        $insererArticle->execute(array($name, $price, $description, $new_img_name));
        echo "L'article a bien été ajouté";

    }else {
        echo "Veuillez compléter tous les champs...";
    }
    
}
?>
<!DOCTYPE html>
<html>

<head>

    <title>Afficher tout les articles</title>
    <meta charset="utf-8">


</head>

<body>
<a href="general.php">Home</a>
    <?php
    $recupArticles = $bdd->query('SELECT * FROM products');
    while($article = $recupArticles->fetch()){
        ?>
        <div class="article" style="border: 1px solid black";>
            <h1><?= $article['name']; ?></h1>
            <p><?= $article['price'];?></p>
            <p><?= $article['description'];?></p>
            
            <img src="uploaded_img/<?=$article['image']?>">
            <a href="supprimer-article.php?id=<?=$article['id']; ?>">
            <button style="color:white; background-color:red; margin-bottom: 10px">Supprimer le produit</button>
        </a>
        <a href="modifier-article.php?id=<?=$article['id']; ?>">
            <button style="color:black; background-color:yellow; margin-bottom: 10px">Modifier le produit</button>
        </a>
            
        </div>
        <br>
        <?php
    }
    ?>
</body>

</html>