<?php
// include("connection.php");
include 'nav+bm.php';
// if the user is not logged in 
// uncomment when done
// if(empty($_SESSION['user_id'])){
//     header("location:home.php");
// }

// if(isset($_SESSION['user_id'])){
//     $user_id=$_SESSION['user_id'];
// }

if(isset($_GET['cid'])){
    $client_id= $_GET['cid'];
}
// USER INFO
$select_user = "SELECT * FROM `user` 
                JOIN `nationality` ON `nationality`.`nationality_id` = `user`.`nationality_id`
                WHERE `user_id` = '$client_id'";
$run_user = mysqli_query($connect,$select_user);

// select posted projects
$select_posted_projects = "SELECT * FROM `project`
                            JOIN `user` ON `user`.`user_id` = `project`.`user_id`
                            JOIN `type` ON `type`.`type_id` = `project`.`type_id`
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


<h2>User Profile</h2>

    <div class="profile-container">
        <?php foreach($run_user as $data){ ?>
            
            <div class="profile-image">
                <img src="<?php echo "img/profile/".$data['user_image'] ?>" alt="Profile Image" id="image-preview">
            </div>
            <h1><?php echo $data['user_name'] ?></h1>
            <form method="POST" class="profile-form" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="career">Email:</label>
                    <p> <?php echo $data['email']?></p>
                </div>

                <div class="form-group">
                    <label for="job-title">Phone Number:</label>
                    <p class="web"><?php echo $data['phone_number'] ?></p>
                </div>
                <div class="form-group">
                    <label for="bio">nationality:</label>
                    <p><?php echo $data['nationality'] ?></p>
                </div>

                <div class="form-group">
                    <label for="bio">Bio:</label>
                    <p><?php echo $data['bio'] ?></p>
                </div>

            </form>
            <!-- alaa -->
            <div class="form-group11">
                  
                <div class="all">
                    <div class="txt d-flex f-row "> <label for="experience">Projects:</label>
                    </div>
                    <?php  if(mysqli_num_rows($run_posted_projects) > 0) { ?>
                        <?php foreach($run_posted_projects as $project){ ?>
                        <div class="post2">
                            <p>
                                <strong>Project:</strong> <?php echo $project['project_name']?><br>
                                <strong>Description:</strong>  <?php echo $project['description']?>.<br>
                                <strong>Total Hours:</strong> <?php echo $project['total_hours'] ?> hours<br>
                                <strong>Deadline Date:</strong> <?php echo $project['deadline_date']?>
                            </p>
                        </div>
                    <?php }}else{ ?>
                            <h3>No posts yet</h3>
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