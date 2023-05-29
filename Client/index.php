<?php
// Start or resume the session
// session_start();
// $_SESSION['u_id']=2;
// Establishing a connection to the MySQL database
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$servername = "localhost";
$username = "root";
$password = '';
$dbname = "be_united";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$uId = $_SESSION['id'];

// Fetch the sales of the specific user
$specificUserSalesSql = "SELECT SUM(Quantity * price) AS specificUserSales FROM Sales WHERE U_id = '$uId'";
$specificUserSalesResult = $conn->query($specificUserSalesSql);
$specificUserSales = $specificUserSalesResult->fetch_assoc()['specificUserSales'];

// Fetch the total sales
$totalSalesSql = "SELECT SUM(Quantity * price) AS totalSales FROM Sales";
$totalSalesResult = $conn->query($totalSalesSql);
$totalSaless = $totalSalesResult->fetch_assoc()['totalSales'];

// Task 1: Retrieve available points of the specific user
if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];
    $sql = "SELECT available_points FROM Points WHERE U_id = $userId";
    $result = $conn->query($sql);
    $availablePoints = 0;
    $availableBalance = 0;
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $availablePoints = $row["available_points"];
        //echo "Available Points: " . $availablePoints;
    } else {
       // echo "No points found for the specified user.";
    }
} else {
    //echo "User ID not found in session.";
}

// Task 2: Retrieve available balance of the specific user
if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];
    $sql = "SELECT Available_balance FROM Balance WHERE U_id = $userId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $availableBalance = $row["Available_balance"];
        //echo "Available Balance: " . $availableBalance;
    } else {
       // echo "No balance found for the specified user.";
    }
} else {
    //echo "User ID not found in session.";
}

// Task 3: Calculate total sales done by the specific dealer
if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];
    $sql = "SELECT SUM(Quantity * price) AS totalSales FROM Sales WHERE U_id = $userId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $totalSales = $row["totalSales"];
        //echo "Total Sales: " . $totalSales;
    } else {
       // echo "No sales found for the specified dealer.";
    }
} else {
   // echo "User ID not found in session.";
}

// Task 4: Rank of the specific dealer based on sales
if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];
    $sql = "SELECT U_id, SUM(Quantity * price) AS totalSales FROM Sales GROUP BY U_id ORDER BY totalSales DESC";
    $result = $conn->query($sql);
    $rank = 1;
    while ($row = $result->fetch_assoc()) {
        if ($row["U_id"] == $userId) {
           // echo "Rank: " . $rank;
            break;
        }
        $rank++;
    }
} else {
   // echo "User ID not found in session.";
}
$data = [
    [
        'label' => 'Specific User Sales',
        'value' => $specificUserSales,
        'highlight' => true,
    ],
    [
        'label' => 'Total Sales',
        'value' => $totalSaless - $specificUserSales,
    ],
];
echo $totalSales.$specificUserSales;
// Convert PHP array to JSON for JavaScript usage
$jsonData = json_encode($data);

// Closing the database connection
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Client Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">
<div class="p-4 sm:ml-64">
    <?php include('sidebar.php')?> 

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
                <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

               
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Available Points</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $availablePoints ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Available Balance
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $availableBalance?></div>
                                    </div>
                                    <div class="col-auto">
                                    <i class="fa fa-users fa-2x" aria-hidden="true"></i>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>


                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Sales
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $totalSales.' Rs'?></div>
                                                </div>
                                                <div class="col">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Rank</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $rank?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Sales Overview</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            
                                        </a>
                                        
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="myAreaChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pie Chart -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Dealer's Sales over Total Sales</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            
                                        </a>
                                       
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas id="myPieChart"></canvas>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Content Column -->
                        <div class="col-lg-6 mb-4">

                            

                        

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
        
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>
    
    

    <!-- Page level custom scripts -->

<!--  Area chart -->

    <script>
        // Set new default font family and font color to mimic Bootstrap's default styling
        Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#858796';
        const dates = <?php echo json_encode($dates); ?>;
        const sales = <?php echo json_encode($sales); ?>;
        console.log(dates);
        console.log(sales);
// Area Chart Example
var ctx = document.getElementById("myAreaChart");
var myLineChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: dates,
    datasets: [{
      label: "Sales",
      data: sales,
      lineTension: 0.3,
      backgroundColor: "rgba(78, 115, 223, 0.05)",
      borderColor: "rgba(78, 115, 223, 1)",
      pointRadius: 3,
      pointBackgroundColor: "rgba(78, 115, 223, 1)",
      pointBorderColor: "rgba(78, 115, 223, 1)",
      pointHoverRadius: 3,
      pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
      pointHoverBorderColor: "rgba(78, 115, 223, 1)",
      pointHitRadius: 10,
      pointBorderWidth: 2,
      fill: true // Enable fill to create the area chart
    }],
  },
  options: {
    maintainAspectRatio: false,
    layout: {
      padding: {
        left: 10,
        right: 25,
        top: 25,
        bottom: 0
      }
    },
    scales: {
      xAxes: [{
        time: {
          unit: 'date'
        },
        gridLines: {
          display: false,
          drawBorder: false
        },
        ticks: {
          maxTicksLimit: 7
        }
      }],
      yAxes: [{
        ticks: {
          maxTicksLimit: 5,
          padding: 10,
          // Include a dollar sign in the ticks
          //callback: function(value, index, values) {
            //return '$' + number_format(value);
          //}
        },
        gridLines: {
          color: "rgb(234, 236, 244)",
          zeroLineColor: "rgb(234, 236, 244)",
          drawBorder: false,
          borderDash: [2],
          zeroLineBorderDash: [2]
        }
      }],
    },
    legend: {
      display: false
    },
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      titleMarginBottom: 10,
      titleFontColor: '#6e707e',
      titleFontSize: 14,
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      intersect: false,
      mode: 'index',
      caretPadding: 10,
    //   callbacks: {
    //     label: function(tooltipItem, chart) {
    //       var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
    //       return datasetLabel + ': $' + number_format(tooltipItem.yLabel);
    //     }
    //   }
    }
  }
});

    </script>

    <!-- Pie chart -->

    <script >
    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';
    var data = <?php echo $jsonData; ?>;

// Pie Chart Example
 var data = <?php echo $jsonData; ?>;

    var ctx = document.getElementById("myPieChart").getContext("2d");
    var myChart = new Chart(ctx, {
      type: "pie",
      data: {
        labels: data.map((entry) => entry.label),
        datasets: [
          {
            data: data.map((entry) => entry.value),
            backgroundColor: [
              "#FF6384",
              "#36A2EB",
            ],
          },
        ],
      },
      options: {
        maintainAspectRatio:false,
        responsive: true,
      },
    });
</script>
    
        <?php include_once('../footer.php');?>
 </div>
</body>

</html>