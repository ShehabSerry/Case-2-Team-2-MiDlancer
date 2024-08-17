<?php
include("connection.php");
// if the user is not logged in 
// uncomment when done
// if(empty($_SESSION['freelancer_id'])){
//     header("location:home.php");
// }
if(isset($_POST['logout'])){
    session_unset();
    session_destroy();
    header("location: login_freelancer.php");
}
if(isset($_SESSION['freelancer_id'])){
    $freelancer_id=$_SESSION['freelancer_id'];
}
// freelancer information
$select_freelancer = " SELECT * FROM `freelancer`
                       JOIN `career` ON `career`.`career_id` = `freelancer`.`career_id`
                       JOIN `rank` ON `rank`.`rank_id` = `freelancer`.`rank_id`
                       WHERE `freelancer`.`freelancer_id` = $freelancer_id";
$run_select= mysqli_query($connect,$select_freelancer);

// select skills
$select_skill= "SELECT * FROM `skills` WHERE `freelancer_id`= $freelancer_id ";
$run_select_skill= mysqli_query($connect,$select_skill);

// SELECT RATING 
$select_rating = " SELECT * FROM `rate` 
                    LEFT JOIN `user` ON `user`.`user_id` = `rate`.`user_id`
                    WHERE `freelancer_id`=$freelancer_id";
$run_select_rating=mysqli_query($connect,$select_rating);

// SELECT avg(rate1), AVG(rate2), AVG(rate3) FROM rate WHERE freelancer_id = 4

$select_avg="SELECT AVG(rate1) as RATE1 ,
                    AVG(rate2) as RATE2 ,
                    AVG(rate3) as RATE3
                    FROM `rate` WHERE `freelancer_id`= $freelancer_id ";
$run_avg=mysqli_query($connect,$select_avg);
$key=mysqli_fetch_assoc($run_avg);

// add skill
if(isset($_POST['skill'])){
    $skill=mysqli_real_escape_string($connect,$_POST['skills']);
    $insert_skill="INSERT INTO `skills` VALUES (NULL,'$skill','$freelancer_id')";
    $run_insert_skill=mysqli_query($connect,$insert_skill);
    header("location:FREELANCERPROFILE.php");
}

// delete skill
if(isset($_GET['delete'])){
    $skill_id=$_GET['delete'];
    $delete_skill="DELETE FROM `skills` WHERE `skill_id`= $skill_id ";
    $run_delete_skill=mysqli_query($connect,$delete_skill);
    header("location:FREELANCERPROFILE.php");
}

// Select_experience
$select_experience="SELECT * FROM `experience` WHERE `freelancer_id`= $freelancer_id ";
$run_select_experience=mysqli_query($connect,$select_experience);

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
if(isset($_POST['add_file'])){
    $fileName=$_FILES['file_upload']['name'];
    $upload_file="UPDATE `freelancer` SET `freelancer_file` = '$fileName' WHERE `freelancer_id`= '$freelancer_id' ";
    $run_upload=mysqli_query($connect,$upload_file);
    $move_file= move_uploaded_file($_FILES['file_upload']['tmp_name'],"file/".$_FILES['file_upload']['name']);
    if($move_file){
        header("location:FREELANCERPROFILE.php");
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
if(isset($_POST['del_exper'])){
    $exper_id=mysqli_real_escape_string($connect,$_POST['experience_id']);
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
</head>

<body>
<h2>Freelancer Profile</h2>

    <div class="profile-container">
        <?php foreach($run_select as $data){ ?>
            <div class="class">
            <a href="./dashboard.php" class="btn-dash">Dashboard</a>
            <a href="./freelancerview.php?vfid=<?php echo $data['freelancer_id']?>" class="btn-dash">View As</a>
            </div>
            
            <div class="profile-image">
                <img src="<?php echo "img/profile/".$data['freelancer_image'] ?>" alt="Profile Image" id="image-preview">
            </div>
            <h1><?php echo $data['freelancer_name'] ?></h1>
            <form method="POST" class="profile-form" enctype="multipart/form-data">
                <a href="./EDITPROFILE_freelancer.php" class="btn-prof">Edit profile</a>

                <div class="form-group">
                    <label for="career">Career:</label>
                    <p> <?php echo $data['career_path']?></p>
                </div>

                <div class="form-group">
                    <label for="job-title">Job Title:</label>
                    <p class="web"><?php echo $data['job_title'] ?></p>
                </div>
                <div class="form-group">
                    <label for="bio">Bio:</label>
                    <p><?php echo $data['bio'] ?></p>
                </div>
                <div class="form-group">
                    <label for="bio">Price/hour:</label>
                    <p><?php echo $data['price/hr'] ?>$</p>
                </div>

                <div class="form-group">
                    <label for="bio">Available hours:</label>
                    <p><?php echo $data['available_hours'] ?></p>
                </div>
                <div class="form-group">
                    <label for="bio">Rank:</label>
                    <p><?php echo $data['rank'] ?></p>
                </div>
                <div class="form-group">
                    <label for="bio">Website Price:</label>
                    <p><?php echo $data['webssite_price']?>$</p>
                </div>
                
                <div class="form-group">
                    <?php if($data['premium'] == 1){ ?>
                        <label for="bio">View:</label>
                        <p><?php echo $view_count; }else{ ?>
                            <a href="#" class="btn-dash">Premium</a></p>
                    <?php } ?>
                </div>

                <div class="group">
                                    <!-- GITHUB LINK -->
                    <?php if(!empty($data['link1'])){ ?>
                    <div class="form-group">
                        <label for="github-link"><i class="fa-brands fa-github"></i></label>
                        <div class="social-link1">
                            <a href="<?php echo $data['link1'] ?>" target="_blank"><span>GitHub</span></a>
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
                                <a href="<?php echo $data['link2']?>" target="_blank"><span>LinkedIn</span></a>
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
                    <label for="skills">Skills:</label>
                    <div class="skills">
                        <?php foreach($run_select_skill as $sk){ ?>
                        <?php if(!empty($sk['skill'])){ ?>
                            <button type="button" class="btn btn-outline-secondary"><?php echo $sk['skill']?><a class="btn-del" href="./FREELANCERPROFILE.php?delete=<?php echo $sk['skill_id']?>"><i class="fa-solid fa-trash trash1" ></i></a></button>
                        <?php }else{?>
                            <label for="skills">Skills: ..</label>
                        <?php }} ?>
                            <div class="input-group mb-3">
                                <input type="text" name="skills" class="form-control" placeholder="Add Skill" aria-label="Recipient's username" aria-describedby="button-addon2">
                                <button type="submit" name="skill" class="btn btn-warning">Add Skill</button>
                            </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="rate-communication">Rate Communication:</label>
                    <div class="rate-communic ">
                        <!-- <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i> -->
                        <p style="color: #2124b1;">
                        <?php echo round($key['RATE1'],2);?>/5</p>

                    </div>
                </div>

                <div class="form-group">
                    <label for="rate-quality">Rate Quality:</label>
                    <div class="rate-quality">
                        <!-- <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i> -->
                        <p style="color: #2124b1;">
                        <?php echo round($key['RATE2'],2);?>/5</p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="rate-delivery">Rate Delivering Time:</label>
                    <div class="rate-delivery">
                        <!-- <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i> -->
                        <p style="color: #2124b1;">
                        <?php echo round($key['RATE3'],2);?>/5</p>
                    </div>
                </div>

                <!-- <div class="form-group">
                    <label for="review">Review:</label>
                </div> -->

                <?php if(!empty($data['freelancer_file'])){?>
                    <div class="form-groupupload">
                        <label for="file-upload">CV: <a href="./file/<?php echo $data['freelancer_file'] ?>" target="_blank" ><?php echo $data['freelancer_file'];?></a></label>
                        <!-- <input type="file"> -->
                        <form method="POST">
                            <!-- delete user file -->
                                <button id="del-btn" type="submit" name="delete_file">Delete</button>
                        </form>
                    </div>
                <?php }else{ ?>
                    <div class="form-groupupload">
                        <form method="POST" enctype="multipart/form-data">
                            <label for="file-upload">Upload your CV:</label>
                            <input type="file" id="file-upload" name="file_upload" accept=".pdf,.doc,.docx" required>
                            <!-- <button type="submit" name="add_file">Upload</button> -->
                            <button type="submit" name="add_file" class="add-skill">Add</button>
                        </form>
                    </div>
                <?php } ?>
            </form>


            <div class="form-group11">
                  
                <div class="all">
                    <div class="txt d-flex f-row "> <label for="experience">Experience:</label>
                        <a href="./wall.php" class="btn-exp">Add</a>
                    </div>
                    <?php if(empty($run_select_experience)) { ?>
                        <h3>No posts yet</h3>
                    <?php } else { ?>
                        <?php foreach($run_select_experience as $exper){ ?>
                       
                        <div class="post1">
                            <?php if(!empty($exper['experience_image'])){?>
                            <div class="img"><img src="<?php echo "img/experience/".$exper['experience_image']?>" alt=""></div>
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
                                    
                                    <form method="POST" >
                                        <input type="hidden" name="experience_id" value="<?php echo $exper['experience_id']?>">
                                        <button class="arc" type="submit" name="del_exper"><i class="fa-solid fa-trash-can" style="color: gold; background-color:transparent;"></i></button>
                                    </form>
                                </div>
                                <p><?php echo $exper['experience_text']?></p></div>
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
                                    
                                    <form method="POST" >
                                        <input type="hidden" name="experience_id" value="<?php echo $exper['experience_id']?>">
                                        <button class="arc" type="submit" name="del_exper"><i class="fa-solid fa-trash-can" style="color: gold; background-color:transparent;"></i></button>
                                    </form>
                                </div>
                            <p><?php echo $exper['experience_text']?></p>
                        </div>
                        <?php  ?>
                        <?php } }} ?>
                            
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
    <script src="./js/FREELANCERPROFILE.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>