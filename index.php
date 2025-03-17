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
          height: 10vh; /* Full viewport height */
        }

        .material-symbols-outlined {
          font-size: 60px; /* Make the icon large */
          color: rgb(12, 96, 250);
        }
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
          <a class="nav-link" href="#">
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
          <div class="col-md-3 col-6 col-sm-12 col-lg-3">
            <div class="card">
              <div class="card-body">
                <div class="icon">
                  <span class="material-symbols-outlined">
                    person
                  </span>
                </div>
                <h4 class="text-center mt-3">
                   Total Member
                </h4>
                 <h5 class="text-center">13</h5>
              </div>
            </div>
          </div>

         <div class="col-md-3 col-6 col-sm-12 col-lg-3">
            <div class="card">
              <div class="card-body">
                <div class="icon">
                  <span class="material-symbols-outlined">
                    group
                  </span>
                </div>
                <h4 class="text-center mt-3">
                    Staff
                </h4>
                 <h5 class="text-center">13</h5>
              </div>
            </div>
          </div>

          <div class="col-md-3 col-6 col-sm-12 col-lg-3">
            <div class="card">
              <div class="card-body">
                <div class="icon">
                  <span class="material-symbols-outlined">
                    location_away
                  </span>
                </div>
                <h4 class="text-center mt-3">
                   Field Student
                </h4>
                 <h5 class="text-center">13</h5>
              </div>
            </div>
          </div>

          <div class="col-md-3 col-6 col-sm-12 col-lg-3">
            <div class="card">
              <div class="card-body">
                <div class="icon">
                  <span class="material-symbols-outlined">
                   location_away
                  </span>
                </div>
                <h4 class="text-center mt-3">
                   Intern
                </h4>
                 <h5 class="text-center">13</h5>
              </div>
            </div>
          </div>
    </div>
    <div class="row card-body mt-0">
      <div class="col-md-6 col-12">
            <div class="card shadow-lg rounded-lg border-0">
                <div class="card-body text-center">
                    <!-- Status Icon -->
                    <div class="status-icon mb-3">
                        <span class="material-symbols-outlined text-success" style="font-size: 40px;">
                            power_settings_new
                        </span>
                    </div>
                    
                    <!-- Device Mode -->
                    <h4 class="fw-bold text-primary">
                        <span class="material-symbols-outlined align-middle me-2">
                            settings_accessibility
                        </span>
                        Device Mode: <span id="deviceMode">Authentication</span>
                    </h4>

                    <!-- Device Status -->
                    <h5 class="text-secondary mt-2">
                        <span class="material-symbols-outlined align-middle me-2 text-danger">
                            toggle_on
                        </span>
                        Status: <span id="deviceStatus">Active</span>
                    </h5>
                </div>
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

    <script>
      var DataTable = require( 'datatables.net' );
        require( 'datatables.net-responsive' );
        
             
    </script>
    <script>
         $(document).ready(function() {
        $('#myTable').DataTable();
      });
    </script>
  </body>
</html>
