<?php
include 'connection.php';
if(isset($_SESSION['user_id']))
    $user_id = $_SESSION['user_id'];
else if (isset($_SESSION['freelancer_id']))
    $LI_F_id = $_SESSION['freelancer_id']; // logged in freelancer





if(isset($user_id))
{

    $applicant="SELECT * FROM `applicants` 
    JOIN `project` ON `applicants`.`project_id` = `project`.`project_id`
    JOIN `freelancer` ON `applicants`.`freelancer_id` = `freelancer`.`freelancer_id`
    JOIN `career` ON `freelancer`.`career_id` = `career`.`career_id`
    WHERE `project`.`user_id` = '$user_id'";
$run_a = mysqli_query($connect, $applicant);
$count_a=mysqli_num_rows($run_a);
// echo $count_a;


$request="SELECT * FROM `request`
JOIN `project` ON `request`.`project_id` = `project`.`project_id`
JOIN `freelancer` ON `request`.`freelancer_id` = `freelancer`.`freelancer_id`
JOIN `user` ON `project`.`user_id` = `user`.`user_id`
JOIN `career` ON `freelancer`.`career_id` = `career`.`career_id`
WHERE `request`.`status` = 'accept' AND `user`.`user_id` = '$user_id'";
$run_r = mysqli_query($connect, $request);
$count_r=mysqli_num_rows($run_r);
// echo $count_r;
$notifi=$count_a + $count_r;
    $showBkmrk = "SELECT *,`freelancer`.`freelancer_id` AS 'f_fid' FROM `bookmark`
                    JOIN `freelancer` ON `bookmark`.`freelancer_id` = `freelancer`.`freelancer_id`
                    JOIN `rank` ON `freelancer`.`rank_id` = `rank`.`rank_id`
                    LEFT JOIN `subscription` ON `freelancer`.`freelancer_id` = `subscription`.`freelancer_id`
                    WHERE `bookmark`.`user_id` = '$user_id' AND `freelancer`.`admin_hidden`='0' AND  `freelancer`.`hidden` = '0'
                    GROUP BY `freelancer`.`freelancer_id`
                    ORDER BY `rank`.`rank_id` DESC,`subscription`.`plan_id` DESC, `price/hr` DESC ";
    $execShowBkmrk = mysqli_query($connect, $showBkmrk);
    $bkmrkCount = mysqli_num_rows($execShowBkmrk); // count all
    $showBkmrk .= " LIMIT 5";
    $execShowBkmrk2 = mysqli_query($connect, $showBkmrk); // actual exec
}elseif (isset($_SESSION['freelancer_id'])){
$income="SELECT distinct * FROM `request` 
JOIN `project` ON `request`.`project_id` = `project`.`project_id` 
JOIN `freelancer` ON `request`.`freelancer_id` = `freelancer`. `freelancer_id` 
 JOIN `user` ON `project`.`user_id` = `user`.`user_id` 
 WHERE `request`.`status` = 'pending' AND `freelancer`.`freelancer_id` = $LI_F_id  ";
 $run_i=mysqli_query($connect,$income);
 $count_i=mysqli_num_rows($run_i);}


$currpage = basename($_SERVER['PHP_SELF']);
$pageArray =
    [
        'home.php' => ($currpage == 'home.php') ? ' active' : '',
        'clientprofile.php' => ($currpage == 'clientprofile.php') ? ' active' : '',
        'FREELANCERPROFILE.php' => ($currpage == 'FREELANCERPROFILE.php') ? ' active' : '',
        'career.php' => ($currpage == 'career.php') ? ' active' : '',
        'accepted-requests.php' => ($currpage == 'accepted-requests.php') ? ' active' : '',
        'my_projects_client.php' => ($currpage == 'my_projects_client.php') ? ' active' : '',
        'income-request.php' => ($currpage == 'income-request.php') ? ' active' : '',
        'my_projects_freelancer.php' => ($currpage == 'my_projects_freelancer.php') ? ' active' : '',
        'wall.php' => ($currpage == 'wall.php') ? ' active' : '',
    ];


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>MiDlancer</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="imgs/logo.png" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500&family=Roboto:wght@400;500;700&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
          integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/nav+bm.css" rel="stylesheet">
</head>
<body>






<!-- Navbar & Hero Start -->
<div class="container-xxl position-relative p-0">
    <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5  py-lg-0">
        <a href="home.php" class="navbar-brand p-0">
            <h1 class="m-0"><img src="imgs/MiDlancer (2).png" class="w-50 " alt="">MiD<span
                        class="fs-5">LANCER</span></h1>
            <!-- <img src="img/logo.png" alt="Logo"> -->
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="fa fa-bars"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">
                <a href="home.php" class="nav-item nav-link<?php echo $pageArray['home.php'] ?>">Home</a>
                <a href="career.php" class="nav-item nav-link<?php echo $pageArray['career.php']; ?>">Career</a>
                <a href="wall.php" class="nav-item nav-link<?php echo $pageArray['wall.php'] ?>">Wall</a>


                <?php if(isset($user_id)){ ?>
                    <a href="my_projects_client.php" class="nav-item nav-link<?php echo $pageArray['my_projects_client.php']; ?>">Projects</a>
                    <a href="clientprofile.php" class="nav-item nav-link<?php echo $pageArray['clientprofile.php'] ?>">Profile</a>
                    <a href="accepted-requests.php" class="nav-item nav-link<?php echo $pageArray['accepted-requests.php']; ?>"><i class="fa-solid fa-bell" style="color: #f6d673;"></i>       <span class="position-absolute start-100 translate-middle text-danger badge">
   <?php echo $notifi; ?>
    <span class="visually-hidden">unread messages</span>
  </span></i> </a>
                <?php }else if(isset($LI_F_id)){ ?>
                    <a href="my_projects_freelancer.php" class="nav-item nav-link<?php echo $pageArray['my_projects_freelancer.php']; ?>">Projects</a>
                    <a href="FREELANCERPROFILE.php" class="nav-item nav-link<?php echo $pageArray['FREELANCERPROFILE.php']; ?>">Profile</a>
                    <a href="income-request.php" class="nav-item nav-link<?php echo $pageArray['income-request.php']; ?>"><i class="fa-solid fa-bell" style="color: #f6d673;"></i>        <span class="position-absolute start-100 translate-middle text-danger badge">
    <?php echo $count_i;; ?>

    <span class="visually-hidden">unread messages</span>
  </span></i> </a>

                <?php } ?>
          
                <div class="nav-item dropdown">
                    <?php   if(isset($LI_F_id)){ ?>
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>

                    <div class="dropdown-menu m-0">
                        <a href="job_postings.php" class="dropdown-item">Job Postings</a>
                        <a href="calendar.php" class="dropdown-item">Calendar</a>
                        <a href="dashboard.php" class="dropdown-item">Dashboard</a>
                    </div>
                    <?php }?>
                </div>
                <?php if((!isset($_SESSION['user_id'])) AND (!isset($_SESSION['freelancer_id']))){ ?>
                    <a href="choose_login.php"
                        class="nav-item nav-link">Login</a>
                    </div>
                <?php } ?>
            </div>
            <!-- bookmark -->
            <?php
            if(isset($user_id) ) {?> <!-- BACK decide?? show bkmrk menu for clients only -->
            <button class=" btn-outline-warning ms-1 btn btn-warning text-light rounded-pill py-2 px-4 ms-3" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
                <i class="fa-regular fa-bookmark "></i></button>

            <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions"
                 aria-labelledby="offcanvasWithBothOptionsLabel">
                <div class="offcanvas-header">
                    <h3 class="offcanvas-title" id="offcanvasWithBothOptionsLabel"><i class="fa-regular fa-bookmark"></i> Bookmark </h3>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">


                    <div class="cards-freelancer">
                        <!-- start freelancer card -->
                        <?php if($bkmrkCount > 0) {foreach ($execShowBkmrk2 as $data) { ?>
                            <div class="main-dashcard">
                                <div class="top">
                                    <div class="image-freelancer">
                                        <img src="img/profile/<?php echo $data['freelancer_image']?>" alt="profile pic">
                                    </div>

                                    <?php if (isset($_POST['bkmrk-btnn'])) { $fid = $data['f_fid']; // compact more like unreadable LOL
                                        $delBookmark = "DELETE FROM bookmark WHERE freelancer_id = '$fid' AND user_id = '$user_id'";mysqli_query($connect, $delBookmark);
                                        header("Refresh:0;"); exit();} ?>
                                    <form method="post" class="ms-auto"> <!-- I NEED THE FORM -- BUT IT STICKS TO THE PROFILE -->
                                        <button class="btn" name="bkmrk-btnn">
                                            <a href="#"><i class="fa-solid fa-bookmark"></i></a> <!-- I tried SOLID but it still looks regular) -->
                                        </button>
                                    </form>
                                </div>
                                <div class="title d-flex justify-content-center mt-3">
                                    <h2><?php echo $data['freelancer_name']?></h2>
                                </div>
                                <div><p><?php echo $data['bio']?></p> <!-- BACK decide?? job title, bio or career??? --></div>
                                <div class="content-freelancer">
                                    <div class="d-flex">
                                        <i class="fa-solid fa-user me-2 mt-1"></i>
                                        <p class=""><?php echo $data['rank']?></p>
                                    </div>
                                    <div class="d-flex ">
                                        <i class="fa-solid fa-dollar-sign me-2 mt-1"></i>
                                        <p><?php echo $data['price/hr']?> $/h</p>
                                    </div>

                                </div>
                                <!-- div of content -->
                                <div class="w-100">
                                    <p><?php echo $data['job_title']?></p> <!-- BACK decide?? job title, bio or career??? -->

                                </div>

                                <!-- --------------------- -->

                                <div class="buttons ">

                                    <!-- getstarted btn -->
                                    <form method="post" action="select_project.php?vfid=<?php echo $data['f_fid'] ?>">
                                        <button class="cssbuttons-io-button-freelancer" name="get_drop_down">
                                            <div class="icon-freelancer">
                                                <svg height="24" width="24" viewBox="0 0 24 24"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M0 0h24v24H0z" fill="none"></path>
                                                    <path
                                                            d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"
                                                            fill="currentColor"></path>
                                                </svg>
                                            </div>
                                        </button>
                                    </form>
                                </div>

                            </div>
                        <?php }} ?>
                        <!-- End freelancer div -->
                        <!-- start freelancer card -->
                    </div>
                </div>
                <?php if ($bkmrkCount > 5) { ?>
                    <div class="btn-container">
                        <a href="pinned_freelancers.php" class="btn-bookmark btn-outline-warning">show more</a> <!-- BACK/FRONT DECIDE? show btn when bkmrk > 5 -->
                    </div>
                <?php }} ?>

                <!-- end bookmark -->
            </div>
    </nav>
</div>
<!-- Navbar & Hero End -->

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="lib/wow/wow.min.js"></script>
<script src="lib/waypoints/waypoints.min.js"></script>


<!-- Template Javascript -->
<script src="js/main.js"></script>
</body>

</html>
