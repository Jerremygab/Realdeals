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

if(isset($_POST['update_qty'])){
    $cart_id = $_POST['cart_id'];
    $qty = $_POST['qty'];
    $qty = filter_var($qty, FILTER_SANITIZE_STRING);
    $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
    $update_qty->execute([$qty, $cart_id]);
    $message[] = 'Quantity Updated';
}
if (isset($_POST['submit'])) {
    $status = 'pending';
    $user_id = $_POST['user_id'];
    $user_name = $_POST['user_name'];
    $no_of_items = $_POST['no_of_items'];
    $ship_total = floatval($_POST['ship_total_input']);
    $grand_total = floatval($_POST['grand_total_input']);
    $final_total = floatval($_POST['final_total_input']);

    $insert_order = $conn->prepare("INSERT INTO `payment`(user_id, user_name, no_of_items, shipping_fee, sub_total, total_price) VALUES(?,?,?,?,?,?)");
    $insert_order->execute([$user_id, $user_name, $no_of_items, $ship_total, $grand_total, $final_total]);

    $update_status = $conn->prepare("UPDATE `cart` SET status = ? WHERE user_id = ? AND cart.status = ''");
    $update_status->execute([$status, $user_id]);
    // Redirect or display a success message
    header('location:index.php');
    exit;
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

    <?php include 'components/css.php'; ?>
    <link rel="stylesheet" href="style.css">

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
            $count_cart_items = $conn->prepare("SELECT * FROM `cart` 
                                                LEFT JOIN users ON cart.user_id = users.id 
                                                WHERE user_id = ? AND cart.status = 'completed'");
            $count_cart_items->execute([$user_id]);
            $total_cart_counts = $count_cart_items->rowCount(); 

            $count_completed_items = $conn->prepare("SELECT * FROM `orders` 
                                                WHERE user_id = ? AND orders.payment_status = 'completed'");
            $count_completed_items->execute([$user_id]);
            $total_completed_counts = $count_completed_items->rowCount();

            $count_pending_items = $conn->prepare("SELECT * FROM `orders` 
                                                WHERE user_id = ? AND orders.payment_status = 'pending'");
            $count_pending_items->execute([$user_id]);
            $total_pending_counts = $count_pending_items->rowCount();
        ?>
    <section class="cart-section" id="cart-section">
        <div class="cart-container">
            <div class="cart-content">
                <div class="cart-products">
                    <div class="cart-header">
                        <h2>Orders</h2>
                        <p><?= $total_cart_counts; ?> items</p>
                    </div>
                    <?php
                    $select_cart = $conn->prepare("SELECT 
                                                    cart.id AS cart_id, 
                                                    GROUP_CONCAT(DISTINCT products2.id) AS product_ids, 
                                                    GROUP_CONCAT(DISTINCT products2.product_name) AS product_names,
                                                    products2.brand, 
                                                    products2.category, 
                                                    products2.type, 
                                                    products2.color, 
                                                    cart.product_name, 
                                                    cart.image, 
                                                    cart.user_id, 
                                                    cart.status, 
                                                    cart.price,
                                                    cart.quantity,
                                                    users.user_name, 
                                                    users.email,
                                                    DATE_FORMAT(orders.placed_on, '%y-%m-%d') AS placed_on,
                                                    orders.payment_status,
                                                    orders.method
                                                FROM cart 
                                                INNER JOIN products2 ON products2.id = cart.product_id 
                                                INNER JOIN users ON cart.user_id = users.id 
                                                INNER JOIN orders ON cart.user_id = orders.user_id 
                                                WHERE cart.user_id = ? AND cart.status = 'completed'
                                                GROUP BY cart.id, cart.user_id, cart.status, users.user_name, users.email;
                                                ");
                    $grand_total = 0;
                    $select_cart->execute([$user_id]);
                    if($select_cart->rowCount() > 0){
                        while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
                            $sub_total = $fetch_cart['price'] * $fetch_cart['quantity'];
                            $grand_total += $sub_total;
                    ?>
                    <form action="" method="post">
                        <input type="hidden" name="cart_id" value="<?= $fetch_cart['cart_id']; ?>">
                        <div class="cart-item" style="justify-content: space-between;">
                            <div class="cart-item-img">
                                <img src="assets/images/products/<?= $fetch_cart['image']; ?>" alt="">
                            </div>
                            <div class="cart-item-name">
                                <p><?= $fetch_cart['brand']; ?> / <?= $fetch_cart['category']; ?> / <?= $fetch_cart['type']; ?> / <?= $fetch_cart['color']; ?></p>
                                <h3><?= $fetch_cart['product_name']; ?></h3>
                            </div>
                            <div class="cart-item-qty" style="padding: 0;">
                                <p>(x<?= $fetch_cart['quantity']; ?>)</p>
                            </div>
                            <div class="cart-item-total" style="padding: 0; width:auto;">
                                <p>$<?= $sub_total; ?></p>
                            </div>
                            <div class="cart-item-total" style="padding: 0;">
                                <p><?= $fetch_cart['placed_on']; ?></p>
                            </div>
                            <div class="cart-item-icon" style="padding: 0;">
                               <p style="text-transform: capitalize;"><?= $fetch_cart['payment_status']; ?></p>
                            </div>
                        </div>
                    </form>
                    <?php
                        }
                    } else {
                        echo '<p class="empty">No orders yet</p>';
                    }
                    ?>
                    <div class="cart-footer">
                        <a href="shop.php">Back to shop</a>
                    </div>
                </div>
                <div class="cart-summary">
                    <div class="summary-contents" style="width: 300px;">
                        <div class="summary-header">
                            <h2>Summary</h2>
                        </div>
                        <div class="summary-item">
                            <p><?= $total_cart_counts; ?> items</p>
                        </div>
                        <div class="summary-footer">
                            <p>Completed:</p>
                            <p><?= $total_completed_counts; ?></p>
                        </div>
                        <div class="summary-footer">
                            <p>Pending:</p>
                            <p><?= $total_pending_counts; ?></p>
                        </div>
                        <div class="summary-footer">
                            <p>Total Spent:</p>
                            <p>$<?= $grand_total; ?></p>
                        </div>
                    </div>
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