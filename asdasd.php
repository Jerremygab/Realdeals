<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
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

// Initialize totals
$ship_total = 0;
$grand_total = 0;

// Calculate grand total
$select_cart = $conn->prepare("SELECT cart.id AS cart_id, products2.id AS product_id, cart.*, products2.* FROM cart LEFT JOIN products2 ON products2.id = cart.pid WHERE cart.user_id = ?");
$select_cart->execute([$user_id]);

if($select_cart->rowCount() > 0){
    while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
        $sub_total = $fetch_cart['price'] * $fetch_cart['quantity'];
        $grand_total += $sub_total;
    }
}

// Handle AJAX request to update the ship total
if (isset($_GET['selected'])) {
    $selected_value = intval($_GET['selected']);

    if ($selected_value == 1) {
        $ship_total += 5;
    } elseif ($selected_value == 2) {
        $ship_total += 3;
    } elseif ($selected_value == 3) {
        $ship_total += 1;
    }

    // Calculate the new total and return it
    $new_total = $grand_total + $ship_total;
    echo $new_total;
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
    <script>
    function updateShipTotal(selectedValue) {
        console.log("Selected Value: " + selectedValue);
        const xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log("Response: " + xhr.responseText);
                // Update the total element with the server response
                document.getElementById("total").innerText = xhr.responseText;
            }
        };

        // Send the request to the same PHP file
        xhr.open("GET", "?selected=" + selectedValue, true);
        xhr.send();
    }
    </script>
</head>

<body>
    <!--welcome-hero start -->
    <section id="home" class="welcome-hero">
        <!-- top-area Start -->
        <?php include 'components/header.php'; ?>
        <!-- top-area End -->
    </section><!--/.welcome-hero-->
    <!--welcome-hero end -->

    <section class="cart-section" id="cart-section">
        <div class="cart-container">
            <div class="cart-content">
                <div class="cart-products">
                    <div class="cart-header">
                        <h2>Shopping Cart</h2>
                        <p>3 items</p>
                    </div>
                    <?php
                    $select_cart = $conn->prepare("SELECT cart.id AS cart_id, products2.id AS product_id, cart.*, products2.* FROM cart LEFT JOIN products2 ON products2.id = cart.pid WHERE cart.user_id = ?");
                    $select_cart->execute([$user_id]);
                    if($select_cart->rowCount() > 0){
                        while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
                            $sub_total = $fetch_cart['price'] * $fetch_cart['quantity'];
                            // $grand_total += $sub_total;
                    ?>
                    <form action="" method="post">
                        <input type="hidden" name="cart_id" value="<?= $fetch_cart['cart_id']; ?>">
                        <div class="cart-item">
                            <div class="cart-item-img">
                                <img src="assets/images/products/<?= $fetch_cart['image']; ?>" alt="">
                            </div>
                            <div class="cart-item-name">
                                <p><?= $fetch_cart['brand']; ?> / <?= $fetch_cart['category']; ?> / <?= $fetch_cart['type']; ?> / <?= $fetch_cart['color']; ?></p>
                                <h3><?= $fetch_cart['name']; ?></h3>
                            </div>
                            <div class="cart-item-qty">
                                <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="<?= $fetch_cart['quantity']; ?>">
                                <button type="submit" class="fas fa-edit" name="update_qty"></button>
                            </div>
                            <div class="cart-item-total">
                                <p>$<?= $sub_total; ?></p>
                            </div>
                            <div class="cart-item-icon">
                                <button type="submit" class="fas fa-trash" name="delete"></button>
                            </div>
                        </div>
                    </form>
                    <?php
                        }
                    } else {
                        echo '<p class="empty">Your cart is empty</p>';
                    }
                    ?>
                    <div class="cart-footer">
                        <a href="shop.php">Back to shop</a>
                    </div>
                </div>
                <div class="cart-summary">
                    <div class="summary-contents">
                        <div class="summary-header">
                            <h2>Summary</h2>
                        </div>
                        <div class="summary-item">
                            <p>3 items</p>
                            <p>$<?= $grand_total; ?></p>
                        </div>
                        <div class="summary-shipment">
                            <p>Shipment</p>
                            <select id="option_select" name="option_select" onchange="updateShipTotal(this.value)">
                                <option value="0">Select an option</option>
                                <option value="1">Option 1 (+$5)</option>
                                <option value="2">Option 2 (+$3)</option>
                                <option value="3">Option 3 (+$1)</option>
                            </select>
                        </div>
                        <div class="summary-voucher">
                            <p>Voucher Code</p>
                            <input type="text" placeholder="eg. RLDLS3" maxlength="6">
                        </div>
                        <div class="summary-footer">
                            <p>Total Price</p>
                            <p>Total: $<span id="total"><?= $grand_total; ?></span></p>
                        </div>
                        <div class="summary-btn">
                            <input type="submit" name="submit" value="Checkout">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--blog start -->
    <section id="blog" class="blog"></section><!--/.blog-->
    <!--blog end -->

    <!--contact start-->
    <?php include 'components/footer.php'; ?>
    <!--contact end-->

    <?php include 'components/scripts.php'; ?>
</body>

</html>
