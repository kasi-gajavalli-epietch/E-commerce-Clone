<?php
$bdd = new PDO('mysql:host=127.0.0.1;dbname=my_shop;', 'root', '');
if(isset($_GET['id'])AND !empty($_GET['id'])){
$getid = $_GET['id'];
$recupArticle = $bdd->prepare('SELECT * FROM products WHERE id = ?');
$recupArticle->execute(array($getid));
if($recupArticle->rowCount() > 0) {
    $articleInfos = $recupArticle->fetch();
$name = $articleInfos['name'];
$price = $articleInfos['price'];
if(isset($_POST['valider'])) {
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_img/' . $image;
    $img_ex = pathinfo($image, PATHINFO_EXTENSION);
    $img_ex_lc = strtolower($img_ex);
    $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
    $img_upload_path = 'uploaded_img/' . $new_img_name;
    move_uploaded_file($tmp_name, $img_upload_path);

    $nom_saisi = htmlspecialchars($_POST['name']);
    $prix_saisi = nl2br(htmlspecialchars($_POST['price']));
    $description_saisi = nl2br(htmlspecialchars($_POST['description']));
    //$image_sent = nl2br(htmlspecialchars($_FILES['image']));
    $updateArticle = $bdd->prepare('UPDATE products SET name = ?, price = ?, description = ?, image = ? WHERE id = ?');
    $updateArticle->execute(array($nom_saisi, $prix_saisi, $description_saisi, $new_img_name, $getid));
    header('Location: articles.php');
}

} else {
    echo "Aucun article trouvé";
}
} else {
    echo "Aucun id trouvé";
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Modifier un produit</title>
    <meta charset="utf-8">


</head>

<body>
<a href="general.php">Home</a>
    <form method="POST" action="" enctype="multipart/form-data" >
        <input type="text" name="name" value="<?= $name; ?>" >
        <br>
        <textarea name="price" >
        <?= $price; ?>
        </textarea>
        <br>
        <textarea name="description" placeholder="Description du produit"></textarea>
        <br>
        <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png">
        <br>
        <br><br>
        <input type="submit" name="valider">
    </form>
    
</body>

</html>