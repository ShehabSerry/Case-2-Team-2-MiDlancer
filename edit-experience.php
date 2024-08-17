<?php
// include("connection.php");
include 'nav+bm.php';
// if the user is not logged in 
// uncomment when done
// if(!isset($_SESSION['freelancer_id'])){
//     header("location:home.php");
// }
if(isset($_SESSION['freelancer_id'])){
    $freelancer_id=$_SESSION['freelancer_id'];
}
// poster information freelancer y3ny
$select_poster="SELECT * FROM `freelancer` WHERE `freelancer_id` = '$freelancer_id'";
$run_poster= mysqli_query($connect,$select_poster);

if(isset($_GET['edit_experience'])) {
    $experience_id = $_GET['edit_experience'];
    $select_experience = "SELECT * FROM `experience`
                         WHERE `experience_id`= $experience_id";
    $run_select_experience = mysqli_query($connect, $select_experience);
    // $fetch_experience= mysqli_fetch_assoc($run_select_experience);
}
if (isset($_POST['edit'])){
    $experience_text = mysqli_real_escape_string($connect, $_POST['experience-text']);
    
    if (isset($_FILES['experience-image']['name']) && !empty($_FILES['experience-image']['name'])) {
        $experience_img = mysqli_real_escape_string($connect, $_FILES['experience-image']['name']);
        $move_file = move_uploaded_file($_FILES['experience-image']['tmp_name'], "img/experience/" . $experience_img);
    
        if ($move_file) {
            $edit_exp = "UPDATE `experience`
                            SET `experience_text` = '$experience_text', `experience_image` = '$experience_img'
                            WHERE `experience_id` = '$experience_id'";
            header("location: freelancer_profile.php");
        }
        } else {
        $edit_exp = "UPDATE `experience`
                        SET `experience_text` = '$experience_text'
                        WHERE `experience_id` = '$experience_id'";
        header("location: freelancer_profile.php");
    }
    $run_edit_experience = mysqli_query($connect, $edit_exp);
  }
?>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!----link bootsrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <!-- link css -->
    <link rel='stylesheet' type='text/css' media="screen" href="css/edit-experience.css" />
    <title>Edit Experience</title>
    
</head>

<body>
    
    <!-- <a href="" class="close"><i class="fa-solid fa-x "></i></a> -->
    <div class="background ">
        <div class="container-main ">
            <div class="wrapper">
                <div class="from-wraapper  Sign-in">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="flex-row d-flex" style="gap:6%">
                            <?php foreach($run_poster as $row){?>
                            <img src="<?php echo "img/profile/".$row['freelancer_image']?>" height="60" width="70"
                                class="rounded-circle">
                            <div class="d-flex flex-column justify-content-start ml-2" id="ssss">
                                <div class="ssss">
                                    <span class="d-block font-weight-bold name"><?php echo $row['freelancer_name'] ?></span>
                                    <p class="date text-white-50"><?php echo $row['bio']?></p>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                        <?php foreach($run_select_experience as $data){ ?>
                            <style>
        .labelFile{
            background-image: url("img/experience/<?php echo $data['experience_image'] ?>");
        }
    </style>
                        <label for="file" class="labelFile" ><span><svg xml:space="preserve" viewBox="0 0 184.69 184.69"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg"
                                    id="Capa_1" version="1.1" width="60px" height="60px">
                                    <g>
                                        <g>
                                            <g>
                                                <path
                                                    d="M149.968,50.186c-8.017-14.308-23.796-22.515-40.717-19.813
                            C102.609,16.43,88.713,7.576,73.087,7.576c-22.117,0-40.112,17.994-40.112,40.115c0,0.913,0.036,1.854,0.118,2.834
                            C14.004,54.875,0,72.11,0,91.959c0,23.456,19.082,42.535,42.538,42.535h33.623v-7.025H42.538
                            c-19.583,0-35.509-15.929-35.509-35.509c0-17.526,13.084-32.621,30.442-35.105c0.931-0.132,1.768-0.633,2.326-1.392
                            c0.555-0.755,0.795-1.704,0.644-2.63c-0.297-1.904-0.447-3.582-0.447-5.139c0-18.249,14.852-33.094,33.094-33.094
                            c13.703,0,25.789,8.26,30.803,21.04c0.63,1.621,2.351,2.534,4.058,2.14c15.425-3.568,29.919,3.883,36.604,17.168
                            c0.508,1.027,1.503,1.736,2.641,1.897c17.368,2.473,30.481,17.569,30.481,35.112c0,19.58-15.937,35.509-35.52,35.509H97.391
                            v7.025h44.761c23.459,0,42.538-19.079,42.538-42.535C184.69,71.545,169.884,53.901,149.968,50.186z"
                                                    style="fill:#010002;"></path>
                                            </g>
                                            <g>
                                                <path d="M108.586,90.201c1.406-1.403,1.406-3.672,0-5.075L88.541,65.078
                            c-0.701-0.698-1.614-1.045-2.534-1.045l-0.064,0.011c-0.018,0-0.036-0.011-0.054-0.011c-0.931,0-1.85,0.361-2.534,1.045
                            L63.31,85.127c-1.403,1.403-1.403,3.672,0,5.075c1.403,1.406,3.672,1.406,5.075,0L82.296,76.29v97.227
                            c0,1.99,1.603,3.597,3.593,3.597c1.979,0,3.59-1.607,3.59-3.597V76.165l14.033,14.036
                            C104.91,91.608,107.183,91.608,108.586,90.201z" style="fill:#010002;"></path>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </span>
                            <p>drag and drop your file here or click to select a file!</p>
                        </label>

                        <input class="input" name="experience-image" id="file" type="file" />



                        </div>
                        <div class="input-group">
                            <input type="text" name="experience-text" value="<?php echo $data['experience_text']?>" required>
                            <label for="">Text</label>
                        </div>
                        <?php } ?>
                
                    <div class="btns">
                        <div class="buttons">
                            <button class="cssbuttons-io-button addto" type="submit" name="edit">
                                <a href="#">Submit</a>
                                <div class="icon">
                                    <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 0h24v24H0z" fill="none"></path>
                                        <path
                                            d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"
                                            fill="currentColor"></path>
                                    </svg>
                                </div>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    <script src="main.js"></script>
</body>

</html>