<?php
$conn = mysqli_connect('localhost','root','admin123','my_shop') or die('connection failed');
if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;

   $select = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email' AND password = '$pass'") or die('query select failed');

   if(mysqli_num_rows($select) > 0){
      $message[] = 'User Already Exists'; 
   }else{
      if($pass != $cpass){
         $message[] = 'Passwords do not match!';
      }elseif($image_size > 2000000){
         $message[] = 'Image Size Too Large!';
      }else{
         $insert = mysqli_query($conn, "INSERT INTO users (`username`, `email`, `password`, `image`) VALUES ('$name', '$email', '$pass',  '$image')") or die('query insert failed');

         if($insert){
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'Registered Successfully!';
            header('location:signin.php');
         }else{
            $message[] = 'Registeration Failed!';
         }
      }
   }

}


?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>
   <!-- custom css file link  -->
   <link rel="stylesheet" href="style_signin.css">
</head>
<body>
<div class="form-container">

   <form action="" method="post" enctype="multipart/form-data">
      <h3>Sign Up</h3>
      <?php
      if(isset($message)){
         foreach($message as $message){
            echo '<div class="message">'.$message.'</div>';
         }
      }
      ?>
      <input type="text" name="name" placeholder="Enter Username" class="box" required>
      <input type="email" name="email" placeholder="Enter Email" class="box" required>
      <input type="password" name="password" placeholder="Enter Password" class="box" required>
      <input type="password" name="cpassword" placeholder="Confirm Password" class="box" required>
      <input type="file" name="image" class="box" placeholder="*.jpg, .png, .jpeg formats only" accept="image/jpg, image/jpeg, image/png">
      <!--<input type="user_type" name="utype" placeholder="User Type" class="box" required>-->
      <input type="submit" name="submit" value="Register" class="btn">
      <p>Already a user? <a href="signin.php">Login</a></p>
   </form>

</div>

</body>
</html>