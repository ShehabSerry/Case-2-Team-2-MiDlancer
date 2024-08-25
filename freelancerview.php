<?php
// include("connection.php");
// if the user is not logged in 
// uncomment when done
// if(empty($_SESSION['user_id'])){
//     header("location:home.php");
// }
include("nav+bm.php");

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}

if(isset($_GET['vfid'])) {
    $id = $_GET['vfid'];

    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
        $vfid = $_GET['vfid'];
        $chkView = "SELECT freelancer_id, user_id FROM views WHERE freelancer_id = '$vfid' AND user_id = '$user_id'";
        $runChkView = mysqli_query($connect, $chkView);
        if (mysqli_num_rows($runChkView) == 0){
            $insertView = "INSERT INTO views(freelancer_id, user_id) VALUES ('$vfid','$user_id')";
            mysqli_query($connect, $insertView);
        }
    }
}

// freelancer information
$select_freelancer = " SELECT * FROM `freelancer`
                       JOIN `career` ON `career`.`career_id` = `freelancer`.`career_id`
                       JOIN `rank` ON `rank`.`rank_id` = `freelancer`.`rank_id`
                       WHERE `freelancer`.`freelancer_id` = $id";
$run_select= mysqli_query($connect,$select_freelancer);

// select skills
$select_skill= "SELECT * FROM `skills` WHERE `freelancer_id`= $id ";
$run_select_skill= mysqli_query($connect,$select_skill);

// SELECT RATING 
$select_rating = " SELECT * FROM `rate` 
                    LEFT JOIN `user` ON `user`.`user_id` = `rate`.`user_id`
                    WHERE `freelancer_id`= $id";
$run_select_rating=mysqli_query($connect,$select_rating);

// SELECT avg(rate1), AVG(rate2), AVG(rate3) FROM rate WHERE freelancer_id = 4

$select_avg="SELECT AVG(rate1) as RATE1 ,
                    AVG(rate2) as RATE2 ,
                    AVG(rate3) as RATE3
                    FROM `rate` WHERE `freelancer_id`= $id ";
$run_avg=mysqli_query($connect,$select_avg);
$key=mysqli_fetch_assoc($run_avg);

// Select_experience
$select_experience="SELECT * FROM `experience` WHERE `freelancer_id`= $id ";
$run_select_experience=mysqli_query($connect,$select_experience);

if(isset($_POST['add'])){
    $rating1 = mysqli_real_escape_string($connect, $_POST['rating1']);
    $rating2 = mysqli_real_escape_string($connect, $_POST['rating2']);
    $rating3 = mysqli_real_escape_string($connect, $_POST['rating3']);
    $review = mysqli_real_escape_string($connect, $_POST['review']);

    $insert_rate = "INSERT INTO `rate` (rate1, rate2, rate3, comment, user_id, freelancer_id) VALUES ('$rating1', '$rating2', '$rating3', '$review', '$user_id', '$id')";
    $run_insert = mysqli_query($connect, $insert_rate);
    header("Location: freelancerview.php?vfid=$id");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Freelancer Profile</title>
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/css/bootstrap.min.css" integrity="sha384-SI27wrMjH3ZZ89r4o+fGIJtnzkAnFs3E4qz9DIYioCQ5l9Rd/7UAa8DHcaL8jkWt" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./css/FREELANCERPROFILE.css">
</head>

<body>


<h2>Freelancer Profile</h2>

    <div class="profile-container">
            <?php foreach($run_select as $data){ ?>
            <div class="class"></div>

            <div class="profile-image">
                <img src="<?php echo "img/profile/".$data['freelancer_image'] ?>" alt="Profile Image" id="image-preview">
            </div>
            <h1><?php echo $data['freelancer_name'] ?></h1>
            <form method="POST" class="profile-form" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="career">Career:</label>
                    <p><?php echo $data['career_path']?></p>
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
                            <button type="button" class="btn btn-outline-secondary"><?php echo $sk['skill']?></button>
                        <?php }else{?>
                            <label for="skills">Skills: ..</label>
                        <?php }} ?>
                    
                    </div>
                </div>
                
            <form>
                <div class="form-group">
                    <label for="rate-communication">Rate Communication:</label>
                    <div class="rate-communic ">
                    <div class="rateyo1" id="rating"
                        data-rateyo-rating="4"
                        data-rateyo-num-stars="5"
                        data-rateyo-score="3"></div>
                        <input type="hidden" name="rating1" id="rating_value1">
                        <span class='result1'></span>
                        <p style="color: #2124b1;">
                        <?php echo round($key['RATE1'],2);?>/5</p>

                    </div>
                </div>

                <div class="form-group">
                    <label for="rate-quality">Rate Quality:</label>
                    <div class="rate-quality">
                    <div class="rateyo2" id="rating"
                        data-rateyo-rating="4"
                        data-rateyo-num-stars="5"
                        data-rateyo-score="3"></div>
                        <input type="hidden" name="rating2" id="rating_value2">
                        <span class='result2'></span>
                        <p style="color: #2124b1;">
                        <?php echo round($key['RATE2'],2);?>/5</p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="rate-delivery">Rate Delivering Time:</label>
                    <div class="rate-delivery">
                    <div class="rateyo3" id="rating"
                        data-rateyo-rating="4"
                        data-rateyo-num-stars="5"
                        data-rateyo-score="3"></div>
                        <input type="hidden" name="rating3" id="rating_value3">
                        <span class='result3'></span>
                        <p style="color: #2124b1;">
                        <?php echo round($key['RATE3'],2);?>/5</p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="review">Review: </label>
                    <textarea placeholder="Write a review." name="review"></textarea>
                </div>
                <button type="submit" name="add">Rate</button>

            </form>
                <!-- <div class="form-group">
                    <label for="review">Review:</label>
                </div> -->

                <?php if(!empty($data['freelancer_file'])){?>
                    <div class="form-groupupload">
                        <label for="file-upload">CV: <a href="./file/<?php echo $data['freelancer_file'] ?>" target="_blank" ><?php echo $data['freelancer_file'];?></a></label>
                    </div>
                <?php }else{ ?>
                    <label style="font-weight: bold;
                        font-size: 22px;
                        color: rgb(2, 2, 88);
                        text-align: left; 
                        padding-top: 9px;" for="file-upload">No Files Yet </label>
                <?php } ?>
                <div class="all" style="width: 70%; margin-left: 0%;">
                    <div class="txt d-flex f-row "> <p for="experience">Experience:</p>
                        <!-- <a href="#" class="btn-exp">Add</a> -->
                    </div>

                    <?php foreach($run_select_experience as $exper){ ?>
                        <?php if(!empty($exper['experience_text'])){ ?>
                        <?php if(!empty($exper['experience_image'])){?>
                            <div class="post1">
                                <div class="img"><img src="<?php echo "img/experience/".$exper['experience_image']?>" alt=""></div>
                            <div class="text">
                                <p><?php echo $exper['experience_text']?></p></div>
                            </div>
                        <?php }else{ ?> 
                        <div class="post2">
                            <p><?php echo $exper['experience_text']?></p>
                        </div>
                    <?php }}else{ ?>
                        <label style="font-weight: bold;
                        font-size: 22px;
                        color: rgb(2, 2, 88);
                        text-align: left; 
                        padding-top: 9px;" for="file-upload">No Posts Yet </label>
                    <?php }} ?>
                </div>
            </form>


            <div class="form-group11">
                  
            </div>
           
    <?php } ?>
    </div>

    <script src="./js/FREELANCERPROFILE.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
    <script>
    $(function () {
        $(".rateyo1").rateYo().on("rateyo.change", function (e, data) {
            var rating = data.rating;
            $(this).siblings('input[name=rating1]').val(rating); // Add rating value to input field
            $(this).siblings('.result1').text('Rating: ' + rating +'/5'); // Update the result span
        });

        $(".rateyo2").rateYo().on("rateyo.change", function (e, data) {
            var rating = data.rating;
            $(this).siblings('input[name=rating2]').val(rating); // Add rating value to input field
            $(this).siblings('.result2').text('Rating: ' + rating +'/5'); // Update the result span
        });

        $(".rateyo3").rateYo().on("rateyo.change", function (e, data) {
            var rating = data.rating;
            $(this).siblings('input[name=rating3]').val(rating); // Add rating value to input field
            $(this).siblings('.result3').text('Rating: ' + rating +'/5'); // Update the result span
        });
    });
    </script>
</body>

</html>
