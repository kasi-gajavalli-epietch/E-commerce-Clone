<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=my_shop;', 'root', 'admin123');
if (!$_SESSION['mdp']) {

    header('Location: admin_login.php');
}
if (isset($_POST['envoi'])) {
    if (!empty($_POST['name']) and !empty($_POST['price']) and !empty($_POST['description']) and !empty($_FILES['image']) and !empty($_POST['category_id'])) {
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
        $cate = htmlspecialchars(($_POST['category_id']));



        /*$category = $_POST['category_id']; // get 2 ou 3
        $recupCategory = $bdd->query("SELECT 'parent_id' FROM 'categories' WHERE 'parent_id' = $category");
        $categoryEntity = $recupCategory->fetch();
        if ($categoryEntity) {*/
        $insererArticle = $bdd->prepare('INSERT INTO products(name, price, description, image, category_id ) VALUES(?, ?, ?, ?, ?)') or die('query insererArticle ');
        $insererArticle->execute(array($name, $price, $description, $new_img_name, $_POST["category_id"]));
        //}

        echo "L'article a bien été ajouté";
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
    <link rel='stylesheet' type='text/css' media='screen' href='admin.css'>


</head>

<body>

    <div class="publier-article">
        <h2><a href="general.php" id="style-2" data-replace="Home"><span>Retour page d'acceuil</span></a></h2>

        <h1> Publier un article </h1>
        <form method="post" action="" enctype="multipart/form-data">

            <input type="text" name="name" placeholder="Nom du produit">
            <br>
            <input type="text" name="price" placeholder="Prix">
            <br>
            <input name="description" placeholder="Description du produit"></input>
            <br>
            <input class="file" type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png">
            <br>
            <?php
            $getCategory = $bdd->prepare('SELECT * FROM `categories`');
            $getCategory->execute(array());
            $getCategory = $getCategory->fetchAll();
            ?>

            <select name="category_id" id="name">
                <?php
                foreach ($getCategory as $elem) {
                ?> <option value="<?php echo (string)($elem["id"]); ?>"><br><?php echo $elem["name"]; ?></option> <?php } ?>
            </select>

            <br>
            <input class="submit" type="submit" name="envoi">
        </form>

</body>

</html>