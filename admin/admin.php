<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_POST['add_product'])){

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
    
    // $image_01 = $_FILES['image_01']['pname'];
    // $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
    // $image_size_1 = $_FILES['image_01']['size'];
    // $image_tmp_name_1 = $_FILES['image_01']['tmp_name'];
    // $image_folder_1 = '../assets/images/products/'.$image_01;
    
    $image_01 = $_FILES['image_01']['name']; // Get the original name of the file
    $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING); // Sanitize the filename
    $image_size_1 = $_FILES['image_01']['size']; // Get the size of the file
    $image_tmp_name_1 = $_FILES['image_01']['tmp_name']; // Get the temporary filename
    $image_folder_1 = '../assets/images/products/' . $image_01; // Path to save the uploaded file
    
    $image_02 = $_FILES['image_02']['name'];
    $image_02 = filter_var($image_02, FILTER_SANITIZE_STRING);
    $image_size_2 = $_FILES['image_02']['size'];
    $image_tmp_name_2 = $_FILES['image_02']['tmp_name'];
    $image_folder_2 = '../assets/images/products/'.$image_02;
    
    $image_03 = $_FILES['image_03']['name'];
    $image_03 = filter_var($image_03, FILTER_SANITIZE_STRING);
    $image_size_3 = $_FILES['image_03']['size'];
    $image_tmp_name_3 = $_FILES['image_03']['tmp_name'];
    $image_folder_3 = '../assets/images/products/'.$image_03;
    
    $select_products = $conn->prepare("SELECT * FROM `products2` WHERE product_name = ?");
    $select_products->execute([$name]);
    
    if($select_products->rowCount() > 0){
       $message[] = 'Product name already exist!';
    }else{
    
       $insert_products = $conn->prepare("INSERT INTO `products2`(product_name, description, brand, category, type, color, specs, compatibility, box, price, sold, image_01, image_02, image_03) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
       $insert_products->execute([$name, $description, $brand, $category, $type, $color, $specs, $compatibility, $box, $price, $sold, $image_01, $image_02, $image_03]);
    
       if($insert_products){
          if($image_size_1 > 2000000 OR $image_size_2 > 2000000 OR $image_size_3 > 2000000){
             $message[] = 'Image size is too large!';
          }else{
             move_uploaded_file($image_tmp_name_1, $image_folder_1);
             move_uploaded_file($image_tmp_name_2, $image_folder_2);
             move_uploaded_file($image_tmp_name_3, $image_folder_3);
             $message[] = 'New product added!';
          }
    
       }
    
    }  
};

if(isset($_POST['delete_prod'])){

    $product_id = $_POST['product_id'];
    $delete_product = $conn->prepare("DELETE FROM `products2` WHERE id = ?");
    $delete_product->execute([$product_id]);
    $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE product_id = ?");
    $delete_cart->execute([$product_id]);
    $message[] = 'Product deleted!';
    // header('location:admin.php');
 }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
    <link rel="shortcut icon" type="image/icon" href="../assets/logo/realdeals.jpg"/>
</head>
<body>
    <!-- https://themewagon.github.io/modernize-mui-admin#! -->
     <header>
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
     </header>
    <div class="dashboard">
        <div class="sidebar">
            <div class="sidebar-flex">
                <h2>Admin Dashboard</h2>
                <ul class="tabs">
                    <li class="tab-link active" data-tab="dashboard-tab">Dashboard</li>
                    <li class="tab-link" data-tab="users-tab">Users</li>
                    <li class="tab-link" data-tab="messages-tab">Messages</li>
                    <li class="tab-link" data-tab="orders-tab">Orders</li>
                    <li class="tab-link" data-tab="products-tab">Products</li>
                </ul>
            </div>
            <div class="sidebar-footer">
                <a href="admin_logout.php" onclick="return confirm('logout from the website?');">Logout</a> 
                <i class="fa-solid fa-store" onclick="window.location.href='../index.php'"></i>
            </div>
        </div>
        <div class="content">
            <div id="dashboard-tab" class="tab-content active">
                <h3>Dashboard</h3>
                <div class="stats">
                    <div class="stat-item">
                        <h4>Total Sales</h4>
                        <p>$50,000</p>
                    </div>
                    <div class="stat-item">
                        <h4>Users</h4>
                        <p>123</p>
                    </div>
                    <div class="stat-item">
                        <h4>Message </h4>
                        <p>123</p>
                    </div>
                    <div class="stat-item">
                        <h4>Total Orders</h4>
                        <p>250</p>
                    </div>
                    <div class="stat-item">
                        <h4>Total Products</h4>
                        <p>120</p>
                    </div>
                </div>
                <div class="stat-table-container">
                    <div class="stat-table-content">
                        <h4>Top Products by Unit Sold</h4>
                        <table>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Sold</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Smartphone X</td>
                                    <td>$15,000</td>
                                    <td>32</td>
                                </tr>
                                <tr>
                                    <td>Laptop Pro</td>
                                    <td>$12,000</td>
                                    <td>31</td>
                                </tr>
                                <tr>
                                    <td>Tablet Mini</td>
                                    <td>$8,000</td>
                                    <td>23</td>
                                </tr>
                                <tr>
                                    <td>Smartwatch Z</td>
                                    <td>$7,500</td>
                                    <td>19</td>
                                </tr>
                                <tr>
                                    <td>Wireless Headphones</td>
                                    <td>$7,000</td>
                                    <td>16</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="stat-table-content">
                        <h4>Recent Orders</h4>
                        <table>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Date</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Smartphone X</td>
                                    <td>$15,000</td>
                                    <td>32</td>
                                    <td>pending</td>
                                </tr>
                                <tr>
                                    <td>Laptop Pro</td>
                                    <td>$12,000</td>
                                    <td>31</td>
                                    <td>pending</td>
                                </tr>
                                <tr>
                                    <td>Tablet Mini</td>
                                    <td>$8,000</td>
                                    <td>23</td>
                                    <td>pending</td>
                                </tr>
                                <tr>
                                    <td>Smartwatch Z</td>
                                    <td>$7,500</td>
                                    <td>19</td>
                                    <td>pending</td>
                                </tr>
                                <tr>
                                    <td>Wireless Headphones</td>
                                    <td>$7,000</td>
                                    <td>16</td>
                                    <td>pending</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="stat-table-container">
                    <div class="stat-table-content">
                        <h4>Top Customers by Total Spent</h4>
                        <table>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Items</th>
                                    <th>Total Spent</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Smartphone X</td>
                                    <td>$15,000</td>
                                    <td>32</td>
                                </tr>
                                <tr>
                                    <td>Laptop Pro</td>
                                    <td>$12,000</td>
                                    <td>31</td>
                                </tr>
                                <tr>
                                    <td>Tablet Mini</td>
                                    <td>$8,000</td>
                                    <td>23</td>
                                </tr>
                                <tr>
                                    <td>Smartwatch Z</td>
                                    <td>$7,500</td>
                                    <td>19</td>
                                </tr>
                                <tr>
                                    <td>Wireless Headphones</td>
                                    <td>$7,000</td>
                                    <td>16</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="stat-table-content">
                        <h4>Vouchers</h4>
                        <table>
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Smartphone X</td>
                                    <td>$15,000</td>
                                    <td>pending</td>
                                </tr>
                                <tr>
                                    <td>Laptop Pro</td>
                                    <td>$12,000</td>
                                    <td>pending</td>
                                </tr>
                                <tr>
                                    <td>Tablet Mini</td>
                                    <td>$8,000</td>
                                    <td>pending</td>
                                </tr>
                                <tr>
                                    <td>Smartwatch Z</td>
                                    <td>$7,500</td>
                                    <td>pending</td>
                                </tr>
                                <tr>
                                    <td>Wireless Headphones</td>
                                    <td>$7,000</td>
                                    <td>pending</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="stat-table-content">
                        <h4>Top Selling Brands</h4>
                        <table>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Sold</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Smartphone X</td>
                                    <td>$15,000</td>
                                </tr>
                                <tr>
                                    <td>Laptop Pro</td>
                                    <td>$12,000</td>
                                </tr>
                                <tr>
                                    <td>Tablet Mini</td>
                                    <td>$8,000</td>
                                </tr>
                                <tr>
                                    <td>Smartwatch Z</td>
                                    <td>$7,500</td>
                                </tr>
                                <tr>
                                    <td>Wireless Headphones</td>
                                    <td>$7,000</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="users-tab" class="tab-content">
                <div class="users-con">
                    <div class="users-table">
                        <h3>Admin</h3>
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Update</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <?php
                                $select_admins = $conn->prepare("SELECT * FROM `admins`"); 
                                $select_admins->execute();
                                if($select_admins->rowCount() > 0){
                                while($fetch_admins = $select_admins->fetch(PDO::FETCH_ASSOC)){
                            ?>
                            <tbody>
                                <tr>
                                    <td><?= $fetch_admins['id']; ?></td>
                                    <td><?= $fetch_admins['name']; ?></td>
                                    <td><i class="fa-solid fa-pen-to-square"></i></i></td>
                                    <td><i class="fas fa-trash"></i></td>
                                </tr>
                            </tbody>
                            <?php
                                }
                            }else{
                                echo '<p class="empty">No admin found!</p>';
                            }
                            ?>
                        </table>
                    </div>
                    <div class="users-table">
                        <h3>Users</h3>
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <?php
                                $select_users = $conn->prepare("SELECT * FROM `users`"); 
                                $select_users->execute();
                                if($select_users->rowCount() > 0){
                                while($fetch_users = $select_users->fetch(PDO::FETCH_ASSOC)){
                            ?>
                            <tbody>
                                <tr>
                                    <td><?= $fetch_users['id']; ?></td>
                                    <td><?= $fetch_users['user_name']; ?></td>
                                    <td><?= $fetch_users['email']; ?></td>
                                    <td><i class="fas fa-trash"></i></td>
                                </tr>
                            </tbody>
                            <?php
                                }
                            }else{
                                echo '<p class="empty">No users found!</p>';
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
            <div id="messages-tab" class="tab-content">
                <ul class="messages">
                    <h3>Messages</h3>
                    <li>
                        <strong>John Doe:</strong> Can I change my order?
                        <span class="timestamp">2024-08-21 10:23 AM</span>
                    </li>
                    <li>
                        <strong>Jane Smith:</strong> I didn't receive my package yet.
                        <span class="timestamp">2024-08-20 08:15 AM</span>
                    </li>
                    <li>
                        <strong>Bob Johnson:</strong> Thank you for the quick response!
                        <span class="timestamp">2024-08-19 02:45 PM</span>
                    </li>
                </ul>
            </div>
            <div id="orders-tab" class="tab-content">
                <div class="orders">
                    <h3>Orders</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Contact</th>
                                <th>MOP</th>
                                <th>Products</th>
                                <th>Total</th>
                                <th style="width: 120px;">Status</th>
                            </tr>
                        </thead>
                        <?php
                            $select_orders = $conn->prepare("SELECT * FROM `orders`"); 
                            $select_orders->execute();
                            if($select_orders->rowCount() > 0){
                            while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
                        ?>
                        <tbody>
                            <tr>
                                <td><?= $fetch_orders['id']; ?></td>
                                <td><?= $fetch_orders['name']; ?></td>
                                <td><?= $fetch_orders['address']; ?></td>
                                <td><?= $fetch_orders['number']; ?></td>
                                <td><?= $fetch_orders['method']; ?></td>
                                <td><?= $fetch_orders['total_products']; ?></td>
                                <td>$<?= $fetch_orders['total_price']; ?></td>
                                <td>
                                <?php
                                    $status = $fetch_orders['payment_status']; 
                                    if ($status === "completed") {
                                        echo '<p>Completed</p>';
                                    } else {
                                        echo '<select>
                                                <option value="pending"' . ($status === 'pending' ? ' selected' : '') . '>Pending</option>
                                                <option value="complete"' . ($status === 'complete' ? ' selected' : '') . '>Complete</option>
                                            </select>
                                            <i class="fa-solid fa-pen-to-square"></i>';
                                    }
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                        <?php
                            }
                        }else{
                            echo '<p class="empty">No orders found!</p>';
                        }
                        ?>
                    </table>
                </div>
            </div>
            <div id="products-tab" class="tab-content">
                <div class="products">
                    <form action="" method="post" enctype="multipart/form-data">
                        <h3>Add Products</h3>
                        <div class="add-products-form">
                            <table>
                                <tr class="add-products-input">
                                    <td>Product Name</td>
                                    <td><input type="text" name="pname" required></td>
                                </tr>
                                <tr class="add-products-input">
                                    <td>Description</td>
                                    <td><input type="text" name="description" required></td>
                                </tr>
                                <tr class="add-products-input">
                                    <td>Brand</td>
                                    <td><input type="text" name="brand" required></td>
                                </tr>
                                <tr class="add-products-input">
                                    <td>Category</td>
                                    <td><input type="text" name="category" placeholder="Peripheral, PC Component, Console, .etc" required></td>
                                </tr>
                                <tr class="add-products-input">
                                    <td>Type</td>
                                    <td><input type="text" name="type" placeholder="Motherboard, Mouse, Printer, .etc" required></td>
                                </tr>
                                <tr class="add-products-input">
                                    <td>Color</td>
                                    <td><input type="text" name="color" required></td>
                                </tr>
                                <tr class="add-products-input">
                                    <td>Special Features</td>
                                    <td><input type="text" name="specs" required></td>
                                </tr>
                            </table>
                            <table>
                                <tr class="add-products-input">
                                    <td>Compatibility</td>
                                    <td><input type="text" name="compatibility" required></td>
                                </tr>
                                <tr class="add-products-input">
                                    <td>Inside the box</td>
                                    <td><input type="text" name="box" required></td>
                                </tr>
                                <tr class="add-products-input">
                                    <td>Price</td>
                                    <td><input type="number" name="price" required></td>
                                </tr>
                                <tr class="add-products-input">
                                    <td>Sold</td>
                                    <td><input type="number" name="sold" required></td>
                                </tr>
                                <tr class="add-products-input">
                                    <td>Image 1</td>
                                    <td><input type="file" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" required></td>
                                </tr>
                                <tr class="add-products-input">
                                    <td>Image 2</td>
                                    <td><input type="file" name="image_02" accept="image/jpg, image/jpeg, image/png, image/webp" required></td>
                                </tr>
                                <tr class="add-products-input">
                                    <td>Image 3</td>
                                    <td><input type="file" name="image_03" accept="image/jpg, image/jpeg, image/png, image/webp" required></td>
                                </tr>
                            </table>
                        </div>
                        <div class="add-products-btn">
                            <input type="submit" value="add product" name="add_product">
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
                                <!-- <a href="products.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');"><i class="fas fa-trash"></i></a> -->
                                <button type="submit" class="fas fa-trash delete-btn" name="delete_prod" onclick="return confirm('delete this from cart?');"></button>
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
        </div>
    </div>
    <script src="../assets/js/script.js"></script>
</body>
</html>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.tab-link');
            const contents = document.querySelectorAll('.tab-content');
        
            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    tabs.forEach(item => item.classList.remove('active'));
                    contents.forEach(content => content.classList.remove('active'));
        
                    tab.classList.add('active');
                    document.getElementById(tab.dataset.tab).classList.add('active');
                });
            });
        });
        
    </script>