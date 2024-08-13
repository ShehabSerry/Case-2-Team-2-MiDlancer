<?php
include 'connection.php';
if(isset($_SESSION['user_id']))
    $user_id = $_SESSION['user_id'];
else if (isset($_SESSION['freelancer_id']))
    $LI_F_id = $_SESSION['freelancer_id']; // logged in freelancer
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
                <a href="index.php" class="navbar-brand p-0">
                    <h1 class="m-0"><img src="imgs/MiDlancer (2).png" class="w-50 " alt="">MiD<span
                            class="fs-5">LANCER</span></h1>
                    <!-- <img src="img/logo.png" alt="Logo"> -->
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0">
                        <a href="index.php" class="nav-item nav-link active">Home</a>
                        <a href="#" class="nav-item nav-link">About</a> <!-- NOTE we lack an about us page -->
                        <a href="#" class="nav-item nav-link">Service</a> <!-- NOTE we lack a service page??? what is a "service" page... -->
                        <?php if(isset($LI_F_id)) {?>
                        <a href="my_projects_freelancer.php" class="nav-item nav-link">Project</a>
                        <?php } else if(isset($user_id)) {?>
                        <a href="my_projects_client.php" class="nav-item nav-link">Project</a>
                        <?php } else {?> <!-- projects won't show up if not logged in -->
                        <?php } ?>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                            <div class="dropdown-menu m-0">
                                <a href="team.html" class="dropdown-item">Our Team</a> <!-- NOTE we lack a TEAM page??? -->
                            </div>
                        </div>
                        <a href="contact.html" class="nav-item nav-link">Contact</a> <!-- NOTE we lack a CONTACT us page??? -->
                    </div>

                    <a href=""
                        class="btn btn-outline-warning text-warning rounded-pill py-2 px-4 ms-3">sign up</a> <!-- we have 2 signup pages, yet no intermediary page to pick from) -->
                </div>
            </nav>

            <div class="container-xxl py-5 bg-primary hero-header mb-5">
                <div class="container my-5 py-5 px-lg-5">
                    <div class="row g-5 py-5">
                        <div class="col-lg-6 text-center text-lg-start">
                            <h1 class="text-white mb-4 animated zoomIn">Egypt's Top Freelancers at Your Service</h1>
                            <p class="text-white pb-3 animated zoomIn">Get the best freelance services in Egypt, from
                                web development to content creation, and more.</p>
                            <a href=""
                                class="btn btn-warning text-white py-sm-3 px-sm-5 rounded-pill me-3 animated slideInLeft">Free
                                Quote</a> <!-- NOTE we have 0 idea -->
                            <a href=""
                                class="btn btn-outline-warning py-sm-3 px-sm-5 rounded-pill animated slideInRight">Contact
                                Us</a> <!-- NOTE we lack a Contact us page -->
                        </div>
                        <div class="col-lg-6 text-center text-lg-start
                        col-md-6 text-center d-md-block">
                            <img class="img-fluid pyramid" src="imgs/12.jpeg" alt="">
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
                            <a class="btn btn-warning text-white rounded-pill px-4 me-3" href="">Read More</a> <!-- NOTE we lack read more -->
                            <a class="btn btn-outline-warning btn-square me-3" href="https://www.facebook.com/profile.php?id=61564326657962"><i
                                    class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-warning btn-square me-3" href=""><i <!-- NOTE we lack TW -->
                                    class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-warning btn-square me-3" href="https://www.instagram.com/midlancer.1/"><i
                                    class="fab fa-instagram"></i></a>
                            <a class="btn btn-outline-warning btn-square" href=""><i class="fab fa-linkedin-in"></i></a> <!-- NOTE we lack Lin -->
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
                                        <h4>Reach Out</h4>
                                        <div class="line-dec"></div>
                                        <p>This HTML5 template is based on Bootstrap 5 CSS. You are free to customize
                                            anything.</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="features-item second-feature wow fadeInUp" data-wow-duration="1s"
                                        data-wow-delay="0.2s">
                                        <div class="second-number number">
                                            <h6>02</h6>
                                        </div>
                                        <div class="icon"></div>
                                        <h4>Develop a Strategy</h4>
                                        <div class="line-dec"></div>
                                        <p>Lorem ipsum dolor sit ameter consectetur adipiscing li elit sed do eiusmod.
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="features-item features-item3 first-feature wow fadeInUp"
                                        data-wow-duration="1s" data-wow-delay="0.4s">
                                        <div class="third-number number">
                                            <h6>03</h6>
                                        </div>
                                        <div class="icon"></div>
                                        <h4>Implementation</h4>
                                        <div class="line-dec"></div>
                                        <p>If this template is useful for your website, please consider to <a
                                                rel="nofollow" href="" target="_blank">support us</a> a little.</p>  <!-- NOTE 0 idea -->
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="features-item second-feature last-features-item wow fadeInUp"
                                        data-wow-duration="1s" data-wow-delay="0.6s">
                                        <div class="fourth-number number">
                                            <h6>04</h6>
                                        </div>
                                        <div class="icon"></div>
                                        <h4>Analyze the result</h4>
                                        <div class="line-dec"></div>
                                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Obcaecati, temporibus deserunt provident.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="skills-content">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="skill-item wow fadeIn" data-wow-duration="1s" data-wow-delay="0s">
                                        <div class="progress" data-percentage="80"> <!-- What does this represent -->
                                            <span class="progress-left">
                                                <span class="progress-bar"></span>
                                            </span>
                                            <span class="progress-right">
                                                <span class="progress-bar"></span>
                                            </span>
                                            <div class="progress-value">
                                                <div>
                                                    80%<br>
                                                    <span>project</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="skill-item wow fadeIn" data-wow-duration="1s" data-wow-delay="0.4s">
                                        <div class="progress" data-percentage="90"> <!-- What does this represent -->
                                            <span class="progress-left">
                                                <span class="progress-bar"></span>
                                            </span>
                                            <span class="progress-right">
                                                <span class="progress-bar"></span>
                                            </span>
                                            <div class="progress-value">
                                                <div>
                                                    90%<br>
                                                    <span>freelancer</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="skill-item last-skill-item wow fadeIn" data-wow-duration="1s"
                                        data-wow-delay="0.6s">
                                        <div class="progress" data-percentage="70"> <!-- What does this represent -->
                                            <span class="progress-left">
                                                <span class="progress-bar"></span>
                                            </span>
                                            <span class="progress-right">
                                                <span class="progress-bar"></span>
                                            </span>
                                            <div class="progress-value">
                                                <div>
                                                    70%<br>
                                                    <span>team</span>
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
        <div class="container-xxl bg-primary newsletter my-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="container px-lg-5">
                <div class="row align-items-center" style="height: 250px;">
                    <div class="col-12 col-md-6">
                        <h3 class="text-white">Ready to get started</h3>
                        <small class="text-white">Diam elitr est dolore at sanctus nonumy.</small>
                        <div class="position-relative w-100 mt-3">
                            <input class="form-control border-0 rounded-pill w-100 ps-4 pe-5" type="text"
                                placeholder="Enter Your Email" style="height: 48px;">
                            <button type="button" class="btn shadow-none position-absolute top-0 end-0 mt-1 me-2"><i
                                    class="fa fa-paper-plane text-primary fs-4"></i></button>
                        </div>
                    </div>
                    <div class="col-md-6 text-center mb-n5 d-none d-md-block">
                        <img class="img-fluid " style="height: 300px;" src="imgs/head.png">
                    </div>
                </div>
            </div>
        </div>
        <!-- Newsletter End -->


        <!-- Service Start -->
        <div class="container-xxl py-5">
            <div class="container px-lg-5">
                <div class="section-title position-relative text-center mb-5 pb-2 wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="position-relative d-inline text-warning ps-4">Our Services</h6>
                    <h2 class="mt-2">What Solutions We Provide</h2>
                </div>
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.1s">
                        <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                            <div class="service-icon flex-shrink-0">
                                <i class="fa-solid fa-ankh"></i>
                            </div>
                            <h5 class="mb-3">SEO Optimization</h5>
                            <p>Erat ipsum justo amet duo et elitr dolor, est duo duo eos lorem sed diam stet diam sed
                                stet lorem.</p>
                            <a class="btn px-3 mt-auto mx-auto" href="">Read More</a> <!-- NOTE 0 idea perhaps freelancers.php?cid=NO SEO OPT-->
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.3s">
                        <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                            <div class="service-icon flex-shrink-0">
                                <i class="fa-solid fa-ankh"></i>
                            </div>
                            <h5 class="mb-3">Web Design</h5>
                            <p>Erat ipsum justo amet duo et elitr dolor, est duo duo eos lorem sed diam stet diam sed
                                stet lorem.</p>
                            <a class="btn px-3 mt-auto mx-auto" href="">Read More</a> <!-- NOTE 0 idea perhaps freelancers.php?cid=1 (developer) (vague vs specific)-->
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.6s">
                        <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                            <div class="service-icon flex-shrink-0">
                                <i class="fa-solid fa-ankh"></i>
                            </div>
                            <h5 class="mb-3">Social Media Marketing</h5>
                            <p>Erat ipsum justo amet duo et elitr dolor, est duo duo eos lorem sed diam stet diam sed
                                stet lorem.</p>
                            <a class="btn px-3 mt-auto mx-auto" href="">Read More</a> <!-- NOTE 0 idea perhaps freelancers.php?cid=4 (marketing analyst)--> -->
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.1s">
                        <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                            <div class="service-icon flex-shrink-0">
                                <i class="fa-solid fa-ankh"></i>
                            </div>
                            <h5 class="mb-3">Email Marketing</h5>
                            <p>Erat ipsum justo amet duo et elitr dolor, est duo duo eos lorem sed diam stet diam sed
                                stet lorem.</p>
                            <a class="btn px-3 mt-auto mx-auto" href="">Read More</a> <!-- NOTE 0 idea perhaps freelancers.php?cid=4 (marketing analyst) (vague vs specific)--> -->
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.3s">
                        <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                            <div class="service-icon flex-shrink-0">
                                <i class="fa-solid fa-ankh"></i>
                            </div>
                            <h5 class="mb-3">PPC Advertising</h5>
                            <p>Erat ipsum justo amet duo et elitr dolor, est duo duo eos lorem sed diam stet diam sed
                                stet lorem.</p>
                            <a class="btn px-3 mt-auto mx-auto" href="">Read More</a> <!-- NOTE 0 idea perhaps freelancers.php?cid=NO PPC ADV--> -->
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.6s">
                        <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                            <div class="service-icon flex-shrink-0">
                                <i class="fa-solid fa-ankh"></i>
                            </div>
                            <h5 class="mb-3">App Development</h5>
                            <p>Erat ipsum justo amet duo et elitr dolor, est duo duo eos lorem sed diam stet diam sed
                                stet lorem.</p>
                            <a class="btn px-3 mt-auto mx-auto" href="">Read More</a> <!-- NOTE 0 idea perhaps freelancers.php?cid=1 (dev yet again, vague vs specific)--> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Service End -->
       <!-- Testimonial Start -->
       <div class="container-xxl bg-primary testimonial py-5 my-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container py-5 px-lg-5">
            <div class="owl-carousel testimonial-carousel">
                <div class="testimonial-item bg-transparent border rounded text-white p-4">
                    <i class="fa fa-quote-left fa-2x mb-3"></i>
                    <p>Dolor et eos labore, stet justo sed est sed. Diam sed sed dolor stet amet eirmod eos labore
                        diam</p>
                    <div class="d-flex align-items-center">
                        <img class="img-fluid flex-shrink-0 rounded-circle" src="imgs/testimonial-1.jpg"
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
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->


        <!-- Portfolio Start --> <!-- have mercy on me -->
        <div class="container-xxl py-5">
            <div class="container px-lg-5">
                <div class="section-title position-relative text-center mb-5 pb-2 wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="position-relative d-inline text-warning ps-4">Our Projects</h6>
                    <h2 class="mt-2">Recently Launched Projects</h2>
                </div>
                <div class="row mt-n2 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="col-12 text-center">
                        <ul class="list-inline mb-5" id="portfolio-flters">
                            <li class="btn px-3 pe-4 active" data-filter="*">All</li>
                            <li class="btn px-3 pe-4" data-filter=".first">Design</li>
                            <li class="btn px-3 pe-4" data-filter=".second">Development</li>
                        </ul>
                    </div>
                </div>
                <div class="row g-4 portfolio-container">
                    <div class="col-lg-4 col-md-6 portfolio-item first wow zoomIn" data-wow-delay="0.1s">
                        <div class="position-relative rounded overflow-hidden">
                            <img class="img-fluid w-100" src="imgs/portfolio-1.jpg" alt="">
                            <div class="portfolio-overlay">
                                <a class="btn btn-light" href="imgs/portfolio-1.jpg" data-lightbox="portfolio"><i
                                        class="fa fa-plus fa-2x text-primary"></i></a>
                                <div class="mt-auto">
                                    <small class="text-white"><i class="fa fa-folder me-2"></i>Web Design</small>
                                    <a class="h5 d-block text-white mt-1 mb-0" href="">Project Name</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 portfolio-item second wow zoomIn" data-wow-delay="0.3s">
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
                </div>
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
                            <p><i class="fa fa-map-marker-alt me-3"></i>123 Street, Zamalek, Egypt</p> <!-- NOTE I made this up -->
                            <p><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
                            <p><i class="fa fa-envelope me-3"></i>midlancerteam@gmail.com</p> <!-- literally the mail we use to send OTP vs midlancer22 (found on facebook) -->
                            <div class="d-flex pt-2">
                                <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a> <!-- NOTE we lack TW -->
                                <a class="btn btn-outline-light btn-social" href="https://www.facebook.com/profile.php?id=61564326657962"><i
                                        class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a> <!-- NOTE we lack YT -->
                                <a class="btn btn-outline-light btn-social" href="https://www.instagram.com/midlancer.1/"><i class="fab fa-instagram"></i></a>
                                <a class="btn btn-outline-light btn-social" href=""><i
                                        class="fab fa-linkedin-in"></i></a> <!-- NOTE we lack Lin -->
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <h5 class="text-white mb-4">Popular Link</h5>
                            <a class="btn btn-link" href="">About Us</a> <!-- NOTE we lack About us -->
                            <a class="btn btn-link" href="">Contact Us</a> <!-- NOTE we lack Contact us -->
                            <a class="btn btn-link" href="">Privacy Policy</a> <!-- NOTE we lack PrivacyPolicy -->
                            <a class="btn btn-link" href="">Terms & Condition</a> <!-- Planned, and discussed, we don't have it just yet -->
                            <a class="btn btn-link" href="career.php">Career</a>
                        </div>

                        <div class="col-md-6 col-lg-6 mt-auto pe-5  mb-4">
                            <h5 class="text-white mb-4">Newsletter</h5> <!-- NOTE as BACK nobody brought up newsletter subscription-->
                            <p>Lorem ipsum dolor sit amet elit. Phasellus nec pretium mi. Curabitur facilisis ornare
                                velit non vulpu</p>
                            <div class="position-relative w-100 mt-3 ">
                                <input class="form-control border-0 rounded-pill w-100 ps-4 pe-5" type="text"
                                    placeholder="Your Email" style="height: 48px;">
                                <button type="button" class="btn shadow-none position-absolute top-0 end-0 mt-1 me-2"><i
                                        class="fa fa-paper-plane text-primary fs-4"></i></button>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="container px-lg-5">
                    <div class="copyright">
                        <div class="row">
                            <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                                &copy; <a class="border-bottom" href="#">MID LANCER</a>, All Right Reserved.
                                Designed By <a class="border-bottom" href="">team 2</a> <!-- that if wwe have a "team page" -->
                            </div>
                            <div class="col-md-6 text-center text-md-end">
                                <div class="footer-menu">
                                    <a href="index.php">Home</a>
                                    <a href="">Cookies</a> <!-- NOTE we lack Cookies -->
                                    <a href="">Help</a> <!-- NOTE we lack Help, "Help I am poor" ~Tarek -->
                                    <a href="">FQAs</a> <!-- NOTE we lack FAQs -->
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