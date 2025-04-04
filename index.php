<?php 
session_start();
require  "server/db.php";

// Total members
$total_query = "SELECT COUNT(*) AS total_members FROM user_deatils";
$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_members = $total_row['total_members'];

// Count Field Students
$field_query = "SELECT COUNT(*) AS field_students FROM user_deatils WHERE position = 'field'";
$field_result = mysqli_query($conn, $field_query);
$field_row = mysqli_fetch_assoc($field_result);
$field_students = $field_row['field_students'];

// Count Interns
$intern_query = "SELECT COUNT(*) AS interns FROM user_deatils WHERE position = 'intern'";
$intern_result = mysqli_query($conn, $intern_query);
$intern_row = mysqli_fetch_assoc($intern_result);
$interns = $intern_row['interns'];

// Count Staff
$staff_query = "SELECT COUNT(*) AS staff FROM user_deatils WHERE position = 'staff'";
$staff_result = mysqli_query($conn, $staff_query);
$staff_row = mysqli_fetch_assoc($staff_result);
$staff = $staff_row['staff'];

$device_query = "SELECT mode FROM device_modes";
$device_result = mysqli_query($conn, $device_query);
$device_row = mysqli_fetch_assoc($device_result);
$device_mode = $device_row['mode'];
if($device_mode == 'reg_mod'){
  $device_mode = "Registration";
}else if($device_mode == 'auth_mod'){
  $device_mode = "Authentication";
}
$fail_query = "SELECT COUNT(*) AS fail FROM logs WHERE status = 'error'";
$fail_result = mysqli_query($conn, $fail_query);
$fail_row = mysqli_fetch_assoc($fail_result);
$fail = $fail_row['fail'];

$success_query = "SELECT COUNT(*) AS success FROM logs WHERE status = 'success'";
$success_result = mysqli_query($conn, $success_query);
$success_row = mysqli_fetch_assoc($success_result);
$success = $success_row['success'];


?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="Assets/css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.1/css/dataTables.dataTables.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">


    <title>Access Control</title>
    <style>
      .material-symbols-outlined {
        font-variation-settings:
        'FILL' 0,
        'wght' 400,
        'GRAD' 0,
        'opsz' 24
      }
        .icon {
          display: flex;
          justify-content: center; /* Centers horizontally */
          height: 5vh; /* Full viewport height */
        }

        .material-symbols-outlined {
          font-size: 30px; /* Make the icon large */
          color: black;
        }
        body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; }
        .icon { display: flex; justify-content: center; align-items: center; width: 50px; height: 50px; }
        .card { border-radius: 10px; }
        .chart-container { height: 400px; }
    </style>
  </head>
  <body>
    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link active" href="#">
            <i class="fas fa-tachometer-alt"></i> Dashboard 
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="register.php">
            <i class="fas fa-box"></i> Register
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">
            <i class="fas fa-tags"></i> Accounting
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="member.php">
            <i class="fas fa-users"></i> Member
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="log.php">
            <i class="fas fa-chart-line"></i> Logs
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">
            <i class="fas fa-cogs"></i> Settings
          </a>
        </li>
      </ul>
    </nav>

    <!-- Hide/Unhide Sidebar Button -->
    <button class="hide-sidebar-btn" id="toggleSidebarBtn">
      <i class="fas fa-angle-left"></i>
    </button>

    <!-- Main Content -->
   <!-- <div class="header-image">
      <img class="img-fluid max-width: 100%; header-image" src="" alt="">
   </div> -->
    <div class="main-content" id="mainContent">
      <div class="logo">
        <img class="img-fluid" src="Assets/Images/logo.png" alt="">
      </div>
      <!-- Header Section -->
      <div class="card col-12 mx-auto" style="height: 700px;opacity: 0.8">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Dashboard</h5>
          <form class="d-flex">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form>
        </div>
       <div class="card-body row mb-0">
  
      <!-- Total Members -->
      <div class="col-md-3 col-6 col-sm-12 col-lg-3">
        <div class="card p-3 rounded shadow-md">
          <div class="card-body d-flex align-items-center">
            <div class="icon bg-primary text-white d-flex justify-content-center align-items-center rounded-circle me-3" style="width: 40px; height: 40px;">
              <span class="material-symbols-outlined">person</span>
            </div>
            <div>
              <h6 class="mb-1">Total Members</h6>
              <h5 class="fw-bold mb-0"><?php echo $total_members ?></h5>
            </div>
          </div>
        </div>
      </div>

      <!-- Staff -->
      <div class="col-md-3 col-6 col-sm-12 col-lg-3">
        <div class="card p-3 rounded shadow-md">
          <div class="card-body d-flex align-items-center">
            <div class="icon bg-success text-white d-flex justify-content-center align-items-center rounded-circle me-3" style="width: 40px; height: 40px;">
              <span class="material-symbols-outlined">group</span>
            </div>
            <div>
              <h6 class="mb-1">Staff</h6>
              <h5 class="fw-bold mb-0"><?php echo $staff ?></h5>
            </div>
          </div>
        </div>
      </div>

      <!-- Field Student -->
      <div class="col-md-3 col-6 col-sm-12 col-lg-3">
        <div class="card p-3 rounded shadow-md">
          <div class="card-body d-flex align-items-center">
            <div class="icon bg-warning text-white d-flex justify-content-center align-items-center rounded-circle me-3" style="width: 40px; height: 40px;">
              <span class="material-symbols-outlined">location_away</span>
            </div>
            <div>
              <h6 class="mb-1">Field Student</h6>
              <h5 class="fw-bold mb-0"><?php echo $field_students ?></h5>
            </div>
          </div>
        </div>
      </div>

      <!-- Intern -->
      <div class="col-md-3 col-6 col-sm-12 col-lg-3">
        <div class="card p-3 rounded shadow-md">
          <div class="card-body d-flex align-items-center">
            <div class="icon bg-danger text-white d-flex justify-content-center align-items-center rounded-circle me-3" style="width: 40px; height: 40px;">
              <span class="material-symbols-outlined">location_away</span>
            </div>
            <div>
              <h6 class="mb-1">Intern</h6>
              <h5 class="fw-bold mb-0"><?php echo $interns ?></h5>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
    <!-- Device Mode Status -->
        <div class="col-md-3 col-6 col-sm-12 col-lg-3">
            <div class="card p-3 text-center shadow-md ms-3">
                <h5>Device Mode</h5>
                <h4 id="deviceMode" class="text-primary"><?php echo $device_mode ?></h4>
            </div>
        </div>
        
        <!-- System Status -->
        <div class="col-md-3 col-6 col-sm-12 col-lg-3">
            <div class="card p-3 text-center shadow-md">
                <h5>System Status</h5>
                <h4 id="systemStatus" class="text-success">Online</h4>
            </div>
        </div>
        <div class="col-md-3 col-6 col-sm-12 col-lg-3">
            <div class="card p-3 text-center shadow-md">
                <h5>Success Attempts</h5>
                <h4 id="systemStatus" class="text-success"><?php echo $success ?></h4>
            </div>
        </div>
        <div class="col-md-3 col-6 col-sm-12 col-lg-3">
            <div class="card p-3 text-center shadow-md me-3">
                <h5>Failed Attempts</h5>
                <h4 id="systemStatus" class="text-success"><?php echo $fail ?></h4>
            </div>
        </div>
    </div>

    <div class="row">
      <div class="col-md-6 col-6 col-sm-12 col-lg-6">
        <div class="card m-3 shadow-md">
            <div class="card-header">Access Statistics</div>
            <div class="card-body">
                <canvas id="accessChart"></canvas>
            </div>
        </div>
      </div>

      <!-- Access Logs Table -->
        <div class="card shadow-md mt-3 col-md-6 col-6 col-sm-12 col-lg-6 ">
            <div class="card-header">Recent Access Logs</div>
            <div class="card-body">
                <table id="accessLogsTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>John Doe</td><td>Staff</td><td>10:15 AM</td><td><span class="badge bg-success">Granted</span></td></tr>
                        <tr><td>Jane Smith</td><td>Intern</td><td>10:30 AM</td><td><span class="badge bg-danger">Denied</span></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


  
   
    <!-- JavaScript -->
    <script src="Assets/js/main.js"></script>
    <script src="https://cdn.datatables.net/2.2.1/js/dataTables.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- jQuery (required for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
      var DataTable = require( 'datatables.net' );
        require( 'datatables.net-responsive' );
        
             
    </script>
    <script>
         $(document).ready(function() {
        $('#myTable').DataTable();
      });

      var ctx = document.getElementById('accessChart').getContext('2d');
      var accessChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
          datasets: [
            { label: 'Success', data: [12, 19, 5, 10, 7], backgroundColor: 'rgba(54, 162, 235, 0.7)' },
            { label: 'Fail', data: [5, 8, 3, 6, 4], backgroundColor: 'rgba(255, 99, 132, 0.7)' }
          ]
        },
        options: { responsive: true, scales: { y: { beginAtZero: true } } }
      });
    </script>
  </body>
</html>
