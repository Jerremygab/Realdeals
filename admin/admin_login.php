<?php

include '../components/connect.php';

session_start();

if(isset($_POST['submit'])){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
 
    $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE name = ? AND password = ?");
    $select_admin->execute([$name, $pass]);
    $row = $select_admin->fetch(PDO::FETCH_ASSOC);
 
    if($select_admin->rowCount() > 0){
       $_SESSION['admin_id'] = $row['id'];
       header('location:admin.php');
    }else{
       $message[] = 'incorrect username or password!';
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
   
   <?php include '../components/css.php'; ?>

</head>
<body>
<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
?>


        <section class="login" id="login">
            <div class="login-container">
                <div class="login-content">
					<div class="login-header">
                        <img src="assets/logo/realdeals.jpg" alt="">
                    </div>
                    <div class="login-form">
                        <h2>Admin Login</h2>
                        <form action="" method="post">
                            <div class="form-input">
                                <i class="fa-solid fa-user icons"></i>
                                <input type="text" name="name" required placeholder="enter your username" maxlength="50"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
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



<script src="../assets/js/script.js"></script>


</body>
</html>