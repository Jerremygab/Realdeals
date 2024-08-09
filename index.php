<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

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

			<div class="container">
				<div class="welcome-hero-txt">
					<h2>Welcome to real deals</h2>
					<p>
						Get your desired computer parts in resonable price, play With Style. Best Gaming Experience. 
					</p>
					<button class="welcome-btn" onclick="window.location.href='#'">Shop now</button>
				</div>
			</div>

			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="model-search-content">
							<div class="content-grid">
								
									<div class="content-items">
										<a href="#">
											<img src="assets/images/welcome-hero/components.jpg" alt="">
										</a>
										<h2>PC <br>Compontents</h2>
									</div>
								<a href="#">
									<div class="content-items">
										<img src="assets/images/welcome-hero/peripherals.jpg" alt="">
										<h2>PC <br>Peripherals</h2>
									</div>
								</a>
								<a href="#">
									<div class="content-items">
										<img src="assets/images/welcome-hero/printers.jpg" alt="">
										<h2>Printer and <br>Scanners</h2>
									</div>
								</a>
								<a href="#">
									<div class="content-items">
										<img src="assets/images/welcome-hero/console.jpg" alt="">
										<h2>Gaming <br>Consoles</h2>
									</div>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>

		</section><!--/.welcome-hero-->
		<!--welcome-hero end -->

		<!--service start -->
		<section id="service" class="service">
			<div class="container">
				<div class="service-content">
					<div class="row">
						<div class="col-md-4 col-sm-6">
							<div class="single-service-item">
								<div class="single-service-icon">
									<i class="fa-solid fa-computer"></i>
								</div>
								<h2><a href="#">largest PC dealership</a></h2>
								<p>
									Lorem ipsum dolor sit amet consectetur, adipisicing elit. Iusto, sit! Aliquid corrupti id veritatis quidem.
								</p>
							</div>
						</div>
						<div class="col-md-4 col-sm-6">
							<div class="single-service-item">
								<div class="single-service-icon">
									<i class="fa-solid fa-gears"></i>
								</div>
								<h2><a href="#">repair warranty</a></h2>
								<p>
									Lorem ipsum dolor sit amet consectetur, adipisicing elit. Iusto, sit! Aliquid corrupti id veritatis quidem.
								</p>
							</div>
						</div>
						<div class="col-md-4 col-sm-6">
							<div class="single-service-item">
								<div class="single-service-icon">
									<i class="fa-solid fa-laptop-file"></i>
								</div>
								<h2><a href="#">insurance support</a></h2>
								<p>
									Lorem ipsum dolor sit amet consectetur, adipisicing elit. Iusto, sit! Aliquid corrupti id veritatis quidem.
								</p>
							</div>
						</div>
					</div>
				</div>
			</div><!--/.container-->

		</section><!--/.service-->
		<!--service end-->

		<!--new-cars start -->
		<section id="new-cars" class="new-cars">
			<div class="container">
				<div class="section-header">
					<p>checkout <span>the</span> latest release</p>
					<h2>newest</h2>
				</div><!--/.section-header-->
				<div class="new-cars-content">
					<div class="owl-carousel owl-theme" id="new-cars-carousel">
						<div class="new-cars-item">
							<div class="single-new-cars-item">
								<div class="row">
									<div class="col-md-7 col-sm-12">
										<div class="new-cars-img">
											<img src="assets/images/new/i9-14.png" alt="img"/>
										</div><!--/.new-cars-img-->
									</div>
									<div class="col-md-5 col-sm-12">
										<div class="new-cars-txt">
											 
											<h2><a href="#">Intel Core <span> i9-14900HX</span></a></h2>
											<p>
												This is a newly released CPU that contains 24 Cores and 32 Threads. The Intel Core i9-14900HX also has great single threaded performance that will serve well in games.
											</p>
											<p class="new-cars-para2">
												Is this CPU Good for Gaming? Yes, this is a high end chip that would be great for gaming.
											</p>
											<button class="welcome-btn new-cars-btn" onclick="window.location.href='#'">
												buy now
											</button>
										</div><!--/.new-cars-txt-->	
									</div><!--/.col-->
								</div><!--/.row-->
							</div><!--/.single-new-cars-item-->
						</div><!--/.new-cars-item-->
						<div class="new-cars-item">
							<div class="single-new-cars-item">
								<div class="row">
									<div class="col-md-7 col-sm-12">
										<div class="new-cars-img">
											<img src="assets/images/new/4070.png" alt="img"/>
										</div><!--/.new-cars-img-->
									</div>
									<div class="col-md-5 col-sm-12">
										<div class="new-cars-txt">
											<h2><a href="#">GeForce RTX 4070 Super</a></h2>
											<p>
												The RTX 4070 was already a great graphics card, but Nvidia made it even better with a Super refresh. On top of that the RTX 4070 Super has enough power to press up to 4K. 
											<p class="new-cars-para2">
												Midrange to high-end gamers looking for a GPU that can handle the most demanding games at 1440p.
											</p>
											<button class="welcome-btn new-cars-btn" onclick="window.location.href='#'">
												buy now
											</button>
										</div><!--/.new-cars-txt-->	
									</div><!--/.col-->
								</div><!--/.row-->	
							</div><!--/.single-new-cars-item-->
						</div><!--/.new-cars-item-->
						<div class="new-cars-item">
							<div class="single-new-cars-item">
								<div class="row">
									<div class="col-md-7 col-sm-12">
										<div class="new-cars-img">
											<img src="assets/images/new/nzxt.png" alt="img"/>
										</div><!--/.new-cars-img-->
									</div>
									<div class="col-md-5 col-sm-12">
										<div class="new-cars-txt">
											<h2><a href="#">NZXT H9 Flow</a></h2>
											<p>
												The H9 Flow is designed to cool off powerful GPUs with its expansive thermal capabilities, featuring the capacity for ten fans and numerous 360mm radiator mounting options.
											</p>
											<p class="new-cars-para2">
												Offering room for the latest NVIDIA 40 Series and AMD 7000 Series cards.
											</p>
											<button class="welcome-btn new-cars-btn" onclick="window.location.href='#'">
												buy now
											</button>
										</div><!--/.new-cars-txt-->	
									</div><!--/.col-->
								</div><!--/.row-->
							</div><!--/.single-new-cars-item-->
						</div><!--/.new-cars-item-->
					</div><!--/#new-cars-carousel-->
				</div><!--/.new-cars-content-->
			</div><!--/.container-->

		</section><!--/.new-cars-->
		<!--new-cars end -->

		<!--featured-cars start -->
		<section id="featured-cars" class="featured-cars">
			<div class="container">
				<div class="section-header">
					<p>checkout <span>the</span> featured items</p>
					<h2>featured</h2>
				</div><!--/.section-header-->
				<div class="featured-cars-content">
					<div class="row">
						<div class="col-lg-3 col-md-4 col-sm-6">
							<div class="single-featured-cars">
								<div class="featured-img-box">
									<div class="featured-cars-img">
										<img src="assets/images/featured/pro-x-superlight.jpg" alt="">
									</div>
								</div>
								<div class="featured-cars-txt">
									<h2><a href="#">Logitech G Pro X </a></h2>
									<h3>$129.99</h3>
									<p>
										Less than 63 grams. Advanced low-latency LIGHTSPEED wireless. Sub-micron precision with HERO 25K sensor.
									</p>
									<div class="cart-btn">
										<p>View More</p>
										<i class="fa-solid fa-cart-shopping cart"></i>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-4 col-sm-6">
							<div class="single-featured-cars">
								<div class="featured-img-box">
									<div class="featured-cars-img">
										<img src="assets/images/featured/pro-x-superlight.jpg" alt="">
									</div>
								</div>
								<div class="featured-cars-txt">
									<h2><a href="#">Logitech G Pro X </a></h2>
									<h3>$129.99</h3>
									<p>
										Less than 63 grams. Advanced low-latency LIGHTSPEED wireless. Sub-micron precision with HERO 25K sensor.
									</p>
									<div class="cart-btn">
										<p>View More</p>
										<i class="fa-solid fa-cart-shopping cart"></i>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-4 col-sm-6">
							<div class="single-featured-cars">
								<div class="featured-img-box">
									<div class="featured-cars-img">
										<img src="assets/images/featured/pro-x-superlight.jpg" alt="">
									</div>
								</div>
								<div class="featured-cars-txt">
									<h2><a href="#">Logitech G Pro X </a></h2>
									<h3>$129.99</h3>
									<p>
										Less than 63 grams. Advanced low-latency LIGHTSPEED wireless. Sub-micron precision with HERO 25K sensor.
									</p>
									<div class="cart-btn">
										<p>View More</p>
										<i class="fa-solid fa-cart-shopping cart"></i>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-4 col-sm-6">
							<div class="single-featured-cars">
								<div class="featured-img-box">
									<div class="featured-cars-img">
										<img src="assets/images/featured/pro-x-superlight.jpg" alt="">
									</div>
								</div>
								<div class="featured-cars-txt">
									<h2><a href="#">Logitech G Pro X </a></h2>
									<h3>$129.99</h3>
									<p>
										Less than 63 grams. Advanced low-latency LIGHTSPEED wireless. Sub-micron precision with HERO 25K sensor.
									</p>
									<div class="cart-btn">
										<p>View More</p>
										<i class="fa-solid fa-cart-shopping cart"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div><!--/.container-->

		</section><!--/.featured-cars-->
		<!--featured-cars end -->

		<!-- clients-say strat -->
		<section id="clients-say"  class="clients-say">
			<div class="container">
				<div class="section-header">
					<h2>what our clients say</h2>
				</div><!--/.section-header-->
				<div class="row">
					<div class="owl-carousel testimonial-carousel">
						<div class="col-sm-3 col-xs-12">
							<div class="single-testimonial-box">
								<div class="testimonial-description">
									<div class="testimonial-info">
										<div class="testimonial-img">
											<img src="assets/images/clients/c1.png" alt="image of clients person" />
										</div><!--/.testimonial-img-->
									</div><!--/.testimonial-info-->
									<div class="testimonial-comment">
										<p>
											Lorem ipsum dolor sit amet consectetur adipisicing elit. Alias exercitationem eligendi mollitia accusantium. Sit iusto, possimus in porro aliquid eveniet!
										</p>
									</div><!--/.testimonial-comment-->
									<div class="testimonial-person">
										<h2><a href="#">tomas lili</a></h2>
										<!-- <h4>new york</h4> -->
									</div><!--/.testimonial-person-->
								</div><!--/.testimonial-description-->
							</div><!--/.single-testimonial-box-->
						</div><!--/.col-->
						<div class="col-sm-3 col-xs-12">
							<div class="single-testimonial-box">
								<div class="testimonial-description">
									<div class="testimonial-info">
										<div class="testimonial-img">
											<img src="assets/images/clients/c2.png" alt="image of clients person" />
										</div><!--/.testimonial-img-->
									</div><!--/.testimonial-info-->
									<div class="testimonial-comment">
										<p>
											Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem sint exercitationem eveniet harum modi vero cupiditate natus recusandae ducimus nihil.
										</p>
									</div><!--/.testimonial-comment-->
									<div class="testimonial-person">
										<h2><a href="#">romi rain</a></h2>
										<!-- <h4>london</h4> -->
									</div><!--/.testimonial-person-->
								</div><!--/.testimonial-description-->
							</div><!--/.single-testimonial-box-->
						</div><!--/.col-->
						<div class="col-sm-3 col-xs-12">
							<div class="single-testimonial-box">
								<div class="testimonial-description">
									<div class="testimonial-info">
										<div class="testimonial-img">
											<img src="assets/images/clients/c3.png" alt="image of clients person" />
										</div><!--/.testimonial-img-->
									</div><!--/.testimonial-info-->
									<div class="testimonial-comment">
										<p>
											Lorem ipsum dolor sit amet consectetur adipisicing elit. Ex alias a consectetur ipsa quaerat fugiat obcaecati doloremque sint saepe quos?
										</p>
									</div><!--/.testimonial-comment-->
									<div class="testimonial-person">
										<h2><a href="#">john doe</a></h2>
										<!-- <h4>washington</h4> -->
									</div><!--/.testimonial-person-->
								</div><!--/.testimonial-description-->
							</div><!--/.single-testimonial-box-->
						</div><!--/.col-->
					</div><!--/.testimonial-carousel-->
				</div><!--/.row-->
			</div><!--/.container-->

		</section><!--/.clients-say-->	
		<!-- clients-say end -->

		<!--brand strat -->
		<section id="brand"  class="brand">
			<div class="container">
				<div class="brand-area">
					<div class="owl-carousel owl-theme brand-item">
						<div class="item">
							<a href="#">
								<img src="assets/images/brand/amd.png" alt="brand-image" />
							</a>
						</div><!--/.item-->
						<div class="item">
							<a href="#">
								<img src="assets/images/brand/intel.png" alt="brand-image" />
							</a>
						</div><!--/.item-->
						<div class="item">
							<a href="#">
								<img src="assets/images/brand/rtx.png" alt="brand-image" />
							</a>
						</div><!--/.item-->
						<div class="item">
							<a href="#">
								<img src="assets/images/brand/asus.png" alt="brand-image" />
							</a>
						</div><!--/.item-->
						<div class="item">
							<a href="#">
								<img src="assets/images/brand/logitech.png" alt="brand-image" />
							</a>
						</div><!--/.item-->
						<div class="item">
							<a href="#">
								<img src="assets/images/brand/playstation.png" alt="brand-image" />
							</a>
						</div><!--/.item-->
						<div class="item">
							<a href="#">
								<img src="assets/images/brand/xbox.png" alt="brand-image" />
							</a>
						</div><!--/.item-->
					</div><!--/.owl-carousel-->
				</div><!--/.clients-area-->

			</div><!--/.container-->

		</section><!--/brand-->	
		<!--brand end -->

		<!--blog start -->
		<section id="blog" class="blog"></section><!--/.blog-->
		<!--blog end -->

		<!--contact start-->
		<?php include 'components/footer.php'; ?>
		<!--contact end-->
		
		<?php include 'components/scripts.php'; ?>
        
    </body>
	
</html>