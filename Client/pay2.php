<!DOCTYPE html>
<html>
<head>
  <title>Add Amount to Balance</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.1.2/tailwind.min.css">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-100">
<div class="p-4 sm:ml-64">
    <?php include('sidebar.php')?> 


<header class="bg-gray-900 text-white">
    <div class="container mx-auto py-4">
      <h1 class="text-2xl font-bold">Add Amount</h1>
    </div>
</header>
<section class="bg-gray-50 dark:bg-gray-900">
    <div class="flex flex-col items-center justify-center px-6 py-8  ">
    <div class="w-full bg-white rounded-lg shadow dark:border dark:bg-gray-800 dark:border-gray-700">
    
    <div class="container mx-auto p-4">

        <?php
        // require_once("config.php");
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
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

        // Retrieve the current available balance from the database
        if (isset($_SESSION['id'])) {
        $uid = $_SESSION['id'];
        $sql = "SELECT Available_balance FROM Balance WHERE U_id = $uid";
        $result = mysqli_query($conn, $sql);
        $balance = 0;
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $balance = $row['Available_balance'];
        } else {
            echo "Error: " . mysqli_error($conn);
        }
        } else {
        echo "Error: U_id not set in session";
        }

        // Check if the form has been submitted
        if (isset($_POST['submit'])) {
        // Retrieve the entered amount
        $amount = $_POST['amount'];

        // Update the available balance in the database
        $new_balance = $balance + $amount;
        $sql = "UPDATE Balance SET Available_balance = $new_balance WHERE U_id = $uid";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            echo "Error: " . mysqli_error($conn);
        }

        // Display a success message
        echo "<h3 class='block mb-2 text-sm font-medium text-gray-900 dark:text-white'>Amount added successfully!</h3>";
        echo "<p class='block mb-2 text-sm font-medium text-gray-900 dark:text-white'>Amount added: $amount</p>";
        echo "<p class='block mb-2 text-sm font-medium text-gray-900 dark:text-white'>New balance: $new_balance</p>";

        // Close the database connection
        mysqli_close($conn);
        exit();
        }

        mysqli_close($conn);
        ?>

    <form method="post">
        <div class="p-7 space-y-4 md:space-y-4 sm:p-8">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Available Balance:</label>
                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-50 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value= "<?php echo $balance; ?>" readonly>
        </div>
        <div class="p-7 space-y-4 md:space-y-4 sm:p-8">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Enter Amount:</label>
            <input type="number" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-50 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="amount" required>
        </div>
        <button  type='submit' name='submit' class='bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4'>Add Amount</button>
    </form>
    </div>
  </div>
  </div>
</section>
<?php include_once('../footer.php');?>
 </div>
</body>
</html>
