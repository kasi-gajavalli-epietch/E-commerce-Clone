<?php


$bdd = new PDO('mysql:host=localhost;dbname=my_shop;', 'root', 'admin123');
if (isset($_GET['id']) and !empty($_GET['id'])) {
    $getid = $_GET['id'];
    $recupUser = $bdd->prepare('SELECT * FROM users WHERE id = ?');
    $recupUser->execute(array($getid));
    if ($recupUser->rowCount() > 0) {
        $userInfos = $recupUser->fetch();
        $username = $userInfos['username'];
        $email = $userInfos['email'];
        $password = $userInfos['password'];
        // $admin = $userInfos['admin'];
        if (isset($_POST['valider'])) {
            $username_saisi = htmlspecialchars($_POST['username']);
            $email_saisi = nl2br(htmlspecialchars($_POST['email']));
            $password_saisi = nl2br(htmlspecialchars($_POST['password']));


            $updateUser = $bdd->prepare('UPDATE users SET username = ?, email = ? ,password = ? WHERE id = ?');
            $updateUser->execute(array($username_saisi, $email_saisi, $password_saisi, $getid));
            header('Location: membres.php');
        }
    } else {
        echo "Aucun membre trouvé";
    }
} else {
    echo "Aucun id trouvé";
}
?>
<!DOCTYPE html>
<html>

<head>

    <title>Modifier un utilisateur</title>
    <meta charset="utf-8">


</head>

<body>
<a href="general.php">Home</a>
    <form method="POST" action="" enctype="multipart/form-data">

        <input type="text" name="username" value="<?= $username; ?>">
        <br>
        <input type="email" name="email" value="<?= $email; ?>">
        <br>
        <input type="text" name="password" value="<?= $userInfos['password']; ?>">
        <br>

        <br><br>
        <input type="submit" name="valider">
    </form>
    <br>
    

</body>

</html>