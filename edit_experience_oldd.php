<?php
include("connection.php");
if(!isset($_SESSION['freelancer_id'])){
    header("location:login_freelancer.php");
}
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
    <link rel='stylesheet' type='text/css' media="screen" href="css/editexp.css" />
    <title>edit post</title>
</head>

<body>
<div class="background">
    <div class="container-main">
        <div class="wrapper">
            <div class="from-wraapper  Sign-in">
                <a href="#" class="close"><i class="fa-solid fa-x "></i></a>
                <form method="POST" enctype="multipart/form-data">
                    <div class="flex-row d-flex">
                        <?php foreach($run_poster as $row){ ?>
                            <img src="<?php echo "img/profile/".$row['freelancer_image']?>" height="60" width="70" class="rounded-circle">
                            <div class="d-flex flex-column justify-content-start ml-2" id="ssss">
                                <div class="ssss">
                                    <span class="d-block font-weight-bold name" style="text-align: left;margin-left:50px"><?php echo $row['freelancer_name']?></span>
                                    <p class="date text-white-50 " style="margin-left:50px ;" ><?php echo $row['bio'] ?></p>
                                </div>
                            </div>
                        <?php } ?>
                    </div>



            </div>
            <?php foreach($run_select_experience as $data){ ?>
                <div class="input-group">
                    <input type="text" name="experience-text" value="<?php echo $data['experience_text']?>" id="text" required>
                    <label for="text">Text</label>
                </div>

                <div class="btns">
                    <div class="buttons">
                        <button class="cssbuttons-io-button addto" type="submit" name="edit">
                            <a href="#" style="text-decoration: none;">Submit</a>
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
</div>
</div>
<script src="main.js"></script>
</body>

</html>
