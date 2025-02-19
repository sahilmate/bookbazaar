<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
   session_start();
}
include 'config.php';

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

<header class="header">

   <div class="header-1">
      <div class="flex">
         <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-linkedin"></a>
         </div>
         <p>
            <?php if(isset($_SESSION['user_id'])): ?>
               Welcome, <a href="profile.php"><?php echo $_SESSION['user_name']; ?></a> | <a href="logout.php">Logout</a>
            <?php else: ?>
               new <a href="login.php">Login</a> | <a href="register.php">Register</a>
            <?php endif; ?>
         </p>
      </div>
   </div>

   <div class="header-2">
      <div class="flex">
         <a href="home.php" class="logo">BookBazaar!</a>

         <nav class="navbar">
            <a href="home.php">Home</a>
            <a href="about.php">About</a>
            <a href="shop.php">Shop</a>
            <a href="contact.php">Contact</a>
            <a href="orders.php">Orders</a>
            <a href="cart.php">Stripe Checkout</a>
         </nav>

         <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="search_page.php" class="fas fa-search"></a>
            <div id="user-btn" class="fas fa-user"></div>
            <?php
               if(isset($_SESSION['user_id'])){
                  $user_id = $_SESSION['user_id'];
                  $select_cart_number = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
                  $cart_rows_number = mysqli_num_rows($select_cart_number); 
               } else {
                  $cart_rows_number = 0;
               }
            ?>
            <a href="cart.php"> <i class="fas fa-shopping-cart"></i> <span>(<?php echo $cart_rows_number; ?>)</span> </a>
         </div>

         <?php if(isset($_SESSION['user_id'])): ?>
         <div class="user-box">
            <p>username : <span><?php echo $_SESSION['user_name']; ?></span></p>
            <p>email : <span><?php echo $_SESSION['user_email']; ?></span></p>
            <a href="logout.php" class="delete-btn">Logout</a>
         </div>
         <?php endif; ?>
      </div>
   </div>

</header>