<?php
include("connection.php");
//$user_id=$_SESSION['user_id'];
$user_id=1;

//$join="SELECT *, distinct `team_member`.`project_id` FROM `project`
// $join="SELECT * FROM `project`
// right JOIN `user` ON `user`.`user_id`=`project`.`user_id`
// left JOIN `team_member` ON `project`.`project_id`=`team_member`.`project_id`
// left JOIN `freelancer` ON `freelancer`.`freelancer_id`=`team_member`.`freelancer_id`
// WHERE `user`.`user_id` ='$user_id'";
$join = "SELECT *, SUM(`price/hr`) AS 'sumrates' FROM `project`
right JOIN `user` ON `user`.`user_id`=`project`.`user_id`
left JOIN `team_member` ON `project`.`project_id`=`team_member`.`project_id`
left JOIN `freelancer` ON `freelancer`.`freelancer_id`=`team_member`.`freelancer_id`
WHERE `user`.`user_id` ='$user_id'
GROUP BY `project`.`project_id`";
$run_join=mysqli_query($connect,$join);

// $fetch=mysqli_fetch_assoc($run_join);
// $price_per_hr=$fetch['price/hr'];
// $price_per_hr = $fetch['sumrates'];
// $total_hours=$fetch['total_hours'];

function SUM($price_per_hr,$total_hours){
    $total_price=$price_per_hr * $total_hours;
    return "$total_price";
}




?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="css/index.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
<div class="main">
    <h1 class="title">MY PROJECTS</h1>
    <a href="#"><button>Add Project</button></a>
    <a href="#"><button>All</button></a>
    <a href="#"><button>Individual</button></a>
    <a href="#"><button>Teams</button></a>

</div>
<div class="ag-format-container">
    <div class="ag-courses_box">
        <?php foreach($run_join as $data) { ?>
        <div class="ag-courses_item">
                <a href="#" class="ag-courses-item_link">
            <div class="ag-courses-item_bg"></div>
            <div class="ag-courses-item_title">
                <div class="ag-courses-item_title">
                    <h4 class="teams"><?php echo $data ['project_name']?></h4>
                    <p class="para"><?php echo $data ['description']?>
                    </p>
                </div>
            </div>

            <div class="ag-courses-item_date-box">
                <i class="fa-regular fa-clock"></i> Total Hours:
                <span class="ag-courses-item_date">
                <?php echo $data ['total_hours']?> Hour
                </span>
            </div>

            <div class="ag-courses-item_date-box">
                <i class="fa-solid fa-money-bills"></i>
                Total Price:
                <span class="ag-courses-item_date">
                <!-- <?php //echo SUM($fetch['price/hr'], $fetch['total_hours'])?> EGP -->
                <?php echo SUM($data['sumrates'], $data['total_hours'])?> EGP
                </span>
            </div>

                <a href="project_details_client.php?details=<?php echo $data['project_id']?>" class="ag-courses-item_anchor">project details</a>
            </a>
            
        </div>
        <?php } ?>
    </div>
</div>
</body>

</html>