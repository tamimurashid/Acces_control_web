<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Access Control</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
      body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; }
      .icon { display: flex; justify-content: center; align-items: center; width: 50px; height: 50px; }
      .card { border-radius: 10px; }
      .chart-container { height: 400px; }
    </style>
  </head>
  <body>
    <div class="container mt-4">
      <div class="row">
        <div class="col-md-3">
          <div class="card text-center p-3 shadow-sm">
            <h6>Total Members</h6>
            <h5 class="text-primary">13</h5>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card text-center p-3 shadow-sm">
            <h6>Staff</h6>
            <h5 class="text-success">13</h5>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card text-center p-3 shadow-sm">
            <h6>Field Student</h6>
            <h5 class="text-warning">13</h5>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card text-center p-3 shadow-sm">
            <h6>Intern</h6>
            <h5 class="text-danger">13</h5>
          </div>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col-md-6">
          <div class="card p-3 shadow-sm">
            <h5>Access Statistics</h5>
            <div class="chart-container">
              <canvas id="accessChart"></canvas>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card p-3 shadow-sm">
            <h5>Recent Access Logs</h5>
            <table class="table table-striped">
              <thead>
                <tr><th>Name</th><th>Role</th><th>Time</th><th>Status</th></tr>
              </thead>
              <tbody>
                <tr><td>John Doe</td><td>Staff</td><td>10:15 AM</td><td><span class="badge bg-success">Granted</span></td></tr>
                <tr><td>Jane Smith</td><td>Intern</td><td>10:30 AM</td><td><span class="badge bg-danger">Denied</span></td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <script>
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
