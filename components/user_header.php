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

    <!-- top-area Start -->
    <div class="top-area">
        <div class="header-area">
            <!-- Start Navigation -->
            <nav class="navbar navbar-default bootsnav  navbar-sticky navbar-scrollspy"  data-minus-value-desktop="70" data-minus-value-mobile="55" data-speed="1000">

                <div class="container">

                    <!-- Start Header Navigation -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                            <i class="fa fa-bars"></i>
                        </button>
                        <a class="navbar-brand" href="index.html"><img src="assets/logo/realdeals-removebg-preview.png" alt=""></a>

                    </div><!--/.navbar-header-->
                    <!-- End Header Navigation -->

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse menu-ui-design" id="navbar-menu">
                        <ul class="nav navbar-nav navbar-right" data-in="fadeInDown" data-out="fadeOutUp">
                            <li class=" scroll active"><a href="#home">home</a></li>
                            <li class="scroll"><a href="#service">all products</a></li>
                            <li class="scroll"><a href="#featured-cars">orders</a></li>
                            <li class="scroll"><a href="#contact">contact</a></li>
                            <li class="scroll"><a href="#contact"><i class="fa-solid fa-magnifying-glass"></i></a></li>
                            <li class="scroll"><a href="#contact"><i class="fa-solid fa-cart-shopping"></i></a></li>
                            <li class="scroll"><a href="#contact"><i id="user-btn" class="fa-solid fa-user"></i></a></li>
                        </ul><!--/.nav -->
                    </div><!-- /.navbar-collapse -->
                    <div class="profile">
                        <?php          
                            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                            $select_profile->execute([$user_id]);
                            if($select_profile->rowCount() > 0){
                            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <p><?= $fetch_profile["name"]; ?></p>
                        <a href="update_user.php" class="btn">Update profile</a>
                        <div class="flex-btn">
                            <a href="user_login.php" class="option-btn">Register</a>
                            <a href="user_login.php" class="option-btn">Login</a>
                        </div>
                        <a href="components/user_logout.php" class="delete-btn" onclick="return confirm('logout from the website?');">Logout</a> 
                        <?php
                            }else{
                        ?>
                        <p>Please Login or Register first!</p>
                        <div class="flex-btn">
                            <a href="user_login.php" class="option-btn">Register</a>
                            <a href="user_login.php" class="option-btn">Login</a>
                        </div>
                        <?php
                            }
                        ?>      
                    </div>
                </div><!--/.container-->
            </nav><!--/nav-->
            <!-- End Navigation -->
        </div><!--/.header-area-->
        <div class="clearfix"></div>

    </div><!-- /.top-area-->
    <!-- top-area End -->