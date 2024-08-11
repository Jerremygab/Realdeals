<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
 
    $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
    $select_user->execute([$email, $pass]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);
 
    if($select_user->rowCount() > 0){
       $_SESSION['user_id'] = $row['id'];
       header('location:index.php');
    }else{
       $message[] = 'Incorrect username or password!';
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

        <section class="login" id="login">
            <div class="login-container">
                <div class="login-content">
					<div class="login-header">
                        <img src="assets/logo/realdeals.jpg" alt="">
                        <a href="register.php">Create an account</a>
                    </div>
                    <div class="login-form">
                        <h2>Login</h2>
                        <form action="" method="post">
                            <div class="form-input">
                                <i class="fa-solid fa-user icons"></i>
                                <input type="email" name="email" required placeholder="enter your email" maxlength="50"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
                            </div>
                            <div class="form-input">
                                <i class="fa-solid fa-lock icons"></i>
                                <input type="password" name="pass" required placeholder="enter your password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
                            </div>
                            <div class="form-input">
                                <input type="checkbox" name="check">
                                <p> Remember me</p>
                            </div>
                            <div class="form-input" style="width: fit-content;">
                                <a href="index.php"><input type="submit" id="signin" value="Sign in" name="submit"></a>
                            </div>
                        </form>
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