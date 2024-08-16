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

// Initialize totals
$ship_total = 1;
$grand_total = 0;

// Calculate grand total
$select_cart = $conn->prepare("SELECT cart.id AS cart_id, products2.id AS product_id, cart.*, products2.* FROM cart LEFT JOIN products2 ON products2.id = cart.product_id WHERE cart.user_id = ? AND cart.status = ''");
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

    // Determine ship_total based on selected option
    if ($selected_value == 1) {
        $ship_total = 5;
    } elseif ($selected_value == 2) {
        $ship_total = 3;
    } elseif ($selected_value == 3) {
        $ship_total = 1;
    } else {
        $ship_total = 0;
    }

    // Calculate final total
    $final_total = $grand_total + $ship_total;

    // Return JSON response
    echo json_encode([
        'ship_total' => $ship_total,
        'final_total' => $final_total
    ]);
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
        <?php
            $count_cart_items = $conn->prepare("SELECT * FROM `cart` LEFT JOIN users ON cart.user_id = users.id WHERE user_id = ? AND cart.status = ''");
            $count_cart_items->execute([$user_id]);
            $total_cart_counts = $count_cart_items->rowCount();
        ?>
    <section class="cart-section" id="cart-section">
        <div class="cart-container">
            <div class="cart-content">
                <div class="cart-products">
                    <div class="cart-header">
                        <h2>Shopping Cart</h2>
                        <p><?= $total_cart_counts; ?> items</p>
                    </div>
                    <?php
                    $select_cart = $conn->prepare("SELECT cart.id AS cart_id, products2.id AS product_id, cart.*, products2.*, users.* FROM cart LEFT JOIN products2 ON products2.id = cart.product_id LEFT JOIN users ON cart.user_id = users.id WHERE cart.user_id = ? AND cart.status = ''");
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
                                <h3><?= $fetch_cart['product_name']; ?></h3>
                            </div>
                            <div class="cart-item-qty">
                                <input type="number" name="qty" class="qty" min="1" max="5" onkeypress="if(this.value.length == 2) return false;" value="<?= $fetch_cart['quantity']; ?>">
                                <button type="submit" class="fas fa-edit" name="update_qty"></button>
                            </div>
                            <div class="cart-item-total">
                                <p>$<?= $sub_total; ?></p>
                            </div>
                            <div class="cart-item-icon">
                                <button type="submit" class="fas fa-trash" name="delete" onclick="return confirm('delete this from cart?');"></button>
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
                            <p><?= $total_cart_counts; ?> items</p>
                            <p>$<?= $grand_total; ?></p>
                        </div>
                        <div class="summary-shipment">
                            <p>Shipment</p>
                            <select id="option_select" name="option_select" onchange="updateShipTotal(this.value)" >
                                <option value="1">Same day delivery (+$5)</option>
                                <option value="2">Express Delivery (+$3)</option>
                                <option value="3" selected>Standard Delivery (+$1)</option>
                            </select>
                        </div>
                        <div class="summary-voucher">
                            <p>Voucher Code</p>
                            <input type="text" placeholder="eg. RLDLS3" maxlength="6">
                        </div>
                        <div class="summary-footer" style="display: none;">
                            <p>Grand Total:</p>
                            <p>$<span id="grand_total"><?= $grand_total; ?></span></p>
                        </div>
                        <div class="summary-footer" style="display: none;">
                            <p>Shipping Cost:</p>
                            <p>$<span id="ship_total"><?= $ship_total; ?></span></p>
                        </div>
                        <div class="summary-footer">
                            <p>Final Total:</p>
                            <p>$<span id="final_total_display"><?= $grand_total + $ship_total; ?></span></p>
                        </div>
                        <div class="summary-btn">
                            <?php          
                                $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                                $select_profile->execute([$user_id]);
                                if($select_profile->rowCount() > 0){
                                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
                            ?>
                            <form action="" method="post">
                                <input type="hidden" name="user_id" value="<?= $fetch_profile['id']; ?>">
                                <input type="hidden" name="user_name" value="<?= $fetch_profile['user_name']; ?>">
                                <input type="hidden" name="no_of_items" value="<?= $total_cart_counts; ?>">
                                <input type="hidden" name="grand_total_input" id="grand_total_input" value="<?= $grand_total; ?>">
                                <input type="hidden" name="ship_total_input" id="ship_total_input" value="<?= $ship_total; ?>">
                                <input type="hidden" name="final_total_input" id="final_total_input" value="<?= $grand_total + $ship_total; ?>">
                                <input type="submit" name="submit" value="Checkout" <?= ($grand_total > 1)?'':'disabled'; ?>>
                            </form>
                            <?php
									}
								?>
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