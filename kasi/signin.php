<?php
$conn = mysqli_connect('localhost','root','admin123','my_shop') or die('connection failed');
session_start();
if (isset($_POST['submit'])) {

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $remember = mysqli_real_escape_string($conn, $_POST['remember']);
   if ($remember == 1) {
      setcookie('uemail', $email, time() + 6060, "/");
      setcookie('upassword', $pass, time() + 6060, "/");
   }

   $select = mysqli_query($conn, "SELECT * FROM `users` WHERE `email` = '$email' AND `password` = '$pass'") or die('query failed');

   if (mysqli_num_rows($select) > 0) {
      $row = mysqli_fetch_assoc($select);
      $_SESSION['user_id'] = $row['id'];
      //header('location:home.php');
      header('location:index-login.php');
   } else {
      $message[] = 'incorrect email or password!';
   }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Sign In</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="style_signin.css">

</head>

<body>

   <div class="form-container">

      <form action="" method="post" enctype="multipart/form-data">
         <h3>Sign In</h3>
         <?php
         if (isset($message)) {
            foreach ($message as $message) {
               echo '<div class="message">' . $message . '</div>';
            }
         }
         ?>
         <input type="email" name="email" placeholder="Enter Email" class="box" value="<?php if (isset($_cookie['uemail'])) echo $_COOKIE['uemail']; ?>" required>
         <input type="password" name="password" placeholder="Enter Password" class="box" value="<?php if (isset($_cookie['upassword'])) echo $_COOKIE['upassword']; ?>" required>
         <div class="form-check">
            <label class="form-check-label text-muted">
               <input type="checkbox" name="remember" value="1" class="form-check-input">
               Keep me signed in
            </label>
         </div>
         <input type="submit" name="submit" value="Login" class="btn">
         <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
      </form>

   </div>

</body>

</html>