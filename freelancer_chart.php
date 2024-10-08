<?php
// include "connection.php";
if(isset($_SESSION['freelancer_id'])) // if someone types in url = kicked
    $freelancer_id=$_SESSION['freelancer_id'];
else
    header("Location: home.php");

$select = "SELECT DATE_FORMAT(`date`, '%Y-%m') as month, COUNT(`freelancer_id`) as total_projects
           FROM `payment` 
           WHERE `freelancer_id`=$freelancer_id
           GROUP BY `month`
           ORDER BY month"; // ASC for reals???
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
    <title>Monthly Projects Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
    
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
    <a href="my_projects_freelancer.php">View Details</a>
    <div id="chartContainer">
        <canvas id="freelancerChart"></canvas> <!-- Corrected ID -->
    </div>
    <script>
        // Parse the JSON data from PHP
        const data = <?php echo $json; ?>;

        // Extract labels (months) and freelancer counts
        const labels = data.map(item => item.month);
        const freelancers = data.map(item => item.total_projects);

        // Initialize the chart
        const ctx = document.getElementById('freelancerChart').getContext('2d');
        const freelancerChart = new Chart(ctx, {
            type: 'bar',  
            data: {
                labels: labels,
                datasets: [{
                    label: 'Monthly Projects',
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
