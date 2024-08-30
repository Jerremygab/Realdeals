<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['send_msg'])){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $msg = $_POST['msg'];
    $msg = filter_var($msg, FILTER_SANITIZE_STRING);
 
    $select_message = $conn->prepare("SELECT * FROM `messages` WHERE name = ? AND email = ? AND number = ? AND message = ?");
    $select_message->execute([$name, $email, $number, $msg]);
 
    if($select_message->rowCount() > 0){
       $message[] = 'Already sent message!';
    }else{
 
       $insert_message = $conn->prepare("INSERT INTO `messages`(user_id, name, email, number, message) VALUES(?,?,?,?,?)");
       $insert_message->execute([$user_id, $name, $email, $number, $msg]);
 
       $message[] = 'Sent message successfully!';
 
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
                <div class="login-content" style="align-items: center;">
                    <div class="login-form">
                        <h2>Get in touch</h2>
                        <form action="" method="post" >
                            <div class="form-input">
                                <p style="font-size: 16px;color:#000;">Name</p>
                                <input type="text" name="name" required maxlength="20" style="border:1px solid #aaa;" oninput="this.value = this.value.replace(/\s/g, '')">
                            </div>
                            <div class="form-input">
                                <p style="font-size: 16px;color:#000;">Email</p>
                                <input type="email" name="email" required maxlength="50" style="border:1px solid #aaa;" oninput="this.value = this.value.replace(/\s/g, '')">
                            </div>
                            <div class="form-input">
                                <p style="font-size: 16px;color:#000;">Number</p>
                                <input type="number" name="number" required maxlength="20" style="width:100%; border:1px solid #aaa;" oninput="this.value = this.value.replace(/\s/g, '')">
                            </div>
                            <div class="form-input">
                                <p style="font-size: 16px;color:#000;">Message</p>
                                <textarea name="msg" id="" cols="30" rows="5" style="width:100%; border:1px solid #aaa;"></textarea>
                                <!-- <input type="text" name="name" required  oninput="this.value = this.value.replace(/\s/g, '')"> -->
                            </div>
                            <div class="form-input">
                                <p></p>
                                <input type="submit" value="Send" style="padding: .6rem 0;" name="send_msg">
                            </div>
                        </form>
                    </div>
                    <hr style="color: #4e4ffa;border: 1px #4e4ffa solid;height: 50%;">
                    <div class="login-header" style="gap: 2rem;">
                        <div class="info">
                            <i class="fa-solid fa-location-dot"></i>
                            <h4>Location</h4>
                            <p style="font-size: 16px;color:#000;">123, Abc st. Lorem City, Ipsum</p>
                        </div>
                        <div class="info">
                            <i class="fa-solid fa-envelope"></i>
                            <h4>Email</h4>
                            <p style="font-size: 16px;color:#000;">info@realdeals.com</p>
                        </div>
                        <div class="info">
                            <i class="fa-solid fa-phone"></i>
                            <h4>Phone</h4>
                            <p style="font-size: 16px;color:#000;">(+123) 456 789</p>
                        </div>
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