<?php
$conn = mysqli_connect('localhost','root','admin123','my_shop') or die('connection failed');
$bdd = new PDO('mysql:host=localhost;dbname=my_shop;', 'root', 'admin123');
session_start();
$user_id = $_SESSION['user_id'];


if (!isset($user_id)) {
    header('location:signin.php');
};

if (isset($_GET['logout'])) {
    unset($user_id);
    session_destroy();
    header('location:index.php');
}
$allproducts = $bdd->query('SELECT * FROM products ORDER BY id DESC');
if ((isset($_GET['s'])) and !empty($_GET['s'])) {
    $recherche = htmlspecialchars($_GET['s']);
    $allproducts = $bdd->query('SELECT name FROM products WHERE name LIKE "%' . $recherche . '%" ORDER BY id DESC');
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
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>

</head>

<body>
    <div class="ecommerce">
        <div class="header">
                <div class="navbar">
                    <div class="gauche">
                        <a href="#" class="logo"><img src="integration-design-and-assets/Logo.png" /></a>
                        <div class="nav">
                            <a href="home.html" class="nav-links">HOME</a>
                            <a href="shop.html" class="nav-links">SHOP</a>
                            <a href="magazine.html" class="nav-links">MAGAZINE</a>
                        </div>
                    </div>
                    <div class="droite">
                        <a href="cart.html" class="nav-links2"><img src="images/Cart Button-2.png" /></a>
                        <?php
                        $select = mysqli_query($conn, "SELECT * FROM `users` WHERE `id` = '$user_id'") or die('query select \home failed');
                        if (mysqli_num_rows($select) > 0) {
                            $fetch = mysqli_fetch_assoc($select);
                        }
                        ?>
                        <h3><?php echo $fetch['username']; ?></h3>

                        <div class="right">
                            <ul>
                                <li>
                                    <?php
                                    $select = mysqli_query($conn, "SELECT * FROM `users` WHERE `id` = '$user_id'") or die('query select \home failed');
                                    if (mysqli_num_rows($select) > 0) {
                                        $fetch = mysqli_fetch_assoc($select);
                                    }
                                    if ($fetch['image'] == '') {
                                        echo '<img src="images/default-avatar.png">';
                                    } else {
                                        echo '<img src="uploaded_img/' . $fetch['image'] . '">';
                                    }
                                    ?>
                                    <i class="fas fa-angle-down"></i>
                                    <div class="dropdown">
                                        <ul>
                                            <a href="update_profile.php"><i class="fas fa-user"></i> Profile</a>
                                            <a href="#"><i class="fas fa-sliders-h"></i> Settings</a>
                                            <a href="admin_login.php"><i class="fa fa-lock" aria-hidden="true"></i> Admin</a>
                                            <a href="home.php?logout=<?php echo $user_id; ?>" class="delete-btn"><i class="fas fa-sign-out-alt"></i> Signout</a>
                                </li>
                            </ul>
                        </div>
                        </li>
                        </ul>
                    </div>
                    <!--<h3><?php echo $fetch['username']; ?></h3>-->
                    <!--<a href="home.php?logout=<?php echo $user_id; ?>" class="delete-btn">Logout</a>-->
                    <a href="#" class="burgermobile"><img src="images/burger_Mobile.png" /></a>
                </div>
        </div>
        <div class="searchbar-grand">
            <div class="searchbar">
                <div class="search">
                    <a href="#" class="searchlogo"><img src="images/Search.png" /></a>
                </div>
                <div class="algolia">

                    <form method="GET">
                        <input type="search" name="s" placeholder="researche" autocomplete="off">
                        <input type="submit" name="envoyer">
                    </form>
                    <?php
                    if ($allproducts->rowCount() > 0) {
                        while ($products = $allproducts->fetch()) {
                    ?>
                            <p><?= $products['name']; ?></p>
                        <?php
                        }
                    } else {
                        ?>
                        <p>Aucun produit trouvé</p>
                    <?php

                    }
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
            <!--<div class= "dropdown-bestmatch">
                        <button class="bestmatch">Best Match</button>
                        <i class="fas fa-angle-down"></i>
                   </div>
                   <div class="dropdown-content">
                        <a class= "dropdown-links" href="#">Link 1</a>
                        <a class= "dropdown-links" href="#">Link 2</a>
                        <a class= "dropdown-links"href="#">Link 3</a>
                    </div>-->
            <div class="right">
                <ul>
                    <li>
                        <button class="bestmatch">Best Match<i class="fas fa-angle-down"></i></button>
                        <div class="dropdown">
                            <ul>
                                <a href="update_profile.php"><i class="fas fa-user"></i> Profile</a>
                                <a href="#"><i class="fas fa-sliders-h"></i> Settings</a>
                                <a href="admin_login.php/"><i class="fa fa-lock" aria-hidden="true"></i> Admin</a>
                                <a href="home.php?logout=<?php echo $user_id; ?>" class="delete-btn"><i class="fas fa-sign-out-alt"></i> Signout</a>
                    </li>
                </ul>
            </div>
            </li>
            </ul>
        </div>
    </div>
    </header>
    </div>
    <div class="container-grid">
        <?php
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

                $insererArticle = $bdd->prepare('SELECT * FROM products');
                $insererArticle->execute(array($name, $price, $description, $new_img_name));
                echo "L'article a bien été ajouté";
            } else {
                echo "Veuillez compléter tous les champs...";
            }
        }

        $recupArticles = $bdd->query('SELECT * FROM products');
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
    </div>
    <script>
        document.querySelector(".right ul li").addEventListener("click", function() {
            this.classList.toggle("active");
        });
    </script>
</body>

</html>