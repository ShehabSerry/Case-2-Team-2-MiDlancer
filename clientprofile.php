<?php
// include("connection.php");
include 'nav+bm.php';
// if the user is not logged in 
// uncomment when done
if(empty($_SESSION['user_id'])){
    header("location:home.php");
}

if(isset($_SESSION['user_id'])){
    $user_id=$_SESSION['user_id'];
}
// USER INFO
$select_user = "SELECT * FROM `user` 
                JOIN `nationality` ON `nationality`.`nationality_id` = `user`.`nationality_id`
                WHERE `user_id` = '$user_id'";
$run_user = mysqli_query($connect,$select_user);

// select posted projects
$select_posted_projects = "SELECT * FROM `project`
                            JOIN `user` ON `user`.`user_id` = `project`.`user_id`
                            WHERE `project`.`user_id` = '$user_id' AND `project`.`posting` = 1";
$run_posted_projects = mysqli_query($connect,$select_posted_projects);

// delete projects
if(isset($_POST['del_pro'])){
    $pro_id= $_POST['project_id'];
    $delete_pro="DELETE FROM `project` WHERE `project_id` = $pro_id";
    $run_delete_pro=mysqli_query($connect,$delete_pro);
    header("location:clientprofile.php");
}
// unpost project
if (isset($_POST['unpost'])){
    $project_id=$_POST['project_id'];
    $unpost="UPDATE `project` SET `posting` = 0 WHERE `project_id` = $project_id";
    $run_unpost=mysqli_query($connect,$unpost);
    header("location:clientprofile.php");
}
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
            <div class="class">
            <!-- <a href="./dashboard.php" class="btn-dash">Dashboard</a> -->
            <a href="./clientview.php?cid=<?php echo htmlspecialchars($data['user_id'], ENT_QUOTES, 'UTF-8' )?>" class="btn-dash">View</a>
            </div>
            
            <div class="profile-image">
                <img src="<?php echo "img/profile/".htmlspecialchars($data['user_image'], ENT_QUOTES, 'UTF-8' )?>" alt="Profile Image" id="image-preview">
            </div>
            <h1><?php echo $data['user_name'] ?></h1>
            <div class="profile-form">
                <a href="./edit_client_profile.php" class="btn-prof">Edit profile</a>

                <div class="form-group">
                    <label for="career">Email:</label>
                    <p> <?php echo htmlspecialchars($data['email'], ENT_QUOTES, 'UTF-8' )?></p>
                </div>

                <div class="form-group">
                    <label for="job-title">Phone Number:</label>
                    <p class="web"><?php echo htmlspecialchars($data['phone_number'], ENT_QUOTES, 'UTF-8' )?></p>
                </div>
                <div class="form-group">
                    <label for="bio">nationality:</label>
                    <p><?php echo htmlspecialchars($data['nationality'], ENT_QUOTES, 'UTF-8' )?></p>
                </div>

                <div class="form-group">
                    <label for="bio">Bio:</label>
                    <p><?php echo htmlspecialchars ($data['bio'], ENT_QUOTES, 'UTF-8' )?></p>
                </div>

            </div>
            <!-- alaa -->
            <div class="form-group11">
                <div class="all">
                    <div class="txt d-flex f-row "> <label for="experience">Projects:</label>
                        <a href="./addproject.php" class="btn-exp">Add</a>
                    </div>
                    <?php  if(mysqli_num_rows($run_posted_projects) > 0) { ?>
                        <?php foreach($run_posted_projects as $project){ ?>
                        <div class="post2 position-relative">

                            <div class="anchers position-absolute">
                                <!-- عاوزين نديليت علطول و لا نشيل البوست خالص ؟ -->
                                <!-- <form method="POST">
                                    <input type="hidden" name="project_id" value="<?php echo $project['project_id']?>">
                                    <button class="arc" type="submit" name="unpost"><i class="fa-solid fa-box" style="color: gold; background-color:transparent;"></i></button>
                                </form> -->

                                <form method="POST">
                                    <input type="hidden" name="project_id" value="<?php echo $project['project_id']?>">
                                    <button class="arc" type="submit" name="del_pro"><i class="fa-solid fa-trash-can" style="color: gold; background-color:transparent;"></i></button>
                                </form>
                            </div>
                            <p>
                                <strong>Project:</strong> <?php echo htmlspecialchars($project['project_name'], ENT_QUOTES, 'UTF-8' )?><br>
                                <strong>Description:</strong>  <?php echo htmlspecialchars($project['description'], ENT_QUOTES, 'UTF-8' )?>.<br>
                                <strong>Total Hours:</strong> <?php echo htmlspecialchars($project['total_hours'], ENT_QUOTES, 'UTF-8' )?> hours<br>
                                <strong>Deadline Date:</strong> <?php echo htmlspecialchars($project['deadline_date'], ENT_QUOTES, 'UTF-8' )?>
                            </p>
                        </div>
                    <?php }}else{ ?>
                        <label style="font-weight: bold;
                                font-size: 22px;
                                color: rgb(2, 2, 88);
                                text-align: left; 
                                padding-top: 9px;" for="file-upload">No Posts Yet</label>
                    <?php } ?>   
                </div>
            </div>
            <div class="button-container">
            <!-- <div class="buttoncont2"> -->
                <a href="./changepass_client.php" class="btn-12">Change Password</a>
                <form method="POST">
                    <button type="submit" name="logout" class="btn-12" id="logout">Logout</button>
                </form>
            </div>
        </div>
    <?php } ?>

    </div>
    <script src="./js/FREELANCERPROFILE.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>
