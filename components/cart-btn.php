<?php


if(isset($_POST['add_to_cart'])){

    if($user_id == ''){
      //  header('location:login.php');
      $message[] = 'Please login first';
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

      $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE product_name = ? AND user_id = ? AND cart.status = ''");
      $check_cart_numbers->execute([$name, $user_id]);

      if($check_cart_numbers->rowCount() > 0){
      $message[] = 'already added to cart!';
      }else{

      $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, product_id, product_name, price, quantity, image) VALUES(?,?,?,?,?,?)");
      $insert_cart->execute([$user_id, $pid, $name, $price, $qty, $image]);
      $message[] = 'added to cart!';
      }
 
    }
 
 }

?>
