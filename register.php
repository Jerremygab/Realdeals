<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['signup'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select_user->execute([$email,]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if($select_user->rowCount() > 0){
      $message[] = 'Email already exists!';
   }else{
      if($pass != $cpass){
         $message[] = 'Confirm password not matched!';
      }else{
         $insert_user = $conn->prepare("INSERT INTO `users`(user_name, email, password) VALUES(?,?,?)");
         $insert_user->execute([$name, $email, $cpass]);
         $message[] = 'Registered successfully, Login now please!';
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
   <title>Real deals</title>
   
   <?php include 'components/css.php'; ?>

</head>
<body>
   
<?php include 'components/header.php'; ?>

        <section class="login" id="register">
            <div class="login-container">
                <div class="login-content">
                    <div class="login-form">
                        <h2>Sign Up</h2>
                        <form action="" method="post" >
                            <div class="form-input">
                                <i class="fa-solid fa-user icons"></i>
                                <input type="text" name="name" required placeholder="enter your username" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
                            </div>
                            <div class="form-input">
                                <i class="fa-solid fa-envelope icons"></i>
                                <input type="email" name="email" required placeholder="enter your email" maxlength="50"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
                            </div>
                            <div class="form-input">
                                <i class="fa-solid fa-lock icons"></i>
                                <input type="password" name="pass" required placeholder="enter your password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
                            </div>
                            <div class="form-input">
                                <i class="fa-solid fa-user-lock icons"></i>
                                <input type="password" name="cpass" required placeholder="confirm your password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
                            </div>
                            <div class="form-input">
                                <input type="checkbox" name="check" >
                                <p> I agree all statements in Terms of service</p>
                            </div>
                            <div class="form-input" style="width: fit-content;">
                                <input type="submit" id="signup" value="Sign up" name="signup">
                            </div>
                        </form>
                    </div>
                    <div class="login-header">
                        <img src="assets/logo/realdeals.jpg" alt="">
                        <a href="login.php">I have already an account</a>
                    </div>
                </div>
            </div>
        </section>

		<!--blog start -->
		<section id="blog" class="blog"></section><!--/.blog-->
		<!--blog end -->


<?php include 'components/footer.php'; ?>
<?php include 'components/scripts.php'; ?>

<script src="assets/js/script.js"></script>


</body>
</html>