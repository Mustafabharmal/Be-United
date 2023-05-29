<!DOCTYPE html>
<html>
<head>
  <title>E-commerce Website</title>
  <link rel="stylesheet" href="https://cdn.tailwindcss.com/dist/tailwind.min.css">
  <link rel="icon" type="image/x-icon" href="images/CompanyLogoSVG.svg">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
  <!-- <link href="css/styles.css" rel="stylesheet" /> -->

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    .product-item {
  background-color: #fff;
  border: 1px solid #ddd;
  border-radius: 0.25rem;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
  margin-bottom: 2rem;
  overflow: hidden;
  padding: 1rem;
  position: relative;
  transition: box-shadow 0.3s ease-in-out;
}

.product-item:hover {
  box-shadow: 0 4px 8px rgba(0, 0, 0, 1);
}

.product-item img {
  height: 10rem;
  object-fit: cover;
  width: 100%;
}

.product-item h2 {
  font-family: "Amazon Ember", sans-serif;
  font-size: 1.25rem;
  font-weight: bold;
  margin: 0.5rem 0;
}

.product-item p {
  font-family: "Amazon Ember", sans-serif;
  font-size: 1rem;
  margin: 0.5rem 0;
}

.product-item .rating {
  align-items: center;
  display: flex;
  margin-bottom: 0.5rem;
}

.product-item .rating i {
  color: #FF9900;
  font-size: 1.25rem;
  margin-right: 0.25rem;
}

.product-item .prime-badge {
  background-color: #FF9900;
  color: #fff;
  font-family: "Amazon Ember", sans-serif;
  font-size: 0.75rem;
  font-weight: bold;
  padding: 0.25rem 0.5rem;
  position: absolute;
  right: 1rem;
  top: 1rem;
}

.product-item .buy-now {
  background-color: #FF9900;
  border: none;
  border-radius: 0.25rem;
  color: #fff;
  font-family: "Amazon Ember", sans-serif;
  font-size: 1rem;
  font-weight: bold;
  padding: 0.5rem 1rem;
  position: absolute;
  right: 1rem;
  bottom: 1rem;
}

.product-item .buy-now:hover {
  background-color: #FF8C00;
  cursor: pointer;
}
  </style>
</head>
<body class="bg-gray-200">

  <div class="p-4 sm:ml-64">

        <?php include('sidebar.php')?>
      <section class="bg-gray-50 dark:bg-gray-900">

      <header class="bg-gray-900 text-white">
        <div class="container mx-auto py-4">
          <h1 class="text-2xl font-bold">E-commerce Website</h1>
        </div>
      </header>
        <br>
        <div class="px-6">
          <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
          <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
      <h2 class="text-3xl md:text-4xl uppercase dark:text-gray-400 font-bold">Discover Our Gifts</h2>
      <a href="redemption_history.php" class="flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 18h9a2 2 0 002-2V8a2 2 0 00-2-2H9a2 2 0 00-2 2v8a2 2 0 002 2z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10"></path></svg>
        redemption_history
      </a>

      <a href="CustCart.php" class="flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 18h9a2 2 0 002-2V8a2 2 0 00-2-2H9a2 2 0 00-2 2v8a2 2 0 002 2z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10"></path></svg>
        View Cart
      </a>

    </div>
            <div class="product-item">
              <?php
                // Connect to database
                // session_start();
                $conn = mysqli_connect("localhost", "root", "", "be_united");
                

                // Check connection
                if (!$conn) {
                  die("Connection failed: " . mysqli_connect_error());
                }
                $id=$_SESSION['id'];
                echo $id.'\n';

                $sql = "SELECT available_points FROM Points WHERE U_id='$id'";
                $avpoints=0;
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result))
                    {
                        $avpoints = $row['available_points'];
                    }
                }
                echo $avpoints;
                // Group products by price range
                $price_ranges = array(
                  array("min" => 1, "max" => 1000),
                  array("min" => 1000, "max" => 10000),
                  array("min" => 10000, "max" => 100000),
                  array("min" => 100000, "max" => 1000000),
                  array("min" => 1000000, "max" => "")
                );

                foreach ($price_ranges as $range) {
                  // Display products within price range
                  if ($range['max'] !== '') {
                    $sql = "SELECT * FROM products WHERE price >= " . $range["min"] . " AND price < " . $range["max"];
                    $price_range = "" . $range["min"] . " - " . $range["max"];
                  } else {
                    $sql = "SELECT * FROM products WHERE price >= " . $range["min"];
                    $price_range = ">" . $range["min"];
                  }
                  $id=$_SESSION['id'];
                  
                  $result = mysqli_query($conn, $sql);

                  if (mysqli_num_rows($result) > 0) {
                    echo "<div class='mb-8'>";
                    echo "<div class='bg-gray-200 p-4 rounded-md mb-2'>";
                    echo "<h3 class='text-lg font-bold text-gray-800'>" . $price_range . "</h3>";
                    echo "</div>";
                    // echo "<p class='text-gray-600 mb-4'>" . mysqli_num_rows($result) . " items</p>";
                    echo "<div class='grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5'>";

                    while($row = mysqli_fetch_assoc($result)) {?>
                      <div class="product-item">
                        <!-- <div class="prime-badge">Prime</div> -->
                        <img src='../Admin/images/<?php echo $row['p_photo']; ?>' alt='<?php echo $row['p_name']; ?>'>
                        <h2><?php echo $row['p_name']; ?></h2>
                        <p><?php echo $row['description']; ?></p>
                        <div class="mt-4 flex items-center justify-between">
                          <h3 class="text-gray-700 font-medium"><?php echo $row['price']; ?></h3>
                          
                        </div>
                    </br>
                        <form method='post' action='CustCart.php'>
                            <input type='hidden' name='product_id' value='<?php echo $row['id']; ?>'>
                            <button type="submit" name="Addcart" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded">Add to Cart</button>
                          </form>
                      </div>
                    <?php
                    }

                    echo "</div>";
                    echo "</div>";

                  }
                }
                // Close connection
                mysqli_close($conn);
              ?>
            </div>
          <!-- </div> -->
        </div>
        <br>
      </section>
      <div>
        <?php include('../Footer.php')?>

        </div>
 </div>
</body>
</html>
