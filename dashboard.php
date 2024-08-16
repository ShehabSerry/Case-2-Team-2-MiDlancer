<?php
include("connection.php");
// if the user is not logged in 
// uncomment when done
// if(empty($_SESSION['freelancer_id'])){
//     header("location:home.php");
// }

if(isset($_SESSION['freelancer_id'])){
    $freelancer_id=$_SESSION['freelancer_id'];
}
$select_views="SELECT * FROM `views` WHERE `freelancer_id`= $freelancer_id";
$run_select_views=mysqli_query($connect, $select_views);
// COUNT VIEWS
$view_count_query = "SELECT COUNT(*) as view_count FROM `views` WHERE `freelancer_id` = $freelancer_id ";
$view_result_result = mysqli_query($connect,$view_count_query);
$view_count = mysqli_fetch_assoc($view_result_result)['view_count'];


$select_project="SELECT * FROM `team_member` WHERE `freelancer_id`= $freelancer_id";
$run_select_project=mysqli_query($connect, $select_project);
// COUNT PROJECTS
$project_query = "SELECT COUNT(*) as project_count FROM `team_member` WHERE `freelancer_id` = $freelancer_id ";
$project_result = mysqli_query($connect,$project_query);
$project_count = mysqli_fetch_assoc($project_result)['project_count'];

$select_comment="SELECT * FROM `comment` WHERE `freelancer_id`= $freelancer_id";
$run_select_comment=mysqli_query($connect, $select_project);
// COUNT COMMENTS
$comment_query = "SELECT COUNT(*) as comment_count FROM `comment` WHERE `freelancer_id` = $freelancer_id ";
$comment_result = mysqli_query($connect,$comment_query);
$comment_count = mysqli_fetch_assoc($comment_result)['comment_count'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>midlancer</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500&family=Jost:wght@500;600;700&display=swap" rel="stylesheet"> 

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="css/dashboard.css" rel="stylesheet">
</head>

<body>
<?php include("nav+bm.php"); ?> 

    <div class="container-xxl p-0">
        

        <!-- About Start -->
        <div class="container-xxl py-5" id="about">
            <div class="container py-5 px-lg-5">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                        <h5 class="text-primary-gradient fw-medium">About Profile</h5>
                        <h1 class="mb-4">Keep Up with your profile</h1>
                        <p class="mb-5">"Add more information to your profile to improve its visibility and effectiveness. Analyzing and enhancing your profile can help you make a stronger impression and attract more opportunities."</p>
                        <div class="row g-4 mb-4">
                            
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.5s">
                                <div class="d-flex">
                                    <i class="fa fa-cogs fa-2x text-primary-gradient flex-shrink-0 mt-1"></i>
                                    <div class="ms-3">
                                        <h2 class="mb-0" data-toggle="counter-up"><?php echo $view_count; ?></h2>
                                        <p class="text-primary-gradient mb-0">Profile Vews</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.7s">
                                <div class="d-flex">
                                    <i class="fa fa-comments fa-2x text-secondary-gradient flex-shrink-0 mt-1"></i>
                                    <div class="ms-3">
                                        <h2 class="mb-0" data-toggle="counter-up"><?php echo $project_count; ?></h2>
                                        <p class="text-secondary-gradient mb-0">Projects Numbar</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 wow fadeIn m-auto" data-wow-delay="0.7s">
                                <div class="d-flex justify-content-center">
                                    <i class="fa fa-user fa-2x text-secondary-gradient flex-shrink-0 mt-1"></i>
                                    <div class="ms-3">
                                        <h2 class="mb-0" data-toggle="counter-up"><?php echo $comment_count; ?></h2>
                                        <p class="text-secondary-gradient mb-0">Clients Reviews</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="./FREELANCERPROFILE.php" class="btn btn-primary-gradient py-sm-3 px-4 px-sm-5 rounded-pill mt-3">profile</a>
                    </div>
                    <div class="col-lg-6">
                        <img class="img-fluid wow fadeInUp" data-wow-delay="0.5s" src="img/undraw_analysis_dq08.svg">
                    </div>
                </div>
            </div>
        </div>
        <!-- About End -->


    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>

    <!-- Javascript -->
    <script src="js/main.js"></script>
</body>

</html>