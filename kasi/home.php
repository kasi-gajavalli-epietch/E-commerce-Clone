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
   <title>Home</title>

    <!-- custom css file link  -->
    <link rel="stylesheet" href="style_signin.css">

</head>
<body>
   
<div class="container">

   <div class="profile">
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
      <h3><?php echo $fetch['username']; ?></h3>
      <a href="update_profile.php" class="btn">Update Profile</a>
      <a href="home.php?logout=<?php echo $user_id; ?>" class="delete-btn">Logout</a>
      <p>New <a href="signin.php">Login</a> OR <a href="signup.php">Sign Up</a></p>
   </div>

</div>

</body>
</html>