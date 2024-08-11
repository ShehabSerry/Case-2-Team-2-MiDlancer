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
// freelancer information
$select_freelancer = " SELECT * FROM `freelancer`
                       JOIN `career` ON `career`.`career_id`= `freelancer`.`career_id`
                       JOIN `rank` ON `rank`.`rank_id` = `freelancer`.`rank_id`
                       WHERE `freelancer`.`freelancer_id` = $freelancer_id";
$run_select= mysqli_query($connect,$select_freelancer);

// SELECT SKILLS 
$select_skill= "SELECT * FROM `skills` WHERE `freelancer_id`= $freelancer_id ";
$run_select_skill= mysqli_query($connect,$select_skill);

// SELECT RATING 
$select_rating = " SELECT * FROM `rate` 
                    LEFT JOIN `user` ON `user`.`user_id` = `rate`.`user_id`
                    WHERE `freelancer_id`=$freelancer_id";
$run_select_rating=mysqli_query($connect,$select_rating);
    
// add skill
if(isset($_POST['skill'])){
    $skill=mysqli_real_escape_string($connect,$_POST['skills']);
    $insert_skill="INSERT INTO `skills` VALUES (NULL,'$skill','$freelancer_id')";
    $run_insert_skill=mysqli_query($connect,$insert_skill);
    header("location:freelancer_profile.php");
}

// delete skill
if(isset($_GET['delete'])){
    $skill_id=$_GET['delete'];
    $delete_skill="DELETE FROM `skills` WHERE `skill_id`= $skill_id ";
    $run_delete_skill=mysqli_query($connect,$delete_skill);
    header("location:freelancer_profile.php");
}
// Select_experience
$select_experience="SELECT * FROM `experience` WHERE `freelancer_id`= $freelancer_id ";
$run_select_experience=mysqli_query($connect,$select_experience);

// archive experience
if(isset($_POST['archive'])){
    $experience_id=$_POST['experience_id'];
    $archive="UPDATE `experience` SET `hidden` = 1 WHERE `experience_id` = $experience_id";
    $run_archive=mysqli_query($connect,$archive);
    header("location:freelancer_profile.php");
}

// unarchive 
if(isset($_POST['unarchive'])){
    $experience_id=$_POST['experience_id'];
    $unarchive="UPDATE `experience` SET `hidden` = 0 WHERE `experience_id` = $experience_id";
    $run_unarchive=mysqli_query($connect,$unarchive);
    header("location:freelancer_profile.php");
}
// UPLOAD FILE
if(isset($_POST['add_file'])){
    $fileName=$_FILES['file_upload']['name'];
    $upload_file="UPDATE `freelancer` SET `freelancer_file` = '$fileName' WHERE `freelancer_id`= '$freelancer_id' ";
    $run_upload=mysqli_query($connect,$upload_file);
    $move_file= move_uploaded_file($_FILES['file_upload']['tmp_name'],"file/".$_FILES['file_upload']['name']);
    if($move_file){
        header("location:freelancer_profile.php");
    }
}
// delete cv or file
if(isset($_POST['delete_file'])){
    $delete_file="UPDATE `freelancer` SET `freelancer_file` = NULL  WHERE freelancer_id = $freelancer_id ";
    $run_delete=mysqli_query($connect,$delete_file);
    header("location:freelancer_profile.php");
}
// HOLD ACCOUNT
if(isset($_POST['hold'])){
    $hold_accunt="UPDATE `freelancer` SET `hidden`= 1  WHERE freelancer_id = $freelancer_id ";
    $run_hold=mysqli_query($connect,$hold_accunt);
    header("location:freelancer_profile.php");
}
// UNHOLD ACCOUNT
if(isset($_POST['unhold'])){
    $unhold_accunt="UPDATE `freelancer` SET `hidden`= 0  WHERE freelancer_id = $freelancer_id ";
    $run_unhold=mysqli_query($connect,$unhold_accunt);
    header("location:freelancer_profile.php");
}
// COUNT VIEWS
$view_count_query = "SELECT COUNT(*) as view_count FROM views WHERE freelancer_id = $freelancer_id ";
$view_result_result = mysqli_query($connect,$view_count_query);
$view_count = mysqli_fetch_assoc($view_result_result)['view_count'];
// premium
if(isset($_POST['premium'])){
    $premium= "UPDATE `freelancer` SET `premium` = 1 WHERE `freelancer_id` = $freelancer_id";
    $run_update_premium= mysqli_query($connect,$premium);
    header("location:freelancer_profile.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="./css/freelancer_profile.css">
    <style>
        .icon-link {
            display: inline-block; /* Allows you to apply dimensions */
            width: 40px;           /* Set the width of the icon */
            height: 40px;          /* Set the height of the icon */
            background-color: white; /* Background color */
            border-radius: 50%;    /* Makes the icon circular */
            text-align: center;    /* Centers the icon inside the link */
            line-height: 40px;     /* Centers the icon vertically */
            color: white;          /* Icon color */
            font-size: 20px;       /* Icon size */
            text-decoration: none; /* Removes the underline from the link */
            transition: background-color 0.3s ease; /* Smooth background color change on hover */
        }

        .icon-link:hover {
            background-color: #0056b3; /* Darker shade on hover */
        }

        .icon-link i {
            vertical-align: middle; /* Aligns the icon vertically in the center */
        }

    </style>
</head>
<body>

<div class="profile-container">
    <?php foreach($run_select as $data){ ?>
    <div class="profile-header">
        <img src="<?php echo "img/". $data['freelancer_image'] ?>" alt="User Image" class="profile-image">
        <div class="profile-info">
            <h2><?php echo $data['freelancer_name'] ?></h2>
            <p>Career: <?php echo $data['career_path']?></p>
            <p>Job Title: <?php echo $data['job_title'] ?></p>
        <?php if(!empty($data['price/hr'])){ ?>
            <p>Price/hr: $<?php echo $data['price/hr'] ?></p>
        <?php }else{ ?>
            <p>Price/hr: ..</p>
        <?php } ?>
        <?php if(!empty($data['available_hours'])){ ?>
            <p>Available Hours: <?php echo $data['available_hours'] ?></p>
        <?php }else{ ?>
            <p>Available Hours: ..</p>
        <?php } ?>
            <p>Rank: <?php echo $data['rank'] ?></p>
        <?php if(!empty($data['link2'])){ ?>
            <p>GitHub: <a href="<?php echo $data['link2']?>" target="_blank">GitHub</a>
        <?php }else{ ?>
            <p>GitHub: ..</p>
        <?php } ?>
        <?php if(!empty($data['link1'])){ ?>
            <p>LinkedIn: <a href="<?php echo $data['link1']?>" target="_blank">LinkedIn</a>
        <?php }else{ ?>
            <p>LinkedIn: ..</p>
        <?php } ?>
        <a href="./EDITPROFILE.php">Edit Profile</a>
        </div>
    </div>

    <div class="profile-bio">
        <h3>Bio</h3>
        <p><?php echo $data['bio'] ?></p>
    </div>
    <?php if($data['premium'] == 1){ ?>
    <div>
        <h4>Views: <?php echo $view_count ;?></h4>
    </div>
    <?php }else{ ?>
        <p>Join Our premium plan</p>
        <form method="POST">
            <button type="submit" name="premium">be premium</button>
        </form>
    <?php } ?>
    <!-- USER FILES OR CV  -->
    <?php if(!empty($data['freelancer_file'])){ ?>
    <div class="profile-details">
        <h3>Files</h3>
        <p>CV: <a target="_blank" href="./file/<?php echo $data['freelancer_file']; ?> "><?php echo $data['freelancer_file']; ?></a>
            <form method="POST">
                <!-- delete user file -->
                <button type="submit" name="delete_file">Delete</button>
            </form>
        </p>
    </div>
    <?php }else{ ?>
        <h3>No Files</h3>
        <!-- button to add file or cv -->
        <div class="profile-upload">
            <form method="POST" enctype="multipart/form-data">
                <h3>Upload File</h3>
                <input type="file" name="file_upload" class="file-input" accept=".pdf,.doc,.docx">
                <button type="submit" name="add_file" >Upload</button>
            </form>
        </div>
    <?php } ?>



    <!-- EXPERIENCE -->
    <h3>Experience</h3> <a href="#">Add Experience</a>

    <?php foreach($run_select_experience as $exper){ ?>
    <?php if(!empty($exper['experience_text'])){ ?>

    <div class="profile-experience">
        <img src="<?php echo "img/".$exper['experience_image']?>" alt=".." class="profile-image">
            <p><?php echo $exper['experience_text']?>
            <a href="./edit_experience.php?edit_experience=<?php echo $exper['experience_id'] ?>" class="icon-link">edit
                <i class="fa fa-home"></i>
            </a></p>
        <?php if($exper['hidden'] == 0 ){ ?>
        <form method="POST">
            <input type="hidden" name="experience_id" value="<?php echo $exper['experience_id']?>">
            <button type="submit" name="archive">Archive</button>
        </form>
        <?php }else{ ?>
        <form method="POST">
            <input type="hidden" name="experience_id" value="<?php echo $exper['experience_id']?>">
            <button type="submit" name="unarchive">Unarchive</button>
        </form>
        <?php } ?>
    </div>
    <?php }else{ ?>
        <h3>No posts yet</h3>
        <a href="#">Add Experience</a>
    <?php }} ?>
    <!-- SKILLS -->
        <h3>Skills</h3>
    <?php foreach($run_select_skill as $sk){?>
    <?php if(!empty($sk['skill'])){ ?>

    <div class="profile-skills">
        <p><?php echo $sk['skill'] ?> <a href="freelancer_profile.php?delete=
        <?php echo $sk['skill_id']?>"><span class="trash-icon">🗑️</span></a></p>
    </div>
       <?php  } else { ?>
        <h3>No Skills</h3>
    <?php }} ?>
    
<?php foreach($run_select_rating as $row){ ?>
    <div class="profile-rate">
        <h3>Rate</h3>
        <div class="rate-section">
            <div>Communication: <?php echo $row['rate1'] ?>/5</div>
            <div>Quality: <?php echo $row['rate2'] ?>/5</div>
            <div>Delivering Time: <?php echo $row['rate3'] ?>/5</div>
        </div>
    </div>

    <div class="profile-review">
        <h3>Review</h3>
        <div class="review-section">
            <p>Review: <?php echo $row['comment'] ?></p>
            <p>Written by: <?php echo $row['user_name'] ?></p>
        </div>
    </div>
<?php } ?>

    <div class="profile-upload">
        <form method="POST">
            <h3>Add skill</h3>
            <input type="text" name="skills" class="file-input" placeholder="Add new skill">
            <button type="submit" name="skill">Add skill</button>
        </form>
    </div>

    <div class="profile-actions">
        <a href="#">Dashboard</a>
        <?php if($data['hidden'] == 0 ){ ?>
        <form method="POST">
            <button type="submit" name="hold">Hold account</button>  
        </form>
        <?php }else{ ?>
        <form method="POST">
            <button type="submit" name="unhold">Unhold account</button>  
        </form>
        <?php } ?>
        <a href="./changepass_freelancer.php">Change Password</a>
        <form method="POST">
            <button type="submit" name="logout">Logout</button>
        </form>
    </div>
<?php } ?>
</div>

</body>
</html>
