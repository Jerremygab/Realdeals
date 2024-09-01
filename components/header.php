<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="alert-message">
            <p>'.$message.'</p>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
?>




<div class="top-area">
	<div class="header-area">
		<!-- Start Navigation -->
		<nav class="navbar navbar-default bootsnav  navbar-sticky navbar-scrollspy"  data-minus-value-desktop="70" data-minus-value-mobile="55" data-speed="1000">

			<div class="container" style="flex-wrap: nowrap;">

				<!-- Start Header Navigation -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
						<i class="fa fa-bars"></i>
					</button>
					<a class="navbar-brand" href="admin/admin.php"><img src="assets/logo/realdeals-removebg-preview.png" alt=""></a>

				</div><!--/.navbar-header-->
				<!-- End Header Navigation -->

				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse menu-ui-design" id="navbar-menu">
					<ul class="nav navbar-nav navbar-right" data-in="fadeInDown" data-out="fadeOutUp" style="flex-direction: row;">
						<li class=" scrolls actives"><a href="index.php">home</a></li>
						<li class="scrolls"><a href="shop.php">all products</a></li>
						<li class="scrolls"><a href="orders.php">orders</a></li>
						<li class="scrolls"><a href="contact.php">contact</a></li>
						<li class="scrolls"><a href="search.php"><i class="fa-solid fa-magnifying-glass"></i></a></li>
						<li class="scrolls"><a href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a></li>
						<li class="scrolls"><a><i class="fa-solid fa-user" data-toggle="modal" data-target="#myModal"></i></a></li>
					</ul><!--/.nav -->
				</div><!-- /.navbar-collapse -->
					<!-- Modal -->
					<div class="modal fade" id="myModal" role="dialog" style="z-index: 9999999;">
						<div class="modal-dialog" style="display: flex; justify-content: center;">
						
						<!-- Modal content-->
						<div class="modal-content" style="width: 350px;">
								<?php          
									$count_cart_items = $conn->prepare("SELECT * FROM `cart` LEFT JOIN users ON cart.user_id = users.id WHERE user_id = ? AND cart.status = ''");
									$count_cart_items->execute([$user_id]);
									$total_cart_counts = $count_cart_items->rowCount();

									$count_completed_items = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ? AND payment_status = 'completed'");
									$count_completed_items->execute([$user_id]);
									$total_completed_counts = $count_completed_items->rowCount();

									$count_total_spent = $conn->prepare("SELECT SUM(total_price) AS total_sold FROM orders WHERE user_id = ? AND payment_status = 'completed'");
									$count_total_spent->execute([$user_id]);
									$total_total_spent = $count_total_spent->rowCount();

									$select_profile = $conn->prepare("SELECT *,SUM(total_price) AS total_sold FROM `users` LEFT JOIN orders ON users.id = orders.user_id WHERE users.id = ? AND orders.payment_status = 'completed' ");
									$select_profile->execute([$user_id]);
									if($select_profile->rowCount() > 0){
									$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
								?>
							<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title"><?= $fetch_profile["user_name"]; ?></h4>
							</div>
							<div class="modal-body">
								<table class="single-service-table">
									<tr>
										<td>In Cart:</td>
										<td><?= $total_cart_counts; ?></td>
									</tr>
									<tr>
										<td>My Purchase:</td>
										<td><?= $total_completed_counts; ?></td>
									</tr>
									<tr>
										<td>Total Spent</td>
										<td>$<?= $fetch_profile["total_sold"]; ?></td>
									</tr>
								</table>
							</div>
							<div class="modal-footer">
								<!-- <button type="button" class="modal-btn" data-dismiss="modal">Update Profile</button> -->
								<a href="components/logout.php" class="modal-btn" onclick="return confirm('logout from the website?');">Logout</a> 
								<button type="button" class="modal-btn" data-dismiss="modal">Close</button>
							</div>
								<?php
									}else{
								?>
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
								</div>
									<div class="modal-body">
									<p>Please login or register first.</p>
									
								</div>
								<div class="modal-footer">
									<a href="login.php" class="modal-btn">Login</a>
									<button type="button" class="modal-btn" data-dismiss="modal">Close</button>
								</div>
								<?php
									}
								?> 
						</div>
						
						</div>
					</div>
			</div><!--/.container-->
		</nav><!--/nav-->
		<!-- End Navigation -->
	</div><!--/.header-area-->
	<div class="clearfix"></div>

</div><!-- /.top-area-->