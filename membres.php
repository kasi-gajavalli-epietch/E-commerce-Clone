<?php
session_start();
$bdd = new PDO('mysql:host=127.0.0.1;dbname=my_shop;', 'root', '');
if (!$_SESSION['mdp']) {

    header('Location: connexion.php');
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Afficher les membres</title>
    <meta charset="utf-8">


</head>

<body>
    <?php
    $recupUsers = $bdd->query('SELECT * FROM users');
    while ($user = $recupUsers->fetch()) {
    ?>
        <div class="article" style="border: 1px solid black" ;>
            <table>
                <tr>
                    <th scope="row">Username
                        <br>
                        <p><?= $user['username']; ?>
                    </th>
                    <br>
                    <th scope="row">Email
                        <br>
                        <?= $user['email']; ?>
                    </th>
                    <br>
                    <th scope="row">Password
                        <br>
                        <?= $user['password']; ?>
                    </th>
                    <br>
                    <th scope="row">Role
                    <fieldset>


                        <div>
                            <input type="checkbox" id="admin" name="admin" checked>
                            <label for="admin">Admin</label>
                        </div>

                        <div>
                            <input type="checkbox" id="admin" name="admin">
                            <label for="admin">Users</label>
                        </div>
                    </fieldset>
                    </th>
                    <br>
                    <th scope="row">Supprimer
                        <a href="bannir.php?id=<?= $user['id']; ?>"><br>
                            <button style="color:white; background-color:red; margin-bottom: 10px">Bannir le membre</button>
                        </a></p>
                    </th><br>
                    <th scope="row">Modifier
                        <a href="modifier-membre.php?id=<?= $article['id']; ?>"><br>
                            <button style="color:black; background-color:yellow; margin-bottom: 10px">Modifier l'utilisateur</button>
                        </a>
                    </th>
                </tr>
            </table>
        </div>
    <?php

    }
    ?>
</body>

</html>