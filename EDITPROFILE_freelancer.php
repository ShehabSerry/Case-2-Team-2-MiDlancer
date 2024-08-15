<?php
include("connection.php");
if(isset($_SESSION['freelancer_id'])){
    $freelancer_id=$_SESSION['freelancer_id'];
}
$select_freelancer = " SELECT * FROM `freelancer`
                       JOIN `career` ON `career`.`career_id`= `freelancer`.`career_id`
                       JOIN `rank` ON `rank`.`rank_id` = `freelancer`.`rank_id`
                       WHERE `freelancer`.`freelancer_id` = $freelancer_id";
$run_select= mysqli_query($connect,$select_freelancer);
$freelancer_data =mysqli_fetch_assoc($run_select);
if(isset($_POST['update'])){
    $freelancer_name =mysqli_real_escape_string($connect,$_POST['name']);
    $phone_number=mysqli_real_escape_string($connect,$_POST['phone']);
    $freelancer_image=mysqli_real_escape_string($connect,$_FILES['image']['name']);
    $jop_title =mysqli_real_escape_string($connect,$_POST['job-title']);
    $bio =mysqli_real_escape_string($connect,$_POST['bio']);
    $price =mysqli_real_escape_string($connect,$_POST['price-hr']);
    $hours =mysqli_real_escape_string($connect,$_POST['available-hour']);
    $link_github =mysqli_real_escape_string($connect,$_POST['github-link']);
    $link_linkedin =mysqli_real_escape_string($connect,$_POST['linkedin-link']);
    // to make sure the phone number is valid
    if(strlen($phone_number)!=11){
        echo "Please enter a valid Phone number";
    }else{
        if(empty($freelancer_image)){
            $freelancer_image=$freelancer_data['freelancer_image'];
        }
        if(empty($bio)){
            $bio = $freelancer_data['bio'];
        }
        $update_freelancer= "UPDATE `freelancer` 
                            SET `freelancer_name` = '$freelancer_name',
                                `freelancer_image`= '$freelancer_image',
                                `phone_number` = '$phone_number',
                                `job_title` = '$jop_title',
                                `available_hours` = '$hours',
                                `price/hr` = '$price',
                                `link1` = '$link_github',
                                `link2` = '$link_linkedin',
                                `bio` = '$bio'
                            WHERE `freelancer_id`=$freelancer_id ";
        $run_update_freelancer=mysqli_query($connect,$update_freelancer);
        if (!empty($_FILES['image']['name'])) {
            move_uploaded_file($_FILES['image']['tmp_name'], "img/profile/" . $_FILES['image']['name']);
        }
        header("location:freelancer_profile.php");

}}
?>
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="css/EDITPROFILE.css">
</head>
<body>
    <div class="profile-container  ">
        <div class="profile-card">
            <a href="./freelancer_profile.php" class="close"><i class="fa-solid fa-x "></i></a>
            <h2>Edit Your Profile</h2>
            <form class="profile-form" method="POST" enctype="multipart/form-data">
                <?php foreach($run_select as $edit){ ?>
                <div class="profile-image">
                        <img src="<?php echo "img/profile/".$edit['freelancer_image'] ?>" alt="Profile Image" id="image-preview">
                    <!-- <input type="file" id="profile-image" name="image" accept="image/*" onchange="previewImage(event)"> -->
                   
                </div>

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" value="<?php echo $edit['freelancer_name'] ?>" placeholder="Your Name">
                </div>

                <div class="form-group">
                    <label for="job-title">Job Title</label>
                    <input type="text" id="job-title" name="job-title" value="<?php echo $edit['job_title'] ?>" placeholder="Your Job Title">
                </div>
                <div class="form-group">
                    <label for="phone-number">Phone Number</label>
                    <input type="number" id="phone-number" name="phone" value="<?php echo $edit['phone_number'] ?>" placeholder="Your Phone Number">
                </div>

                <div class="form-group">
                    <label for="bio">Bio</label>
                    <textarea id="bio" name="bio" placeholder="A short bio about yourself"></textarea>
                </div>
                <div class="form-group">
                    <label for="name">Edit profile photo</label>
                    <input type="file" id="profile photo" name="image" value="<?php echo $edit['freelancer_image'] ?>" placeholder="profile photo">
                </div>
                <div class=" lol">
                    <div class=" link-group lol">
                <div class="form-group llll">
                    <label for="price-hr">Price per Hour ($)</label>
                    <input type="number" id="price-hr" name="price-hr" value="<?php echo $edit['price/hr'] ?>" placeholder="Hourly Rate">
                </div>

                <div class="form-group llll ">
                    <label for="available-hour">Available Hours per Week</label>
                    <input type="number" id="available-hour" name="available-hour" value="<?php echo $edit['available_hours'] ?>" placeholder="Hours per Week">
                </div>
            </div>
        </div>

                <!-- New wrapper for links -->
                <div class="link-group-wrapper ">
                    <div class="form-group link-group">
                        <label for="github-link ">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/9/91/Octicons-mark-github.svg" alt="GitHub" class="icon"> GitHub Link
                        </label>
                        <input type="url" id="github-link" name="github-link" value="<?php echo $edit['link1'] ?>" placeholder="GitHub Profile URL">
                    </div>

                    <div class="form-group link-group ">
                        <label for="linkedin-link">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/c/ca/LinkedIn_logo_initials.png" alt="LinkedIn" class="icon"> LinkedIn Link
                        </label>
                        <input type="url" id="linkedin-link" name="linkedin-link" value="<?php echo $edit['link2'] ?>" placeholder="LinkedIn Profile URL">
                        
                    </div>
                </div>

                <div class="btns">
                    <div class="buttons">
                      <button class="cssbuttons-io-button addto" type="submit" name="update">Update Profile
                        <div class="icon">
                          <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"
                              fill="currentColor"></path>
                          </svg>
                        </div>
                      </button>
                    </div>
                </div>
            <?php } ?>
            </form>
        </div>
    </div>
<script src="js/FREELANCERPROFILE.js"></script>

</body>
</html>
