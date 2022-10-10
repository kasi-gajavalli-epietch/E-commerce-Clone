<?php
session_start();
if (isset($_POST['valider'])) {
    if (!empty($_POST['pseudo']) and !empty($_POST['mdp'])) {
        $pseudo_par_defaut = "admin";
        $mdp_par_defaut = "admin1234";
        $pseudo_saisi = htmlspecialchars($_POST['pseudo']);
        $mdp_saisi = htmlspecialchars($_POST['mdp']);
        if ($pseudo_saisi == $pseudo_par_defaut and $mdp_saisi == $mdp_par_defaut) {
            $_SESSION['mdp'] = $mdp_saisi;
            header("Location: general.php");
            } else {
            echo "Votre mot de passe ou pseudo est incorrect";
        }
    } else {
        echo "Veuillez compléter tous les champs..";
    }
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Espace de connexion admin</title>
    <meta charset="utf-8">
    <link rel='stylesheet' type='text/css' media='screen' href='admin.css'>

</head>

<body>
    <div class="admin_login">
        <h1> Admin login </h1>
    <form method="POST" action="" align="center">
        <input type="text" name="pseudo" placeholder="USERNAME" autocomplete="off">
        <br>
        <input type="password" name="mdp" placeholder="PASSWORD">
        <br><br>
        <input class="submit" type="submit" name="valider">
    </form>

    </div>
    
</body>

</html>