<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['place_order'])){
    $status = 'Y';
    $name = $_POST['fname'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $mop = $_POST['mop'];
    $mop = filter_var($mop, FILTER_SANITIZE_STRING);
    $address = $_POST['street'] .', '.$_POST['street2'] .', '. $_POST['city'] .', '. $_POST['state'] .', '. $_POST['country'] .' - '. $_POST['zip'];
    $address = filter_var($address, FILTER_SANITIZE_STRING);
    $products = $_POST['total_products'];
    $cart_id = $_POST['cart_id'];
    $total_price = $_POST['grandtotal'];
    $total_price = filter_var($total_price, FILTER_SANITIZE_STRING);
 
    $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $check_cart->execute([$user_id]);
 
    if($check_cart->rowCount() > 0){
 
    //    $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
    //    $insert_order->execute([$user_id, $name, $number, $email, $mop, $address, $products, $total_price]);
       $insert_order = $conn->prepare("INSERT INTO `orders`(cart_id, user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?,?)");
       $insert_order->execute([$cart_id,$user_id, $name, $number, $email, $mop, $address, $products, $total_price]);

       $update_status = $conn->prepare("UPDATE `cart` SET status = ? WHERE user_id = ? AND cart.status = ''");
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
                                <td><input type="number" name="number" placeholder="09123456789" required></td>
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
                            <p>Items</p>
                        </div>
                        <div class="checkout-payment-items">
                            <?php
                                $grand_total = 0;
                                $cart_id = []; 
                                $cart_items = [];
                                $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND status = ''");
                                $select_cart->execute([$user_id]);  
                                if ($select_cart->rowCount() > 0) {
                                    while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                                        $cart_id[] = $fetch_cart['id'];
                                        $cart_items[] = $fetch_cart['product_name'] . ' (' . $fetch_cart['price'] . ' x ' . $fetch_cart['quantity'] . ') - ';
                                        $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
                                ?>
                                <div class="checkout-payment-list">
                                    <p style="max-width:300px; width:300px;overflow:hidden; white-space:nowrap; text-overflow:ellipsis;">
                                        <?= $fetch_cart['product_name']; ?>
                                        <span>(<?= 'x' . $fetch_cart['quantity']; ?>)</span>
                                    </p>
                                    <p>$<?= $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?></p>
                                </div>
                                <?php
                                    }
                                    $cart_ids = implode(',', $cart_id); 
                                    $total_products = implode('', $cart_items);

                                } else {
                                    echo '<p class="empty">your cart is empty!</p>';
                                }
                                ?>
                        </div>
                        <div class="checkout-payment-list">
                        <input type="hidden" name="total_products" value="<?= $total_products; ?>">
                        <input type="hidden" name="cart_id" value="<?= $cart_ids; ?>">
                        <input type="hidden" name="grandtotal" value="<?= $grand_total; ?>">
                        </div>
                        <div class="checkout-payment-list">
                            <input type="hidden" value="" name="subtotal">
                            <p>Subtotal</p>
                            <p>$<?= $grand_total; ?></p>
                        </div>
                        <div class="checkout-payment-list">
                            <input type="hidden" value="" name="shippingfee">
                            <p>Voucher Discount</p>
                            <p>$0</p>
                        </div>
                        <div class="checkout-payment-list">
                            <input type="hidden" value="" name="total_price">
                            <p>Total Payment</p>
                            <p>$<?= $grand_total; ?></p>
                        </div>
                        <div class="checkout-payment-mop">
                            <p>Mode of Payment: </p>
                            <select name="mop" required>
                                <option value="Cash on delivery">Cash on Delivery</option>
                                <option value="Credit card">Credit Card</option>
                                <option value="Paypal">PayPal</option>
                            </select>
                        </div>
                        <br>
                        <div class="checkout-payment-btn">
                            <input type="submit" value="Place order" name="place_order">
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