<?php
include "connection.php";

$filter = "";
$user_id = $_SESSION['user_id'];
$freelancer_id = $_GET['freelancer_id'];
$project_id = $_GET['project_id'];
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
    <!-- flaticon -->
  <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.5.1/uicons-bold-rounded/css/uicons-bold-rounded.css'>
  <!-- link google fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
  <!-- link fontawsome -->
  <script src="https://kit.fontawesome.com/4f17bdb3b3.js" crossorigin="anonymous"></script>
  <!-- link bootstrab -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css"
    integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- link css -->
  <link rel="stylesheet" href="css/incomingrequest.css">
  
  <!-- link google fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Unna:ital,wght@0,400;0,700;1,400;1,700&display=swap"
    rel="stylesheet">
    <!-- link for google icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- icofont -->
    <link rel="stylesheet" href="myProjects/webProject/icofont/css/icofont.min.css">
    <title>Document</title>
</head>
<body>
    <!-- title -->
    <div class="titleincom">
        <h2 class="inbold">Applicants & Accepted Requests</h2>
    </div>
    <hr/>
      <div class="submenu">
                
                <div class="submenu-item">
                    <a href="accepted-requests.php?filter=applicant" class="submenu-link">Applicants</a>
                </div>
                <div class="submenu-item">
                    <a href="accepted-requests.php?filter=requests" class="submenu-link">Accepted Requests</a>
                </div>
            </div>
    <!-- Display Requests -->
    <?php if ($filter == 'requests') {?>
        <div class="sizeofcards">
        <div class="container">
    
    </div>
    <?php foreach ($run_select2 as $key) { ?>
    <div class="row g-4">
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <div class="col-md-3">
                    <div class="col">
            <div class="box openPopupBtn bg-danger" id="openPopupBtnn">                   
                 <div class="card h-100">
                        <div class="card-body">
                    
                              <br>
                                <img src="./img/<?php echo $image ?>" alt="" class="img">
                                <div class="TXT">
                                    <h6 class="card-subtitle mb-2">Freelancer Name</h6>
                                    <h5 class="card-title"><?php echo $key['freelancer_name']; ?></h5>
                                </div>
                                <h3><?php echo $key['project_name']; ?></h3>
                                <h4><?php echo $total_price; ?></h4>
                                <p class="deadline card-subtitle mb-2">
                                    <span class="material-icons">calendar_month</span>
                                    <?php echo $key['deadline_date']; ?>
                                </p>
                            </div>
                            <br>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <form method="post">
                                <input type="hidden" value="<?php echo $key['request_id'];?>" name="request_id">
                                <input type="hidden" value="<?php echo $key['freelancer_id'];?>" name="freelancer_id">

                                <button type="submit" name="pay" class="Btn">Payment</button>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      <!-- popup card details -->
   
    </div>
    
    <?php } } elseif ($filter == 'applicant'){ ?>
        
        
        <?php foreach ($run_select1 as $key) { ?>
            
            <form method="POST"> 
                <div class="sizeofcards">
                    <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col">
                <div class="box">
                    <div class="card h-100">
                        <div class="card-body">

                            <div class="cardtext">
                              <br>
                                <img src="./img/<?php echo $image ?>" alt="" class="img">
                                <div class="TXT">
                                    <h6 class="card-subtitle mb-2">Freelancer Name</h6>
                                    <h5 class="card-title"><?php echo $key['freelancer_name']; ?></h5>
                                </div>
                                <h3><?php echo $key['project_name']; ?></h3>
                                <h4><?php echo $key['job_title']; ?></h4>
                                <h4><?php echo $key['career_path']; ?></h4>
                                
                               
                               
                            </div>
                            <br>
                                
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">

                            <input type="hidden" value="<?php echo $key['project_id'];?>" name="project_id">
                            <input type="hidden" value="<?php echo $key['freelancer_id'];?>" name="freelancer_id">

                            <a href="./freelancer_view.php?vfid=<?php echo $key ['freelancer_id'];?>"> 
                                <button class="Btn">View Profile</button></a>

                            <!-- <a href="payment.php">  -->
                                <button type="submit" name="accept" class="Btn">Accept</button>
                            <!-- </a> -->
                             
                                    <!-- <button name="accept" class="Btn">Accept</button> -->
  
                                    <button type="submit" name="decline" class="Btn">decline</button>
                                <!-- <a href="accepted-requests.php?delete=true&pid=<?php echo $key['project_id'];?>&fi=<?php echo $key['freelancer_id'];?>">Decline</a> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    </div>
<?php }} ?>
<?php foreach($run_select2 as $key){ ?>
<div id="popup" class="popup">
                                  <div class="popup-content">
                                      <span id="closePopupBtn" class="close closePopupBtn">&times;</span>
                                      <!-- <div class="col"> -->
                                      <!-- <div class="card "> -->
                                        <div class="card-body">
                                              <img src="./img/<?php echo $image ?>" alt="" class="img">
                                              <h6 class="card-subtitle mb-2 text-muted">Freelancer Name</h6>
                                              <h5 class="card-title"><?php echo $key['freelancer_name'];?></h5>
                                              
                                              <h3><?php echo $key['project_name'];?></h3>
                                              <h5>Description:</h5>
                                              <p class="card-text"> <?php echo $key['description'];?> </p>
                                              <h4> <?php echo $total_price;?> </h4>
                                              <p class=" deadline2 card-subtitle mb-2 text-muted"><span class="material-icons">
                                                  calendar_month
                                                  </span> <?php echo $key['deadline_date'];?></p>
                                        </div>
                                  </div>
                                  <?php } ?>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js"
  integrity="sha512-ykZ1QQr0Jy/4ZkvKuqWn4iF3lqPZyij9iRv6sGqLRdTPkY69YX6+7wvVGmsdBbiIfN/8OdsI7HABjvEok6ZopQ=="
  crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="sweetalert2.all.min.js"></script>
  <script src="js/popupdetails.js"></script>
</body>
</html>
