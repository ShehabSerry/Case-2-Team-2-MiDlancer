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
                <?php
                if(isset($_SESSION['user_id'])){ ?>
                        <li><a href="clientprofile.php">Profile</a></li>
                       <?php } elseif(isset($_SESSION['freelancer_id'])){ ?>
                       <li><a href="FREELANCERPROFILE.php">Profile</a></li>
                        <?php } ?>
            
                <li><a href="career.php">career</a></li>
                <?php 
                if(isset($_SESSION['user_id'])){ ?>                       
                        <li><a href="accepted-requests.php">Notifications</a></li>
                        <?php } ?>
            
                <li><a href="wall.php">wall</a></li>
                <?php
                  if(isset($_SESSION['user_id'])){ ?>
                    <li><a href="my_projects_client.php">Projects</a></li>
                 <?php } elseif(isset($_SESSION['freelancer_id'])){ ?>
                  <li><a href="my_projects_freelancer.php">Projects</a></li>
                  <?php } ?>
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