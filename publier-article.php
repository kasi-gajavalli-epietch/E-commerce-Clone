<?php
session_start();
$bdd = new PDO('mysql:host=127.0.0.1;dbname=my_shop;', 'root', '');
if (!$_SESSION['mdp']) {
    
    header('Location: connexion.php');
}
if (isset($_POST['envoi'])) {
    if (!empty($_POST['name']) and !empty($_POST['price']) and !empty($_POST['description']) and !empty($_FILES['image'])) {
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

        $insererArticle = $bdd->prepare('INSERT INTO products(name, price, description, image) VALUES(?, ?, ?, ?)') or die('query insererArticle ');
        $insererArticle->execute(array($name, $price, $description, $new_img_name));


        echo "L'article a bien été ajouté";
        //header('Location: general.php');

    } else {
        echo "Veuillez compléter tous les champs...";
    }
}
?>
<!DOCTYPE html>
<html>

<head>

    <title>Publie un article</title>
    <meta charset="utf-8">


</head>

<body>
<a href="general.php">Home</a>
    <form method="post" action="" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Nom du produit">
        <br>
        <input type="text" name="price" placeholder="Prix">
        <br>
        <textarea name="description" placeholder="Description du produit"></textarea>
        <br>
        <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png">
        <br>
        <input type="submit" name="envoi">
    </form>

</body>

</html>