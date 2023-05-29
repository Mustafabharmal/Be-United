<!DOCTYPE html>
<html>
<head>
  <title>Order Requests</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.1.2/tailwind.min.css">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-100">
<div class="p-4 sm:ml-64">
    <?php include('sidebar.php')?> 
<header class="bg-gray-900 text-white">
    <div class="container mx-auto py-4">
      <h1 class="text-2xl font-bold">Request Order</h1>
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


$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Check if the form has been submitted
if (isset($_POST['submit'])) {
  // Loop through each sale and update its status
  foreach ($_POST['status'] as $o_id => $status) {
    $sql = "UPDATE Sales SET status='$status' WHERE O_id=$o_id";
    $conn->query($sql);
  }
  // Display an alert message
  echo "<script>alert('Status updated successfully.');</script>";

}

// Retrieve the sales data from the database
$sql = "SELECT * FROM Sales";
$result = $conn->query($sql);?>
<form method='POST'>
<table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr class="text-center">
                            <th scope="col" class="px-4 py-3">U_id</th>
                            <th scope="col" class="px-4 py-3">First Name</th>
                            <th scope="col" class="px-4 py-3">Last Name</th>
                            <th scope="col" class="px-4 py-3">Quantity</th>
                            <th scope="col" class="px-4 py-3">Price</th>
                            <th scope="col" class="px-4 py-3">Order ID</th>
                            <th scope="col" class="px-4 py-3">Status ID</th>
                            <th scope="col" class="px-4 py-3">Date</th>
                        </tr>
                    </thead>
                    <tbody>
<?php while ($row = $result->fetch_assoc()) {?>
 <tr class="text-center border-b dark:border-gray-700">
  <td class="px-4 py-3"><?php echo $row["U_id"]; ?></td>
  <td class="px-4 py-3"><?php echo $row["Fname"]; ?></td>
  <td class="px-4 py-3"><?php echo $row["lname"]; ?></td>
  <td class="px-4 py-3"><?php echo $row["Quantity"]; ?></td>
  <td class="px-4 py-3"><?php echo $row["price"]; ?></td>
  <td class="px-4 py-3"><?php echo $row["O_id"]; ?></td>
  <td>
  <select name="status[<?php echo $row['O_id']; ?>]" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">
      <option value="pending" <?php echo ($row['status'] == 'pending' ? 'selected' : ''); ?>>Pending</option>
      <option value="approved" <?php echo ($row['status'] == 'approved' ? 'selected' : ''); ?>>Approved</option>
      <option value="rejected" <?php echo ($row['status'] == 'rejected' ? 'selected' : ''); ?>>Rejected</option>
    </select>
  </td>
  <td><?php echo $row['timestamp']; ?></td>
</tr>


 
<?php }
 echo "</tbody></table>";
 echo "<button type='submit' name='submit' class='bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4'>Update Status</button>";
 echo "</form>";

// Close the database connection
$conn->close();
?>
  </section>
<!-- </div> -->
<?php include_once('../footer.php');?>

<!-- </div> -->
<!-- </div> -->
<!-- </div> -->



</div>

</body>

</html>
