<?php 
session_start();


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
    


    <title>Access Control</title>
    <style>
        /* Style the welcome message */
      #welcomeMessage {
          width: 80%;
          max-width: 500px;
          padding: 20px;
          background: rgba(255, 255, 255, 0.9);
          box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
          border-radius: 10px;
          animation: popUp 0.6s ease-out;
        }
        .step{
          animation: popUp 0.6s ease-out;
        }
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
        @keyframes blink {
          0% { color: rgba(0, 0, 0, 0.5); } /* Visible */
          50% { color: transparent; }       /* Hidden */
          100% { color: rgba(0, 0, 0, 0.5); } /* Visible */
        }

        #cardId::placeholder {
          animation: blink 1s infinite;
        }

             /* Pop-up animation for the welcome message */
        @keyframes popUp {
            0% { transform: scale(0.5); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }      
    </style>
  </head>
  <body>
    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link" href="index.php">
            <i class="fas fa-tachometer-alt"></i> Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="register.php">
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
   <div class="main-content" id="mainContent">
      <div class="logo">
        <img class="img-fluid" src="Assets/Images/logo.png" alt="">
      </div>
   <div class="card col-12 mx-auto " style="height: 700px;opacity: 0.8">
    <div class="card-header">
        <h5>
            <?php if(isset($_SESSION['success'])) { ?>
              <div class="alert alert-success text-center" role="alert">
                  <?php echo $_SESSION['success']; ?>
                  <button class="btn btn-primary btn-sm float-end" onclick="setMode()">Change Mode</button>
              </div><?php 
           
                // Unset the session variable after displaying the message
                unset($_SESSION['success']);
            }?>
             <?php if(isset($_SESSION['error'])){?>
              <div class="alert alert-danger text-center" role="alert">
                <?php echo $_SESSION['error']; ?>
                  <button class="btn btn-danger btn-sm float-end" onclick="setMode()">Change Mode</button>
              </div>
            <?php }
            unset($_SESSION['error']); ?>
        </h5>
    </div>
    <div class="card-body d-flex justify-content-center align-items-center position-relative">
        <!-- Welcome Message Overlay -->
        <div id="welcomeMessage" class="position-absolute text-center p-4 bg-light shadow rounded-4" 
             style="width: 80%; max-width: 500px; padding: 20px;">
            <img class="img-fluid mb-3" src="Assets/Images/3071357.jpg" alt="" style="width: 100%; height:400px;">
            <h5>Welcome to the Register System</h5>
            <p class="small">
                By clicking scan id button in last step, your device will switch to Register Mode, 
                and authentication will be paused until registration is complete.
            </p>
            <button id="startRegistration" class="btn btn-primary mt-2">Register</button>
        </div>

        <!-- Glassmorphic Form (Initially Hidden) -->
        <div id="registrationFormContainer" class="form-container col-10 col-sm-12 col-md-6 col-lg-4 p-4 rounded-4 d-none">
            <form id="registrationForm" method="post" action="server/controller/register_cont.php">
                <!-- Step 1: Personal Information -->
                <div class="step step-1 d-none">
                    <h6 class="text-center mb-4">Step 1: Personal Information</h6>
                    <div class="mb-3">
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text" name="firstname" class="form-control" id="firstName" placeholder="Enter your first name" required>
                    </div>
                    <div class="mb-3">
                        <label for="secondName" class="form-label">Second Name</label>
                        <input type="text" name="secondname" class="form-control" id="secondName" placeholder="Enter your second name" required>
                    </div>
                    <div class="mb-3">
                        <label for="lastName" class="form-label">Last  Name</label>
                        <input type="text" name="lastname" class="form-control" id="lastName" placeholder="Enter your last name" required>
                    </div>
                    <button type="button" class="btn btn-primary w-100 next-btn">Next</button>
                </div>
                
                <!-- Step 2: Contact Information -->
                <div class="step step-2 d-none">
                    <h6 class="text-center mb-4">Step 2: Contact Information</h6>
                    <div class="mb-3">
                        <label for="age" class="form-label">Age</label>
                        <input type="number" name="age" class="form-control" id="age" placeholder="Enter your age" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" id="phone" placeholder="eg 07xxxxxxx" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email address" required>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary w-50 prev-btn mt-2 mx-2">Previous</button>
                        <button type="button" class="btn btn-primary w-50 next-btn mt-2">Next</button>
                    </div>
                </div>

                <!-- Step 3: Position and Card -->
                <div class="step step-3 d-none">
                    <h6 class="text-center mb-4">Step 3: Position and Card ID</h6>
                    <div class="mb-3">
                        <label for="position" class="form-label">Position</label>
                        <select name="position" class="form-select" id="position">
                          <option selected>Choose position</option>
                          <option value="staff">Staff</option>
                          <option value="intern">Intern</option>
                          <option value="field">Field</option>
                        </select>
                    </div>

                    <button class="btn btn-primary my-3" id="scan">Scan Card</button>

                    <div class="mb-3 ms-3 d-none" id="thecard">
                        <label for="cardId" class="form-label">Card ID</label>
                        <input type="text" name="cardId" value="" class="form-control" id="cardId" placeholder="Scan your card to capture ID" readonly>
                    </div>
                    <div class="img-card d-none" id="scan-animation">
                        <video class="img-fluid" style="height:200px; width: 100%;" 
                            src="Assets/Images/tap-to-pay.mp4" 
                            autoplay 
                            muted 
                            loop 
                            playsinline>
                        </video>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary w-50 prev-btn mt-2 mx-2">Previous</button>
                        <!-- <button type="submit"  name="'submit" class="btn btn-primary w-50 next-btn mt-2">Submit</button> -->
                        <input type="submit"  name="submit" class="btn btn-primary w-50 next-btn mt-2" value="Submit">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

</div>

    <!-- JavaScript -->
     <script>
      

     </script>
    <script src="Assets/js/main.js"></script>
    <script src="https://cdn.datatables.net/2.2.1/js/dataTables.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
      document.getElementById('scan').addEventListener('click', function () {
        fetch("http://localhost:8888/Access_control/Api/set_mode.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ mode: "reg_mod" }) // Switch ESP32 to register mode
        })
        .then(response => response.json())
        .then(data => {
            console.log("Response from API:", data);
            if (data.status === "success") {
                alert("The device is now in Register Mode. Press okay and scan the card, do not submit untill you see card id on the input .");
                
                // Wait for the ESP to send the scanned card ID
                setTimeout(fetchScannedCard, 5000); // Delay before fetching card ID
            }
        })
        .catch(error => console.error("Error switching to Register Mode:", error));
    });

    function fetchScannedCard() {
        fetch("http://localhost:8888/Access_control/server/controller/checkUser_cont.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ check: "scanned_card" }) // Request for scanned Card ID
        })
        .then(response => response.json())
        .then(data => {
            console.log("Scanned Card ID Response:", data);
            if (data.status === "success" && data.cardID) {
                document.getElementById("cardId").value = data.cardID; // Display scanned card ID
                document.getElementById("thecard").classList.remove("d-none"); // Show the input field
            }
        })
        .catch(error => console.error("Error fetching scanned Card ID:", error));
    }
    function setMode() {
            fetch("http://localhost:8888/Access_control/Api/set_mode.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ mode: "auth_mod" }) // Send mode update request
            })
            .then(response => response.json())
            .then(data => {
                console.log("Mode Update Response:", data);
                if (data.status === "success") {
                    alert("System returned to authentication mode.");
                    location.reload(); // Reload the page after setting the mode
                } else {
                    alert("Failed to set mode. Try again.");
                }
            })
            .catch(error => console.error("Error setting mode:", error));
        }
    </script>
  </body>
</html>
