<?php
include("connection.php");
$freelancer_id=$_SESSION['freelancer_id'];


// if(isset($_GET['project_id'])){
//     $project_id=$_GET['project_id'];

// }
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
              <p class="para"><?php echo $data ['description']?> </p>
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
                        <?php echo SUM($fetch['price/hr'], $fetch['total_hours'])?>
            EGP
            </span>
          </div>
          <div class="ag-courses-item_date-box">
            <i class="fa-regular fa-user"></i>Client:
            <span class="ag-courses-item_date">
            <?php echo $data ['user_name']?>
            </span>
          </div>
          <!-- <a href="project_details_freelancer.php?pid=<?php echo $project['project_id'] ?>"><button class="view-button">View</button></a> -->
          <a href="project_details_freelancer.php?details=<?php echo $data['project_id']?>" class="ag-courses-item_anchor" name="project_details">project details</a>
        </a>
      </div>
      <?php } ?>
      </div>
  </div>
  
</body>

</html>