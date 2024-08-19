<?php
include 'connection.php';
if(isset($_SESSION['user_id']))
    $user_id = $_SESSION['user_id'];
else if (isset($_SESSION['freelancer_id']))
    $LI_F_id = $_SESSION['freelancer_id']; // logged in freelancer

if(isset($user_id))
{
    $showBkmrk = "SELECT *,`freelancer`.`freelancer_id` AS 'f_fid' FROM `bookmark`
                  JOIN `freelancer` ON `bookmark`.`freelancer_id` = `freelancer`.`freelancer_id`
                  JOIN `rank` ON `freelancer`.`rank_id` = `rank`.`rank_id`
                  WHERE `bookmark`.`user_id` = '$user_id'
                  AND  `freelancer`.`hidden` = '0'
                  GROUP BY `freelancer`.`freelancer_id`
                  ORDER BY `premium` DESC, `rank`.`rank_id` DESC, `price/hr` DESC
                 ";
    $execShowBkmrk = mysqli_query($connect, $showBkmrk);
    $bkmrkCount = mysqli_num_rows($execShowBkmrk); // count all
    $showBkmrk .= " LIMIT 5";
    $execShowBkmrk2 = mysqli_query($connect, $showBkmrk); // actual exec
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>SEO Master </title>
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
                        <a href="home.php" class="nav-item nav-link active">Home</a>
                        <?php if(isset($user_id)) {?>
                        <a href="client_profile.php" class="nav-item nav-link">profile</a>
                        <a href="career.php" class="nav-item nav-link">career</a>
                        <?php } else if(isset($LI_F_id)) {?>
                        <a href="client_profile.php" class="nav-item nav-link">profile</a>
                        <a href="career.php" class="nav-item nav-link">career</a>
                        <?php } else {?>
                        <a href="career.php" class="nav-item nav-link">career</a>
                        <?php }?>

                        <a href="#" class="nav-item nav-link">requests</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                            <div class="dropdown-menu m-0">
                                <a href="#" class="dropdown-item">career path</a>
                                <?php if(isset($user_id)) {?>
                                <a href="my_projects_client.php" class="dropdown-item">my projects</a>
                                <a href="#" class="dropdown-item">jop posting</a>
                                <?php } else if(isset($LI_F_id)) {?>
                                <a href="my_projects_client.php" class="dropdown-item">my projects</a>
                                <?php } else {?>
                                <?php }?>

                            </div>
                        </div>
                        <a href="contact.html" class="nav-item nav-link">wall</a>
                    </div>
                     <!-- bookmark -->
                    <?php $currpage = basename($_SERVER['PHP_SELF']);
                        if(isset($user_id) &&  $currpage != 'career.php') {?> <!-- BACK decide?? show bkmrk menu for clients only -->
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
                                <form method="post">
                                <button class="cssbuttons-io-button-freelancer" name="get_drop_down">
                                    <?php
                                        if (isset($_POST['get_drop_down']))
                                        {
                                            $freelancer_id = $data['f_fid'];
                                            header("Location: select_project.php?vfid=$freelancer_id");
                                         }
                                        ?>
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
                    <a href="freelancers.php?b=1" class="btn-bookmark btn-outline-warning">show more</a> <!-- BACK/FRONT DECIDE? show btn when bkmrk > 5 -->
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
