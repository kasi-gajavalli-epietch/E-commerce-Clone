<?php
session_start();
$bdd = new PDO('mysql:host=127.0.0.1;dbname=my_shop;', 'root', '');
if (!$_SESSION['mdp']) {

    header('Location: admin_login.php');
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Afficher les membres</title>
    <meta charset="utf-8">
    <link rel='stylesheet' type='text/css' media='screen' href='admin.css'>



</head>

<body>

    <?php
    $recupUsers = $bdd->query('SELECT * FROM users');
    while ($user = $recupUsers->fetch()) {
    ?>
    
        <div class="member-grand">
            <div class="member" style="border: 1px solid black" ;>
                <div>
                    <p>Username:<b class="value"> <?= $user['username']; ?></b></p>
                </div>

                <div>
                    <p>Email:<b class="value"><?= $user['email']; ?></br></p>
                </div>

                <!--<div>
                    <p>Password: </p><b class="value"> <?= $user['password']; ?></b>
                </div>-->
                <div class=button-grand>
                    <div>
                        <a href="bannir.php?id=<?= $user['id']; ?>"><br>
                            <button class="supprimer">Bannir le membre</button>
                        </a></p>
                    </div>
                    <div>
                        <a href="modifier-membre.php?id=<?= $user['id']; ?>"><br>
                            <button class="modifier">Modifier l'utilisateur</button>
                        </a>

                    </div>
                </div>


            </div>

        <?php

    }
        ?>
        <a href="general.php">Home</a>
        </div>
</body>

</html>