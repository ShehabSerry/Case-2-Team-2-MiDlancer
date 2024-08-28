<?php
include "connection.php"; 

$admin_id = $_SESSION['admin_id'];

// Correct the SQL query to group by nationality

$select = "SELECT `nationality`.`nationality`, COUNT(`user`.`user_id`) as client_count
            FROM `user`
            JOIN `nationality` ON `user`.`nationality_id` = `nationality`.`nationality_id`
            GROUP BY `nationality`.`nationality`";


$run = mysqli_query($connect, $select);

if (!$run) {
    // Handle query error
    die("Query failed: " . mysqli_error($connect));
}

$data = [];

while ($row = mysqli_fetch_assoc($run)) {
    $data[] = $row;
}

$json = json_encode($data);

// Optionally, you can return or echo the JSON
// echo $json;

// Free result set and close the connection
mysqli_free_result($run);
// mysqli_close($connect);



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nationality Distribution Chart</title>
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
            width: 80% !important;  /* Ensure the canvas takes full width of container */
            height: 80% !important;  /* Maintain aspect ratio */
        }
    </style>
</head>
<body>
    <a href="display_users.php">View Details</a>
    <div id="chartContainer">
        <canvas id="nationalityChart"></canvas>
    </div>
    <script>
        // JSON data directly embedded from PHP
        const data = <?php echo $json; ?>;

        // Extract labels (nationalities) and counts
        const labels = data.map(item => item.nationality);
        const counts = data.map(item => parseInt(item.client_count, 10)); // Convert to integer

        // Initialize the chart
        const ctx = document.getElementById('nationalityChart').getContext('2d');
        const nationalityChart = new Chart(ctx, {
            type: 'doughnut',  // Pie chart type
            data: {
                labels: labels,
                datasets: [{
                    label: 'User Distribution by Nationality',
                    data: counts,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });
    </script>
</body>
</html>
