<?php

// include 'connection.php';
include "nav+bm.php"; 
$freelancer_id=$_SESSION['freelancer_id'];

//------------AUTH-------------
// Imma comment this for now
//if(!isset($_SESSION['freelancer_id'], $_GET['details']))
//    header("Location: home.php");
//-------------------------------

$freelancer_id=$_SESSION['freelancer_id'];
$details = htmlspecialchars(strip_tags(mysqli_real_escape_string($connect, $_GET['details'])));

$join="SELECT * FROM `team_member`
JOIN `project` ON `project`.`project_id`=`team_member`.`project_id`
JOIN `freelancer` ON `freelancer`.`freelancer_id`=`team_member`.`freelancer_id`
JOIN `user` ON `user`.`user_id`=`project`.`user_id`
WHERE `project`.`project_id` = '$details'";

$run_join=mysqli_query($connect,$join);

$select_rank="SELECT * FROM `freelancer` 
              JOIN `rank` ON `rank`.`rank_id` = `freelancer`.`rank_id`
              WHERE `freelancer`.`freelancer_id` = $freelancer_id";
$run_rank = mysqli_query($connect,$select_rank);

$fetch = mysqli_fetch_assoc($run_rank);
$rankID = $fetch['rank_id'];

if(isset($_POST['done']))
{
    $update="UPDATE `team_member` SET `status`='Done' WHERE `freelancer_id` ='$freelancer_id'";
    $run_update=mysqli_query($connect,$update);

    $chkDone = "SELECT * FROM `team_member` WHERE `freelancer_id` ='$freelancer_id' AND `status` = 'DONE'";
    $exec_chk = mysqli_query($connect, $chkDone);
    $count = mysqli_num_rows($exec_chk);
    if($count % 3 == 0 && $count != 0)
    {
        if($rankID != 3)
        {
            $updateRank = "UPDATE `freelancer` SET `rank_id`= rank_id + 1 WHERE `freelancer_id` ='$freelancer_id'";
            $execUpdateRank = mysqli_query($connect, $updateRank);
        }
        $updateWebsitePrice = "UPDATE `freelancer` SET `webssite_price`= webssite_price + 10 WHERE `freelancer_id` ='$freelancer_id'";
        $execUpdateWebsitePrice = mysqli_query($connect, $updateWebsitePrice);
    }
    header("refresh:1; url=project_details_freelancer.php?details=$details");

}
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
<br> <br> <br> <br> <br>
  <div class="ag-format-container ">
    <div class="ag-courses_box">

      <!--card -->
      <?php foreach($run_join as $data) { ?>
     
      <div class="ag-courses_item ">
      <a class="ag-courses-item_link" href="freelancerview.php?vfid=<?php echo $data['freelancer_id']?>">
        <!-- <a href="" class="ag-courses-item_link"> -->
          <div class="ag-courses-item_bg"></div>

          <div class="ag-courses-item_title">
            <div class="ag-courses-item_title">
              <h4 class="teams"><?php echo $data['project_name']?></h4>

            </div>
          </div>

          <div class="ag-courses-item_date-box">
            <!-- <i class="fa-regular fa-clock"></i>  -->
            <h3>
              <span><img src="img/profile/<?php echo $data['freelancer_image']?>" alt="member"></span>
              <span class="ag-courses-item_date">
                <?php echo $data['freelancer_name']?>
              </span>
            </h3>

          </div>
          <div class="ag-courses-item_date-box">
            <!-- <i class="fa-solid fa-money-bills"></i> -->
            <h3>Status: <span class="ag-courses-item_date">
            <?php echo $data ['status']?>
              </span></h3>

          </div>

          <?php if($data['freelancer_id'] == $freelancer_id && $data['status'] == "In Progress"){?>
          <a href="#" class="ag-courses-item_anchor">
            <form method="POST">
              <button type="submit" name="done">Done</button>
            </form>
          </a>
          <?php }else{ ?>
          <?php } ?>
        </a>
        <?php  ?>

      </div>
      <?php } ?>

    </div>
  </div>
</body>

</html>
