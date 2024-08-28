<?php
include("connection.php"); // may include mailer in the near future

// if(isset($_GET['project_id'])){
//     $project_id=$_GET['project_id'];
// }



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
$fetch = mysqli_fetch_assoc($run_join);
$rankID = $fetch['rank_id'];

if(isset($_POST['done']))
{
    $update="UPDATE `team_member` SET `status`='DONE' WHERE `freelancer_id` ='$freelancer_id'";
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
  <title>Freelancers Cards</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link rel="stylesheet" href="css/details.css">
</head>

<body>

  <div class="cards">

  <?php foreach($run_join as $data) { ?>
    <div class="main-dashcard">
      <div class="txt">
        <h1 class="details">Project Details</h1>
        <div class="title-container">
          <h2>Team Members:</h2>
          <div class="profile-icons">
          <?php echo $data['freelancer_name']?>
          
            <i class="fa-solid fa-user"></i>
            <i class="fa-solid fa-user"></i>
            <i class="fa-solid fa-user"></i>
          </div>
        </div>
        <div class="title-container">
          <h2>status:</h2>
          <p><?php echo $data ['status']?></p>
          </div>
        <?php if($data['freelancer_id']==$freelancer_id){?>
        <form method="POST">
        <div class="btns">
          <div class="buttons">
            <!-- <button><a href="#">Add Member</a></button> -->
            <button class="cssbuttons-io-button addto" name="done" type="submit">
              <p>DONE</p>
              <div class="icon">
                <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path d="M0 0h24v24H0z" fill="none"></path>
                  <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"
                    fill="currentColor"></path>
                </svg>
              </div>
            </button>
          </div>
        </div>
        </form>
        <?php }else{ ?>
            <?php } ?>

      </div>
    </div>
    <!-- End freelancer div -->
    <?php } ?>
  </div>


</body>

</html>