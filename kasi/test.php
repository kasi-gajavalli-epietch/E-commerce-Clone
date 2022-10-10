<?php
$conn = mysqli_connect('localhost','root','admin123','my_shop') or die('connection failed');
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' type='text/css' media='screen' href='test.css'>
    <title>test</title>
</head>
<body>

<div class="right">
    <ul>
        <li>
            <?php
                $select = mysqli_query($conn, "SELECT * FROM `users` WHERE `id` = '$user_id'") or die('query select \home failed');
                if(mysqli_num_rows($select) > 0){
                    $fetch = mysqli_fetch_assoc($select);
                }
                if($fetch['image'] == ''){
                    echo '<img src="images/default-avatar.png">';
                }else{
                    echo '<img src="uploaded_img/'.$fetch['image'].'">';
                }
            ?>
            <i class="fas fa-angle-down"></i>
                     
            <div class="dropdown">
                <ul>
                    <li><a href="update_profile.php"><i class="fas fa-user"></i> Profile</a></li>
                    <li><a href="#"><i class="fas fa-sliders-h"></i> Settings</a></li>
                    <li><a href="admin_login.php"><i class="fas fa-sign-out-alt"></i> Admin Login</a></li>
                    <li><a href="#"><i class="fas fa-sign-out-alt"></i> Signout</a></li>
                </ul>
            </div>
                    
        </li>
    </ul>
</div>
        
    <script>
        document.querySelector(".right ul li").addEventListener("click", function(){
            this.classList.toggle("active");
        });
    </script>
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>

</body>
</html>
<div class="profile-image">
                            <?php
                                $select = mysqli_query($conn, "SELECT * FROM `users` WHERE `id` = '$user_id'") or die('query select \home failed');
                                if(mysqli_num_rows($select) > 0){
                                $fetch = mysqli_fetch_assoc($select);
                                }
                                if($fetch['image'] == ''){
                                    echo '<img src="images/default-avatar.png">';
                                }else{
                                    echo '<img src="uploaded_img/'.$fetch['image'].'">';
                                }
                                    
                            ?>
                            <i class="fas fa-angle-down"></i>
                            <div class="dropdown">
                                <ul>
                                    <li><a href="#"><i class="fas fa-user"></i> Profile</a></li>
                                    <li><a href="#"><i class="fas fa-sliders-h"></i> Settings</a></li>
                                    <li><a href="#"><i class="fas fa-sign-out-alt"></i> Signout</a></li>
                                </ul>
                            </div>
                        </div>
