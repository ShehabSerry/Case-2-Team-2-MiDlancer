<?php
include("connection.php");
$freelancer_id=$_SESSION['freelancer_id'];
// $run_select1="";
$join="SELECT * FROM `team_member`
JOIN `project` ON `project`.`project_id`=`team_member`.`project_id`
JOIN `freelancer` ON `freelancer`.`freelancer_id`=`team_member`.`freelancer_id`
JOIN `user` ON `user`.`user_id`=`project`.`user_id`
WHERE `freelancer`.`freelancer_id` ='$freelancer_id'";
$run_join=mysqli_query($connect,$join);
$fetch=mysqli_fetch_assoc($run_join);
$price_per_hr=$fetch['price/hr'];
$total_hours=$fetch['total_hours'];

function SUM($price_per_hr,$total_hours){
    $total_price=$price_per_hr * $total_hours;
     return "$total_price";
}

if(isset($_GET['project_id'])){
    $project_id=$_GET['project_id'];


    // $select2="SELECT * FROM `freelancer` WHERE `freelancer_id`='$freelancer_id'";
    // $run_select2=mysqli_query($connect,$select2);

    // $price_per_hr=$run_select2['price/hr'];
    // $total_hours=$run_select1['total_hours'];

    // function SUM($price_per_hr,$total_hours){
    //     $total_price=$price_per_hr * $total_hours;
    //     echo"$total_price";
    // }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>my projects</title>
</head>
<body>
    <div>
        <?php foreach($run_join as $data) { ?>
        <h5><?php echo $data ['project_name']?></h5>
        <h5><?php echo $data ['description']?></h5>
        <h5><?php echo $data ['total_hours']?></h5>
        <h5><?php echo $data ['user_name']?></h5>
        <h5><?php echo SUM($fetch['price/hr'], $fetch['total_hours'])?></h5>

        <?php } ?>

    </div>
</body>
</html>