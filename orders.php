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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
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
                                                WHERE user_id = ? AND cart.status = 'Y'");
            $count_cart_items->execute([$user_id]);
            $total_cart_counts = $count_cart_items->rowCount(); 

            $count_completed_items = $conn->prepare("SELECT *
                                                    FROM cart T1
                                                    JOIN orders T2
                                                    ON FIND_IN_SET(T1.id, T2.cart_id) > 0 
                                                    WHERE T1.user_id = ? AND T2.payment_status = 'completed'");
            $count_completed_items->execute([$user_id]);
            $total_completed_counts = $count_completed_items->rowCount();

            $count_pending_items = $conn->prepare("SELECT *
                                                FROM cart T1
                                                JOIN orders T2
                                                ON FIND_IN_SET(T1.id, T2.cart_id) > 0 
                                                WHERE T1.user_id = ? AND T2.payment_status = 'pending'");
            $count_pending_items->execute([$user_id]);
            $total_pending_counts = $count_pending_items->rowCount();
        ?>
    <section class="cart-section" id="cart-section">
    <div class="card-section">
        <div class="row">
            <div class="col-md-8 carts">
                <div class="title">
                    <div class="row">
                        <div class="col"><h4><b>Orders</b></h4></div>
                        <div class="col align-self-center text-right text-muted"><?= $total_cart_counts; ?> items</div>
                    </div>
                </div>    
                <div class="row">
                    <?php
                        $select_cart = $conn->prepare("SELECT *
                                                        FROM cart T1
                                                        JOIN orders T2
                                                        ON FIND_IN_SET(T1.id, T2.cart_id) > 0
                                                        LEFT JOIN products2 T3 ON T3.id = T1.product_id
                                                        WHERE T1.user_id = ? AND T1.status = 'Y'");
                        $grand_total = 0;
                        $select_cart->execute([$user_id]);
                        if($select_cart->rowCount() > 0){
                            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
                                $sub_total = $fetch_cart['price'] * $fetch_cart['quantity'];
                                $grand_total += $sub_total;
                    ?>
                    <form action="" method="post" style="width: 100%;">
                    <input type="hidden" name="cart_id" value="<?= $fetch_cart['cart_id']; ?>">
                    <div class="row main align-items-center border-bottom">
                        <div class="col-2"><img class="img-fluid" src="assets/images/products/<?= $fetch_cart['image']; ?>"></div>
                        <div class="col">
                            <div class="row text-muted" style="font-size: 10px;"><?= $fetch_cart['brand']; ?> / <?= $fetch_cart['category']; ?> / <?= $fetch_cart['type']; ?> / <?= $fetch_cart['color']; ?></div>
                            <div class="row"><?= $fetch_cart['product_name']; ?></div>
                        </div>
                        <div class="col" style="max-width: 70px;">
                            <p>(x<?= $fetch_cart['quantity']; ?>)</p>
                        </div>
                        <div class="col" style="max-width: 70px;">
                            $<?= $sub_total; ?> 
                        </div>
                        <div class="col" style="max-width: 120px;">
                                <?= $fetch_cart['placed_on']; ?>
                        </div>
                        <div class="col" style="max-width: 100px;">
                                <?= $fetch_cart['payment_status']; ?>
                        </div>
                    </div>
                    <?php
                        }
                    } else {
                        echo '<p class="empty">Your cart is empty</p>';
                    }
                    ?>
                    </form>
                </div>
                <div class="back-to-shop"><a href="#">&leftarrow;</a><span class="text-muted">Back to shop</span></div>
            </div>
            <div class="col-md-4 summary">
                <div><h5><b>Summary</b></h5></div>
                <hr>
                <div class="row">
                    <div class="col" style="padding-left:0;">Items <?= $total_cart_counts; ?></div>
                </div>
                <div class="row" style="padding-bottom: .5rem;">
                    <div class="col" style="padding: 0;">Completed</div>
                    <div class="col text-right"><?= $total_completed_counts; ?></div>
                </div>
                <div class="row" style="padding-bottom: .5rem;">
                    <div class="col" style="padding: 0;">Pending</div>
                    <div class="col text-right"><?= $total_pending_counts; ?></div>
                </div>
                <div class="row" style="padding-bottom: .5rem;">
                    <div class="col" style="padding: 0;">Total Spent</div>
                    <div class="col text-right">$<?= $grand_total; ?></div>
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