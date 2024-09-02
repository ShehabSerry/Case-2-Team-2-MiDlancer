<?php
include "nav+bm.php"; 
// include 'connection.php';
if(!isset($_SESSION['user_id'], $_GET['details'])) // may validate details project id if we have the time
    header("Location: home.php");

$user_id=$_SESSION['user_id'];
$error="";
$details = htmlspecialchars(strip_tags(mysqli_real_escape_string($connect, $_GET['details'])));

$join= "SELECT * FROM `team_member`
                JOIN `project` ON `project`.`project_id`=`team_member`.`project_id`
                JOIN `freelancer` ON `freelancer`.`freelancer_id`=`team_member`.`freelancer_id`
                JOIN `user` ON `user`.`user_id`=`project`.`user_id` 
        WHERE `project`.`project_id` = '$details'";

$run_join=mysqli_query($connect,$join);

if(mysqli_num_rows($run_join) == 0){
$error= true;
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
  <style>
        :root{
    --white: #fcfcfc;
    --gray: #cbcdd3;
    --dark: #777777;
    --error: #ef8d9c;
    --orange: #ffc39e;
    --success: #b0db7d;
    --secondary: #99dbb4;
}


@import url("https://fonts.googleapis.com/css?family=Lato:400,700");

/* $font: "Lato", sans-serif; */





.container {
  position: relative;
  margin: auto;
  overflow: hidden;
  width: 700px;
  height: 250px;
}

#container {
  position: relative;
  margin: auto;
  overflow: hidden;
  width: 700px;
  height: 250px;
}

h1 {
  font-size: 0.9em;
  font-weight: 100;
  letter-spacing: 3px;
  padding-top: 5px;
  color: var(--white) ;
  padding-bottom: 5px;
  text-transform: uppercase;
}

.green {
  color:var(--secondary);
   /* darken($secondary, 20%); */
}

.red {
  color: var(--error);
  /* darken($error, 10%); */
}

.alert {
  font-weight: 700;
  letter-spacing: 5px;
}

p {
  margin-top: -5px;
  /* font-size: 0.5em; */
  /* font-weight: 100; */
  color: var(--white);
  /* darken($dark, 10%); */
  letter-spacing: 1px;
}

button,
.dot {
  cursor: pointer;
}

#success-box {
  position: absolute;
  width: 35%;
  height: 100%;
  right: 0;
  background: linear-gradient(to bottom right, var(--success) , var(--secondary) );
  border-radius: 20px;
  box-shadow: 5px 5px 20px rgba(var(--gray), 10%);
  perspective: 40px;
}

#error-box {
  position: absolute;
  width: 35%;
  height: 100%;
  right: 30vh;
  background: linear-gradient(to bottom left, var(--error) 40%, var(--orange) 100%);
  border-radius: 20px;
  box-shadow: 5px 5px 20px rgba(var(--gray), 10%);
}

.dot {
  width: 8px;
  height: 8px;
  background: var(--white);
  border-radius: 50%;
  position: absolute;
  top: 4%;
  right: 6%;

}
.dot:hover {
    background: darken(var(--white), 20%);
  }

.two {
  right: 12%;
  opacity: 0.5;
}

.face {
  position: absolute;
  width: 22%;
  height: 22%;
  background: var(--white);
  border-radius: 50%;
  border: 1px solid var(--dark);
  top: 21%;
  left: 37.5%;
  z-index: 2;
  animation: bounce 1s ease-in infinite;
}

.face2 {
  position: absolute;
  width: 22%;
  height: 22%;
  background: var(--white);
  border-radius: 50%;
  border: 1px solid var(--dark);
  top: 21%;
  left: 37.5%;
  z-index: 2;
  animation: roll 3s ease-in-out infinite;
}

.eye {
  position: absolute;
  width: 5px;
  height: 5px;
  background: var(--dark);
  border-radius: 50%;
  top: 40%;
  left: 20%;
}

.right {
  left: 68%;
}

.mouth {
  position: absolute;
  top: 43%;
  left: 41%;
  width: 7px;
  height: 7px;
  border-radius: 50%;
}

.happy {
  border: 2px solid;
  border-color: transparent var(--dark) var(--dark) transparent;
  transform: rotate(45deg);
}

.sad {
  top: 49%;
  border: 2px solid;
  border-color: var(--dark) transparent transparent var(--dark);
  transform: rotate(45deg);
}

.shadow {
  position: absolute;
  width: 21%;
  height: 3%;
  opacity: 0.5;
  background: var(--dark);
  left: 40%;
  top: 43%;
  border-radius: 50%;
  z-index: 1;
}

.scale {
  animation: scale 1s ease-in infinite;
}
.move {
  animation: move 3s ease-in-out infinite;
}

.message {
  position: absolute;
  width: 100%;
  text-align: center;
  height: 40%;
  top: 47%;
}

.button-box {
  position: absolute;
  background: var(--white);
  width: 50%;
  height: 15%;
  border-radius: 20px;
  top: 73%;
  left: 25%;
  outline: 0;
  border: none;
  box-shadow: 2px 2px 10px rgba(var(--dark), 0.5);
  transition: all 0.5s ease-in-out;
}
.button-box:hover {
    /* background: darken(var(--white), 5%); */
    transform: scale(1.05);
    transition: all 0.3s ease-in-out;
  }

@keyframes bounce {
  50% {
    transform: translateY(-10px);
  }
}

@keyframes scale {
  50% {
    transform: scale(0.9);
  }
}

@keyframes roll {
  0% {
    transform: rotate(0deg);
    left: 25%;
  }
  50% {
    left: 60%;
    transform: rotate(168deg);
  }
  100% {
    transform: rotate(0deg);
    left: 25%;
  }
}

@keyframes move {
  0% {
    left: 25%;
  }
  50% {
    left: 60%;
  }
  100% {
    left: 25%;
  }
}
</style>
</head>

<body>
<br> <br> <br> <br> <br>
 <div class="malak">
 <button style="width: 12em;">
 <!-- <i class="fa-solid fa-plus"></i> -->
<a href="career.php?details=<?php echo $details?>" style="padding: 10px;">Add Member</a></button>

 </div>
    <div class="ag-courses_box">
<?php 
if(mysqli_num_rows($run_join) == 0){
    ?> 
    
<div class="container popup " style="margin-top:20vh" id="popup">
<div id="error-box">
    <div class="dot"></div>
    <div class="dot two"></div>
    <div class="face2">
        <div class="eye"></div>
        <div class="eye right"></div>
        <div class="mouth sad"></div>
    </div>
    <div class="shadow move"></div>
    <div class="message">
        <!-- <h1 class="alert">Error!</h1> -->
         <br>
         <br>
        <p>There are no current members in this project!</p>
    </div>
    <!-- <button type="submit" class="button-box">
        <h1 class="red">try again</h1>
    </button> -->
</div>
</div>

<?php }else{ ?>

      <!--card -->
      <?php foreach($run_join as $data) { ?>

      <div class="ag-courses_item ">
        <a href="" class="ag-courses-item_link">
          <div class="ag-courses-item_bg"></div>

          <div class="ag-courses-item_title">
            <div class="ag-courses-item_title">
              <h4 class="teams"><?php echo $data['project_name']?></h4>

            </div>
          </div>

          <div class="ag-courses-item_date-box">
            <!-- <i class="fa-regular fa-clock"></i>  -->
            <h3>
            <span><img src="img/profile/<?php echo $data['freelancer_image']?>" alt="team member img"></span>
              <span class="ag-courses-item_date">
            <?php echo $data['freelancer_name']?>
              </span>
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
 
      </div>
      <?php } }?>


    </div>
    
  </div>
</body>

</html>
