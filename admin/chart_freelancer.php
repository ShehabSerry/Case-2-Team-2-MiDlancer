<?php
include "connection.php"; 
$admin_id=$_SESSION['admin_id'];

$select = "SELECT DATE_FORMAT(`fl_join_date`, '%Y-%m') as month, COUNT(`freelancer_id`) as total_freelancers 
           FROM `freelancer` 
           GROUP BY `month` 
           ORDER BY month ASC";
$run = mysqli_query($connect, $select);

$data = [];

while ($row = mysqli_fetch_assoc($run)) {
    $data[] = $row;
}

$json = json_encode($data);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Freelancer Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;  /* Light gray background */
            font-family: Arial, sans-serif;  /* Clean font */
        }
        #chartContainer {
            width: 80%;  /* Adjust the width as needed */
            max-width: 800px;  /* Maximum width */
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);  /* Subtle shadow */
            background-color: #fff;  /* White background for the chart container */
            border-radius: 8px;  /* Rounded corners */
        }
        canvas {
            width: 100% !important;  /* Ensure the canvas takes full width of container */
            height: auto !important;  /* Maintain aspect ratio */
        }
    </style>
</head>
<body>
    <a href="display_freelancers.php">View Details</a>
    <div id="chartContainer">
        <canvas id="freelancerChart"></canvas> <!-- Corrected ID -->
    </div>
    <script>
        // Parse the JSON data from PHP
        const data = <?php echo $json; ?>;

        // Extract labels (months) and freelancer counts
        const labels = data.map(item => item.month);
        const freelancers = data.map(item => item.total_freelancers);

        // Initialize the chart
        const ctx = document.getElementById('freelancerChart').getContext('2d');
        const freelancerChart = new Chart(ctx, {
            type: 'line',  
            data: {
                labels: labels,
                datasets: [{
                    label: 'Monthly Freelancers',
                    data: freelancers,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',  
                    borderColor: 'rgba(75, 192, 192, 1)', 
                    borderWidth: 2,
                    fill: true,  
                    tension: 0.1  
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
