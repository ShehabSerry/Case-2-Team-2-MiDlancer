<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Favicon -->
    <link href="imgs/logo.png" rel="icon">

    <!-- Google Web Fonts -->
    <!-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500&family=Roboto:wght@400;500;700&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
          integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
          crossorigin="anonymous" referrerpolicy="no-referrer" /> -->

    <!-- Customized Bootstrap Stylesheet -->
    <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->

    <link rel="stylesheet" href="css/navbarr.css">
</head>
<body>
    <nav class="navbar">
        <div class="brand-container">
            <img src="img/MiDlancer (2).png" alt="Logo" class="logo">
            <div class="brand-title"><span>Mid</span><span>Lancer</span></div>
        </div>

        <div class="navbar-links">
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="career.php">Career</a></li>
                <li><a href="wall.php">Wall</a></li>
                <?php
                  if(isset($_SESSION['user_id'])){ ?>
                    <li><a href="my_projects_client.php">Projects</a></li>
                    <li><a href="clientprofile.php">Profile</a></li>
                    <li><a href="./php-chat-app-client/home.php" class="nav-item nav-link">Chat</a></li>
                 

                    <!-- <li><a href="accepted-requests.php"><i class="fa-solid fa-bell" style="color: #f6d673;"> 
                        <span class="position-absolute start-100 translate-middle text-danger badge">
    7+
    <span class="visually-hidden">unread messages</span> -->
  </span></i></a></li>
                <?php } elseif(isset($_SESSION['freelancer_id'])){ ?>
                    <li><a href="my_projects_freelancer.php">Projects</a></li>
                    <li><a href="FREELANCERPROFILE.php">Profile</a></li>
                    <li><a href="./chatFreelancer/home.php" class="nav-item nav-link">Chat</a></li> <!-- Farah, this page doesn't have active or the array, chatf is temp name I assume -->

                    <!-- <li><a href="./income-request.php"><i class="fa-solid fa-bell" style="color: #f6d673;"></i></a></li> -->
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
             
            </ul>
        </div>
        <a href="#" class="toggle-button">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </a>
    </nav>

    <script src="js/nav.js"></script>
</body>
</html>
