<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

// Calculate the total amount from the cart
$cart_total = 0;
$cart_products = array();
$cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
if(mysqli_num_rows($cart_query) > 0){
   while($cart_item = mysqli_fetch_assoc($cart_query)){
      $sub_total = ($cart_item['price'] * $cart_item['quantity']);
      $cart_total += $sub_total;
      $cart_products[] = $cart_item['name'].' ('.$cart_item['quantity'].')';
   }
}

if(isset($_POST['stripeToken'])) {
    $token = $_POST['stripeToken'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $method = 'Stripe';
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $total_products = mysqli_real_escape_string($conn, implode(', ', $cart_products));
    $amount = $cart_total;

    try {
        $charge = \Stripe\Charge::create([
            'amount' => $amount * 100, // Amount in cents
            'currency' => 'usd',
            'description' => 'Book Purchase',
            'source' => $token,
            'receipt_email' => $email,
        ]);

        // Insert order details into the database
        $placed_on = date('d-M-Y');
        $order_query = "INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on, payment_status) VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$amount', '$placed_on', 'completed')";
        if (mysqli_query($conn, $order_query)) {
            // Clear the cart
            mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
            $message[] = 'Payment successful! Order placed.';
        } else {
            $message[] = 'Order placement failed! ' . mysqli_error($conn);
        }
    } catch (\Stripe\Exception\CardException $e) {
        $message[] = 'Payment failed! ' . $e->getError()->message;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stripe Checkout</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="heading">
    <h3>Checkout</h3>
    <p> <a href="home.php">Home</a> / Checkout </p>
</div>

<section class="checkout">
    <form action="" method="post" id="payment-form">
        <h3>Place your order</h3>
        <div class="flex">
            <div class="inputBox">
                <span>Your Name :</span>
                <input type="text" name="name" required placeholder="Enter your name">
            </div>
            <div class="inputBox">
                <span>Your Email :</span>
                <input type="email" name="email" required placeholder="Enter your email">
            </div>
            <div class="inputBox">
                <span>Your Number :</span>
                <input type="text" name="number" required placeholder="Enter your number">
            </div>
            <div class="inputBox">
                <span>Your Address :</span>
                <input type="text" name="address" required placeholder="Enter your address">
            </div>
            <div class="inputBox">
                <span>Total Amount :</span>
                <input type="text" name="amount" value="$<?php echo $cart_total; ?>" readonly>
            </div>
        </div>
        <div id="card-element">
            <!-- A Stripe Element will be inserted here. -->
        </div>
        <!-- Used to display form errors. -->
        <div id="card-errors" role="alert"></div>
        <input type="hidden" name="stripeToken" id="stripeToken">
        <button type="submit" class="btn">Pay with Stripe</button>
    </form>
</section>

<?php include 'footer.php'; ?>

<script src="https://js.stripe.com/v3/"></script>
<script>
    var stripe = Stripe('<?php echo $_ENV['STRIPE_PUBLISHABLE_KEY']; ?>'); // Use the actual publishable key from the .env file
    var elements = stripe.elements();
    var card = elements.create('card');
    card.mount('#card-element');

    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function(event) {
        event.preventDefault();

        stripe.createToken(card).then(function(result) {
            if (result.error) {
                // Inform the user if there was an error
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
            } else {
                // Send the token to your server
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', result.token.id);
                form.appendChild(hiddenInput);

                // Submit the form
                form.submit();
            }
        });
    });
</script>

</body>
</html>