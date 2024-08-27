<?php
include("connection.php");


$select = "SELECT * FROM `freelancer`
JOIN `career` ON `freelancer`.`career_id` = `career`.`career_id`
ORDER BY `freelancer`.`fl_join_date` ASC";
$run_select = mysqli_query($connect, $select);




if (isset($_GET['hold'])) {
    $freelancer_id =$_GET['hold']; 

    $update = "UPDATE `freelancer` SET `hidden` = 1 WHERE `freelancer_id` = $freelancer_id";
   $runupdate = mysqli_query($connect, $update);

        // echo "this freelancer has been put on hold.";

        header("Location: display_freelancers.php");

    } else 
    if (isset($_GET['unhold'])) {
        $freelancer_id=$_GET['unhold']; 
    
        $update = "UPDATE `freelancer` SET `hidden` = 0 WHERE `freelancer_id` = $freelancer_id";
       $runupdate = mysqli_query($connect, $update);
    
            // echo "this freelancer's account has been restored .";
    
            header("Location: display_freelancers.php");
    
        } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Freelancers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<table id="example" class="table table-striped" style="width:90%; margin:auto;">
    <thead>
        <tr class="head">
            <th>photo</th>
            <th>Freelancer Name</th>
            <th>Freelancer Email</th>
            <th>career</th>
            <th>job title</th>
            <th>Join_date</th>
            <th>Price/hr</th>
            <th>Hold acount</th>
        </tr>
    </thead>
    <tbody>
  
        <?php foreach($run_select as $row){ ?>
            <tr>
                <td><img src="../img/profile/<?php echo $row['freelancer_image']?>" alt="Profile Pic"></td>
                <td><?php echo htmlspecialchars($row['freelancer_name']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['career_path']); ?></td>
                <td><?php echo htmlspecialchars($row['job_title']); ?></td>
                <td><?php echo htmlspecialchars($row['fl_join_date']); ?></td>
                <td><?php echo htmlspecialchars($row['price/hr']); ?></td>
                <td>
                   
                <?php if ($row['hidden'] == 0) { ?>
                    <a href="display_freelancers.php?hold=<?php echo $row['freelancer_id']; ?>;">
                        <button type="button" class="btn btn-danger" name="hold">hold</button>
                    </a>
                    <?php }else{ ?>
                        <a href="display_freelancers.php?unhold=<?php echo $row['freelancer_id']; ?>;">
                        <button type="button" class="btn btn-danger"name="unhold">Unhold</button>
                    </a>
                </td>
            </tr>
        <?php } }?>
    </tbody>
</table>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
