<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
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

// Retrieve the user's available balance from the Balance table
// session_start();
// $_SESSION['user_id']="";

$user_id = $_SESSION['id'];
$sql = "SELECT Available_balance FROM Balance WHERE U_id=$user_id";
echo $user_id;
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$available_balance = $row['Available_balance'];

// Check if the form has been submitted
if (isset($_POST['submit'])) {
  // Retrieve the form data
  $quantity = $_POST['quantity'];
  $price = $_POST['price'];
  $total = $quantity * $price;

  // Check if the total price is less than the available balance
  if ($total <= $available_balance) {
    // Insert the sale data into the Sales table
    $fname = "arya"; // Replace with the user's first name
    $lname = "sharma"; // Replace with the user's last name
    $status = "pending";
    $timestamp = date("Y-m-d H:i:s");
    $O_id = "1009";
    $sql = "INSERT INTO Sales (U_id, Fname, Quantity, lname, price, O_id, status, timestamp) VALUES ($user_id, '$fname', $quantity, '$lname', $price, $O_id,'$status', '$timestamp')";
    $conn->query($sql);

    // Update the user's available balance in the Balance table
    $new_balance = $available_balance - $total;
    $sql = "UPDATE Balance SET Available_balance=$new_balance WHERE U_id=$user_id";
    echo "<script>alert('data updated successfully.');</script>";
    header('Location: index.php');

    exit();
  } else {
    // Redirect the user to an error page
    header("Location: pay2.php");
    exit();
  }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Sales Form</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.1.2/tailwind.min.css">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
<div class="p-4 sm:ml-64">
    <?php include('sidebar.php')?> 


  <div class="max-w-md mx-auto bg-white rounded-md shadow-md p-6">
    <h1 class="text-2xl font-bold text-center mb-6">Sales Form</h1>
    <form method="post">
      <table class="w-full">
        <tr>
          <th class="py-2">Quantity:</th>
          <td><input type="number" id="quantity" name="quantity" class="border-gray-300 rounded-md p-2 w-full" required></td>
        </tr>
        <tr>
          <th class="py-2">Price:</th>
          <td><input type="number" id="price" name="price" step="0.01" class="border-gray-300 rounded-md p-2 w-full" required></td>
        </tr>
        <tr>
          <th class="py-2">Total:</th>
          <td><input type="number" id="total" name="total" step="0.01" class="border-gray-300 rounded-md p-2-full" readonly></td>
        </tr>
        <tr>
          <td colspan="2"><input type="submit" name="submit" value="Submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full"></td>
        </tr>
      </table>
    </form>
  </div>
  <script>
    // Calculate the total price automatically
    var quantityInput = document.getElementById("quantity");
    var priceInput = document.getElementById("price");
    var totalInput = document.getElementById("total");
    quantityInput.addEventListener("input", updateTotal);
    priceInput.addEventListener("input", updateTotal);
    function updateTotal() {
      var quantity = quantityInput.value;
      var price = priceInput.value;
      var total = quantity * price;
      totalInput.value = total.toFixed(2);
    }
  </script>
  	<?php include_once('../footer.php');?>
 </div>
</body>

</html>