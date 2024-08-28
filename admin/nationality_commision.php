<?php
include "connection.php"; 

// $admin_id = $_SESSION['admin_id'];

// Updated SQL query for payments per nationality per month
$select = "SELECT 
            nationality.nationality,
            MONTH(payment.date) AS payment_month,
            SUM(payment.amount) AS total_payment
           FROM payment
           JOIN user ON payment.user_id = user.user_id
           JOIN nationality ON user.nationality_id = nationality.nationality_id
           GROUP BY nationality.nationality, payment_month
           ORDER BY nationality.nationality, payment_month";

$run = mysqli_query($connect, $select);

if (!$run) {
    die("Query failed: " . mysqli_error($connect));
}

$data = [];

while ($row = mysqli_fetch_assoc($run)) {
    $data[] = $row;
}

$json = json_encode($data);

mysqli_free_result($run);
// mysqli_close($connect);
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
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
        }
        #chartContainer {
            width: 80%;
            max-width: 800px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            border-radius: 8px;
        }
        canvas {
            width: 100% !important;
            height: 80% !important;
        }
    </style>
</head>
<body>
    <div id="chartContainer">
    <h3>Commission from each nationality</h3>
        <canvas id="nationalityChart"></canvas>
    </div>
    <script>
        // JSON data directly embedded from PHP
        const data = <?php echo $json; ?>;

        // Organize data by nationality and months
        const chartData = {};
        data.forEach(item => {
            if (!chartData[item.nationality]) {
                chartData[item.nationality] = Array(12).fill(0);  // Initialize with zero for each month
            }
            chartData[item.nationality][item.payment_month - 1] = parseFloat(item.total_payment);
        });

        const labels = Object.keys(chartData);
        const datasets = Object.entries(chartData).map(([key, value], index) => ({
            label: key,
            data: value,
            backgroundColor: `rgba(${Math.floor(Math.random()*256)}, ${Math.floor(Math.random()*256)}, ${Math.floor(Math.random()*256)}, 0.2)`,
            borderColor: `rgba(${Math.floor(Math.random()*256)}, ${Math.floor(Math.random()*256)}, ${Math.floor(Math.random()*256)}, 1)`,
            borderWidth: 1
        }));

        // Initialize the chart
        const ctx = document.getElementById('nationalityChart').getContext('2d');
        const nationalityChart = new Chart(ctx, {
            type: 'bar',  // Bar chart type
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: datasets
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    x: {
                        stacked: true
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Total Payment (Commission)'
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
