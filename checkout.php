<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){
    $status = 'complete';
    $name = $_POST['fname'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $method = $_POST['method'];
    $method = filter_var($method, FILTER_SANITIZE_STRING);
    $address = $_POST['street'] .', '.$_POST['street2'] .', '. $_POST['city'] .', '. $_POST['state'] .', '. $_POST['country'] .' - '. $_POST['zip'];
    $address = filter_var($address, FILTER_SANITIZE_STRING);
    $total_products = $_POST['total_products'];
    $total_price = $_POST['total_price'];
 
    $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $check_cart->execute([$user_id]);
 
    if($check_cart->rowCount() > 0){
 
       $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
       $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

       $update_status = $conn->prepare("UPDATE `cart` SET status = ? WHERE user_id = ? AND cart.status = 'pending'");
       $update_status->execute([$status, $user_id]);
 
       $message[] = 'Order placed successfully!';
    }else{
       $message[] = 'Your cart is empty';
    }
 
}

?>
<!doctype html>
<html class="no-js" lang="en">

    <head>
        <!-- meta data -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- title of site -->
        <title>Real Deals</title>
        <link rel="stylesheet" href="style.css">

        <?php include 'components/css.php'; ?>

    </head>
	
	<body>
	
		<!--welcome-hero start -->
		<section id="home" class="welcome-hero">
			<!-- top-area Start -->
            <?php include 'components/header.php'; ?>
			<!-- top-area End -->
		</section><!--/.welcome-hero-->
		<!--welcome-hero end -->

		<!--featured-cars start -->
        <section class="checkout" id="checkout">
        <div class="checkout-container">
            <h2>Checkout</h2>
            <form action="" method="post">
            <div class="checkout-content">
                    <div class="checkout-form">
                        <table>
                            <tr class="checkout-form-input">
                                <td><p>Full Name</p></td>
                                <td><input type="text" name="fname" required></td>
                            </tr>
                            <tr class="checkout-form-input">
                                <td><p>Email Address</p></td>
                                <td><input type="email" name="email" required></td>
                            </tr>
                            <tr class="checkout-form-input">
                                <td><p>Contact Number</p></td>
                                <td><input type="number" name="number" maxlength="11" placeholder="09123456789" required></td>
                            </tr>
                            <tr class="checkout-form-input">
                                <td><p>Company Name (optional)</p></td>
                                <td><input type="text" name="company"></td>
                            </tr>
                            <tr class="checkout-form-input">
                                <td><p>Street Address</p></td>
                                <td><input type="text" name="street" placeholder="House number and street name" required></td>
                            </tr>
                            <tr class="checkout-form-input">
                                <td><p>Street Address 2 (optional)</p></td>
                                <td><input type="text" name="street2" placeholder="Appartment, Suite, Unit no., etc."></td>
                            </tr>
                            <tr class="checkout-form-input">
                                <td><p>Town / City</p></td>
                                <td><input type="text" name="city" required></td>
                            </tr>
                            <tr class="checkout-form-input">
                                <td><p>State</p></td>
                                <td><input type="text" name="state" required></td>
                            </tr>
                            <tr class="checkout-form-input">
                                <td><p>Country</p></td>
                                <td><input type="text" name="country" required></td>
                            </tr>
                            <tr class="checkout-form-input">
                                <td><p>Postcode / ZIP</p></td>
                                <td><input type="number" name="zip" required></td>
                            </tr>
                        </table>
                    </div>
                    <div class="checkout-payment">
                        <div class="checkout-payment-list">
                            <h3>Your order</h3>
                            <p>4 Items</p>
                        </div>
                        <div class="checkout-payment-list">
                            <p style="max-width:250px; overflow:hidden; white-space:nowrap; text-overflow:ellipsis;">Logitech G Pro X Logitech G Pro X Logitech G Pro X</p>
                            <p>$123</p>
                        </div>
                        <div class="checkout-payment-list">
                            <p>Subtotal</p>
                            <p>$123</p>
                        </div>
                        <div class="checkout-payment-list">
                            <p>Shipping Fee</p>
                            <p>$123</p>
                        </div>
                        <div class="checkout-payment-list">
                            <p>Total Payment</p>
                            <p>$123</p>
                        </div>
                        <div class="checkout-payment-mop">
                            <p>Mode of Payment: </p>
                            <p><input type="radio" name="mop" value="gcash" checked> GCash</p>
                            <p><input type="radio" name="mop" value="cod"> Cash on Delivery</p>
                            <p><input type="radio" name="mop" value="card"> Debit / Credit Card</p>
                        </div>
                        <br>
                        <div class="checkout-payment-btn">
                            <input type="submit" value="Place order" name="submit">
                            <a href="shop.php">Back to shop</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
		<!--featured-cars end -->

		<!--blog start -->
		<section id="blog" class="blog"></section><!--/.blog-->
		<!--blog end -->

		<!--contact start-->
        <?php include 'components/footer.php'; ?>
		<!--contact end-->

        <?php include 'components/scripts.php'; ?>
        
    </body>
	
</html>