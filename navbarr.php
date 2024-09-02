<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Nav Bar</title>
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
                <li><a href="career.php">career</a></li>
                <li><a href="wall.php">wall</a></li>
                <?php
                  if(isset($_SESSION['user_id'])){ ?>
                    <li><a href="my_projects_client.php">Projects</a></li>
                    <li><a href="clientprofile.php">Profile</a></li>
                    <li><a href="accepted-requests.php"><i class="fa-solid fa-bell" style="color: #f6d673;"></i></a></li>
                <?php } elseif(isset($_SESSION['freelancer_id'])){ ?>
                    <li><a href="my_projects_freelancer.php">Projects</a></li>
                    <li><a href="FREELANCERPROFILE.php">Profile</a></li>
                    <li><a href="./income-request.php"><i class="fa-solid fa-bell" style="color: #f6d673;"></i></a></li>
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
