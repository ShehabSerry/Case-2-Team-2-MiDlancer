<?php

include("connection.php");
// if(isset($_SESSION['user_id'])){
//     $user_id = $_SESSION['user_id'];
// }else{
//     header("location:home.php");
// }
$user_id = $_SESSION['user_id'];
$history = "SELECT `project`.*, 
                    `user`.*,
                    `freelancer`.*, 
                    `payment`.* FROM  `payment`
        JOIN `freelancer` ON `payment`.`freelancer_id` = `freelancer`.`freelancer_id`
        JOIN `project` ON `payment`.`project_id` = `project`.`project_id`
        JOIN `user` ON `payment`.`user_id` = `user`.`user_id`
        WHERE `payment`.`user_id` = '$user_id'
        ORDER BY `payment`.`date` DESC";
$result = mysqli_query($connect,$history);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
     <!-- fontaswomn link -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- bootstrab link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css
    ">
    <!-- css -->
    <link rel="stylesheet" href="css/payment_history.css">

    <title>Payment History</title>
</head>
<body>
<?php  include("navbarr.php"); ?>  
<h2 class="text-center my-5 ">
Payment History
</h2>
<div class="all">


    
<table class="table table-striped w-90">
    <thead>
        <tr>
            <th><h3>Project Name</h3></th>
            <th><h3>Freelancer Name</h3></th>
            <th><h3>Total Amount</h3></th>
            <th><h3>Payment Date</h3></th>
          
        </tr>
    </thead>
    <tbody>
        <?php
        foreach($result as $data){
        ?> 
        <tr>
            <td><?php echo htmlspecialchars($data["project_name"]) ?></td>
            <td><?php echo htmlspecialchars($data["freelancer_name"]) ?></td>
            <td><?php echo htmlspecialchars($data["amount"]) ?></td>
            <td><?php echo date("d-m-Y", strtotime($data["date"])) ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
</div>
</body>
</html>
