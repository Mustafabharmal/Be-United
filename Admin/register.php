<!DOCTYPE html>
<html>
<head>
  <title>User Registration Requests</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.1.2/tailwind.min.css">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-100">
<div class="p-4 sm:ml-64">
    <?php include('sidebar.php')?> 
<header class="bg-gray-900 text-white">
    <div class="container mx-auto py-4">
      <h1 class="text-2xl font-bold">Request User</h1>
    </div>
  </header>
  <!-- <div class="container mx-auto p-4"> -->
  <section class="bg-gray-50 dark:bg-gray-900">
<div class="flex flex-col items-center justify-center px-6 py-8  ">
  
  <div class="w-full bg-white rounded-lg shadow dark:border dark:bg-gray-800 dark:border-gray-700">
    
  <div class="container mx-auto p-4">
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

    // Retrieve all pending user registration requests
    $sql = "SELECT * FROM Login_form_user WHERE status = 'pending'";
    $result = mysqli_query($conn, $sql);
?>
  
    <!-- echo "<table class='table-auto w-full bg-white shadow-md rounded my-6'>";
    echo "<thead><tr><th class='px-4 py-2 bg-blue-500 text-white font-bold uppercase text-sm'>ID</th><th class='px-4 py-2 bg-blue-500 text-white font-bold uppercase text-sm'>Name</th><th class='px-4 py-2 bg-blue-500 text-white font-bold uppercase text-sm'>Email</th><th class='px-4 py-2 bg-blue-500 text-white font-bold uppercase text-sm'>Action</th></tr></thead>";
    echo "<tbody>"; -->
    <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr class="text-center">
                            <th scope="col" class="px-4 py-3">id</th>
                            <th scope="col" class="px-4 py-3">Name</th>
                            <th scope="col" class="px-4 py-3">Email</th>
                            <th scope="col" class="px-4 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
   <?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <tr class="text-center border-b dark:border-gray-700">
  <td class="px-4 py-3"><?php echo $row["U_id"]; ?></td>
  <td class="px-4 py-3"><?php echo $row["name"] ; ?></td>
  <td class="px-4 py-3"><?php echo $row["Email"]; ?></td>
  <td class="px-4 py-3">
  <form action='approve_user.php' method='POST'>
      <input type='hidden' name='id' value='<?php echo $row['U_id']; ?>'>
      <button type='submit' name='action' value='approve' class='bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2'>Approve</button>
      <button type='submit' name='action' value='decline' class='bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded'>Decline</button>
    </form>
  </td>
</tr>

    <?php }
    echo "</tbody></table>";

    // Close the database connection
    mysqli_close($conn);
    ?>
   </div>
  </div>
  <!-- </div> -->
  </section>
  <?php include('../footer.php')?>
</div>
</body>
</html>
