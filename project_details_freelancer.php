<?php
include("connection.php");
$freelancer_id=$_SESSION['freelancer_id'];
// if(isset($_GET['project_id'])){
//     $project_id=$_GET['project_id'];
// }
$details = $_GET['details'];
// $user_id=2;


$join="SELECT * FROM `team_member`
JOIN `project` ON `project`.`project_id`=`team_member`.`project_id`
JOIN `freelancer` ON `freelancer`.`freelancer_id`=`team_member`.`freelancer_id`
JOIN `user` ON `user`.`user_id`=`project`.`user_id`
WHERE `project`.`project_id` = '$details'";


$run_join=mysqli_query($connect,$join);
// if($_SESSION['freelancer_id']){
//     $freelancer_id=$_SESSION['freelancer_id']=6;

if(isset($_POST['done'])){
$update="UPDATE `team_member` SET `status`='DONE' WHERE `freelancer_id` ='$freelancer_id'";
$run_update=mysqli_query($connect,$update);
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