<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=my_shop;', 'root', 'admin123');
$allproducts = $bdd->query('SELECT * FROM products ORDER BY id DESC');

if ((isset($_GET['s'])) and !empty($_GET['s'])) {
    $recherche = htmlspecialchars($_GET['s']);
    $allproducts = $bdd->query('SELECT * FROM products WHERE name LIKE "%' . $recherche . '%" ORDER BY id DESC');
    $allproducts->execute();
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">

    <link rel='stylesheet' type='text/css' media='screen' href='style.css'>
    <title>Document</title>
</head>

<body>
    <form method="GET">
    <input type="search" name="s" placeholder="researche" autocomplete="off">
    <input type="submit" name="envoyer">
    </form>

    <div class="container-grid">
    <?php
    if ($allproducts->rowCount() > 0) {
        while ($products = $allproducts->fetch()) {
    ?>
    
        <div class="product-items">
                <div class="product">
                    <div class="product-content">
                        <img src="uploaded_img/<?=$products['image']?>">
                    </div>
                    <div class="product-info">
                        <div class="product-info-top">
                            <div class="inline-container">
                                 
                                <h2 class="sm-title"><?= $products['name']; ?></h2>
                                <h2 class="price"><?= $products['price']; ?></h2>
                            </div>
                            <div class="product-subtitle">
                                <h4><?= $products['description']; ?></h4>
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
    } else {
        ?>
        <p>Aucun produit trouvé</p>
    <?php

    }
    ?>
    </div>
</body>

</html>