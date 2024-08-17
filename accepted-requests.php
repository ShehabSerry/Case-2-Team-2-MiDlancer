<?php
include "connection.php";

$filter = "";
$user_id = $_SESSION['user_id'];
// $freelancer_id = $_GET['freelancer_id'];
// $project_id = $_GET['project_id'];
// $request_id = $_GET['request_id'];

// $user_id = 1;
// $freelancer_id = 1;
// $project_id = 1;
$run_select1 = [];
$run_select2 = [];

if (isset($_GET['filter'])) {
    $filter = mysqli_real_escape_string($connect, $_GET['filter']);

    if ($filter == 'applicant') {
        $select1 = "SELECT * FROM `applicants` 
                    JOIN `project` ON `applicants`.`project_id` = `project`.`project_id`
                    JOIN `freelancer` ON `applicants`.`freelancer_id` = `freelancer`.`freelancer_id`
                    JOIN `career` ON `freelancer`.`career_id` = `career`.`career_id`
                    WHERE `project`.`user_id` = '$user_id'";
        $run_select1 = mysqli_query($connect, $select1);

        if ($run_select1) {  // Check if query was successful
            $fetch_project = mysqli_fetch_assoc($run_select1);
        } else {
            echo "Error: " . mysqli_error($connect);
        }

        if (isset($_POST['accept'])) {
            $project_id = $_POST['project_id'];
            $freelancer_id = $_POST['freelancer_id'];
            $delete1 = "DELETE FROM `applicants` WHERE `project_id` = $project_id AND `freelancer_id` = $freelancer_id";
            mysqli_query($connect, $delete1);
            header("Location: payment.php?pay=true&fi=$freelancer_id&pid=$project_id");
        }

        // $project_name = $fetch_project['project_name'];
        // $freelancer_id = $_GET['freelancer_id'];

        $select_freelancer = "SELECT * FROM `freelancer`
                              JOIN `career` ON `freelancer`.`career_id` = `career`.`career_id` ";
                              // WHERE `freelancer_id` = $freelancer_id";
        $run_select_freelancer = mysqli_query($connect, $select_freelancer);

        if ($run_select_freelancer) {  // Check if query was successful
            $fetch_freelancer = mysqli_fetch_assoc($run_select_freelancer);
            $freelancer_name = $fetch_freelancer['freelancer_name'];
            $job_title = $fetch_freelancer['job_title'];
            $career_path = $fetch_freelancer['career_path'];
        } else {
            echo "Error: " . mysqli_error($connect);
        }

        if (isset($_POST['delete'])) {
            $project_id=$_POST['project_id'];
            $freelancer_id=$_POST['freelancer_id'];
            $delete = "DELETE FROM `applicants` WHERE `project_id` = $project_id AND `freelancer_id` = $freelancer_id";
            if (mysqli_query($connect, $delete)) {
                echo "Applicant has been removed.";
            } else {
                echo "Error: " . mysqli_error($connect);
            }
        }
    } elseif ($filter == 'requests') {
        $select2 = "SELECT * FROM `request`
                    JOIN `project` ON `request`.`project_id` = `project`.`project_id`
                    JOIN `freelancer` ON `request`.`freelancer_id` = `freelancer`.`freelancer_id`
                    JOIN `user` ON `project`.`user_id` = `user`.`user_id`
                    WHERE `request`.`status` = 'accept' AND `user`.`user_id` = '$user_id'";
        $run_select2 = mysqli_query($connect, $select2);

        if ($run_select2 && mysqli_num_rows($run_select2) > 0) {  // Check if query was successful
            $fetch = mysqli_fetch_assoc($run_select2);
            $image = $fetch['freelancer_image'];
            $price_per_hr = $fetch['price/hr'];
            $total_hours = $fetch['total_hours'];
            $total_price = $price_per_hr * $total_hours;
            $_SESSION['total_price'] = $total_price;
        } else {
            echo "Error: " . mysqli_error($connect);
        }
        if (isset($_POST['pay'])) {
            $request_id = $_POST['request_id'];
            $freelancer_id = $_POST['freelancer_id'];
            $delete2 = "DELETE FROM `request` WHERE `request_id` = $request_id AND `freelancer_id` = $freelancer_id";
            mysqli_query($connect, $delete2);
            header("Location: payment.php?pay=true&fi=$freelancer_id&pay=$request_id");
        }
        
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> Rrequests</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link rel="stylesheet" href="css/incomerequest.css">
</head>

<body>
<?php include "navbarr.php";?>

<div class="submenu">

    <div class="mainbtns">
                <div class="submenu-item">
                <a  href="accepted-requests.php?filter=applicant"><button>Applicants</button></a>
                </div>
                <div class="submenu-item">
                <a  href="accepted-requests.php?filter=requests"><button>Accepted Requests</button></a>
                </div>
                </div>
            </div>
<?php if ($filter == 'requests') {?>
  <div class="cards">
  
  <?php foreach ($run_select2 as $key) { ?>   
     <div class="main-dashcard">
      <div class="txt">
        <div class="title-container">
          <div class="profile-icons">
            <img src="img/<?php echo $image ?>" alt="Profile 1">
          </div>
          <div class="client">
            <h3>Freelancer Name</h3>
            <h3><?php echo $key['freelancer_name']; ?></h3>
          </div>
          <div class="maint">
            <h1><?php echo $key['project_name'];?></h1>
          </div>
          <div class="maint">
            <h4><?php echo $key['description'];?></h4>
          </div>
          <div class="price">
            <h2>$<?php echo $total_price;?></h2>
            <h3 class="month">
                <i class="fa fa-calendar" aria-hidden="true"></i> <?php echo $key['deadline_date'];?> 
            </h3>
          </div>
        </div>

        <div class="btns">
          <div class="buttons">
            
          <form method="post">
                                <input type="hidden" value="<?php echo $key['request_id'];?>" name="request_id">
                                <input type="hidden" value="<?php echo $key['freelancer_id'];?>" name="freelancer_id">

                                <button type="submit" name="pay" >Payment</button>
  </form>
            <!-- <button><a  href="income-request.php?decline=">Decline</a></button>
            <button class="cssbuttons-io-button">
              Accept
              <div class="icon">
                <a  href="income-request.php?accept=">
                  <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"
                    fill="currentColor"></path>
                  </svg>
                </a>
              </div>
            </button> -->

          </div>

        </div>
      </div>
    </div>
    <?php } } elseif ($filter == 'applicant'){ ?>
  </div>

  <div class="cards">
  
  <?php foreach ($run_select1 as $key) { ?>
    <div class="main-dashcard">
    
      <div class="txt">
     
        <div class="title-container">
          <div class="profile-icons">
            <img src="img/<?php echo $image ?>" alt="Profile 1">
          </div>
          <div class="client">
          <a href="./freelancerview.php?vfid=<?php echo $key ['freelancer_id'];?>"><i style='font-size:24px' class='fas'>&#xf2bb;</i>
          </a>
            <h3>Freelancer Name</h3>
            <h4><?php echo $key['freelancer_name']; ?></h4>
          </div>
          <div class="client">
            
            <h4><?php echo $key['job_title']; ?></h4>
            <h4><?php echo $key['career_path']; ?></h4>
          </div>
          <div class="maint">
            <h1><?php echo $key['project_name'];?></h1>
          </div>
          <div class="maint">
            <h4><?php echo $key['description'];?></h4>
          </div>
          <div class="price">
            
            <h3 class="month">
                <i class="fa fa-calendar" aria-hidden="true"></i> <?php echo $key['deadline_date'];?> 
            </h3>
          </div>
        </div>

        <div class="btns">
          <div class="buttons">
          <form method="post">
                                <input type="hidden" value="<?php echo $key['project_id'];?>" name="project_id">
                                <input type="hidden" value="<?php echo $key['freelancer_id'];?>" name="freelancer_id">

                                
                                <div class="twobtns">
                                <button class="cssbuttons-io-button" type="submit" name="accept" id="acceptbtn" >
                                    Accept
                                    <div class="icon">
                                        <!-- <a  href="income-request.php?accept="> -->
                                            <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"
                                                fill="currentColor"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </button>
                                <button name="decline" type="submit"><a  href="accepted-requests.php?decline=<?php echo $key['project_id'] ?>">Decline</a></button>
                                </div>
                            </div>
                            
                        </form>
        </div>
      </div>
    </div>
    <?php } } ?>
  </div>

