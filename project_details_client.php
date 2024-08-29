<?php
include "nav+bm.php"; 
$user_id=$_SESSION['user_id'];
// if(isset($_GET['project_id'])){
//     $project_id=$_GET['project_id'];
// }
$details = mysqli_real_escape_string($connect, $_GET['details']);

$join= "SELECT * FROM `team_member`
                JOIN `project` ON `project`.`project_id`=`team_member`.`project_id`
                JOIN `freelancer` ON `freelancer`.`freelancer_id`=`team_member`.`freelancer_id`
                JOIN `user` ON `user`.`user_id`=`project`.`user_id` 
        WHERE `project`.`project_id` = '$details'";

$run_join=mysqli_query($connect,$join);


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Project_details_Freelancer</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
  integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
  crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="css/project details.css">
</head>

<body>
<!-- <br> <br> <br> <br> <br> -->
  <div class="ag-format-container ">
    <div class="ag-courses_box">

      <!--card -->
      <div class="ag-courses_item ">
      <?php foreach($run_join as $data) { ?>
        <a href="" class="ag-courses-item_link">
          <div class="ag-courses-item_bg"></div>

          <div class="ag-courses-item_title">
            <div class="ag-courses-item_title">
              <h4 class="teams"><?php echo $data['project_name']?></h4>

            </div>
          </div>

          <div class="ag-courses-item_date-box">
            <!-- <i class="fa-regular fa-clock"></i>  -->
            <h3>Team Member: <span class="ag-courses-item_date">
            <?php echo $data['freelancer_name']?>
              </span>
              <span><img src="img/profile/<?php echo $data['freelancer_image']?>" alt="team member img"></span>
            </h3>
          </div>
          <div class="ag-courses-item_date-box">
            <!-- <i class="fa-solid fa-money-bills"></i> -->
            <h3>Status: <span class="ag-courses-item_date">
            <?php echo $data ['status']?>
              </span>
            </h3>
          </div>

          </a>  
        <?php } ?>
      </div>
      

    </div>
  </div>
</body>

</html>
