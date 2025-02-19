# BookBazaar: Online Book Store

An online book store built with **PHP**, **MySQL**, **HTML/CSS**, **JavaScript**, and **Stripe** for payment processing. This project allows users to browse, search, and purchase books, while administrators can manage products, orders, and user data.  

## Table of Contents

1. [Description](#description)  
2. [Features](#features)  
3. [Requirements](#requirements)  
4. [Installation](#installation)  
5. [Configuration](#configuration)  
6. [Usage & Navigation](#usage--navigation)  
7. [Screenshots](#screenshots)  
8. [Stripe Test & Verification](#stripe-test--verification)  
9. [Contributing](#contributing)  
10. [License](#license)

---

## Description

**BookBazaar** provides a simple and intuitive way for customers to explore a curated selection of books, add them to a cart, and proceed to checkout using Stripe for secure payments. Administrators have a dedicated panel to add/edit/delete books, manage orders, and view messages from users.

---

## Features

- **User Registration & Login**  
  - Standard account creation and login process.
- **Product Browsing & Search**  
  - Browse a list of books with images, descriptions, and prices.
- **Shopping Cart**  
  - Add items to the cart, update quantities, and remove items.
- **Secure Checkout**  
  - Integrated with Stripe for payment.
- **Admin Panel**  
  - Manage books, orders, users, and messages.
- **Responsive UI**  
  - A clean layout that adjusts to different screen sizes.

---

## Requirements

1. **PHP 7.4+**  
2. **MySQL** (e.g., via XAMPP or WAMP)  
3. **Composer**  
4. **Stripe Account** (for test and/or production keys)

### `requirements.txt`
While PHP projects typically use **Composer** instead of `requirements.txt`, here’s a minimal list of what you’ll need:

```
php >= 7.4
composer
vlucas/phpdotenv
stripe/stripe-php
```

*(Install actual dependencies via Composer — see [Installation](#installation) below.)*

---

## Installation

Follow these steps to get the project running on your local machine:

1. **Clone the Repository**  
   ```bash
   git clone https://github.com/sahilmate/bookbazaar.git
   cd bookbazaar-main
   ```

2. **Move into `htdocs` (XAMPP) or `www` (WAMP)**  
   - If using XAMPP on Windows, place the entire project folder inside `C:\xampp\htdocs\`.  
   - If using MAMP on macOS, place it inside `Applications/MAMP/htdocs/`.  
   - If using WAMP, place it inside the `www` folder.

3. **Install Composer Dependencies** (or [install Composer](https://getcomposer.org/Composer-Setup.exe)) 
   ```bash
   composer install
   ```
   *Alternatively try*
   ```bash
   composer require stripe/stripe-php
   composer require vlucas/phpdotenv
   ```
   This will create a `vendor/` folder containing all necessary libraries (e.g., **stripe-php**, **vlucas/phpdotenv**).

5. **Import the Database**  
   - Open [phpMyAdmin](http://localhost/phpmyadmin/) in your browser.
   - Create a new database, e.g. `shop_db`.
   - Import the SQL file (e.g., `shop_db.sql`) into that database which is present in the repository.

6. **Configure `.env`**  
   - Create a new file named `.env` in the root of your project (same level as `config.php`, etc.).
   - Add the following lines (using your own Stripe keys):
     ```env
     STRIPE_PUBLISHABLE_KEY=pk_test_1234567890
     STRIPE_SECRET_KEY=sk_test_1234567890
     ```
   - If you don’t have a `.env` file, copy the example below:
     ```env
     # .env file
     STRIPE_PUBLISHABLE_KEY=pk_test_yourPublishableKey
     STRIPE_SECRET_KEY=sk_test_yourSecretKey
     ```

7. **Update `config.php`** (if needed)  
   ```php
   <?php
   // Example config file
   $conn = mysqli_connect('localhost','root','','shop_db') or die('connection failed');

   // Load Composer autoload
   require 'vendor/autoload.php';

   // Load .env variables
   $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
   $dotenv->load();

   // Stripe Keys from .env
   $publishableKey = $_ENV['STRIPE_PUBLISHABLE_KEY'];
   $secretKey = $_ENV['STRIPE_SECRET_KEY'];

   // Initialize Stripe
   \Stripe\Stripe::setApiKey($secretKey);
   ?>
   ```

8. **Run the Project**  
   - Start Apache and MySQL from your XAMPP/WAMP control panel.  
   - In your browser, go to `http://localhost/bookbazaar-main/home.php`.

---

## Configuration

### `.env` File

Your `.env` file should include at least the Stripe keys:

```env
STRIPE_PUBLISHABLE_KEY=pk_test_XXXXXXX
STRIPE_SECRET_KEY=sk_test_XXXXXXX
```

- For **production**, replace with your **live** Stripe keys (and enable SSL).

---

## Usage & Navigation

1. **Home Page**  
   - Displays featured books.
   - Users can view details, add to cart, or proceed to checkout.

2. **User Accounts**  
   - **Default User**:  
     - **Email**: `abc@gmail.com`  
     - **Password**: `pass`  
   - You can log in as this user to simulate a typical shopping experience.

3. **Admin Accounts**  
   - **Default Admin**:  
     - **Email**: `xyz@gmail.com`  
     - **Password**: `pass`  
   - Log in as this admin to manage products, orders, users, and more.

4. **Cart & Checkout**  
   - After adding items to the cart, users can checkout and pay with **Stripe**.

---

## Screenshots

*(Below are placeholders. Replace with actual screenshot paths.)*
```
I will make a Medium post with all the screenshots and procedures as well, hence leaving this section blank right now.
```
<!--
| Home Page                           | Admin Dashboard                     |
|-------------------------------------|-------------------------------------|
| ![Home Page](screenshots/home.png)  | ![Admin Dashboard](screenshots/admin.png) |
-->
---

## Stripe Test & Verification

1. **Test Card Numbers**  
   - Use `4242 4242 4242 4242` with any future expiration date (e.g., `12/34`) and any CVC (e.g., `123`) for a **successful** test payment.  
   - [See Stripe Docs](https://stripe.com/docs/testing) for additional test cards (e.g., for declined payments).

2. **Verify in Stripe Dashboard**  
   - Log in to [Stripe Dashboard](https://dashboard.stripe.com/).  
   - Switch to **Test Mode** (toggle in the left menu).  
   - Go to [Integrations](dashboard.stripe.com/settings/integration).
   - Toggle ON `Enable card data collection with a publishable key.`
   - Give a correct Shop Name.
   - Go to [Balance](https://dashboard.stripe.com/test/balance/all-activity) to ensure payments are getting logged.

---

## Contributing

Contributions are welcome! Here’s how you can help:

1. **Fork** the project repository.  
2. **Create a new branch** for your feature/fix:
   ```bash
   git checkout -b feature/my-feature
   ```
3. **Commit your changes** with clear commit messages:
   ```bash
   git commit -m "Add new feature"
   ```
4. **Push to your fork**:
   ```bash
   git push origin feature/my-feature
   ```
5. **Create a Pull Request** on GitHub.  
   - Include a detailed description of your changes.

We’ll review your PR and merge if everything looks good!

---

## License

This project is licensed under the [MIT License](LICENSE). You’re free to modify and distribute it, but please give credit to the original author.  

---

### Questions or Feedback?

Feel free to open an issue or contact the maintainers. Happy coding!



