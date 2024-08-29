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
        <?php
            $pid = $_GET['pid'];
            $select_products = $conn->prepare("SELECT * FROM `products2` WHERE id = ?"); 
            $select_products->execute([$pid]);
            if($select_products->rowCount() > 0){
            while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
        ?>
		<!--new-cars start -->
		<section id="new-cars" class="new-cars" style="padding: 112px 0 62px;">
			<div class="container">
				<div class="section-header">
					<p>checkout <span>this</span> product now</p>
					<h2>Quickview</h2>
				</div><!--/.section-header-->
                <div class="quickview-content-box">
                    <form action="" method="post">
                        <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
                        <input type="hidden" name="name" value="<?= $fetch_product['product_name']; ?>">
                        <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
                        <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
                    <div class="quickview-content-item">
                        <div class="quickview-content-img">
                            <div class="quickview-main-img">
                                <img src="assets/images/products<?= $fetch_product['image_01']; ?>" alt="">
                            </div>
                            <div class="quickview-sub-img">
                                <img src="assets/images/products<?= $fetch_product['image_01']; ?>" alt="">
                                <img src="assets/images/products<?= $fetch_product['image_02']; ?>" alt="">
                                <img src="assets/images/products<?= $fetch_product['image_03']; ?>" alt="">
                            </div>
                        </div>
                        <div class="quickview-content-text">
                            <h2><a><?= $fetch_product['product_name']; ?> </a></h2>
                            <p><?= $fetch_product['description']; ?></p>
                            <h3>$<?= $fetch_product['price']; ?></h3>
                            <div class="featured-cars-rating">
                                <i class="fa-solid fa-star ratings"></i>
                                <i class="fa-solid fa-star ratings"></i>
                                <i class="fa-solid fa-star ratings"></i>
                                <i class="fa-solid fa-star ratings"></i>
                                <i class="fa-solid fa-star ratings"></i>
                            </div>
                            <div class="featured-cars-txt solds" style="margin: 0;">
                                <p><?= $fetch_product['sold']; ?> Sold</p>
                            </div>
                            <div class="form-input">
                                <input type="submit" value="Add to cart" name="add_to_cart" style="width:fit-content">
                            </div>
                        </div>
                    </div>
                    </form>
                        
                </div>
			</div><!--/.container-->

		</section><!--/.new-cars-->
		<!--new-cars end -->
        <!--service start -->
        <section id="service" class="service" style="padding: 32px 0 62px; background:#f8f9fb;">
					<div class="container">
						<div class="service-content">
							<div class="row">
								<div class="col-md-4 col-sm-6 column">
									<div class="single-service-item">
										<div class="single-service-icon">
											<i class="fa-regular fa-lightbulb"></i>
										</div>
										<h2><a>Specs and Details</a></h2>
										<table class="single-service-table">
											<tr>
												<td>Brand</td>
												<td><?= $fetch_product['brand']; ?></td>
											</tr>
											<tr>
												<td>Color</td>
												<td><?= $fetch_product['color']; ?></td>
											</tr>
											<tr>
												<td>Special Feature</td>
												<td><?= $fetch_product['specs']; ?></td>
											</tr>
											
										</table>
										<p></p>
									</div>
								</div>
								<div class="col-md-4 col-sm-6 column">
									<div class="single-service-item">
										<div class="single-service-icon">
											<i class="fa-solid fa-circle-nodes"></i>
										</div>
										<h2><a>Compatibility</a></h2>
										<p><?= $fetch_product['compatibility']; ?></p>
									</div>
								</div>
								<div class="col-md-4 col-sm-6 column">
									<div class="single-service-item">
										<div class="single-service-icon">
											<i class="fa-solid fa-parachute-box"></i>
										</div>
										<h2><a>In the box</a></h2>
										<p><?= $fetch_product['box']; ?></p>
									</div>
								</div>
							</div>
						</div>
					</div><!--/.container-->
		
        </section><!--/.service-->
        		<!--featured-cars start -->
		<section id="featured-cars" class="featured-cars" style="padding: 62px 0 120px">
			<div class="container">
				<div class="section-header">
                <p>you may also like</p>
                <h2>similar products</h2>
				</div><!--/.section-header-->
                    
				<div class="featured-cars-content" style="padding-top: 32px;">
                    <?php
                        $select_products = $conn->prepare("SELECT * FROM `products2` ORDER BY RAND() LIMIT 4;"); 
                        $select_products->execute();
                        if($select_products->rowCount() > 0){
                        while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
                    ?>
                    <form action="" method="post">
                        <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
                        <input type="hidden" name="name" value="<?= $fetch_product['pname']; ?>">
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
                                        <h2><a><?= $fetch_product['pname']; ?> </a></h2>
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
                        ?>
						
						
					</div>
				</div>
                
			</div><!--/.container-->

		</section><!--/.featured-cars-->
		<!--featured-cars end -->
                <?php
                    }
                }else{
                    echo '<p class="empty">No products found!</p>';
                }
                ?>
				<!--service end-->
		<!--blog start -->
		<section id="blog" class="blog"></section><!--/.blog-->
		<!--blog end -->

		<!--contact start-->
        <?php include 'components/footer.php'; ?>
		<!--contact end-->
        <script src="assets/js/script.js"></script>
		<?php include 'components/scripts.php'; ?>
        
    </body>
	
</html>