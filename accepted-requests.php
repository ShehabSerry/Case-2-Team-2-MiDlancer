<?php
include "connection.php";

$filter = "";
$error = false;
// AUTH near future
// if(!isset($_SESSION['user_id']))
//     header("Location: home.php");
$user_id = $_SESSION['user_id'];

// $freelancer_id = $_GET['freelancer_id'];
// $project_id = $_GET['project_id'];
// $request_id = $_GET['request_id'];

$run_select1 = [];
$run_select2 = [];

if (isset($_GET['filter'])) {
    $filter = htmlspecialchars(strip_tags(mysqli_real_escape_string($connect,$_GET['filter'])));

    if ($filter == 'applicant') {
        $select1 = "SELECT * FROM `applicants` 
                    JOIN `project` ON `applicants`.`project_id` = `project`.`project_id`
                    JOIN `freelancer` ON `applicants`.`freelancer_id` = `freelancer`.`freelancer_id`
                    JOIN `career` ON `freelancer`.`career_id` = `career`.`career_id`
                    WHERE `project`.`user_id` = '$user_id'";
        $run_select1 = mysqli_query($connect, $select1);

        if ($run_select1 && mysqli_num_rows($run_select1) > 0) {  // Check if query was successful
            $fetch_project = mysqli_fetch_assoc($run_select1);
            $price_per_hr = $fetch_project['price/hr'];
            $total_hours = $fetch_project['total_hours'];
            $total_price = $price_per_hr * $total_hours;
            $_SESSION['total_price'] = $total_price;
        } else {
            $error = true;
        }

        if (isset($_POST['accept'])) {
            $project_id = $_POST['project_id'];
            $freelancer_id = $_POST['freelancer_id'];
            
            // $delete1 = "DELETE FROM `applicants` WHERE `project_id` = $project_id AND `freelancer_id` = $freelancer_id";
            // mysqli_query($connect, $delete1);
            header("Location: payment.php?pay=true&fi=$freelancer_id&pid=$project_id");
        }

        $select_freelancer = "SELECT * FROM `freelancer`
                              JOIN `career` ON `freelancer`.`career_id` = `career`.`career_id` ";
                              // WHERE `freelancer_id` = $freelancer_id";
        $run_select_freelancer = mysqli_query($connect, $select_freelancer);

        if ($run_select_freelancer) {  // Check if query was successful
            $fetch_freelancer = mysqli_fetch_assoc($run_select_freelancer);
            $freelancer_name = $fetch_freelancer['freelancer_name'];
            $job_title = $fetch_freelancer['job_title'];
        } else {
            echo "Error: " . mysqli_error($connect);
        }

        if (isset($_POST['decline'])) {
            $project_id=$_POST['project_id'];
            $freelancer_id=$_POST['freelancer_id'];
            $delete = "DELETE FROM `applicants` WHERE `project_id` = $project_id AND `freelancer_id` = $freelancer_id";
            if (mysqli_query($connect, $delete)) {
                // echo "Applicant has been removed.";
                header("location: accepted-requests.php?filter=applicant");
            } else {
                echo "Error: " . mysqli_error($connect);
            }
        }
    } elseif ($filter == 'requests') {
        $select2 = "SELECT * FROM `request`
                    JOIN `project` ON `request`.`project_id` = `project`.`project_id`
                    JOIN `freelancer` ON `request`.`freelancer_id` = `freelancer`.`freelancer_id`
                    JOIN `user` ON `project`.`user_id` = `user`.`user_id`
                    JOIN `career` ON `freelancer`.`career_id` = `career`.`career_id`
                    WHERE `request`.`status` = 'accept' AND `user`.`user_id` = '$user_id'";
        $run_select2 = mysqli_query($connect, $select2);

        if ($run_select2 && mysqli_num_rows($run_select2) > 0) {
            $fetch = mysqli_fetch_assoc($run_select2);
            $image = $fetch['freelancer_image'];
            $price_per_hr = $fetch['price/hr'];
            $total_hours = $fetch['total_hours'];
            $total_price = $price_per_hr * $total_hours;
            $_SESSION['total_price'] = $total_price;
        } else {
            $error = "Nobody accepted any of your requests just yet";
        }
        if (isset($_POST['pay'])) {
            $project_id = $_POST['project_id'];
            $request_id = $_POST['request_id'];
            $freelancer_id = $_POST['freelancer_id'];
            
            //  $delete2 = "DELETE FROM `request` WHERE `request_id` = $request_id AND `freelancer_id` = $freelancer_id";
            //  mysqli_query($connect, $delete2);
            //header("Location: payment.php?pay=true&fi=$freelancer_id&pay=$request_id"); moved to when transc is done (payment.php)
            header("Location: payment.php?pay=true&fi=$freelancer_id&pay=$request_id&pid=$project_id");
            $delete1 = "DELETE FROM `applicants` WHERE `project_id` = $project_id AND `freelancer_id` = $freelancer_id";
            mysqli_query($connect, $delete1);
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
          integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link rel="stylesheet" href="css/incomerequest.css">
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

        /* Popup styling */
        .popup {
            display: none; /* Hide popups by default */
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background: white;
            border: 1px solid #ccc;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
            z-index: 1000;
            transform: translate(-50%,-50%);
            text-align: center;
            border-radius: 7px;
            color:#58151c;
        }
        .popup.show {
            display: block; /* Show popup when class 'show' is added */
        }
        .overlay {
            display: none; /* Hide overlay by default */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }
        .overlay.show {
            display: block; /* Show overlay when class 'show' is added */
        }
        .lol{
            color:#58151c;
        }
  
</style>
</head>

<body>


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
  <?php 
    if($error==true){
            ?> 
            
    <div class="container popup" id="popup">
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
                <h1 class="alert">Error!</h1>
                <p>oh no, something went wrong.</p>
            </div>
            <!-- <button type="submit" class="button-box">
                <h1 class="red">try again</h1>
            </button> -->
        </div>
    </div>

    <?php } ?>
    <?php foreach ($run_select2 as $key) { ?>   
     <div class="main-dashcard">
      <div class="txt">
        <div class="title-container">
        <a style="color: white;" href="./freelancerview.php?vfid=<?php echo $key['freelancer_id'] ?>">

          <div class="profile-icons">
            <img src="img/profile/<?php echo $key['freelancer_image'] ?>" alt="Profile 1">
          </div>
          <div class="client">
            <h3><?php echo  htmlspecialchars ($key['freelancer_name'],ENT_QUOTES,'UTF-8') ?></h3>
            <h4><?php echo htmlspecialchars ($key['career_path'],ENT_QUOTES,'UTF-8') ?></h4>
          </div>
          <div class="maint">
            <h1><?php echo htmlspecialchars ($key['project_name'],ENT_QUOTES,'UTF-8')?></h1>
          </div>
          <div class="maint">
            <h4><?php echo htmlspecialchars  ($key['description'],ENT_QUOTES,'UTF-8')?></h4>
          </div>
          <div class="price">
            <h2>$<?php echo htmlspecialchars ($total_price,ENT_QUOTES,'UTF-8')?></h2>
            <h3 class="month">
                <i class="fa fa-calendar" aria-hidden="true"></i> <?php echo htmlspecialchars ($key['deadline_date'],ENT_QUOTES,'UTF-8')?> 
            </h3>
          </div>
        </a>
        </div>

        <div class="btns">
          <div class="buttons">
            
          <form method="post">
                                <input type="hidden" value="<?php echo htmlspecialchars ($key['request_id'],ENT_QUOTES,'UTF-8')?>" name="request_id">
                                <input type="hidden" value="<?php echo htmlspecialchars ($key['freelancer_id'],ENT_QUOTES,'UTF-8')?>" name="freelancer_id">
                                <input type="hidden" value="<?php echo htmlspecialchars ($key['project_id'],ENT_QUOTES,'UTF-8')?>" name="project_id">
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
  <?php 
    if($error==true){
            ?> 
            
    <div class="container popup" id="popup">
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
                <h1 class="alert">Error!</h1>
                <p>oh no, something went wrong.</p>
            </div>
            <!-- <button type="submit" class="button-box">
                <h1 class="red">try again</h1>
            </button> -->
        </div>
    </div>

    <?php } ?>
  <?php foreach ($run_select1 as $key) { ?>
    <div class="main-dashcard">
    
      <div class="txt">
     
        <div class="title-container">
          <a style="color: white;" href="./freelancerview.php?vfid=<?php echo $key['freelancer_id'] ?>">
          <div class="profile-icons">
            <img src="img/profile/<?php echo $key['freelancer_image'] ?>" alt="Profile 1">
          </div>
          <div class="client">
            <h3><?php echo htmlspecialchars ($key['freelancer_name'],ENT_QUOTES,'UTF-8') ?></h3>
            <h4><?php echo htmlspecialchars ($key['job_title'],ENT_QUOTES,'UTF-8') ?></h4>
            <h4><?php echo htmlspecialchars ($key['career_path'],ENT_QUOTES,'UTF-8') ?></h4>
          </div>
          
          <div class="maint">
            <h1><?php echo htmlspecialchars ($key['project_name'],ENT_QUOTES,'UTF-8')?></h1>
          </div>
          <div class="maint">
            <h4><?php echo htmlspecialchars ($key['description'],ENT_QUOTES,'UTF-8')?></h4>
          </div>
          <div class="price">
          <h2>$<?php echo htmlspecialchars ($total_price,ENT_QUOTES,'UTF-8')?></h2>

            <h3 class="month">
                <i class="fa fa-calendar" aria-hidden="true"></i> <?php echo htmlspecialchars ($key['deadline_date'],ENT_QUOTES,'UTF-8')?> 
            </h3>
          </div>
          </a>
        </div>

        <div class="btns">
          <div class="buttons">
          <form method="post">
                                <input type="hidden" value="<?php echo htmlspecialchars ($key['project_id'],ENT_QUOTES,'UTF-8')?>" name="project_id">
                                <input type="hidden" value="<?php echo htmlspecialchars ($key['freelancer_id'],ENT_QUOTES,'UTF-8')?>" name="freelancer_id">


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

                  </form>

                  <!-- Button to Open Popup -->
                  <button class="cssbuttons-io-button" type="button" class="btn btn-outline-danger" onclick="openPopup(<?php echo $key['project_id']; ?>, <?php echo $key['freelancer_id']; ?>)">
    Decline
</button>

<!-- Hidden Form for Deletion -->
<form method="post" id="deleteForm-<?php echo $key['project_id']; ?>-<?php echo $key['freelancer_id']; ?>"  style="display:none;">
    <input type="hidden" name="project_id" value="<?php echo $key['project_id']; ?>">
    <input type="hidden" name="freelancer_id" value="<?php echo $key['freelancer_id']; ?>">
    <input type="hidden" name="decline" >
</form>

<!-- Popup Modal -->
<div class="popup alert alert-danger" id="popup-<?php echo $key['project_id']; ?>-<?php echo $key['freelancer_id']; ?>">
    <h2><i class="fa-solid fa-triangle-exclamation"></i> Are you sure you want to delete this applicant?</h2>
    <button type="button" class="lol btn btn-outline-dark" onclick="confirmDelete()">Yes</button>
   
    <button type="button" class="lol btn btn-outline-dark" onclick="closePopup()">No</button>
</div>

<!-- Overlay for Popup -->
<div class="overlay" id="overlay-<?php echo $key['project_id']; ?>-<?php echo $key['freelancer_id']; ?>"></div>

                              
                              
                              
                              
                              
                              
                              </div>
                            </div>

        </div>
      </div>
    </div>
    <?php } } ?>
  </div>

  <script>
    let deleteRequestId;

    function openPopup(projectId, freelancerId) {
        deleteRequestId = projectId + '-' + freelancerId;
        document.getElementById('popup-' + deleteRequestId).classList.add('show');
        document.getElementById('overlay-' + deleteRequestId).classList.add('show');
    }

    function closePopup() {
        if (deleteRequestId) {
            document.getElementById('popup-' + deleteRequestId).classList.remove('show');
            document.getElementById('overlay-' + deleteRequestId).classList.remove('show');
        }
    }

    function confirmDelete() {
        if (deleteRequestId) {
            document.getElementById('deleteForm-' + deleteRequestId).submit();
        }
    }
</script>
</html>