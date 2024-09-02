<?php
// include("connection.php");
include 'nav+bm.php';

if(isset($_GET['cid']))
{
    $client_id= mysqli_real_escape_string($connect, $_GET['cid']);
    $valid = mysqli_num_rows(mysqli_query($connect,"SELECT user_id FROM user WHERE user_id = $client_id"));
    if(!$valid)
        header("Location: home.php");
}
else
    header("Location: home.php");

// USER INFO
$select_user = "SELECT * FROM `user` 
                JOIN `nationality` ON `nationality`.`nationality_id` = `user`.`nationality_id`
                WHERE `user_id` = '$client_id'";
$run_user = mysqli_query($connect,$select_user);

// select posted projects
$select_posted_projects = "SELECT * FROM `project`
                            JOIN `user` ON `user`.`user_id` = `project`.`user_id`
                            WHERE `project`.`user_id` = '$client_id' AND `project`.`posting` = 1";
$run_posted_projects = mysqli_query($connect,$select_posted_projects);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./css/clientprofile.css">
</head>

<body>

<h2></h2>

    <div class="profile-container">
        <?php foreach($run_user as $data){ ?>
            
            <div class="profile-image">
                <img src="<?php echo "img/profile/".htmlspecialchars($data['user_image'], ENT_QUOTES, 'UTF-8' )?>" alt="Profile Image" id="image-preview">
            </div>
            <h1 class="text-warning"><?php echo htmlspecialchars($data['user_name'], ENT_QUOTES, 'UTF-8' )?></h1>
            <form method="POST" class="profile-form" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="career">Email:</label>
                    <p> <?php echo htmlspecialchars($data['email'], ENT_QUOTES, 'UTF-8' )?></p>
                </div>

                <div class="form-group">
                    <label for="job-title">Phone Number:</label>
                    <p class="web"><?php echo htmlspecialchars($data['phone_number'], ENT_QUOTES, 'UTF-8' ) ?></p>
                </div>
                <div class="form-group">
                    <label for="bio">nationality:</label>
                    <p><?php echo htmlspecialchars($data['nationality'], ENT_QUOTES, 'UTF-8' ) ?></p>
                </div>

                <div class="form-group">
                    <label for="bio">Bio:</label>
                    <p><?php echo htmlspecialchars($data['bio'], ENT_QUOTES, 'UTF-8' ) ?></p>
                </div>
                <div class=" text-center">
                    <label for="experience">Projects</label>
                </div>

            </form>
            <!-- alaa -->
            <div class="">
                  
                <div class="all">
                    </div>
                    <?php  if(mysqli_num_rows($run_posted_projects) > 0) { ?>
                        <?php foreach($run_posted_projects as $project){ ?>
                        <div class="post2 p-3">
                           
                            <!-- lol -->
                            <p>
                                
                                <span class="text-warning p-5 haha">
                                <?php echo htmlspecialchars($project['project_name'], ENT_QUOTES, 'UTF-8' )?></span> 
                                <div class="d-flex text-warning">
                                <span class="w-50"><i class="fa-regular fa-clock mx-1"></i>Hours: <?php echo htmlspecialchars($project['total_hours'] , ENT_QUOTES, 'UTF-8' )?> hours</span>
                                <span class="w-50"><i class="fa-regular fa-paper-plane mx-1"></i>Deadline: <?php echo htmlspecialchars($project['deadline_date'], ENT_QUOTES, 'UTF-8' )?></span>
                                </div>
                                <!-- <strong class="">Description:</strong> -->
                                  <?php echo htmlspecialchars($project['description'] , ENT_QUOTES, 'UTF-8' )?>.<br>
                               
                            </p>
                            <!-- lol -->
                        </div>
                    <?php }}else{ ?>
                        <h3>No Posts Yet</h3>
                    <?php } ?>   
                </div>
            </div>
        </div>
    <?php } ?>

    </div>
    <script src="./js/FREELANCERPROFILE.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>
