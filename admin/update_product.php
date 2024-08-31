<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

// if(!isset($admin_id)){
//    header('location:admin_login.php');
// }

if(isset($_POST['update_prod'])){

    $pid = $_POST['pid'];
    $name = $_POST['pname'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $description = $_POST['description'];
    $description = filter_var($description, FILTER_SANITIZE_STRING);
    $brand = $_POST['brand'];
    $brand = filter_var($brand, FILTER_SANITIZE_STRING);
    $category = $_POST['category'];
    $category = filter_var($category, FILTER_SANITIZE_STRING);
    $type = $_POST['type'];
    $type = filter_var($type, FILTER_SANITIZE_STRING);
    $color = $_POST['color'];
    $color = filter_var($color, FILTER_SANITIZE_STRING);
    $specs = $_POST['specs'];
    $specs = filter_var($specs, FILTER_SANITIZE_STRING);
    $compatibility = $_POST['compatibility'];
    $compatibility = filter_var($compatibility, FILTER_SANITIZE_STRING);
    $box = $_POST['box'];
    $box = filter_var($box, FILTER_SANITIZE_STRING);
    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);
    $sold = $_POST['sold'];
    $sold = filter_var($sold, FILTER_SANITIZE_STRING);
    $update_product = $conn->prepare("UPDATE `products2` SET product_name = ?, description = ?, brand = ?, category = ?, type = ?, color = ?, specs = ?, compatibility = ?, box = ?, price = ?, sold = ? WHERE id = ?");
    $update_product->execute([$name, $description, $brand, $category, $type, $color, $specs, $compatibility, $box, $price, $sold, $pid]);
 
    $message[] = 'product updated successfully!';
 
    $old_image_01 = $_POST['old_image_01'];
    $image_01 = $_FILES['image_01']['name'];
    $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
    $image_size_01 = $_FILES['image_01']['size'];
    $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
    $image_folder_01 = '../assets/images/products/'.$image_01;
 
    if(!empty($image_01)){
       if($image_size_01 > 2000000){
          $message[] = 'image size is too large!';
       }else{
          $update_image_01 = $conn->prepare("UPDATE `products2` SET image_01 = ? WHERE id = ?");
          $update_image_01->execute([$image_01, $pid]);
          move_uploaded_file($image_tmp_name_01, $image_folder_01);
          unlink('../assets/images/products/'.$old_image_01);
          $message[] = 'image 01 updated successfully!';
       }
    }
 
    $old_image_02 = $_POST['old_image_02'];
    $image_02 = $_FILES['image_02']['name'];
    $image_02 = filter_var($image_02, FILTER_SANITIZE_STRING);
    $image_size_02 = $_FILES['image_02']['size'];
    $image_tmp_name_02 = $_FILES['image_02']['tmp_name'];
    $image_folder_02 = '../assets/images/products/'.$image_02;
 
    if(!empty($image_02)){
       if($image_size_02 > 2000000){
          $message[] = 'image size is too large!';
       }else{
          $update_image_02 = $conn->prepare("UPDATE `products2` SET image_02 = ? WHERE id = ?");
          $update_image_02->execute([$image_02, $pid]);
          move_uploaded_file($image_tmp_name_02, $image_folder_02);
          unlink('../assets/images/products/'.$old_image_02);
          $message[] = 'image 02 updated successfully!';
       }
    }
 
    $old_image_03 = $_POST['old_image_03'];
    $image_03 = $_FILES['image_03']['name'];
    $image_03 = filter_var($image_03, FILTER_SANITIZE_STRING);
    $image_size_03 = $_FILES['image_03']['size'];
    $image_tmp_name_03 = $_FILES['image_03']['tmp_name'];
    $image_folder_03 = '../assets/images/products/'.$image_03;
 
    if(!empty($image_03)){
       if($image_size_03 > 2000000){
          $message[] = 'image size is too large!';
       }else{
          $update_image_03 = $conn->prepare("UPDATE `products2` SET image_03 = ? WHERE id = ?");
          $update_image_03->execute([$image_03, $pid]);
          move_uploaded_file($image_tmp_name_03, $image_folder_03);
          unlink('../assets/images/products/'.$old_image_03);
          $message[] = 'image 03 updated successfully!';
       }
    }
    header('location:admin.php');
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div id="products-tab" class="tab-content" style="display: block;padding: 5rem;">
        <?php
            if(isset($message)){
                foreach($message as $message){
                    echo '
                    <div class="message">
                        <span>'.$message.'</span>
                        <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
                    </div>
                    ';
                }
            }
        ?>
        <div class="products">
            <form action="" method="post" enctype="multipart/form-data">
                <h3>Update Products</h3>
                <div class="add-products-form">
                <?php
                    $update_id = $_GET['update'];
                    $select_products = $conn->prepare("SELECT * FROM `products2` WHERE id = ?");
                    $select_products->execute([$update_id]);
                    if($select_products->rowCount() > 0){
                        while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
                ?>
                    <table>
                        <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                        <input type="hidden" name="old_image_01" value="<?= $fetch_products['image_01']; ?>">
                        <input type="hidden" name="old_image_02" value="<?= $fetch_products['image_02']; ?>">
                        <input type="hidden" name="old_image_03" value="<?= $fetch_products['image_03']; ?>">
                        <tr class="add-products-input">
                            <td>Product Name</td>
                            <td><input type="text" name="pname" value="<?= $fetch_products['product_name']; ?>" required></td>
                        </tr>
                        <tr class="add-products-input">
                            <td>Description</td>
                            <td><input type="text" name="description" value="<?= $fetch_products['description']; ?>" required></td>
                        </tr>
                        <tr class="add-products-input">
                            <td>Brand</td>
                            <td><input type="text" name="brand" value="<?= $fetch_products['brand']; ?>" required></td>
                        </tr>
                        <tr class="add-products-input">
                            <td>Category</td>
                            <td><input type="text" name="category" value="<?= $fetch_products['category']; ?>" required></td>
                        </tr>
                        <tr class="add-products-input">
                            <td>Type</td>
                            <td><input type="text" name="type" value="<?= $fetch_products['type']; ?>" required></td>
                        </tr>
                        <tr class="add-products-input">
                            <td>Color</td>
                            <td><input type="text" name="color" value="<?= $fetch_products['color']; ?>" required></td>
                        </tr>
                        <tr class="add-products-input">
                            <td>Special Features</td>
                            <td><input type="text" name="specs" value="<?= $fetch_products['specs']; ?>" required></td>
                        </tr>
                    </table>
                    <table>
                        <tr class="add-products-input">
                            <td>Compatibility</td>
                            <td><input type="text" name="compatibility" value="<?= $fetch_products['compatibility']; ?>" required></td>
                        </tr>
                        <tr class="add-products-input">
                            <td>Inside the box</td>
                            <td><input type="text" name="box" value="<?= $fetch_products['box']; ?>" required></td>
                        </tr>
                        <tr class="add-products-input">
                            <td>Price</td>
                            <td><input type="number" name="price" value="<?= $fetch_products['price']; ?>" required></td>
                        </tr>
                        <tr class="add-products-input">
                            <td>Sold</td>
                            <td><input type="number" name="sold" value="<?= $fetch_products['sold']; ?>" required></td>
                        </tr>
                        <tr class="add-products-input">
                            <td>Image 1</td>
                            <td><input type="file" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" ></td>
                        </tr>
                        <tr class="add-products-input">
                            <td>Image 2</td>
                            <td><input type="file" name="image_02" accept="image/jpg, image/jpeg, image/png, image/webp" ></td>
                        </tr>
                        <tr class="add-products-input">
                            <td>Image 3</td>
                            <td><input type="file" name="image_03" accept="image/jpg, image/jpeg, image/png, image/webp" ></td>
                        </tr>
                    </table>
                    <?php
                        }
                    }else{
                        echo '<p class="empty">No products found!</p>';
                    }
                    ?>
                </div>
                <div class="add-products-btn">
                    <input type="submit" value="update product" name="update_prod" onclick="window.location.href='admin.php'">
                </div>  
            </form>
        </div>
        <h3>Product list</h3>
        <div class="product-list-container">
            <div class="product-list-content">
            <?php
                $select_products = $conn->prepare("SELECT * FROM `products2` ORDER BY RAND();"); 
                $select_products->execute();
                if($select_products->rowCount() > 0){
                while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
            ?>
            <form action="" method="post">
                <div class="product-list-card">
                    <input type="hidden" name="product_id" value="<?= $fetch_product['id']; ?>">
                    <img src="../assets/images/products/<?= $fetch_product['image_01']; ?>" alt="">
                    <b><?= $fetch_product['product_name']; ?></b>
                    <p style="font-size:12px;"><?= $fetch_product['brand']; ?> / <?= $fetch_product['category']; ?> / <?= $fetch_product['type']; ?> / <?= $fetch_product['color']; ?></p>
                    <p style="font-size:14px;">$<?= $fetch_product['price']; ?></p>
                    <div class="product-list-card-btn">
                        <a href="update_product.php?update=<?= $fetch_products['id']; ?>" class="update-btn">update</a>
                        <!-- <a href="products.php?delete=<?= $fetch_products['id']; ?>" class="icon-btn" onclick="return confirm('delete this product?');"><i class="fas fa-trash"></i></a> -->
                        <button type="submit" class="fas fa-trash icon-btn" name="delete_prod" onclick="return confirm('delete this from cart?');"></button>
                    </div>
                </div>
            </form>
            <?php
                }
            }else{
                echo '<p class="empty">No products found!</p>';
            }
            ?>
            </div>
        </div>
    </div>
    
</body>
</html>
