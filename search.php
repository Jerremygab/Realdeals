<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};
include 'components/cart-btn.php';
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

    </head>
	
	<body>
	
		<!--welcome-hero start -->
		<section id="home" class="welcome-hero">

			<!-- top-area Start -->
            <?php include 'components/header.php'; ?>
			<!-- top-area End -->
		</section><!--/.welcome-hero-->
		<!--welcome-hero end -->
		<!--featured-cars start -->
		<section id="featured-cars" class="featured-cars">
			<div class="container">
				<div class="section-header">
					<p>Find your products</p>
					<h2>Search</h2>
				</div><!--/.section-header-->
                    
				<div class="featured-cars-content">
               <form action="" method="post" style="display: flex; justify-content: flex-end; gap: 1rem;">
                  <input type="text" name="search_box" placeholder="Search Product" maxlength="100" class="box" style="padding: 3px;font-size: 14px;height: 25px;border: 1px solid #999;border-radius: 1px;padding-bottom: 5px;"required>
                  <button type="submit" class="fas fa-search" name="search_btn"></button>
               </form>
               <?php
                  if(isset($_POST['search_box']) OR isset($_POST['search_btn'])){
                  $search_box = $_POST['search_box'];
                  $select_products = $conn->prepare("SELECT * FROM `products2` WHERE product_name LIKE '%{$search_box}%' OR brand LIKE '%{$search_box}%' OR category LIKE '%{$search_box}%' OR type LIKE '%{$search_box}%'"); 
                  // $select_products = $conn->prepare("SELECT * FROM `products2` WHERE brand LIKE '%{$search_box}%'"); 
                  $select_products->execute();
                  if($select_products->rowCount() > 0){
                     while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
               ?>
               <form action="" method="post">
               <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
               <input type="hidden" name="name" value="<?= $fetch_product['product_name']; ?>">
               <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
               <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
					<div class="row">
						<div class="col-lg-3 col-md-4 col-sm-6">
                            <a href="quickview.php?pid=<?= $fetch_product['id']; ?>">
                                <div class="single-product-box">
                                    <div class="product-img-box">
                                        <div class="product-img">
                                            <img src="assets/images/products/<?= $fetch_product['image_01']; ?>" alt="">
                                        </div>
                                    </div>
                                    <div class="featured-cars-txt solds">
                                        <h2><a><?= $fetch_product['product_name']; ?> </a></h2>
                                        <h3>$<?= $fetch_product['price']; ?></h3>
                                        <div class="featured-cars-rating">
                                            <i class="fa-solid fa-star ratings"></i>
                                            <i class="fa-solid fa-star ratings"></i>
                                            <i class="fa-solid fa-star ratings"></i>
                                            <i class="fa-solid fa-star ratings"></i>
                                            <i class="fa-solid fa-star ratings"></i>
                                        </div>
                                        <p><?= $fetch_product['sold']; ?> Sold</p>
                                        <br>
                                        <div class="form-input">
                                            <input type="submit" value="Add to cart" name="add_to_cart">
                                        </div>
                                        <!-- <div class="add-btn">
                                            <p>Add to cart</p>
                                            <i class="fa-solid fa-cart-shopping"></i>
                                        </div> -->
                                    </div>
                                </div>
                            </a>
						</div>
                        </form>
						<?php
                        }
                     }else{
                        echo '<p class="empty">No products found!</p>';
                     }
                  }
                        ?>
						
						
					</div>
				</div>
                
			</div><!--/.container-->

		</section><!--/.featured-cars-->
		<!--featured-cars end -->

		<!--blog start -->
		<section id="blog" class="blog"></section><!--/.blog-->
		<!--blog end -->

		<!--contact start-->
        <?php include 'components/footer.php'; ?>
		<!--contact end-->

        <?php include 'components/scripts.php'; ?>
        
    </body>
	
</html>