<?php
$conn = mysqli_connect('localhost','root','admin123','my_shop') or die('connection failed');
$bdd = new PDO('mysql:host=localhost;dbname=my_shop;', 'root', 'admin123');
session_start();
$user_id = $_SESSION['user_id'];


if(!isset($user_id)){
   header('location:signin.php');
};

if(isset($_GET['logout'])){
   unset($user_id);
   session_destroy();
   header('location:index.php');
}

?>
<!DOCTYPE html>
<html>

<head>

    <title>Home</title>
    <meta charset="utf-8">
    <link rel='stylesheet' type='text/css' media='screen' href='admin.css'>


</head>

<body>
<a href="home.php?logout=<?php echo $user_id; ?>" class="delete-btn"><i class="fas fa-sign-out-alt"></i> Signout</a>
<div class="general">
    <h2><a href="membres.php" id="style-2" data-replace="Display all members"><span>Afficher les membres</span></a></h2>
   
   <br>
   <h2><a href="publier-article.php" id="style-2" data-replace="Add a product"><span>Publier un nouveau produit</span></a></h2>
   
   <br>
   <h2><a href="articles.php" id="style-2" data-replace="Display all products"><span>Afficher les produits</span></a></h2>
   
   <br>
</div>
</body>

</html>