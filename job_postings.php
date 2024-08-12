<?php
include("connection.php");

$filter = "";
$select_posts = "SELECT * FROM `project`
JOIN `user` ON `user`.`user_id`=`project`.`user_id` 
 WHERE `posting` = 1";

if (isset($_GET['filter'])) {
    $filter = mysqli_real_escape_string($connect, $_GET['filter']);

    if ($filter == '0-20') {
        $select_posts .= " AND `total_hours` BETWEEN 0 AND 20";
    } elseif ($filter == '20-40') {
        $select_posts .= " AND `total_hours` BETWEEN 20 AND 40";
    } elseif ($filter == '40-60') {
        $select_posts .= " AND `total_hours` BETWEEN 40 AND 60";
    }
}

$run_post = mysqli_query($connect, $select_posts);
$freelancer_id = $_SESSION['freelancer_id'];

if (isset($_POST['apply'])) {
    $project_id = $_POST['project_id'];
    $insert_applicant = "INSERT INTO `applicants` VALUES ('$freelancer_id','$project_id','pending')";
    $run_insert_applicant = mysqli_query($connect, $insert_applicant);
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
    <title>Job Posting</title>
</head>
<body>
    <!-- dropdown filter start -->
    <div class="menu">
        <div class="item">
            <a href="#" class="link">
                <span>Our Services</span>
                <svg viewBox="0 0 360 360" xml:space="preserve">
                    <g id="SVGRepo_iconCarrier">
                        <path id="XMLID_225_" d="M325.607,79.393c-5.857-5.857-15.355-5.858-21.213,0.001l-139.39,139.393L25.607,79.393 c-5.857-5.857-15.355-5.858-21.213,0.001c-5.858,5.858-5.858,15.355,0,21.213l150.004,150c2.813,2.813,6.628,4.393,10.606,4.393 s7.794-1.581,10.606-4.394l149.996-150C331.465,94.749,331.465,85.251,325.607,79.393z"></path>
                        </g>
                </svg>
            </a>
            <div class="submenu">
                <!-- hours filter -->
                <div class="submenu-item">
                    <a href="job_postings.php" class="submenu-link">All</a>
                </div>
                <div class="submenu-item">
                    <a href="job_postings.php?filter=0-20" class="submenu-link">0-20h</a>
                </div>
                <div class="submenu-item">
                    <a href="job_postings.php?filter=20-40" class="submenu-link">20-40h</a>
                </div>
                <div class="submenu-item">
                    <a href="job_postings.php?filter=40-60" class="submenu-link">40-60h</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row d-flex justify-content-center"><?php foreach ($run_post as $data) { ?>
            <div class="col-md-12 mt-4">
                
                <!-- start first post -->
                <div class="mx-auto w-75">
                    <div class="d-flex flex-column" id="comment-container">
                        <div class="client d-flex">
                            <div class="d-flex flex-column justify-content-start ml-0">
                                <!-- client name -->
                                <span class="d-block font-weight-bold name"><?php echo $data['user_name']; ?></span>
                                <span class="date text-black-50"><?php echo $data['bio']; ?></span>
                                <!-- --------------------------------- -->
                            </div>
                        </div>

                        <div class="jop-dis">
                            <!-- Display project details -->
                            <h6>Project Name:- <span><?php echo $data['project_name']; ?></span></h6>
                            <h6>Description :- <span><?php echo $data['description']; ?></span></h6>
                            <h6>Total Hours:- <span><?php echo $data['total_hours']; ?></span></h6>
                            <h6>Deadline:- <span><?php echo $data['deadline_date']; ?></span></h6>

                            <!-- btn apply -->
                            <div class="butns d-flex justify-content-end">
                                <form method="post">
                                    <input type="hidden" name="project_id" value="<?php echo $data['project_id']; ?>">
                                    <button class="butn" name="apply">Apply</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                  <?php } ?>
            </div>
          
        </div>
    </div>
</body>
</html>
