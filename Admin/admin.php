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
  <header class="bg-gray-900 text-white">
    <div class="container mx-auto py-4">
      <h1 class="text-2xl font-bold">E-commerce Website - Admin Panel</h1>
    </div>
  </header>

  <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5">
  <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
        <!-- Start coding here -->
        <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
            <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                
            <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
    <form action='Addprod.php'>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md font-semibold flex items-center justify-center text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
            <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
            </svg>
            Add product
        </button>
    </form>
     <a href="adminEcomPrev.php" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 15 15" fill="currentColor">
    <path d="M15 2H5C3.9 2 3 2.9 3 4v10c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-1 10H6v-1h8v1zm0-3H6V8h8v1zm3-4H2V4c0-.6.4-1 1-1h12c.6 0 1 .4 1 1v1z"/>
  </svg>
  <span>Preview</span>
</a>


</div>

            </div>

  <div class="container mx-auto py-4">
    <?php

    // Check if product was deleted
    if (isset($_GET["delete_product"])) {
      // Connect to database
      $conn = mysqli_connect("localhost", "root", "", "be_united");
      // Check connection
      if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
      }
      // Get product ID
      $id = $_GET["id"];
      // Delete product from database
      $sql = "DELETE FROM products WHERE p_id='$id'";
      if (mysqli_query($conn, $sql)) {
        echo "<p>Product deleted successfully.</p>";
      } else {
        echo "Error deleting record: " . mysqli_error($conn);
      }
      // Close connection
      mysqli_close($conn);
    }
    
?>

<div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr class="text-center">
                            <th scope="col" class="px-4 py-3">#</th>
                            <th scope="col" class="px-4 py-3">Name</th>
                            <th scope="col" class="px-4 py-3">Description</th>
                            <th scope="col" class="px-4 py-3">Points</th>
                            <th scope="col" class="px-4 py-3">Image</th>
                            <th scope="col" class="px-4 py-3">Actions
                                <span class="sr-only"></span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
    <?php
    // Connect to database
    $conn = mysqli_connect("localhost", "root", "", "be_united");
    // Check connection
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }

    // Get products from database
    $sql = "SELECT * FROM products";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
      // Output data of each row
      while($row = mysqli_fetch_assoc($result)) {
        ?>
<tr  class="text-center" class="border-b dark:border-gray-700">
    <td class="px-4 py-3"><?php echo $row["P_id"];?></td>
    <td class="px-4 py-3"><?php echo $row["p_name"];?></td>
    <td class="px-4 py-3"><?php echo $row["description"];?></td>
    <td class="px-4 py-3"><?php echo $row["price"];?></td>
    <td class="border px-4 py-2 text-center"><?php echo "<img src='images/" . $row['p_photo'] . "' class='w-16'>"; ?></td>
    <td class="px-4 py-3 flex items-center justify-end">
  <div>
    <button id="<?php echo $row['P_id']; ?>-dropdown-button" data-dropdown-toggle="<?php echo $row['P_id']; ?>-dropdown" class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100" type="button">
    <!-- <svg class="w-5 h-5 mx-auto" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
    <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
</svg> -->
<svg width="14" height="14" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M11.2201 2.02495C10.8292 1.63482 10.196 1.63545 9.80585 2.02636C9.41572 2.41727 9.41635 3.05044 9.80726 3.44057L11.2201 2.02495ZM12.5572 6.18502C12.9481 6.57516 13.5813 6.57453 13.9714 6.18362C14.3615 5.79271 14.3609 5.15954 13.97 4.7694L12.5572 6.18502ZM11.6803 1.56839L12.3867 2.2762L12.3867 2.27619L11.6803 1.56839ZM14.4302 4.31284L15.1367 5.02065L15.1367 5.02064L14.4302 4.31284ZM3.72198 15V16C3.98686 16 4.24091 15.8949 4.42839 15.7078L3.72198 15ZM0.999756 15H-0.000244141C-0.000244141 15.5523 0.447471 16 0.999756 16L0.999756 15ZM0.999756 12.2279L0.293346 11.5201C0.105383 11.7077 -0.000244141 11.9624 -0.000244141 12.2279H0.999756ZM9.80726 3.44057L12.5572 6.18502L13.97 4.7694L11.2201 2.02495L9.80726 3.44057ZM12.3867 2.27619C12.7557 1.90794 13.3549 1.90794 13.7238 2.27619L15.1367 0.860593C13.9869 -0.286864 12.1236 -0.286864 10.9739 0.860593L12.3867 2.27619ZM13.7238 2.27619C14.0917 2.64337 14.0917 3.23787 13.7238 3.60504L15.1367 5.02064C16.2875 3.8721 16.2875 2.00913 15.1367 0.860593L13.7238 2.27619ZM13.7238 3.60504L3.01557 14.2922L4.42839 15.7078L15.1367 5.02065L13.7238 3.60504ZM3.72198 14H0.999756V16H3.72198V14ZM1.99976 15V12.2279H-0.000244141V15H1.99976ZM1.70617 12.9357L12.3867 2.2762L10.9739 0.86059L0.293346 11.5201L1.70617 12.9357Z" fill="#64748B"></path>
</svg>
    </button>
    </div>
    <div id="<?php echo $row['P_id']; ?>-dropdown" class="absolute right-0 z-10 hidden w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="<?php echo $row['P_id']; ?>-dropdown-button">
            <li>
                <a href='EditProd.php?edit_product=1&id=<?php echo $row['P_id']; ?>' class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
            </li>
        </ul>
        <div class="py-1">
            <a href='admin.php?delete_product=1&id=<?php echo $row['P_id']; ?>' class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete</a>
        </div>
    </div>


<script>
    document.getElementById("<?php echo $row['P_id']; ?>-dropdown-button").addEventListener("click", function() {
        var dropdown = document.getElementById("<?php echo $row['P_id']; ?>-dropdown");
        if (dropdown.classList.contains("hidden")) {
            dropdown.classList.remove("hidden");
        } else {
            dropdown.classList.add("hidden");
        }
    });

    document.addEventListener("click", function(event) {
        var dropdown = document.getElementById("<?php echo $row['P_id']; ?>-dropdown");
        var isClickInsideDropdown = dropdown.contains(event.target);
        var isClickInsideButton = document.getElementById("<?php echo $row['P_id']; ?>-dropdown-button").contains(event.target);

        if (!isClickInsideDropdown && !isClickInsideButton) {
            dropdown.classList.add("hidden");
        }
    });
</script>
</td>
</tr>
<?php
    }
  }
 // Close connection
 mysqli_close($conn);
?>
    </div>
    </div>
  </tbody>
</table>
</section>



<?php include('../footer.php')?>
</div>
</body>
</html>
