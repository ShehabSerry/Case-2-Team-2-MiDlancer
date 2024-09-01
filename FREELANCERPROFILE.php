<?php
include 'nav+bm.php';
// if the freelancer is not logged in 
if(empty($_SESSION['freelancer_id'])){
    header("location:home.php");
}

$error= "";

if(isset($_SESSION['freelancer_id'])){
    $freelancer_id=$_SESSION['freelancer_id'];
}

// Combined query to get freelancer info, plan_id, skills, ratings, and experience
$select_all="SELECT *,AVG(rate1) AS RATE1,
                      AVG(rate2) AS RATE2,
                      AVG(rate3) AS RATE3
                    FROM `freelancer`
                    JOIN `career` ON `career`.`career_id` = `freelancer`.`career_id`
                    JOIN `rank` ON `rank`.`rank_id` = `freelancer`.`rank_id`
                    LEFT JOIN `subscription` ON `freelancer`.`freelancer_id` = `subscription`.`freelancer_id`
                    LEFT JOIN `rate` ON `freelancer`.`freelancer_id` = `rate`.`freelancer_id`
                    WHERE `freelancer`.`freelancer_id` = $freelancer_id
                    GROUP BY `freelancer`.`freelancer_id`";
$run_select_all=mysqli_query($connect,$select_all);

if ($freelancer_info = mysqli_fetch_assoc($run_select_all)){
    $plan_id = $freelancer_info['plan_id'];
    $avg_rate1 = $freelancer_info['RATE1'];
    $avg_rate2 = $freelancer_info['RATE2'];
    $avg_rate3 = $freelancer_info['RATE3'];
    $plan_status = $freelancer_info['status'];
}

// select skills
$select_skill= "SELECT * FROM `skills` WHERE `freelancer_id`= $freelancer_id ";
$run_select_skill= mysqli_query($connect,$select_skill);

// Select_experience
$select_experience="SELECT * FROM `experience` WHERE `freelancer_id`= $freelancer_id ";
$run_select_experience=mysqli_query($connect,$select_experience);

// add skill
if(isset($_POST['skill'])){
    $skill=htmlspecialchars(strip_tags(mysqli_real_escape_string($connect,$_POST['skills'])));
    $insert_skill="INSERT INTO `skills` VALUES (NULL,'$skill','$freelancer_id')";
    $run_insert_skill=mysqli_query($connect,$insert_skill);
    header("location:FREELANCERPROFILE.php");
}

// delete skill
if(isset($_GET['delete_skill'])){
    $skill_id=$_GET['delete_skill'];
    $delete_skill="DELETE FROM `skills` WHERE `skill_id`= '$skill_id' ";
    $run_delete_skill=mysqli_query($connect,$delete_skill);
    header("location:FREELANCERPROFILE.php");
}


// archive experience
if(isset($_POST['archive'])){
    $experience_id=$_POST['experience_id'];
    $archive="UPDATE `experience` SET `hidden` = 1 WHERE `experience_id` = $experience_id";
    $run_archive=mysqli_query($connect,$archive);
    header("location:FREELANCERPROFILE.php");
}

// unarchive 
if(isset($_POST['unarchive'])){
    $experience_id=$_POST['experience_id'];
    $unarchive="UPDATE `experience` SET `hidden` = 0 WHERE `experience_id` = $experience_id";
    $run_unarchive=mysqli_query($connect,$unarchive);
    header("location:FREELANCERPROFILE.php");
}
// UPLOAD FILE
$max_file_size= 5 * 1024 * 1024;
if(isset($_POST['add_file'])){
    $fileName=$_FILES['file_upload']['name'];
    if($_FILES['file-upload']['name'] < $max_file_size){
        $upload_file="UPDATE `freelancer` SET `freelancer_file` = '$fileName' WHERE `freelancer_id`= '$freelancer_id' ";
        $run_upload=mysqli_query($connect,$upload_file);
        $move_file= move_uploaded_file($_FILES['file_upload']['tmp_name'],"file/".$_FILES['file_upload']['name']);
        if($move_file){
            header("location:FREELANCERPROFILE.php");
        }
    }else{
        $error = "File size exceeds the maximum limit of 5MB.";
    }
}
// delete cv or file
if(isset($_POST['delete_file'])){
    $delete_file="UPDATE `freelancer` SET `freelancer_file` = NULL  WHERE freelancer_id = $freelancer_id ";
    $run_delete=mysqli_query($connect,$delete_file);
    header("location:FREELANCERPROFILE.php");
}
// HOLD ACCOUNT
if(isset($_POST['hold'])){
    $hold_accunt="UPDATE `freelancer` SET `hidden`= 1  WHERE freelancer_id = $freelancer_id ";
    $run_hold=mysqli_query($connect,$hold_accunt);
    header("location:FREELANCERPROFILE.php");
}
// UNHOLD ACCOUNT
if(isset($_POST['unhold'])){
    $unhold_accunt="UPDATE `freelancer` SET `hidden`= 0  WHERE freelancer_id = $freelancer_id ";
    $run_unhold=mysqli_query($connect,$unhold_accunt);
    header("location:FREELANCERPROFILE.php");
}
// COUNT VIEWS
$view_count_query = "SELECT COUNT(*) as view_count FROM views WHERE freelancer_id = $freelancer_id ";
$view_result_result = mysqli_query($connect,$view_count_query);
$view_count = mysqli_fetch_assoc($view_result_result)['view_count'];

// delete experience 
if(isset($_GET['del_exper'])){
    $exper_id=$_GET['experience_id'];
    $delete_experience="DELETE FROM `experience` WHERE `experience_id` = '$exper_id'";
    $run_delete_experience= mysqli_query($connect,$delete_experience);
    header("location:FREELANCERPROFILE.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Freelancer Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./css/FREELANCERPROFILE.css">
    
    <style>
        /* Popup styling */
        .popup {
            display: none; /* Hide popups by default */
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background: white;
            border: 1px solid #ccc;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
            z-index: 1000;
            transform: translate(-50%,-50%);
            text-align: center;
            border-radius: 7px;
            color:#58151c;
        }
        .popup.show {
            display: block; /* Show popup when class 'show' is added */
        }
        .overlay {
            display: none; /* Hide overlay by default */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }
        .overlay.show {
            display: block; /* Show overlay when class 'show' is added */
        }
        .lol{
            color:#58151c;
        }
    </style>
</head>

<body>
<h2></h2>

    <div class="profile-container">
        <?php foreach($run_select_all as $data){ ?>
            <div class="class">
            <a href="./dashboard.php" class="btn-dash">Dashboard</a>
            <a href="./freelancerview.php?vfid=<?php echo $freelancer_id?>" class="btn-dash">View As</a>
            </div>
            
            <div class="profile-image">
                <img src="<?php echo "img/profile/".$data['freelancer_image'] ?>" alt="Profile Image" id="image-preview">
            </div>
            <h1><?php echo htmlspecialchars($data['freelancer_name'], ENT_QUOTES, 'UTF-8'); ?></h1>
            <div class="profile-form" >
                <a href="./EDITPROFILE_freelancer.php" class="btn-prof">Edit profile</a>

                <div class="form-group">
                    <label for="career">Career:</label>
                    <p> <?php echo htmlspecialchars($data['career_path'], ENT_QUOTES, 'UTF-8' )?></p>
                </div>

                <div class="form-group">
                    <label for="job-title">Job Title:</label>
                    <p class="web"><?php echo htmlspecialchars($data['job_title'], ENT_QUOTES, 'UTF-8' )?></p>
                </div>

                <?php if(!empty($data['bio'])){ ?>
                    <div class="form-group">
                        <label for="bio">Bio:</label>
                        <p><?php echo htmlspecialchars($data['bio'], ENT_QUOTES, 'UTF-8')?></p>
                    </div>
                <?php } ?>

                <div class="form-group">
                    <label for="bio">Price/hour:</label>
                    <p><?php echo htmlspecialchars($data['price/hr'], ENT_QUOTES, 'UTF-8' )?>$</p>
                </div>
                
                <div class="form-group">
                    <label for="bio">Estimated Price:</label>
                    <p><?php echo htmlspecialchars ($data['webssite_price'], ENT_QUOTES, 'UTF-8')?>$</p>
                </div>

                <?php if(!empty($data['available_hours'])){ ?>
                    <div class="form-group">
                        <label for="bio">Available hours:</label>
                        <p><?php echo htmlspecialchars ($data['available_hours'], ENT_QUOTES, 'UTF-8')?></p>
                    </div>
                <?php } ?>

                <div class="form-group">
                    <label for="bio">Rank:</label>
                    <p><?php echo htmlspecialchars ($data['rank'], ENT_QUOTES, 'UTF-8' )?></p>
                </div>

                
                <div class="form-group">
                    <?php 
                    if (isset($plan_id) && $plan_id != 1 && $plan_status == 'Active'){ ?>
                    <label for="bio">Views:</label>
                    <p>
                    <?php echo $view_count; }else{?>
                    <!-- <a href="#" class="btn-dash">Premium</a></p> -->
                    <?php } ?>
                </div>

                <div class="group">
                                    <!-- GITHUB LINK -->
                    <?php if(!empty($data['link1'])){ ?>
                    <div class="form-group">
                        <label for="github-link"><i class="fa-brands fa-github"></i></label>
                        <div class="social-link1">
                            <a href="<?php echo htmlspecialchars($data['link1'], ENT_QUOTES, 'UTF-8'); ?>" target="_blank">GitHub</a>
                        </div>
                    </div>
                    <?php }else{ ?>
                        <div class="form-group">
                            <label for="github-link"><i class="fa-brands fa-github"></i></label>
                            <div class="social-link1">
                            <span>...</span>
                            </div>
                        </div>
                    <?php } ?>
                                    <!-- LINKEDIN LINK -->
                    <?php if(!empty($data['link2'])){?>
                        <div class="form-group">
                            <label for="linkedin-link"><i class="fa-brands fa-linkedin"></i></label>
                            <div class="social-link2">
                                <a href="<?php echo htmlspecialchars($data['link2'], ENT_QUOTES, 'UTF-8'); ?>" target="_blank">LinkedIn</a>
                            </div>
                        </div>
                    <?php }else{ ?>
                        <div class="form-group">
                            <label for="linkedin-link"><i class="fa-brands fa-linkedin"></i></label>
                            <div class="social-link2">
                            </i> <span>...</span>
                            </div>
                        </div>
                    <?php } ?>
                </div>
               
                <div class="form-group1">
                    <label for="skills" class="mt-2">Skills:</label>
                    <div class="skills">
                        <?php foreach($run_select_skill as $sk){ ?>
                        <?php if(!empty($sk['skill'])){ ?>
                            <div class="btn btn-outline-secondary"><?php echo $sk['skill']; ?>
                                <button class="btn-del" onclick="openSkillPopup(<?php echo $sk['skill_id']; ?>)">
                                    <i style="margin-left: -20px;" class="fa-solid fa-trash trash1"></i>
                                </button>
                            </div>
                            <form method="GET" id="deleteSkillForm-<?php echo $sk['skill_id']; ?>" style="display:none;">
                                <input type="hidden" name="delete_skill" value="<?php echo $sk['skill_id']; ?>">
                            </form>
                            <div class="popup alert alert-danger" id="popup-skill-<?php echo $sk['skill_id']; ?>" role="alert"> 
                                <h3><i class="fa-solid fa-triangle-exclamation"></i>sure you wanna delete this skill !!</h3>
                                <button type="submit" class="lol btn btn-outline-dark" onclick="confirmSkillDelete()">yes</button>
                                <button type="button" class="lol btn btn-outline-dark" onclick="closeSkillPopup()">no </button>
                            </div>
                        <?php }} ?>
                            <div class="input-group mb-3">
                                <form method="POST" enctype="multipart/form-data" class="input-group mb-3">
                                    <input type="text" name="skills" class="form-control" placeholder="Add Skill" aria-label="Recipient's username" aria-describedby="button-addon2">
                                    <button type="submit" name="skill" class="btn btn-warning">Add Skill</button>
                                </form>
                            </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="rate-communication">Communication Rate:</label>
                    <div class="rate-communic ">
                        <p style="color: #2124b1;">
                        <?php echo round($avg_rate1,2);?>/5</p>

                    </div>
                </div>

                <div class="form-group">
                    <label for="rate-quality">Quality Rate:</label>
                    <div class="rate-quality">
                        <p style="color: #2124b1;">
                        <?php echo round($avg_rate2,2);?>/5</p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="rate-delivery">Delivering Time Rate:</label>
                    <div class="rate-delivery">
                        <p style="color: #2124b1;">
                        <?php echo round($avg_rate3,2);?>/5</p>
                    </div>
                </div>

                <!-- <div class="form-group">
                    <label for="review">Review:</label>
                </div> -->

                <?php if(!empty($data['freelancer_file'])){?>
                    <div class="form-groupupload">
                        <label for="file-upload">CV: <a style="color: #2124b1;" href="./file/<?php echo htmlspecialchars($data['freelancer_file'], ENT_QUOTES, 'UTF-8' )?>" target="_blank" ><?php echo $data['freelancer_file'];?></a></label>
                        <form method="POST">
                            <!-- delete user file -->
                            <button type="button" class="del-file-btn"onclick="openpopup()">                                        <i class="fa-solid fa-trash-can" ></i></button>
                            <div class="overlay" id="overlay"></div>

                            <div class="popup alert alert-danger" id="popup" role="alert"> 
                                <h3><i class="fa-solid fa-triangle-exclamation"></i>Are you sure, wanna delete this file ?</h3>
                                <button type="submit" class="lol btn btn-outline-dark" name="delete_file" onclick="closepopup()">Yes</button>
                                <button type="button" class="lol btn btn-outline-dark" onclick="closepopup()">no </button>
                            </div>
                        </form>
                    </div>
                <?php }else{ ?>
                    <div class="form-groupupload">
                        <form method="POST" enctype="multipart/form-data">
                            <label for="file-upload">Upload your CV:</label>
                            <!-- <input type="file" id="file-upload" name="file_upload" accept=".pdf,.doc,.docx" required> -->
                            
  <input class="form-control"type="file" id="file-upload" name="file_upload" accept=".pdf,.doc,.docx" required>

                            <!-- <button type="submit" name="add_file">Upload</button> -->
                            <button type="submit" name="add_file" class="add-skill">Add</button>
                            <?php if(!empty($error)) { ?>
                                <div class="alert alert-warning" role="alert">
                                    <?php echo $error ?>
                                </div>
                            <?php } ?>
                        </form>
                    </div>
                <?php } ?>
            </form>


            <div class="form-group11">
                  
                <div class="all">
                    <div class="txt d-flex f-row "> <label for="experience">Experience:</label>
                        <a href="./wall.php" class="btn-exp">Add</a>
                    </div>

                    <?php foreach($run_select_experience as $exper){ ?>
                       
                        <div class="post1">
                            <?php if(!empty($exper['experience_image'])){?>
                            <div class="img"><img src="<?php echo "img/experience/".htmlspecialchars($exper['experience_image'], ENT_QUOTES, 'UTF-8' )?>" alt=""></div>
                            <div class="text">
                                <div class="anchers">
                                    <a href="./edit-experience.php?edit_experience=<?php echo $exper['experience_id']?>"><i class="fa-solid fa-pen-to-square" style="color: gold;"></i></a>
                                    <?php if($exper['hidden'] == 0 ){ ?>
                                    <form method="POST">
                                        <input type="hidden" name="experience_id" value="<?php echo $exper['experience_id']?>">
                                        <button class="arc" type="submit" name="archive"><i class="fa-solid fa-box" style="color: gold; background-color:transparent;"></i></button>
                                    </form>

                                    <?php }else{ ?>

                                    <form method="POST">
                                        <input type="hidden" name="experience_id" value="<?php echo $exper['experience_id']?>">
                                        <button class="arc" type="submit" name="unarchive"><i class="fa-solid fa-box-open" style="color: gold; background-color:transparent;"></i> </button>
                                    </form>
                                    <?php } ?>

                                    <!-- Experience Deletion -->

                                    <button type="button" class="arc" onclick="openExperiencePopup(<?php echo $exper['experience_id']; ?>)">
                                        <i class="fa-solid fa-trash-can" style="color: gold; background-color:transparent;"></i>                                    </button>
                                    <form method="GET" id="deleteExperienceForm-<?php echo $exper['experience_id']; ?>" style="display:none;">
                                        <input type="hidden" name="experience_id" value="<?php echo $exper['experience_id']; ?>">
                                        <input type="hidden" name="del_exper" value="1">
                                    </form>
                                    <div class="popup alert alert-danger" id="popup-experience-<?php echo $exper['experience_id']; ?>">
                                        <h3><i class="fa-solid fa-triangle-exclamation"></i>Are you sure, wanna delete this file ?</h3>
                                        <button type="button" class="lol btn btn-outline-dark" onclick="confirmExperienceDelete()">Yes</button>
                                        <button type="button" class="lol btn btn-outline-dark" onclick="closeExperiencePopup()">No</button>
                                    </div>
                                </div>
                                <?php if(!empty($exper['experience_file'])){ ?>
                                <p><a href="img/experience/<?php echo htmlspecialchars($exper['experience_file'], ENT_QUOTES, 'UTF-8' )?>" target="_blank" >Click to view file</a></p>
                                <?php } ?>
                                <p><?php echo htmlspecialchars ($exper['experience_text'], ENT_QUOTES, 'UTF-8' )?></p></div>
                            </div>
                            <?php }else{ ?> 
                        </div>
                        <div class="post2">
                            <div class="anchers">
                                    <a href="./edit-experience.php?edit_experience=<?php echo $exper['experience_id']?>"><i class="fa-solid fa-pen-to-square" style="color: gold;"></i></a>
                                    <?php if($exper['hidden'] == 0 ){ ?>
                                    <form method="POST">
                                        <input type="hidden" name="experience_id" value="<?php echo $exper['experience_id']?>">
                                        <button class="arc" type="submit" name="archive"><i class="fa-solid fa-box" style="color: gold; background-color:transparent;"></i></button>
                                    </form>

                                    <?php }else{ ?>

                                    <form method="POST">
                                        <input type="hidden" name="experience_id" value="<?php echo $exper['experience_id']?>">
                                        <button class="arc" type="submit" name="unarchive"><i class="fa-solid fa-box-open" style="color: gold; background-color:transparent;"></i> </button>
                                    </form>
                                    <?php } ?>
                                    
                                    <!-- Experience Deletion -->

                                    <button type="button" class="arc" onclick="openExperiencePopup(<?php echo $exper['experience_id']; ?>)">
                                        <i class="fa-solid fa-trash-can" style="color: gold; background-color:transparent;"></i>                                    </button>
                                    <form method="GET" id="deleteExperienceForm-<?php echo $exper['experience_id']; ?>" style="display:none;">
                                        <input type="hidden" name="experience_id" value="<?php echo $exper['experience_id']; ?>">
                                        <input type="hidden" name="del_exper" value="1">
                                    </form>
                                    <div class="popup alert alert-danger" id="popup-experience-<?php echo $exper['experience_id']; ?>">
                                        <h3><i class="fa-solid fa-triangle-exclamation"></i>Are you sure, wanna delete this file ?</h3>
                                        <button type="button" class="lol btn btn-outline-dark" onclick="confirmExperienceDelete()">Yes</button>
                                        <button type="button" class="lol btn btn-outline-dark" onclick="closeExperiencePopup()">No</button>
                                    </div>

                                </div>
                                <?php if(!empty($exper['experience_file'])){ ?>
                                <p><a href="img/experience/<?php echo htmlspecialchars ($exper['experience_file'], ENT_QUOTES, 'UTF-8' )?>" target="_blank" >Click to view file</a></p>
                                <?php } ?>
                                <p><?php echo $exper['experience_text']?></p>
                        </div>
                        <?php  ?>
                         
                    <?php } } ?>
                            
                </div>
            </div>
            <div class="button-container">
                <!-- <div class="buttoncont2"> -->
                <?php if($data['hidden'] == 0){ ?>
                    <form method="POST" >
                        <button type="submit" name="hold" class="btn-12">Freeze Account</button>
                    </form>
                <?php }else{ ?>
                    <form method="POST" >
                        <button type="submit" name="unhold" class="btn-12">Unfreeze Account</button>
                    </form>
                <?php } ?>
                    <a href="./changepass_freelancer.php" class="btn-12">Change Password</a>
                    <form method="POST">
                        <button type="submit" name="logout" class="btn-12" id="logout">Logout</button>
                    </form>
            </div>
        </div>
        <?php } ?>

    </div>
    
    <!-- main js -->
    <script src="./js/FREELANCERPROFILE.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
    let deleteSkillId, deleteExperienceId;

    function openSkillPopup(skillId) {
        deleteSkillId = skillId;
        document.getElementById('popup-skill-' + skillId).classList.add('show');
    }

    function closeSkillPopup() {
        document.getElementById('popup-skill-' + deleteSkillId).classList.remove('show');
    }

    function confirmSkillDelete() {
        document.getElementById('deleteSkillForm-' + deleteSkillId).submit();
    }

    function openExperiencePopup(experienceId) {
        deleteExperienceId = experienceId;
        document.getElementById('popup-experience-' + experienceId).classList.add('show');
    }

    function closeExperiencePopup() {
        document.getElementById('popup-experience-' + deleteExperienceId).classList.remove('show');
    }

    function confirmExperienceDelete() {
        document.getElementById('deleteExperienceForm-' + deleteExperienceId).submit();
    }

    //delete file popup

    function openpopup() {
        var popup = document.getElementById("popup");
        var overlay = document.getElementById("overlay");

        popup.classList.add("show");   // Show the popup
        overlay.classList.add("show"); // Show the overlay
    }

    function closepopup() {
        var popup = document.getElementById("popup");
        var overlay = document.getElementById("overlay");

        popup.classList.remove("show");   // Hide the popup
        overlay.classList.remove("show"); // Hide the overlay
    }
</script>
</body>

</html>
