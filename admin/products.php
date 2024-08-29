<?php
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
   $insert_products->execute([$name, $description, $brand, $category, $type, $color, $specs, $compatibility, $box, $price, $sold, $color, $image_01, $image_02, $image_03]);

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
?>

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