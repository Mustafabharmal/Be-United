<?php

    // Check if product was edited
    if (isset($_POST["edit_product"])) {
    //   // Connect to database
      $conn = mysqli_connect("localhost", "root", "", "be_united");
    //   // Check connection
      if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
      }
    //   // Get form data
    $id = $_POST["pid"];

      $name = $_POST["name"];
      $description = $_POST["description"];
      $price = $_POST["price"];
      // Update product in database
      $sql = "UPDATE products SET p_name='$name', description='$description', price=$price WHERE p_id='$id'";

      if (mysqli_query($conn, $sql)) {
        // echo "<p>Product updated successfully.</p>";
        header('Location: admin.php');
      } else {
        echo "Error updating record: " . mysqli_error($conn);
      }
      // Close connection
      mysqli_close($conn);
    }
   
// // Check if product was edited
if (isset($_GET["edit_product"])) {
  // Connect to database
  $conn = mysqli_connect("localhost", "root", "", "be_united");
  // Check connection
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  // Get product ID
  $id = $_GET["id"];

  // Get product from database
  $sql = "SELECT * FROM products WHERE p_id='$id'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);

//   // Close connection
 
?>
  <!DOCTYPE html>
  <html>
  <head>
    <title>E-commerce Website - Admin Panel</title>
    <link rel="stylesheet" href="https://cdn.tailwindcss.com/dist/tailwind.min.css">
        <link rel="icon"  type="image/x-icon" href="img\CompanyLogoSVG.svg">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

  </head>
  <body>


 <div class="p-4 sm:ml-64">

        <?php include('sidebar.php')?>

<section class="bg-gray-50 dark:bg-gray-900">
  <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
      <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
          <img class="w-40 h-40 mr-2" src="images\CompanyLogoSVG.svg" alt="logo">    
      </a>
      <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
          <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
              <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
              Edit Product
              </h1>
              <form class="space-y-4 md:space-y-6" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
              <input type="hidden" name="pid" value='<?php echo $row["P_id"]; ?>'>

           
                  <div>
                      <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name:</label>
                      <input type="text" name="name" value="<?php echo $row["p_name"]; ?>"  class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required="">
                  </div>
                  <div>
                      <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description:</label>
                      <textarea name="description" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="" ><?php echo $row["description"]; ?></textarea >
                  </div>
                  <div>
                      <label for="price"  class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Points:</label>
                      <input type="number" name="price" value="<?php echo $row["price"]; ?>" step="0.01" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                  </div>
                  <!-- <div>
                      <label for="image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Image:</label>
                      <input type="file" name="image" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                  </div> -->
                 
                  <!-- <div class="flex items-center justify-between">
                      <div class="flex items-start">
                          <div class="flex items-center h-5">
                            <input id="remember" aria-describedby="remember" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800" >
                          </div>
                          <div class="ml-3 text-sm">
                            <label for="remember" class="text-gray-500 dark:text-gray-300">Remember me</label>
                          </div>
                      </div>
                      <a href="#" class="text-sm font-medium text-blue-600 hover:underline dark:text-primary-500">Forgot password?</a>
                  </div> -->
                  <input type="submit"name="edit_product" value="Update Product" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                  <!-- <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                      Don’t have an account yet? <a href="#" class="font-medium text-blue-600 hover:underline dark:text-primary-500">Sign up</a>
                  </p> -->
              </form>
          </div>
      </div>
  </div>
</section>
<?php
  }
  // }
  mysqli_close($conn);
  ?>
<?php include('../footer.php')?>
</div>

