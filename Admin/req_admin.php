<!DOCTYPE html>
<html>
<head>
  <title>Admin Registration Requests</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.1.2/tailwind.min.css">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="p-4 sm:ml-64">
    <?php include('sidebar.php')?> 
<header class="bg-gray-900 text-white">
    <div class="container mx-auto py-4">
      <h1 class="text-2xl font-bold">Request admin</h1>
    </div>
</header>
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

    // Check if the form has been submitted
    if (isset($_POST['submit'])) {
      // Loop through each admin registration request and update its status
      foreach ($_POST['status'] as $u_id => $status) {
        $sql = "UPDATE Login_form_admin SET status='$status' WHERE A_id=$u_id";
        $conn->query($sql);
      }
      // Display an alert message
      echo "<script>alert('Status updated successfully.');</script>";
    }

    // Retrieve all pending admin registration requests
    $sql = "SELECT * FROM Login_form_admin WHERE status = 'pending'";
    $result = mysqli_query($conn, $sql);
?>
    <!-- echo "";
    echo "<table class='table-auto w-full'>";
    echo "<thead><tr><th class='px-4 py-2 bg-blue-500 text-white'>ID</th><th class='px-4 py-2 bg-blue-500 text-white'>Name</th><th class='px-4 py-2 bg-blue-500 text-white'>Email</th><th class='px-4 py-2 bg-blue-500 text-white'>Status</th></tr></thead>";
    echo "<tbody>"; -->
    <div class="p-6 space-y-4 md:space-y-4 sm:p-8">
       
<form method='post'>
    <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr class="text-center">
                            <th scope="col" class="px-4 py-3">id</th>
                            <th scope="col" class="px-4 py-3">Name</th>
                            <th scope="col" class="px-4 py-3">Email</th>
                            <th scope="col" class="px-4 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
 


   <?php while ($row = mysqli_fetch_assoc($result)) {?>
    <tr class="text-center border-b dark:border-gray-700">
  <td class="px-4 py-3"><?php echo $row["A_id"]; ?></td>
  <td class="px-4 py-3"><?php echo $row["name"]; ?></td>
  <td class="px-4 py-3"><?php echo $row["Email"]; ?></td>
  <td class="px-4 py-3">
    <select name="status[<?php echo $row['A_id']; ?>]" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">
      <option value="pending" <?php echo ($row['status'] == 'pending' ? 'selected' : ''); ?>>Pending</option>
      <option value="approved" <?php echo ($row['status'] == 'approved' ? 'selected' : ''); ?>>Approved</option>
      <option value="rejected" <?php echo ($row['status'] == 'rejected' ? 'selected' : ''); ?>>Rejected</option>
    </select>
  </td>
</tr>

      <?php
    }
    echo "</tbody></table>";
    echo "<button type='submit' name='submit' class='bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4'>Update Status</button>";
    echo "</form>";

    // Close the database connection
    mysqli_close($conn);
    ?>
  </div>
  </div>
  </div>
  </section>
  <?php include_once('../footer.php');?>
  </div>
  
</body>
</html>
