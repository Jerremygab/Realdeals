<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:login.php');
}

if(isset($_POST['delete'])){
    $cart_id = $_POST['cart_id'];
    $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
    $delete_cart_item->execute([$cart_id]);
}

if(isset($_POST['update_qty_plus'])){
    $cart_id = $_POST['cart_id'];
    $update_qty = $conn->prepare("UPDATE `cart` SET quantity = quantity + 1 WHERE id = ?");
    $update_qty->execute([$cart_id]);
    $message[] = 'Quantity Updated';
}
if(isset($_POST['update_qty_minus'])){
    $cart_id = $_POST['cart_id'];
    $update_qty = $conn->prepare("UPDATE `cart` SET quantity - 1 WHERE id = ?");
    $update_qty->execute([$cart_id]);
    $message[] = 'Quantity Updated';
}

// if (isset($_POST['checkout'])) {
//     $user_id = $_POST['user_id'];
//     $user_name = $_POST['user_name'];
//     $no_of_items = $_POST['no_of_items'];
//     $ship_total = floatval($_POST['ship_total_input']);
//     $grand_total = floatval($_POST['grand_total_input']);
//     $final_total = floatval($_POST['final_total_input']);

//     $insert_order = $conn->prepare("INSERT INTO `payment`(user_id, user_name, no_of_items, shipping_fee, sub_total, total_price) VALUES(?,?,?,?,?,?)");
//     $insert_order->execute([$user_id, $user_name, $no_of_items, $ship_total, $grand_total, $final_total]);

//     $update_status = $conn->prepare("UPDATE `cart` SET status = ? WHERE user_id = ?");
//     $update_status->execute([$status, $user_id]);
//     // Redirect or display a success message
//     $message[] = 'Order Placed';
//     exit;
//  }

// Initialize totals
// $ship_total = 1;
// $grand_total = 0;

// // Calculate grand total
// $select_cart = $conn->prepare("SELECT cart.id AS cart_id, products2.id AS product_id, cart.*, products2.* FROM cart LEFT JOIN products2 ON products2.id = cart.product_id WHERE cart.user_id = ? AND cart.status = ''");
// $select_cart->execute([$user_id]);

// if($select_cart->rowCount() > 0){
//     while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
//         $sub_total = $fetch_cart['price'] * $fetch_cart['quantity'];
//         $grand_total += $sub_total;
//     }
// }

// Handle AJAX request to update the ship total
// if (isset($_GET['selected'])) {
//     $selected_value = intval($_GET['selected']);

//     // Determine ship_total based on selected option
//     if ($selected_value == 1) {
//         $ship_total = 5;
//     } elseif ($selected_value == 2) {
//         $ship_total = 3;
//     } elseif ($selected_value == 3) {
//         $ship_total = 1;
//     } else {
//         $ship_total = 0;
//     }

//     // Calculate final total
//     $final_total = $grand_total + $ship_total;

//     // Return JSON response
//     echo json_encode([
//         'ship_total' => $ship_total,
//         'final_total' => $final_total
//     ]);
//     exit;
// }
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <!-- meta data -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <!-- title of site -->
    <title>Real Deals</title>

    <?php include 'components/css.php'; ?>
    <link rel="stylesheet" href="style.css">
    <!-- <script>
    function updateShipTotal(selectedValue) {
        console.log("Selected Value: " + selectedValue);
        const xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log("Response: " + xhr.responseText);
                // Parse the JSON response
                const response = JSON.parse(xhr.responseText);
                
                // Update the totals on the page
                document.getElementById("ship_total").innerText = response.ship_total;
                document.getElementById("final_total_display").innerText = response.final_total;

                // Update hidden inputs
                document.getElementById("ship_total_input").value = response.ship_total;
                document.getElementById("final_total_input").value = response.final_total;
            }
        };

        // Send the request to the same PHP file
        xhr.open("GET", "?selected=" + selectedValue, true);
        xhr.send();
    }
    </script> -->

</head>

<body>
    <!--welcome-hero start -->
    <section id="home" class="welcome-hero">
        <!-- top-area Start -->
        <?php include 'components/header.php'; ?>
        <!-- top-area End -->
    </section><!--/.welcome-hero-->
    <!--welcome-hero end -->
        <?php
            $count_cart_items = $conn->prepare("SELECT * FROM `cart` LEFT JOIN users ON cart.user_id = users.id WHERE user_id = ? AND cart.status = ''");
            $count_cart_items->execute([$user_id]);
            $total_cart_counts = $count_cart_items->rowCount();
        ?>
    <section class="cart-section" id="cart-section">
    <div class="card-section">
        <div class="row">
            <div class="col-md-8 carts">
                <div class="title">
                    <div class="row">
                        <div class="col"><h4><b>Shopping Cart</b></h4></div>
                        <div class="col align-self-center text-right text-muted"><?= $total_cart_counts; ?> items</div>
                    </div>
                </div>    
                <div class="row">
                    <?php
                        $grand_total = 0;
                        $select_cart = $conn->prepare("SELECT cart.id AS cart_id, products2.id AS product_id, cart.*, products2.*, users.* FROM cart LEFT JOIN products2 ON products2.id = cart.product_id LEFT JOIN users ON cart.user_id = users.id WHERE cart.user_id = ? AND cart.status = ''");
                        $select_cart->execute([$user_id]);
                        if($select_cart->rowCount() > 0){
                            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
                                // $sub_total = $fetch_cart['price'] * $fetch_cart['quantity'];
                    ?>
                    <form action="" method="post" style="width: 100%;">
                    <input type="hidden" name="cart_id" value="<?= $fetch_cart['cart_id']; ?>">
                    <div class="row main align-items-center border-bottom">
                        <div class="col-2"><img class="img-fluid" src="assets/images/products/<?= $fetch_cart['image']; ?>"></div>
                        <div class="col">
                            <div class="row text-muted" style="font-size: 10px;"><?= $fetch_cart['brand']; ?> / <?= $fetch_cart['category']; ?> / <?= $fetch_cart['type']; ?> / <?= $fetch_cart['color']; ?></div>
                            <div class="row"><?= $fetch_cart['product_name']; ?></div>
                        </div>
                        <div class="col" style="display: flex; justify-content: center; gap: 1rem; max-width: 140px;">
                            <button type="submit" class="fas fa-minus btn-icon" name="update_qty_minus" <?= ($fetch_cart['quantity'] > 1)?'':'disabled'; ?>></button><a href="#" class="border"><?= $fetch_cart['quantity']; ?></a><button type="submit" class="fas fa-plus btn-icon" name="update_qty_plus"></button>
                        </div>
                        <div class="col" style="max-width: 100px;">$<?= $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?></div>
                        <div class="col" style="max-width: 20px;"><span class="close"><button type="submit" class="fas fa-trash btn-icon" name="delete" onclick="return confirm('delete this from cart?');"></button></span></div>
                    </div>
                    <?php
                    $grand_total += $sub_total;
                        }
                    } else {
                        echo '<p class="empty">Your cart is empty</p>';
                    }
                    ?>
                    </form>
                </div>
                <div class="back-to-shop"><a href="shop.php">&leftarrow;</a><span class="text-muted">Back to shop</span></div>
            </div>
            <div class="col-md-4 summary">
                <div><h5><b>Summary</b></h5></div>
                <hr>
                <div class="row">
                    <div class="col" style="padding-left:0;">ITEMS <?= $total_cart_counts; ?></div>
                    <div class="col text-right">$<?= $grand_total; ?></div>
                </div>
                <p>Voucher Code</p>
                <input placeholder="Enter your code" style="margin-bottom: 2rem; border: 1px solid #aaa; padding: 0.5rem;">
                <div class="row" style="border-top: 1px solid rgba(0,0,0,.1); padding: 2vh 0;">
                    <div class="col" style="padding: 0;">TOTAL PRICE</div>
                    <div class="col text-right">$<?= $grand_total; ?></div>
                </div>
                <form action="checkout.php" method="post">
                    <button type="submit" name="checkout" class="btn" <?= ($grand_total > 1)?'':'disabled'; ?>>Checkout</button>
                </form>
            </div>
        </div>
    </div>
    </section>
    <?php

    ?>
    <!--blog start -->
    <section id="blog" class="blog"></section><!--/.blog-->
    <!--blog end -->

    <!--contact start-->
    <?php include 'components/footer.php'; ?>
    <!--contact end-->

    <?php include 'components/scripts.php'; ?>
</body>

</html>