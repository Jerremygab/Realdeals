<?php


if(isset($_POST['add_to_cart'])){

    if($user_id == ''){
       header('location:user_login.php');
    }else{
 
       $pid = $_POST['pid'];
       $pid = filter_var($pid, FILTER_SANITIZE_STRING);
       $name = $_POST['name'];
       $name = filter_var($name, FILTER_SANITIZE_STRING);
       $price = $_POST['price'];
       $price = filter_var($price, FILTER_SANITIZE_STRING);
       $image = $_POST['image'];
       $image = filter_var($image, FILTER_SANITIZE_STRING);
       $qty = 1;
 
       $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
       $check_cart_numbers->execute([$name, $user_id]);
 
       if($check_cart_numbers->rowCount() > 0){
          $message[] = 'already added to cart!';
       }else{
 
          $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
          $check_wishlist_numbers->execute([$name, $user_id]);
 
          if($check_wishlist_numbers->rowCount() > 0){
             $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE name = ? AND user_id = ?");
             $delete_wishlist->execute([$name, $user_id]);
          }
 
          $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES(?,?,?,?,?,?)");
          $insert_cart->execute([$user_id, $pid, $name, $price, $qty, $image]);
          $message[] = 'added to cart!';
          
       }
 
    }
 
 }

?>

.wp-container-core-columns-is-layout-3:not(.is-not-stacked-on-mobile)>.wp-container-core-columns-is-layout-3
wp-block-columns is-layout-flex wp-container-core-columns-is-layout-3 wp-block-columns-is-layout-flex