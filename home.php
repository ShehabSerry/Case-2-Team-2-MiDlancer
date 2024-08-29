<?php
include 'connection.php';

if(isset($_SESSION['user_id']))
    $user_id = $_SESSION['user_id'];
else if (isset($_SESSION['freelancer_id']))
    $LI_F_id = $_SESSION['freelancer_id']; // logged in freelancer

    $select_freelancer="SELECT * FROM `freelancer`";
    $runselect1=mysqli_query($connect, $select_freelancer);
    
    $freelancer_count_query = "SELECT COUNT(*) as freelancer_count FROM `freelancer`";
    $freelancer_result_result = mysqli_query($connect,$freelancer_count_query);
    $freelancer_count = mysqli_fetch_assoc($freelancer_result_result)['freelancer_count'];
    
    
   
    
    $select_user="SELECT * FROM `user` ";
    $runselect2=mysqli_query($connect, $select_user);
    
    $user_query = "SELECT COUNT(*) as user_count FROM `user`  ";
    $user_result = mysqli_query($connect,$user_query);
    $user_count = mysqli_fetch_assoc($user_result)['user_count'];
    
    
    
    
    $select_project="SELECT * FROM `project` ";
    $runselect3=mysqli_query($connect, $select_project);
    
    $project_query = "SELECT COUNT(*) as project_count FROM `project` ";
    $project_result = mysqli_query($connect,$project_query);
    $project_count = mysqli_fetch_assoc($project_result)['project_count'];


    $selectRate="SELECT * FROM `rate` 
    JOIN `user` ON `rate`.`user_id` = `user`.`user_id`
    JOIN `freelancer` ON `rate`.`freelancer_id` = `freelancer`.`freelancer_id` ";
    $runselectRate= mysqli_query($connect,$selectRate);

    $listCareer = "SELECT * FROM `career`";
    $execCareer = mysqli_query($connect, $listCareer);

    
    $select_freelancer_info = "SELECT `freelancer`.*,
                                    `career`.`career_path`,
                                    `rank`.`rank`,
                                    (AVG(`rate`.`rate1`) + AVG(`rate`.`rate2`) + AVG(`rate`.`rate3`)) / 3 AS `overall_avg`
                                FROM `freelancer`
                                JOIN `career` ON `career`.`career_id` = `freelancer`.`career_id`
                                JOIN `rank` ON `rank`.`rank_id` = `freelancer`.`rank_id`
                                JOIN `rate` ON `rate`.`freelancer_id` = `freelancer`.`freelancer_id`
                                GROUP BY `freelancer`.`freelancer_id`
                                ORDER BY `overall_avg` DESC
                                LIMIT 6";

    $run_select_info = mysqli_query($connect, $select_freelancer_info);

    if (isset($_SESSION['freelancer_id'])) {
        $LI_F_id = $_SESSION['freelancer_id']; 

        $select_freelancer_pre="SELECT * FROM freelancer
                                LEFT JOIN `subscription` ON `freelancer`.`freelancer_id` = `subscription`.`freelancer_id`
                                WHERE `freelancer`.`freelancer_id`= '$LI_F_id'";
        $run_pre= mysqli_query($connect,$select_freelancer_pre);
        
        if ($fetch_pre = mysqli_fetch_assoc($run_pre)) {
            $freelancer_plan = $fetch_pre['plan_id'];
        }
    }
 


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

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Navbar & Hero Start -->
        <div class="container-xxl position-relative p-0">
            <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5  py-lg-0">
                <a href="" class="navbar-brand p-0">
                    <h1 class="m-0"><img src="imgs/MiDlancer (2).png" class="w-50 " alt="">MiD<span
                            class="fs-5">LANCER</span></h1>
                    <!-- <img src="img/logo.png" alt="Logo"> -->
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0">
                        <?php  
                        // if((isset($_SESSION['user_id'])) OR (isset($_SESSION['freelancer_id']))){ ?>
                        <a href="home.php" class="nav-item nav-link active">Home</a>
                        <a href="career.php" class="nav-item nav-link">Careers</a>
                        <a href="wall.php" class="nav-item nav-link">Wall</a>
                        <?php
                        if(isset($_SESSION['user_id'])){ ?>
                          <a href="my_projects_client.php" class="nav-item nav-link">Projects</a>
                       <?php } elseif(isset($_SESSION['freelancer_id'])){ ?>
                        <a href="my_projects_freelancer.php" class="nav-item nav-link">Projects</a>
                        <?php }else{}
                        if(isset($_SESSION['user_id'])){ ?>
                          <a href="clientprofile.php" class="nav-item nav-link">Profile</a>
                       <?php } elseif(isset($_SESSION['freelancer_id'])){ ?>
                        <a href="FREELANCERPROFILE.php" class="nav-item nav-link">Profile</a>
                        <?php }else{} ?>
                      
                
                        <div class="nav-item dropdown"> 
                             <?php   if(isset($_SESSION['freelancer_id'])){ ?>
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                                  
                            <div class="dropdown-menu m-0">
                            
                     
                        <a href="job_postings.php" class="dropdown-item">Job Postings</a>
                         <a href="calendar.html" class="dropdown-item">Calendar</a>
                         <a href="dashboard.php" class="dropdown-item">Dashboard</a>
                        <?php } else{} ?>


                            </div>
                        </div>
                        <!-- <a href="contact.html" class="nav-item nav-link">Contact</a> -->
                    </div>
                   <?php if((!isset($_SESSION['user_id'])) AND (!isset($_SESSION['freelancer_id']))){ ?>

                    <a href="choose_login.php"
                        class="btn btn-outline-warning text-warning rounded-pill py-2 px-4 ms-3">Login</a>
                </div>
                <?php } ?>
            </nav>

            <div class="container-xxl py-5 bg-primary hero-header mb-5">
                <div class="container my-5 py-5 px-lg-5">
                    <div class="row g-5 py-5">
                        <div class="col-lg-6 text-center text-lg-start">
                            <h1 class="text-white mb-4 animated zoomIn">Talented Egyptian freelancers ready to collaborate</h1>
                            <p class="text-white pb-3 animated zoomIn">From Development to content creation, and more. Find the Perfect Freelance Service in Egypt</p>
                            <a href="wall.php"
                                class="btn btn-warning text-white py-sm-3 px-sm-5 rounded-pill me-3 animated slideInLeft">Explore</a>
                                <?php if((!isset($_SESSION['user_id'])) AND (!isset($_SESSION['freelancer_id']))){ ?>

                            <a href="choose.php"
                                class="btn btn-outline-warning py-sm-3 px-sm-5 rounded-pill animated slideInRight">Sign up</a>
                                <?php } ?>
                        </div>
                        <div class="col-lg-6 text-center text-lg-start
                        col-md-6 text-center d-md-block">
                            <img class="img-fluid pyramid" src="imgs/MiDlancer (2).png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Navbar & Hero End -->


        <!-- About Start -->
        <div class="container-xxl ">
            <div class="container px-lg-5">
                <div class="row g-5">
                    <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="section-title position-relative mb-4 pb-2">
                            <h6 class="position-relative text-warning ps-4">About Us</h6>
                            <h2 class="mt-2">Egypt's Leading Freelance Platform</h2>
                        </div>
                        <p class="mb-4">We connect businesses with top freelance talent in Egypt, providing a platform
                            for collaboration and innovation.</p>
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <h6 class="mb-3"><i class="fa fa-check text-warning me-2"></i>Expert Freelancers</h6>
                                <h6 class="mb-0"><i class="fa fa-check text-warning me-2"></i>Quality Services</h6>
                            </div>
                            <div class="col-sm-6">
                                <h6 class="mb-3"><i class="fa fa-check text-warning me-2"></i>24/7 Support</h6>
                                <h6 class="mb-0"><i class="fa fa-check text-warning me-2"></i>Competitive Pricing</h6>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mt-4">
                            <a  class="btn btn-warning text-white rounded-pill px-4 me-3" href="">Read More</a>

                            <a target="_blank"  class="btn btn-outline-warning btn-square me-3" href="https://www.facebook.com/profile.php?id=61564326657962&mibextid=ZbWKwL"><i
                                    class="fab fa-facebook-f"></i></a> <!-- FRONT: maybe target blank instead -->
                            <a target="_blank"  class="btn btn-outline-warning btn-square me-3" href="https://www.tiktok.com/@midlancer5?_t=8oxRnoCQ62H&_r=1"><i
                                     class="fa-brands fa-tiktok"></i></a> <!-- FRONT: maybe target blank instead -->
                            <a target="_blank"  class="btn btn-outline-warning btn-square me-3" href="https://www.instagram.com/midlancer.1/"><i
                                    class="fab fa-instagram"></i></a> <!-- FRONT: maybe target blank instead -->
                            <a target="_blank"  class="btn btn-outline-warning btn-square" href="https://www.snapchat.com/add/midlancer?share_id=qSo_IfiGjTg&locale=en-EG"><i class="fa-brands fa-snapchat"></i></a> <!-- FRONT: maybe target blank instead -->
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <img class="img-fluid wow zoomIn" data-wow-delay="0.5s" src="imgs/about.jpg">
                    </div>
                </div>
            </div>
        </div>
        <!-- About End -->


        <!-- features  -->

        <div id="features" class="features section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="features-content">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="features-item first-feature wow fadeInUp" data-wow-duration="1s"
                                        data-wow-delay="0s">
                                        <div class="first-number number">
                                            <h6>01</h6>
                                        </div>
                                        <div class="icon"></div>
                                        <h4>Get Emails</h4>
                                        <div class="line-dec"></div>
                                        <p>Stay in the loop with our latest updates offers,and news!</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="features-item second-feature wow fadeInUp" data-wow-duration="1s"
                                        data-wow-delay="0.2s">
                                        <div class="second-number number">
                                            <h6>02</h6>
                                        </div>
                                        <div class="icon"></div>
                                        <h4>Profile views</h4>
                                        <div class="line-dec"></div>
                                        <p>Monitor who's been viewing your profile with ease!</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <a href="plan.php">
                                    <div class="features-item features-item3 first-feature wow fadeInUp"
                                        data-wow-duration="1s" data-wow-delay="0.4s">
                                        <div class="third-number number">
                                            <h6>03</h6>
                                        </div>
                                        <div class="icon"></div>
                                        <h4 class="text-warning ">Premium</h4>
                                        <div class="line-dec"></div>
                                        <p>Unlock the full potential of our platform!<br><a
                                                rel="nofollow" href="" target="_blank">support us</a> a little.</p>
                                    </div>
                                </a>
                                </div>
                                <div class="col-lg-3">
                                    <div class="features-item second-feature last-features-item wow fadeInUp"
                                        data-wow-duration="1s" data-wow-delay="0.6s">
                                        <div class="fourth-number number">
                                            <h6>04</h6>
                                        </div>
                                        <div class="icon"></div>
                                        <h4>Pinned-in Freelancers</h4>
                                        <div class="line-dec"></div>
                                        <p>Highlight your top projects with the "Pinned" feature!</p>
                                    </div>
                                </div>
                            </div>
                            <?php
                            if(isset($_SESSION['freelancer_id']) && (!isset($freelancer_plan) || ($freelancer_plan == 1))){
                              ?>
                            <div class="position-relative w-100 mt-5">
                                <a href="./payment.php?plan=2">
                                <button class="cssbuttons-io-button" id="prembtn">
                                    Get Premium <br> 25$/Month
                                    <div class="icon">
                                        <svg height="27" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M0 0h24v24H0z" fill="none"></path>
                                            <path
                                                d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"
                                                fill="currentColor"></path>
                                        </svg>
                                    </div>
                                </button>
                            </a>
                            </div>
                            <?php } ?>

                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="skills-content">
                            <h3>Our customers</h3>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="skill-item wow fadeIn" data-wow-duration="1s" data-wow-delay="0s">
                                        <div class="progress" data-percentage="80">
                                            <span class="progress-left">
                                                <span class="progress-bar"></span>
                                            </span>
                                            <span class="progress-right">
                                                <span class="progress-bar"></span>
                                            </span>
                                            <div class="progress-value">
                                                <div>
                                        
                                                    <span>project</span>
                                                    <br><br><p><?php echo  $project_count; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="skill-item wow fadeIn" data-wow-duration="1s" data-wow-delay="0.4s">
                                        <div class="progress" data-percentage="90">
                                            <span class="progress-left">
                                                <span class="progress-bar"></span>
                                            </span>
                                            <span class="progress-right">
                                                <span class="progress-bar"></span>
                                            </span>
                                            <div class="progress-value">
                                                <div>
                                                   
                                                    <span>freelancer</span>
                                                    <br><br><p><?php echo $freelancer_count; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="skill-item last-skill-item wow fadeIn" data-wow-duration="1s"
                                        data-wow-delay="0.6s">
                                        <div class="progress" data-percentage="70">
                                            <span class="progress-left">
                                                <span class="progress-bar"></span>
                                            </span>
                                            <span class="progress-right">
                                                <span class="progress-bar"></span>
                                            </span>
                                            <div class="progress-value">
                                                <div>
                                                   
                                                    <span>users</span>
                                                    <br><br><p><?php echo $user_count;?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- end features  -->



        <!-- Newsletter Start -->
        <?php if((!isset($_SESSION['user_id'])) AND (!isset($_SESSION['freelancer_id']))){ ?>
        <div class="container-xxl bg-primary newsletter my-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="container px-lg-5">
                <div class="row align-items-center" style="height: 250px;">
                    <div class="col-12 col-md-6">
                        <h3 class="text-white">Ready to get started</h3>
                        <small class="text-white2">Diam elitr est dolore at sanctus nonumy.</small>
                        <div class="position-relative w-100 mt-3">
                            <a href="choose.php">
                            <button class="cssbuttons-io-button" id="scndbtn">
                                Get started
                                <div class="icon">
                                    <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 0h24v24H0z" fill="none"></path>
                                        <path
                                            d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"
                                            fill="currentColor"></path>
                                    </svg>
                                </div>
                            </button>
                        </a>
                        </div>
                    </div>
                    <div class="col-md-6 text-center mb-n5 d-none d-md-block">
                        <img class="img-fluid " style="height: 300px;" src="imgs/head.png">
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <!-- Newsletter End -->


        <!-- Service Start -->
        <div class="container-xxl py-5">
            <div class="container px-lg-5">
                <div class="section-title position-relative text-center mb-5 pb-2 wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="position-relative d-inline text-warning ps-4">Our Services</h6>
                    <h2 class="mt-2">What Solutions We Provide</h2>
                </div>
                <div class="row g-4">
                    <?php $dwd='0.1s';
                    foreach ($execCareer as $cData) { ?>
                    <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="<?php if($dwd == '0.1s'){ echo $dwd; $dwd='0.3s';} elseif ($dwd == '0.3s'){echo $dwd; $dwd = '0.6s';}elseif ($dwd == '0.6s'){echo $dwd; $dwd = '0.1s';} ?>">
                        <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                            <div class="service-icon flex-shrink-0">
                                <i class="fa-solid fa-ankh"></i>
                            </div>
                            <h5 class="mb-3"><?php echo $cData['career_path']?></h5>
                            <p><?php echo $cData['career_desc']?></p>
                            <a class="btn px-3 mt-auto mx-auto" href="freelancers.php?cid=<?php echo $cData['career_id']?>">Read More</a>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <!-- Service End -->
       <!-- Testimonial Start -->
       <div class="container-xxl bg-primary testimonial py-5 my-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container py-5 px-lg-5">
            <div class="owl-carousel testimonial-carousel">
                <?php foreach($runselectRate as $data){ ?>
                    <div class="testimonial-item bg-transparent border rounded text-white p-4">
                    <i class="fa fa-quote-left fa-2x mb-3"></i>
                    <p> <?php echo $data['comment'];?></p>
                    <div class="d-flex align-items-center">
                        <img class="img-fluid flex-shrink-0 rounded-circle" src="imgs/testimonial-1.jpg"
                            style="width: 50px; height: 50px;">
                        <div class="ps-3">
                            <h6 class="text-white mb-1"><?php echo $data['user_name'];?></h6>
                            <small><?php echo $data['freelancer_name'];?></small>
                        </div>
                    </div>
                </div>
                    <?php } ?>
            </div>
        </div>
     </div>
                
                <!-- <div class="testimonial-item bg-transparent border rounded text-white p-4">
                    <i class="fa fa-quote-left fa-2x mb-3"></i>
                    <p>Dolor et eos labore, stet justo sed est sed. Diam sed sed dolor stet amet eirmod eos labore
                        diam</p>
                    <div class="d-flex align-items-center">
                        <img class="img-fluid flex-shrink-0 rounded-circle" src="imgs/testimonial-2.jpg"
                            style="width: 50px; height: 50px;">
                        <div class="ps-3">
                            <h6 class="text-white mb-1">Client Name</h6>
                            <small>Profession</small>
                        </div>
                    </div>
                </div>
                <div class="testimonial-item bg-transparent border rounded text-white p-4">
                    <i class="fa fa-quote-left fa-2x mb-3"></i>
                    <p>Dolor et eos labore, stet justo sed est sed. Diam sed sed dolor stet amet eirmod eos labore
                        diam</p>
                    <div class="d-flex align-items-center">
                        <img class="img-fluid flex-shrink-0 rounded-circle" src="imgs/testimonial-3.jpg"
                            style="width: 50px; height: 50px;">
                        <div class="ps-3">
                            <h6 class="text-white mb-1">Client Name</h6>
                            <small>Profession</small>
                        </div>
                    </div>
                </div>
                <div class="testimonial-item bg-transparent border rounded text-white p-4">
                    <i class="fa fa-quote-left fa-2x mb-3"></i>
                    <p>Dolor et eos labore, stet justo sed est sed. Diam sed sed dolor stet amet eirmod eos labore
                        diam</p>
                    <div class="d-flex align-items-center">
                        <img class="img-fluid flex-shrink-0 rounded-circle" src="imgs/testimonial-4.jpg"
                            style="width: 50px; height: 50px;">
                        <div class="ps-3">
                            <h6 class="text-white mb-1">Client Name</h6>
                            <small>Profession</small>
                        </div>
                    </div>
                </div> -->
    <!-- Testimonial End -->


        <!-- Portfolio Start -->
        <div class="container-xxl py-5">
            <div class="container px-lg-5">
                <div class="section-title position-relative text-center mb-5 pb-2 wow fadeInUp" data-wow-delay="0.1s">
                    <!-- <h6 class="position-relative d-inline text-warning ps-4">Our Projects</h6> -->
                    <h2 class="mt-2">Our Top Freelancers</h2>
                </div>
                <!-- <div class="row mt-n2 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="col-12 text-center">
                        <ul class="list-inline mb-5" id="portfolio-flters">
                            <li class="btn px-3 pe-4 active" data-filter="*">All</li>
                            <li class="btn px-3 pe-4" data-filter=".first">Design</li>
                            <li class="btn px-3 pe-4" data-filter=".second">Development</li>
                        </ul>
                    </div>
                </div> -->
                <div class="row g-4 portfolio-container">
                    <?php foreach($run_select_info as $key){ ?>
                    <div class="col-lg-4 col-md-6 portfolio-item first wow zoomIn" data-wow-delay="0.1s">
                        <a  href="./freelancerview.php?vfid=<?php echo $key['freelancer_id'] ?>">
                        <div class="position-relative rounded overflow-hidden">
                            <img class="img-fluid w-100" src="img/profile/<?php echo $key['freelancer_image'] ?>" alt="">
                            <div class="portfolio-overlay">
                                <!-- <a class="btn btn-light" href="./freelancerview.php?vfid=<?php// echo $key['freelancer_id'] ?>" data-lightbox="portfolio"><i
                                        class="fa fa-plus fa-2x text-primary"></i></a> -->
                                <div class="mt-auto">
                                    <small class="text-white"><?php echo $key['freelancer_name'] ?></small>
                                    <p class="h5 d-block text-white mt-1 mb-0" ><?php echo $key['career_path'] ?></p>
                                    <p class="h5 d-block text-white mt-1 mb-0" ><?php echo $key['rank'] ?></p>
                                    <p class="h5 d-block text-white mt-1 mb-0" >Rate: <?php echo round($key['overall_avg'], 2) ?></p>
                                </div>
                            </div>
                        </div>
                    </a>
                    </div>
                    <?php } ?>
                    <!-- <div class="col-lg-4 col-md-6 portfolio-item second wow zoomIn" data-wow-delay="0.3s">
                        <div class="position-relative rounded overflow-hidden">
                            <img class="img-fluid w-100" src="imgs/portfolio-2.jpg" alt="">
                            <div class="portfolio-overlay">
                                <a class="btn btn-light" href="imgs/portfolio-2.jpg" data-lightbox="portfolio"><i
                                        class="fa fa-plus fa-2x text-primary"></i></a>
                                <div class="mt-auto">
                                    <small class="text-white"><i class="fa fa-folder me-2"></i>Web Design</small>
                                    <a class="h5 d-block text-white mt-1 mb-0" href="">Project Name</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 portfolio-item first wow zoomIn" data-wow-delay="0.6s">
                        <div class="position-relative rounded overflow-hidden">
                            <img class="img-fluid w-100" src="imgs/portfolio-3.jpg" alt="">
                            <div class="portfolio-overlay">
                                <a class="btn btn-light" href="imgs/portfolio-3.jpg" data-lightbox="portfolio"><i
                                        class="fa fa-plus fa-2x text-primary"></i></a>
                                <div class="mt-auto">
                                    <small class="text-white"><i class="fa fa-folder me-2"></i>Web Design</small>
                                    <a class="h5 d-block text-white mt-1 mb-0" href="">Project Name</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 portfolio-item second wow zoomIn" data-wow-delay="0.1s">
                        <div class="position-relative rounded overflow-hidden">
                            <img class="img-fluid w-100" src="imgs/portfolio-4.jpg" alt="">
                            <div class="portfolio-overlay">
                                <a class="btn btn-light" href="imgs/portfolio-4.jpg" data-lightbox="portfolio"><i
                                        class="fa fa-plus fa-2x text-primary"></i></a>
                                <div class="mt-auto">
                                    <small class="text-white"><i class="fa fa-folder me-2"></i>Web Design</small>
                                    <a class="h5 d-block text-white mt-1 mb-0" href="">Project Name</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 portfolio-item first wow zoomIn" data-wow-delay="0.3s">
                        <div class="position-relative rounded overflow-hidden">
                            <img class="img-fluid w-100" src="imgs/portfolio-5.jpg" alt="">
                            <div class="portfolio-overlay">
                                <a class="btn btn-light" href="imgs/portfolio-5.jpg" data-lightbox="portfolio"><i
                                        class="fa fa-plus fa-2x text-primary"></i></a>
                                <div class="mt-auto">
                                    <small class="text-white"><i class="fa fa-folder me-2"></i>Web Design</small>
                                    <a class="h5 d-block text-white mt-1 mb-0" href="">Project Name</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 portfolio-item second wow zoomIn" data-wow-delay="0.6s">
                        <div class="position-relative rounded overflow-hidden">
                            <img class="img-fluid w-100" src="imgs/portfolio-6.jpg" alt="">
                            <div class="portfolio-overlay">
                                <a class="btn btn-light" href="imgs/portfolio-6.jpg" data-lightbox="portfolio"><i
                                        class="fa fa-plus fa-2x text-primary"></i></a>
                                <div class="mt-auto">
                                    <small class="text-white"><i class="fa fa-folder me-2"></i>Web Design</small>
                                    <a class="h5 d-block text-white mt-1 mb-0" href="">Project Name</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
        <!-- Portfolio End -->


 

        <!-- Footer Start -->
        <div class="container-fluid pt-5 text-light footer  wow fadeIn" data-wow-delay="0.1s">
            <div class="haha"></div>
            <div class="haha pt-5">
                <div class="container pt-5 px-lg-5">
                    <div class="row g-5">
                        <div class="col-md-6 col-lg-3">
                            <h5 class="text-white mb-4">Get In Touch</h5>
                            <p><i class="fa fa-map-marker-alt me-3"></i>123 Street, New York, USA</p>
                            <p><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
                            <p><i class="fa fa-envelope me-3"></i>MiDlancerTeam@gmail.com</p>
                            <div class="d-flex pt-2">
                                
                                <a target="_blank" class="btn btn-outline-light btn-social" href="https://www.facebook.com/profile.php?id=61564326657962&mibextid=ZbWKwL"><i
                                        class="fab fa-facebook-f"></i></a>
                               
                                <a target="_blank"  class="btn btn-outline-light btn-social" href="https://www.instagram.com/midlancer.1/"><i class="fab fa-instagram"></i></a>
                                <a target="_blank"  class="btn btn-outline-light btn-social" href="https://www.tiktok.com/@midlancer5?_t=8oxRnoCQ62H&_r=1"><i
                                     class="fa-brands fa-tiktok"></i></a>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <h5 class="text-white mb-4">Popular Link</h5>
                            <a class="btn btn-link" href="">About Us</a>
                            <a class="btn btn-link" href="">Contact Us</a>
                           
                            <a class="btn btn-link" href="">Terms & Condition</a>
                            <a class="btn btn-link" href="career.php">Career</a>
                        </div>

                        <div class="col-md-6 col-lg-6 mt-auto pe-5  mb-4">
                            <h5 class="text-white mb-4">Newsletter</h5>
                            <p>Lorem ipsum dolor sit amet elit. Phasellus nec pretium mi. Curabitur facilisis ornare
                                velit non vulpu</p>
                                <a href="choose.php">
                                <button class="cssbuttons-io-button">
                                Get started
                                <div class="icon">
                                        <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M0 0h24v24H0z" fill="none"></path>
                                            <path
                                                d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"
                                                fill="currentColor"></path>
                                        </svg>
                                    </div>
                                </button>
                            </a>
                        </div>

                    </div>
                </div>
                <div class="container px-lg-5">
                    <div class="copyright">
                        <div class="row">
                            <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                                &copy; <a class="border-bottom" href="#">MID LANCER</a>, All Right Reserved.
                                Designed By <a class="border-bottom" href="">team 2</a>
                            </div>
                            <div class="col-md-6 text-center text-md-end">
                                <div class="footer-menu">
                                    <a href="">Home</a>
                                    <a href="">Cookies</a>
                                    <a href="">Help</a>
                                    <a href="">FQAs</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- Footer End -->
        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top pt-2"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/isotope/isotope.pkgd.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>
