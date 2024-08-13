<?php
include("connection.php");
// if the user is not logged in 
// uncomment when done
// if(empty($_SESSION['freelancer_id'])){
//     header("location:home.php");
// }

if(isset($_GET['id'])){
    $id=$_GET['id'];
}
// freelancer information
$select_freelancer = " SELECT * FROM `freelancer`
                       JOIN `career` ON `career`.`career_id`= `freelancer`.`career_id`
                       JOIN `rank` ON `rank`.`rank_id` = `freelancer`.`rank_id`
                       WHERE `freelancer`.`freelancer_id` = $id";
$run_select= mysqli_query($connect,$select_freelancer);

// SELECT SKILLS 
$select_skill= "SELECT * FROM `skills` WHERE `freelancer_id`= $id ";
$run_select_skill= mysqli_query($connect,$select_skill);

// SELECT RATING 
$select_rating = " SELECT * FROM `rate`
                    LEFT JOIN `user` ON `user`.`user_id` = `rate`.`user_id`
                    WHERE `freelancer_id`= $id";
$run_select_rating=mysqli_query($connect,$select_rating);

// Select_experience
$select_experience="SELECT * FROM `experience` WHERE `freelancer_id`= $id ";
$run_select_experience=mysqli_query($connect,$select_experience);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>freelancer Profile</title>
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
        </div>
    </div>

    <div class="profile-bio">
        <h3>Bio</h3>
        <p><?php echo $data['bio'] ?></p>
    </div>

    <!-- USER FILES OR CV  -->
    <?php if(!empty($data['freelancer_file'])){ ?>
    <div class="profile-details">
        <h3>Files</h3>
        <p>CV: <a target="_blank" href="./file/<?php echo $data['freelancer_file']; ?> "><?php echo $data['freelancer_file']; ?></a>
        </p>
    </div>
    <?php }else{ ?>
        <h3>No Files</h3>

    <?php } ?>

    <!-- EXPERIENCE -->
    <h3>Experience</h3>

    <?php foreach($run_select_experience as $exper){ ?>
    <?php if(!empty($exper['experience_text'])){ ?>

    <div class="profile-experience">
        <img src="<?php echo "img/".$exper['experience_image']?>" alt=".." class="profile-image">
            <p><?php echo $exper['experience_text']?></p>
    </div>
    <?php }else{ ?>
        <h3>No posts yet</h3>
    <?php }} ?>
    <!-- SKILLS -->
        <h3>Skills</h3>
    <?php foreach($run_select_skill as $sk){?>
    <?php if(!empty($sk['skill'])){ ?>

    <div class="profile-skills">
        <p><?php echo $sk['skill'] ?></p>
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
                <p><?php echo $row['user_name'] ?>: <?php echo $row['comment'] ?></p>
            </div>
        </div>
    <?php } ?>

    <div class="profile-actions">
        <a href="#">Dashboard</a>
    </div>
<?php } ?>
</div>

</body>
</html>
