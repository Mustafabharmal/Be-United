<?php
session_start();

// Connect to database
$conn = mysqli_connect("localhost", "root", "", "project_dbms");

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Check if product has been added to cart
if (isset($_POST['add_to_cart'])) {
  $product_id = $_POST['product_id'];

  // Add product to cart
  if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id] += 1;
  } else {
    $_SESSION['cart'][$product_id] = 1;
  }
}

// Remove product from cart
if (isset($_GET['remove'])) {
  $product_id = $_GET['remove'];
  unset($_SESSION['cart'][$product_id]);
}

// Display cart items
$cart_items = array();

if (isset($_SESSION['cart'])) {
  foreach ($_SESSION['cart'] as $product_id => $quantity) {
    $sql = "SELECT * FROM products WHERE id = " . $product_id;
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      $cart_items[] = array(
        "product_id" => $product_id,
        "name" => $row['name'],
        "price" => $row['price'],
        "image" => $row['image']
      );
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cart</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://unpkg.com/tailwindcss@latest/dist/tailwind.min.css">
</head>
<body >


<header class="bg-gray-900 text-white">
    <div class="container mx-auto py-4">
      <h1 class="text-2xl font-bold">E-commerce Website</h1>
    </div>
  </header>
  <!-- <nav class="bg-gray-200">
    <div class="container mx-auto">
      <ul class="flex">
        <li class="mr-4"><a href="#" class="px-4 py-2 text-gray-700 font-semibold hover:text-gray-900">Home</a></li>
        <li><a href="Dealer.php" class="px-4 py-2 text-gray-700 font-semibold hover:text-gray-900">Product</a></li>
        <li><a href="CustCart.php" class="px-4 py-2 text-gray-700 font-semibold hover:text-gray-900">Cart</a></li>
        <li><a href="#" class="px-4 py-2 text-gray-700 font-semibold hover:text-gray-900">Login</a></li>
      </ul>
    </div>
  </nav> -->
  <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5">
  <div class="mx-auto  max-w-screen-xl px-4 lg:px-12">
</br>
    <!-- <div class="container mx-auto py-4 bg-gray-100 border border-gray-300 rounded-lg shadow-lg"> -->
    <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
    <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
  <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
    <a href="Dealer.php" class="px-4 py-2 flex items-center justify-center text-gray-700 font-semibold hover:text-gray-900 bg-gray-300 hover:bg-gray-400 rounded-md">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" viewBox="0 0 20 20" fill="currentColor">
        <path d="M16 2H4C2.9 2 2.01 2.9 2.01 4L2 16c0 1.1.89 2 1.99 2H16c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H4V8h12v8z"/>
      </svg>
      <span>Product</span>
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-2 -mr-1 transform rotate-180" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M6.707 5.293a1 1 0 0 1 0 1.414L3.414 10l3.293 3.293a1 1 0 0 1-1.414 1.414l-4-4a1 1 0 0 1 0-1.414l4-4a1 1 0 0 1 1.414 0z" clip-rule="evenodd" />
      </svg>
    </a>
  </div>
</div>



    <?php if (empty($cart_items)): ?>
      <p class="text-center text-gray-600">Your cart is empty.</p>
    <?php else: ?>
      <div class="mb-8">
        <!-- <div class="bg-gray-100 p-4 rounded-md mb-2"> -->
          <h3 class="text-lg font-bold  text-gray-500 dark:text-gray-400">Cart Items</h3>
        </div>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Image
                </th>
                <th scope="col" class="px-6 py-3">
                    Product
                </th>
                <th scope="col" class="px-6 py-3">
                    Price
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>

                <?php foreach ($cart_items as $cart_item): ?>
                  <!-- <tr> -->
                  <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <!-- <td></td> -->
                    <td class="w-32 p-4">
                    <?php echo "<div><img src='images/" . $cart_item['image'] . "' alt='" . $cart_item['name'] . "'></div>" ?>
                    </td>
                    <!-- <td></td> -->
                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                    <?php echo $cart_item['name']; ?></td>
                    <!-- <td></td> -->
                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white"><?php echo $cart_item['price']; ?></td>
                    <!-- <td><a href="">Remove</a></td> -->
                    <td class="px-6 py-4">
                    <a href="?remove=<?php echo $cart_item['product_id']; ?>" class="font-medium text-red-600 dark:text-red-500 hover:underline">Remove</a>
                </td>
                  </tr>
                <?php endforeach; ?>
               
        </tbody>
    </table>
</div>

      <!-- <div class="bg-gray-100 p-4 rounded-md">-->
        <div class="flex justify-between mb-3"> 
          <h3 class="text-lg font-bold text-gray-500 dark:text-gray-400 ">Total</h3>
          <p class="font-semibold text-gray-500 dark:text-gray-400"><?php echo array_reduce($cart_items, function ($accumulator, $cart_item) {
            return $accumulator + $cart_item['price'];
          }, 0); ?></p>
        </div>

        <div class="text-right">
          <a href="#" class="bg-blue-500 text-white px-4 py-2 rounded-md font-semibold">Checkout</a>
        </div>
        </br>
      <!-- </div> -->
    <?php endif; ?>
  </div>
        <!-- </div> -->
        </div>
        </div>
        </div>
</br>

  </section>
</br>
<!-- <footer> -->
    <?php include('Footer.php')?>
        <!-- </footer> -->
</body>
</html>