<?php
// include("connection.php");
include 'nav+bm.php';
$error = "";
$done = "";
$popup1 = false; // Set to false by default
$popup2 = false;
$filter = "";
$select_posts = "SELECT * FROM `project`
JOIN `user` ON `user`.`user_id`=`project`.`user_id` 
WHERE `posting` = 1
ORDER BY `project`.`project_id` DESC";

if (isset($_GET['filter'])) {
    $filter = mysqli_real_escape_string($connect, $_GET['filter']);

    if ($filter == '0-50') {
        $select_posts = "SELECT * FROM `project`
        JOIN `user` ON `user`.`user_id`=`project`.`user_id` 
        WHERE `posting` = 1 AND `total_hours` BETWEEN 0 AND 50
        ORDER BY `project`.`project_id` DESC";
    } elseif ($filter == '50-150') {
        $select_posts = "SELECT * FROM `project`
        JOIN `user` ON `user`.`user_id`=`project`.`user_id` 
        WHERE `posting` = 1 AND `total_hours` BETWEEN 50 AND 150
        ORDER BY `project`.`project_id` DESC";
    } elseif ($filter == '150-300') {
        $select_posts = "SELECT * FROM `project`
        JOIN `user` ON `user`.`user_id`=`project`.`user_id` 
        WHERE `posting` = 1 AND `total_hours` BETWEEN 150 AND 300
        ORDER BY `project`.`project_id` DESC";
    }
}

$run_post = mysqli_query($connect, $select_posts);
$freelancer_id = $_SESSION['freelancer_id'];

if (isset($_POST['apply'])) {
    $project_id = $_POST['project_id'];
    $freelancer_id = $_SESSION['freelancer_id'];

    // Check if the freelancer has already applied
    $check_applicant = "SELECT * FROM `applicants` WHERE `freelancer_id` = '$freelancer_id' AND `project_id` = '$project_id'";
    $run_check_applicant = mysqli_query($connect, $check_applicant);
    if (mysqli_num_rows($run_check_applicant) > 0) {
        $error = "You have already applied to this project.";
        $popup2 = true;
    } else {
        $insert_applicant = "INSERT INTO `applicants` VALUES ('$freelancer_id','$project_id','pending')";
        $run_insert_applicant = mysqli_query($connect, $insert_applicant);
        $done = "Your application has been sent successfully.";
        $popup1 = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrab/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="css/posting.css">
    <!-- <link rel="stylesheet" href="css/newest.css"> -->
    <title>Job Posting</title>
    <style>
        /* Additional CSS for the overlay */
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



.containerr {
  position: relative;
  margin: auto;
  overflow: hidden;
  width: 700px;
  height: 250px;
} 

#containerr {
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
  width: 100%;
  height: 100%;
  right: 0;
  background: linear-gradient(to bottom right, var(--success) , var(--secondary) );
  border-radius: 20px;
  box-shadow: 5px 5px 20px rgba(var(--gray), 10%);
  perspective: 40px;
}

#error-box {
  position: absolute;
  width: 100%;
  height: 100%;
  right: 0;
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

        .overlay {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
        .popup {
            display: none;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 300px;
            background-color: #fff;
            border-radius: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            height: 50%
        }
    </style>
</head>
<body>

    <!-- Dropdown filter start -->
    <div class="menu">
        <div class="item">
            <a href="#" class="link">
                <span>Sort By Total Hours</span>
                <svg viewBox="0 0 360 360" xml:space="preserve">
                    <g id="SVGRepo_iconCarrier">
                        <path id="XMLID_225_" d="M325.607,79.393c-5.857-5.857-15.355-5.858-21.213,0.001l-139.39,139.393L25.607,79.393 c-5.857-5.857-15.355-5.858-21.213,0.001c-5.858,5.858-5.858,15.355,0,21.213l150.004,150c2.813,2.813,6.628,4.393,10.606,4.393 s7.794-1.581,10.606-4.394l149.996-150C331.465,94.749,331.465,85.251,325.607,79.393z"></path>
                    </g>
                </svg>
            </a>
            <div class="submenu">
                <!-- Hours filter -->
                <div class="submenu-item">
                    <a href="job_postings.php" class="submenu-link">All</a>
                </div>
                <div class="submenu-item">
                    <a href="job_postings.php?filter=0-50" class="submenu-link">0-50h</a>
                </div>
                <div class="submenu-item">
                    <a href="job_postings.php?filter=50-150" class="submenu-link">50-150h</a>
                </div>
                <div class="submenu-item">
                    <a href="job_postings.php?filter=150-300" class="submenu-link">150-300h</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row d-flex justify-content-center">
            <?php foreach ($run_post as $data) { ?>
                <div class="col-md-12 mt-4">
                    <!-- Start first post -->
                    <div class="mx-auto w-75">
                        <div class="d-flex flex-column" id="comment-container">
                            <div class="client d-flex">
                                <div class="d-flex flex-column justify-content-start ml-0">
                                    <!-- Client name -->
                                    <span class="d-block font-weight-bold name"><?php echo htmlspecialchars($data['user_name']); ?></span>
                                    <span class="date text-black-50"><?php echo htmlspecialchars($data['bio']); ?></span>
                                </div>
                            </div>

                            <div class="jop-dis">
                                <!-- Display project details -->
                                <h6>Project Name: <span><?php echo htmlspecialchars($data['project_name']); ?></span></h6>
                                <h6>Description: <span><?php echo htmlspecialchars($data['description']); ?></span></h6>
                                <h6>Total Hours: <span><?php echo htmlspecialchars($data['total_hours']); ?></span></h6>
                                <h6>Deadline: <span><?php echo htmlspecialchars($data['deadline_date']); ?></span></h6>

                                <!-- Apply button -->
                                <?php if (isset($_SESSION['freelancer_id'])) { ?>
                                    <div class="butns d-flex justify-content-end">
                                        <form method="post">
                                            <input type="hidden" name="project_id" value="<?php echo $data['project_id']; ?>">
                                            <button class="butn" name="apply">Apply</button>
                                        </form>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- Overlay and Popup HTML -->
<?php if($popup1){?>

    <div class="overlay" id="overlay" onclick="closePopup1()"></div>
      <div class="containerr popup" id="popup">
          <div id="success-box">
            <div class="dot"></div>
            <div class="dot two"></div>
            <div class="face">
              <div class="eye"></div>
              <div class="eye right"></div>
              <div class="mouth happy"></div>
            </div>
            <div class="shadow scale"></div>
            <div class="message">
              <h1 class="alert">Success!</h1>
              <p>Your application has been sent successfully.</p>
            </div>
            <!-- <button type="submit" class="button-box"><h1 class="green">continue</h1></button> -->
          </div>
      </div>
<?php } ?>
<div class="overlay" id="overlay" onclick="closePopup2()"></div>
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
                <p>You have already applied to this project..</p>
            </div>
                <h1 class="red">try again</h1>
            </button>
        </div>
    </div>
    


                  
        <script>
        function openPopup1() {
            document.getElementById('popup').style.display = 'block';
            document.getElementById('overlay').style.display = 'block';
        }

        function closePopup1() {
            document.getElementById('popup').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        }

        <?php if ($popup1){ ?>
        // Automatically open the popup if $popup is true
        openPopup1();
        <?php } ?>


        function openPopup2() {
            document.getElementById('popup').style.display = 'block';
            document.getElementById('overlay').style.display = 'block';
        }

        function closePopup2() {
            document.getElementById('popup').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        }

        <?php if ($popup2){ ?>
        // Automatically open the popup if $popup is true
        openPopup2();
        <?php } ?>
        </script>
</body>
</html>
