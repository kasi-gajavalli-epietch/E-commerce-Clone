<?php
session_start();
$conn = new PDO('mysql:host=localhost;dbname=my_shop;', 'root', 'admin123');
/*if (!$_SESSION['mdp']) {
    header('Location: admin_login.php');
}*/
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

        $insererArticle = $conn->prepare('SELECT * FROM products');
        $insererArticle->execute(array($name, $price, $description, $new_img_name));
        echo "L'article a bien été ajouté";
    } else {
        echo "Veuillez compléter tous les champs...";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Item Grid</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='style.css'>

    <script src='main.js'></script>
</head>

<body>
    <div class="ecommerce">
        <div class="header">
            <header>
                <div class="navbar">
                    <div class="gauche">
                        <a href="#" class="logo"><img src="integration-design-and-assets/Logo.png" /></a>
                        <div class="nav">
                            <a href="index-login.php" class="nav-links">HOME</a>
                            <a href="index-login.php" class="nav-links">FILTER</a>
                            <a href="indexsearch.php" class="nav-links">SEARCH</a>
                        </div>
                    </div>
                    <div class="droite">
                        <a href="cart.html" class="nav-links2"><img src="images/Cart Button-2.png" /></a>
                        <a href="signin.php" class="nav-links">LOGIN</a>
                        <a href="#" class="burgermobile"><img src="images/burger_Mobile.png" /></a>
                    </div>
                </div>
                <div class="searchbar-grand">
                    <div class="searchbar">
                        <div class="search">
                            <a href="#" class="searchlogo"><img src="images/Search.png" /></a>
                        </div>
                        <div class="algolia">
                            <a href="#" class="placeholder-algolia"><input type="text" placeholder="Powered by Algolia"><img src="images/Sajari Logo.png" /></a>
                            <?php
                            ?>
                        </div>
                        <div class="media-screen-algolia">
                            <div class="searchlogo-mobile">
                                <a href="#" class="searchlogo-mobile"><img src="images/Search.png" /></a>
                            </div>
                            <div class="algolia-mobile">
                                <a href="#" class="placeholder-algolia"><input type="text"></a>
                                <div class="algolia-mobile-details">
                                    <p>Powered by Algolia</p>
                                    <img src="images/Sajari Logo.png" />
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="dropdown">

                        <button class="bestmatch">Best Match</button>
                    </div>
                </div>
            </header>

        </div>
        <div class="container-grid">
            <?php
            $recupArticles = $conn->query('SELECT * FROM products');
            while ($article = $recupArticles->fetch()) {
            ?>
                <div class="product-items">
                    <div class="product">
                        <div class="product-content">
                            <img src="uploaded_img/<?= $article['image'] ?>">
                        </div>
                        <div class="product-info">
                            <div class="product-info-top">
                                <div class="inline-container">
                                    <h2 class="sm-title"><?= $article['name']; ?></h2>
                                    <h2 class="price"><?= $article['price']; ?></h2>
                                </div>
                                <div class="product-subtitle">
                                    <h4><?= $article['description']; ?></h4>
                                </div>
                                <div class="rating-cart">
                                    <div class="rating">
                                        <span><img class="star" src="images/Star - On.png"></span>
                                        <span><img class="star" src="images/Star - On.png"></span>
                                        <span><img class="star" src="images/Star - On.png"></span>
                                        <span><img class="star" src="images/Star - On.png"></span>
                                        <span><img class="star" src="images/Star.png"></span>
                                    </div>
                                    <div class="cart">
                                        <span><img class="cart" src="images/Cart Button.png"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
            <?php
            }
            ?>
        </div>
        <div class="footer-grand">
            <div class="footer">
                <footer>
                    <div class="pagination">

                        <a class="active" href="#">1</a>
                        <a href="#">2</a>
                        <a href="#">3</a>
                        <a href="#">4</a>
                        <a href="#">5</a>
                        <a href="#">6</a>
                        <a href="#">7</a>
                        <a href="#">8</a>
                        <a href="#">9</a>
                        <a href="#">10</a>
                        <a href="#">&gt;</a>
                    </div>
                </footer>

            </div>
            <div class="footer-mobile">
                <div class="pagination-mobile">
                    <a class="active" href="#">1</a>
                    <a href="#">2</a>
                    <a href="#">3</a>
                    <a href="#">4</a>
                    <a href="#">&gt;</a>
                </div>
            </div>
        </div>

    </div>

</body>

</html>