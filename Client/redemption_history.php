<!DOCTYPE html>
<html>
<head>
  <title>Redemption History</title>
  <meta charset="-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.1.2/tailwind.min.css">
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
</head>
<body class="bg-gray-100">
<div class="p-4 sm:ml-64">

<?php include('sidebar.php')?>
  <header class="bg-gray-900 text-white">
    <div class="container mx-auto py-4">
      <h1 class="text-2xl font-bold">Redemption History</h1>
    </div>
  </header>
<section class="bg-gray-50 dark:bg-gray-900">
<div class="flex flex-col items-center justify-center px-6 py-8  ">

<?php

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "be_united";
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Retrieve the redemption history from the database
$sql = "SELECT * FROM Redemption_history";
$result = mysqli_query($conn, $sql);

// Display the redemption history in a table
?>
<div class="overflow-x-auto">
  
  <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
      <tr class="text-center">
        <th scope="col" class="px-4 py-3">Product ID</th>
        <th scope="col" class="px-4 py-3">User ID</th>
        <th scope="col" class="px-4 py-3">Price</th>
        <th scope="col" class="px-4 py-3">Status</th>
        <th scope="col" class="px-4 py-3">Product Name</th>
        <th scope="col" class="px-4 py-3">Product Photo</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) { ?>
          <tr class="text-center border-b dark:border-gray-700">
            <td class="px-4 py-3"> <?php echo $row["P_id"]; ?></td>
            <td class="px-4 py-3">  <?php echo $row["U_id"]; ?></td>
            <td class="px-4 py-3">  <?php echo $row["Price"]; ?></td>
            <td class="px-4 py-3">  <?php echo $row["Status"]; ?></td>
            <td class="px-4 py-3">  <?php echo $row["P_name"]; ?></td>
            <td class="px-4 py-3"> <img src='data:image/jpeg;base64," . base64_encode(<?php $row['p_photo']; ?>) . "' width='100' height='100'></td>
          </tr>
        <?php }
      } else { ?>
            <tr class="text-center border-b dark:border-gray-700"> <td class="px-4 py-3" colspan='6'>No redemption history found</td></tr>
     <?php } 
     echo "</tbody></table>";

// Close the database connection
mysqli_close($conn);
?>
</div>
</section>
      
      <?php include('../Footer.php')?>
</div>
</div>
</body>
</html>
