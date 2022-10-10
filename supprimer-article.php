<?php
$bdd = new PDO('mysql:host=127.0.0.1;dbname=my_shop;', 'root', '');
if(isset($_GET['id']) AND !empty($_GET['id'])){
$getid = $_GET['id'];
$recupArticle = $bdd->prepare('SELECT * FROM products WHERE id = ? ');
$recupArticle->execute(array($getid));
if($recupArticle->rowCount() > 0){
$deleteArticle = $bdd->prepare('DELETE FROM products WHERE id = ?');
$deleteArticle->execute(array($getid));
header('Location: articles.php');
} else {
    echo "Aucun article trouvé";
}
}else {
    echo "Aucun id trouvé";
}

?>