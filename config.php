<?php

$conn = mysqli_connect('localhost','root','','shop_db') or die('connection failed');


require 'vendor/autoload.php'; // Make sure this path is correct

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$publishableKey = $_ENV['STRIPE_PUBLISHABLE_KEY'];
$secretKey = $_ENV['STRIPE_SECRET_KEY'];

\Stripe\Stripe::setApiKey($secretKey);
?>