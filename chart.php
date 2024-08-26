<?php
include "connection.php"; 

$select = "SELECT DATE_FORMAT(`date`, '%Y-%m') as month, SUM(`amount` * 0.15) as total_commission 
           FROM `payment` 
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
    <title>Monthly Commission Chart</title>
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
<div id="chartContainer">
        <canvas id="commissionChart"></canvas>
    </div>

    <script>
        const data = <?php echo $json; ?>;

        const labels = data.map(item => item.month);
        const commissions = data.map(item => item.total_commission);

        const ctx = document.getElementById('commissionChart').getContext('2d');
        const commissionChart = new Chart(ctx, {
            type: 'line',  
            data: {
                labels: labels,
                datasets: [{
                    label: 'Monthly Commission',
                    data: commissions,
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
