<?php
session_start();
$conn = mysqli_connect('localhost','root','admin123','my_shop') or die('connection failed');
$bdd = new PDO('mysql:host=localhost;dbname=my_shop;', 'root', 'admin123');
$user_id = $_SESSION['user_id'];

$allproducts = $bdd->query('SELECT * FROM products ORDER BY id DESC');

// SEARCH BAR -'s' = text that is searched
if ((isset($_GET['s'])) and !empty($_GET['s'])) {
    $recherche = htmlspecialchars($_GET['s']);
    $allproducts = $bdd->query('SELECT * FROM products WHERE name LIKE "%' . $recherche . '%" ORDER BY id DESC');
}
// REQUETE USER PROFIL
$select = mysqli_query($conn, "SELECT * FROM `users` WHERE `id` = '$user_id'") or die('query select \home failed');
if (mysqli_num_rows($select) > 0) {
    $fetch = mysqli_fetch_assoc($select); // $fetch = user profil details
}
// REQUEST CATEGORIES 
// PART ONE: DISPLAY CATEGORIES IN FILTER NAV
$category_query = mysqli_query($conn, "SELECT * FROM categories");


// CHECKBOX CATEGORIES DISPLAY PRODUCT 
if (isset($_GET['name'])) {
    $categorychecked = [];
    $categorychecked = $_GET['name'];
    foreach ($categorychecked as $rowcategory) {
        // echo $rowcategory;
        $request_categories = "SELECT * FROM products WHERE id IN ($rowcategory)";
        //display products-container grid
    }
}
//Price range

if (isset($_GET['start_price']) && isset($_GET['end_price'])) {
    $startprice = $_GET['start_price'];
    $endprice = $_GET['end_price'];
    $products = "SELECT * FROM products WHERE price BETWEEN $startprice AND $endprice";
} else {
    $products = "SELECT * FROM products";
}
$request_Pricerange = $products_run = mysqli_query($conn, $products);
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
                        <a href="index-login.php" class="nav-links">HOME</a>
                        <a href="index-login.php" class="nav-links">FILTER</a>
                        <a href="testindex.php" class="nav-links">SEARCH</a>
                    </div>
                </div>
                <div class="droite">
                    <a href="cart.html" class="nav-links2"><img src="images/Cart Button-2.png" /></a>
                    <h3><?php echo $fetch['username']; ?></h3>
                    <div class="right">
                        <ul>
                            <li>
                                <?php
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
                                        <a href="home.php?logout=<?php echo $fetch['id']; ?>" class="delete-btn"><i class="fas fa-sign-out-alt"></i> Signout</a>

                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <a href="#" class="burgermobile"><img src="images/burger_Mobile.png" /></a>
                </div>
                <div class="navbar">
                    <form method="GET">
                        <input type="search" name="s" placeholder="research" autocomplete="off" value="<?php echo (isset($recherche) ? $recherche : "") ?>"></input>
                        <input type="submit" name="envoyer">
                    </form>
                </div>
            </div>

            <div class="container-grid">
                <div class="container-filter">
                    <div class="filter">
                        <div class="filter-title">
                            <br>
                            <button class="collapsible">Category</button>
                            <div class="content">
                                <div>
                                    <?php
                                    if (mysqli_num_rows($category_query) > 0) {
                                        foreach ($category_query as $categorylist) {

                                            $checked = [];
                                            if (isset($_GET['name'])) {
                                                $checked = $_GET['name'];
                                            }
                                            if ($categorylist['name'] === $checked) {
                                    ?>
                                                <input type="checkbox" id="myCheck" name="name[]" value="<?= $categorylist['id']; ?>">
                                            <?php
                                            } else {
                                            ?>
                                                <input type="checkbox" id="myCheck" name="name[]" value="<?= $categorylist['id']; ?>">
                                            <?php
                                            }
                                            ?>
                                    <?php echo $categorylist["name"];
                                        }
                                    } ?>
                                </div>
                            </div>
                            <button class="collapsible">Couleur</button>
                            <div class="content">
                                <br>
                                <label for="myCheck">Checkbox:</label>
                                <input type="checkbox" id="myCheck" onclick="myFunction()"><br><br>
                                <label for="myCheck">Checkbox:</label>
                                <input type="checkbox" id="myCheck" onclick="myFunction()"><br><br>
                            </div>
                            <div class="price-range">
                                <p> Price Range
                                <p>
                                <form>
                                    <div class="price-range-min-max">
                                        <label for="">Min</label>
                                        <input type="int" id="mytext" name="start_price" value="<?php if (isset($_GET['start_price'])) {
                                                                                                    echo $_GET['start_price'];
                                                                                                } ?>">
                                        <label for="">Max</label>
                                        <input type="int" id="mytext" name="end_price" value="<?php if (isset($_GET['end_price'])) {
                                                                                                    echo $_GET['end_price'];
                                                                                                } ?>">
                                    </div>
                                    <div>
                                        <button type="submit-btn" class="price-submit-btn">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                if ($allproducts->rowCount() > 0) {
                    while ($products = $allproducts->fetch()) {
                ?>
                        <div class="product-items">
                            <div class="product">
                                <div class="product-content">
                                    <img src="uploaded_img/<?= $products['image'] ?>">
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
        </div>
        <script>
            document.querySelector(".right ul li").addEventListener("click", function() {
                this.classList.toggle("active");
            });
        </script>
        <script>
            var coll = document.getElementsByClassName("collapsible");
            var i;

            for (i = 0; i < coll.length; i++) {
                coll[i].addEventListener("click", function() {
                    this.classList.toggle("active");
                    var content = this.nextElementSibling;
                    if (content.style.maxHeight) {
                        content.style.maxHeight = null;
                    } else {
                        content.style.maxHeight = content.scrollHeight + "px";
                    }
                });
            }
        </script>

</body>

</html>