<?php
include("connection.php");

// Fetch admin data
$select = "SELECT * FROM `user`
JOIN `nationality` ON `user`.`nationality_id`=`nationality`.`nationality_id`";
$run_select = mysqli_query($connect, $select);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clients List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"
    integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/displayfreelancers.css">
</head>
<body>
<div class="container">
<table id="example" class="table table-striped" style="width:90%; margin:auto;">
    <thead>
        <tr class="head">
            <th>photo</th>
            <th>Client Name</th>
            <th>Client Email</th>
            <th>Nationality</th>
        </tr>
    </thead>
    <tbody>
       
        
      
        <?php foreach($run_select as $row){  ?>
        
        <tr>
        <td><img src="../img/profile/<?php echo $row['user_image']?>" alt="Profile Pic"></td>
            <td><?php echo htmlspecialchars($row['user_name']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['nationality']); ?></td>

           
        </tr>
        <?php } ?>
    </tbody>
</table>
</div>
</body>
</html>
