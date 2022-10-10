<?php


$bdd = new PDO('mysql:host=127.0.0.1;dbname=my_shop;', 'root', '');
if(isset($_GET['id'])AND !empty($_GET['id'])){
    $getid = $_GET['id'];
    $recupUser = $bdd->prepare('SELECT * FROM users WHERE id = ?');
    $recupUser->execute(array($getid));
    if($recupUser->rowCount() > 0) {
        $userInfos = $recupUser->fetch();
        $username = $userInfos['username'];
        $email = $userInfos['email'];
        $password = $userInfos['password'];
        $admin = $userInfos['admin'];
        if(isset($_POST['valider'])) {
            $username_saisi = htmlspecialchars($_POST['username']);
            $email_saisi = nl2br(htmlspecialchars($_POST['email']));
            $password_saisi = nl2br(htmlspecialchars($_POST['password']));
            $admin_saisi = nl2br(htmlspecialchars($_POST['admin']));

            $updateUser = $bdd->prepare('UPDATE users SET username = ?, email = ? ,password = ?, admin = ? WHERE id = ?');
            $updateUser->execute(array($username_saisi, $email_saisi,$password_saisi,$admin_saisi, $getid));
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
<table>
                <tr>
                    <th scope="row">Username
                        <br>
                        <p><?= $username_saisi['username']; ?>
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
    <form method="POST" action="" >
        
        <input type="text" name="username" value="<?= $username; ?>" >
        <br>
        <input type="email" name="email" value="<?= $email; ?>" >
        <br>
        <input type="text" name="password" value="<?= $userInfos['password']; ?>" >
        <br>
        <input type="checkbox" name="admin" value="<?= $userInfos['admin']; ?>" >
        <br><br>
        <input type="submit" name="valider">
    </form>
    <br>
    <form method="POST" action="" enctype="multipart/form-data" >
        <input type="text" name="username" value="<?= $updateUser[$username_saisi]; ?>" >
        <br>
        <textarea name="email" >
        <?= $email; ?>
        </textarea>
        <br>
        <textarea name="password" placeholder="Description du produit"></textarea>
        <br>
        
        <br><br>
        <input type="submit" name="valider">
    </form>
    
</body>

</html>