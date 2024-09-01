<?php
include("connection.php");
$popup = false;

if(isset($_SESSION['freelancer_id']))
    $freelancer_id=$_SESSION['freelancer_id'];
else
    header("Location: home.php");

$select_freelancer = " SELECT * FROM `freelancer`
                       JOIN `career` ON `career`.`career_id`= `freelancer`.`career_id`
                       JOIN `rank` ON `rank`.`rank_id` = `freelancer`.`rank_id`
                       WHERE `freelancer`.`freelancer_id` = $freelancer_id";
$run_select= mysqli_query($connect,$select_freelancer);
$freelancer_data =mysqli_fetch_assoc($run_select);
if(isset($_POST['update'])){
    $freelancer_name =htmlspecialchars(strip_tags(mysqli_real_escape_string($connect,$_POST['name'])));
    $phone_number=mysqli_real_escape_string($connect,$_POST['phone']);
    $freelancer_image=mysqli_real_escape_string($connect,$_FILES['image']['name']);
    $jop_title =htmlspecialchars(strip_tags(mysqli_real_escape_string($connect,$_POST['job-title'])));
    $bio =htmlspecialchars(strip_tags(mysqli_real_escape_string($connect,$_POST['bio'])));
    $price =htmlspecialchars(strip_tags(mysqli_real_escape_string($connect,$_POST['price-hr'])));
    $hours =htmlspecialchars(strip_tags(mysqli_real_escape_string($connect,$_POST['available-hour'])));
    $link_github =htmlspecialchars(strip_tags(mysqli_real_escape_string($connect,$_POST['github-link'])));
    $link_linkedin =htmlspecialchars(strip_tags(mysqli_real_escape_string($connect,$_POST['linkedin-link'])));
    // to make sure the phone number is valid
    if(strlen($phone_number)!=11){
        echo "Please enter a valid Phone number";
    }else{
        if(empty($freelancer_image)){
            $freelancer_image=mysqli_real_escape_string($connect, $freelancer_data['freelancer_image']);
        }
        else
        {
            $check_image_query = "SELECT freelancer_image FROM freelancer WHERE freelancer_image = '$freelancer_image'";
            $run_check_image = mysqli_query($connect, $check_image_query);

            if(mysqli_num_rows($run_check_image) > 0)
                $freelancer_image = pathinfo($freelancer_image, PATHINFO_FILENAME) . "(F$freelancer_id)." . pathinfo($freelancer_image, PATHINFO_EXTENSION); // def (28) .png

            move_uploaded_file($_FILES['image']['tmp_name'], "img/profile/" . $freelancer_image);
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
        $popup = true;
         header("refresh:2; url= freelancerprofile.php");
        // header("location:");

}}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="css/EDITPROFILE.css">
    <style>
        /* Additional CSS for the overlay */
        :root{
    --white: #fcfcfc;
    --gray: #cbcdd3;
    --dark: #777777;
    --error: #ef8d9c;
    --orange: #ffc39e;
    --success: #b0db7d;
    --secondary: #99dbb4;
}


@import url("https://fonts.googleapis.com/css?family=Lato:400,700");

/* $font: "Lato", sans-serif; */



.containerr {
  position: relative;
  margin: auto;
  overflow: hidden;
  width: 700px;
  height: 250px;
} 

#containerr {
  position: relative;
  margin: auto;
  overflow: hidden;
  width: 700px;
  height: 250px;
} 

h1 {
  font-size: 0.9em;
  font-weight: 100;
  letter-spacing: 3px;
  padding-top: 5px;
  color: var(--white) ;
  padding-bottom: 5px;
  text-transform: uppercase;
}

.green {
  color:var(--secondary);
   /* darken($secondary, 20%); */
}

.red {
  color: var(--error);
  /* darken($error, 10%); */
}

.alert {
  font-weight: 700;
  letter-spacing: 5px;
}

p {
  margin-top: -5px;
  /* font-size: 0.5em; */
  /* font-weight: 100; */
  color: var(--white);
  /* darken($dark, 10%); */
  letter-spacing: 1px;
}

button,
.dot {
  cursor: pointer;
}

#success-box {
  position: absolute;
  width: 100%;
  height: 100%;
  right: 0;
  background: linear-gradient(to bottom right, var(--success) , var(--secondary) );
  border-radius: 20px;
  box-shadow: 5px 5px 20px rgba(var(--gray), 10%);
  perspective: 40px;
}

#error-box {
  position: absolute;
  width: 100%;
  height: 100%;
  right: 0;
  background: linear-gradient(to bottom left, var(--error) 40%, var(--orange) 100%);
  border-radius: 20px;
  box-shadow: 5px 5px 20px rgba(var(--gray), 10%);
}

.dot {
  width: 8px;
  height: 8px;
  background: var(--white);
  border-radius: 50%;
  position: absolute;
  top: 4%;
  right: 6%;

}
.dot:hover {
    background: darken(var(--white), 20%);
  }

.two {
  right: 12%;
  opacity: 0.5;
}

.face {
  position: absolute;
  width: 22%;
  height: 22%;
  background: var(--white);
  border-radius: 50%;
  border: 1px solid var(--dark);
  top: 21%;
  left: 37.5%;
  z-index: 2;
  animation: bounce 1s ease-in infinite;
}

.face2 {
  position: absolute;
  width: 22%;
  height: 22%;
  background: var(--white);
  border-radius: 50%;
  border: 1px solid var(--dark);
  top: 21%;
  left: 37.5%;
  z-index: 2;
  animation: roll 3s ease-in-out infinite;
}

.eye {
  position: absolute;
  width: 5px;
  height: 5px;
  background: var(--dark);
  border-radius: 50%;
  top: 40%;
  left: 20%;
}

.right {
  left: 68%;
}

.mouth {
  position: absolute;
  top: 43%;
  left: 41%;
  width: 7px;
  height: 7px;
  border-radius: 50%;
}

.happy {
  border: 2px solid;
  border-color: transparent var(--dark) var(--dark) transparent;
  transform: rotate(45deg);
}

.sad {
  top: 49%;
  border: 2px solid;
  border-color: var(--dark) transparent transparent var(--dark);
  transform: rotate(45deg);
}

.shadow {
  position: absolute;
  width: 21%;
  height: 3%;
  opacity: 0.5;
  background: var(--dark);
  left: 40%;
  top: 43%;
  border-radius: 50%;
  z-index: 1;
}

.scale {
  animation: scale 1s ease-in infinite;
}
.move {
  animation: move 3s ease-in-out infinite;
}

.message {
  position: absolute;
  width: 100%;
  text-align: center;
  height: 40%;
  top: 47%;
  
}

.button-box {
  position: absolute;
  background: var(--white);
  width: 50%;
  height: 15%;
  border-radius: 20px;
  top: 73%;
  left: 25%;
  outline: 0;
  border: none;
  box-shadow: 2px 2px 10px rgba(var(--dark), 0.5);
  transition: all 0.5s ease-in-out;
}
.button-box:hover {
    /* background: darken(var(--white), 5%); */
    transform: scale(1.05);
    transition: all 0.3s ease-in-out;
  }

@keyframes bounce {
  50% {
    transform: translateY(-10px);
  }
}

@keyframes scale {
  50% {
    transform: scale(0.9);
  }
}

@keyframes roll {
  0% {
    transform: rotate(0deg);
    left: 25%;
  }
  50% {
    left: 60%;
    transform: rotate(168deg);
  }
  100% {
    transform: rotate(0deg);
    left: 25%;
  }
}

@keyframes move {
  0% {
    left: 25%;
  }
  50% {
    left: 60%;
  }
  100% {
    left: 25%;
  }
}

        .overlay {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
        .popup {
            display: none;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 300px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            z-index: 1000;
        }
    </style>


</head>
<body>
    <div class="profile-container  ">
        <div class="profile-card">
            <a href="./FREELANCERPROFILE.php" class="close"><i class="fa-solid fa-x "></i></a>
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
                    <textarea id="bio" name="bio" placeholder="A short bio about yourself"><?php echo $edit['bio'] ?></textarea>
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
                    <label for="available-hour">Available Hours/Week</label>
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



    <div class="overlay" id="overlay" onclick="closePopup()"></div>
    <div class="containerr popup" id="popup">
        <div id="success-box">
          <div class="dot"></div>
          <div class="dot two"></div>
          <div class="face">
            <div class="eye"></div>
            <div class="eye right"></div>
            <div class="mouth happy"></div>
          </div>
          <div class="shadow scale"></div>
          <div class="message">
            <h1 class="alert">Success!</h1>
            <p>Your Profile has been edited successfully.</p>
         </div>
          <!-- <button type="submit" class="button-box"><h1 class="green">continue</h1></button> -->
        </div>
        </div>
                                </div>


                  
        <script>
        function openPopup() {
            document.getElementById('popup').style.display = 'block';
            document.getElementById('overlay').style.display = 'block';
        }

        function closePopup() {
            document.getElementById('popup').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        }

        <?php if ($popup){ ?>
        // Automatically open the popup if $popup is true
        openPopup();
        <?php } ?>
        </script>

<script src="js/FREELANCERPROFILE.js"></script>
<script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('form');
            const nameInput = document.querySelector('input[name="name"]');
            const jobTitleInput = document.querySelector('input[name="job-title"]');
            const phoneInput = document.querySelector('input[name="phone"]');
            const bioInput = document.querySelector('textarea[name="bio"]');
            const priceInput = document.querySelector('input[name="price-hr"]');
            const availableHoursInput = document.querySelector('input[name="available-hour"]');
            const githubLinkInput = document.querySelector('input[name="github-link"]');
            const linkedinLinkInput = document.querySelector('input[name="linkedin-link"]');
            const imageInput = document.querySelector('input[name="image"]');

            const errorMessages = {
                name: "Please enter your name.",
                jobTitle: "Please enter your job title.",
                phone: "Please enter a valid 11-digit phone number.",
                bio: "Please enter a bio.",
                price: "Please enter a valid hourly rate.",
                availableHours: "Please enter your available hours per week.",
                githubLink: "Please enter a valid GitHub URL.",
                linkedinLink: "Please enter a valid LinkedIn URL.",
                image: "Please upload a valid image."
            };

            form.addEventListener('submit', function (event) {
                let valid = true;

                if (nameInput.value.trim() === "") {
                    document.getElementById('nameError').textContent = errorMessages.name;
                    valid = false;
                } else {
                    document.getElementById('nameError').textContent = "";
                }

                if (jobTitleInput.value.trim() === "") {
                    document.getElementById('jobTitleError').textContent = errorMessages.jobTitle;
                    valid = false;
                } else {
                    document.getElementById('jobTitleError').textContent = "";
                }

                if (phoneInput.value.length !== 11 || isNaN(phoneInput.value)) {
                    document.getElementById('phoneError').textContent = errorMessages.phone;
                    valid = false;
                } else {
                    document.getElementById('phoneError').textContent = "";
                }

               

                if (priceInput.value <= 0) {
                    document.getElementById('priceError').textContent = errorMessages.price;
                    valid = false;
                } else {
                    document.getElementById('priceError').textContent = "";
                }

                if (availableHoursInput.value <= 0) {
                    document.getElementById('availableHoursError').textContent = errorMessages.availableHours;
                    valid = false;
                } else {
                    document.getElementById('availableHoursError').textContent = "";
                }

                if (githubLinkInput.value && !githubLinkInput.value.startsWith("http")) {
                    document.getElementById('githubLinkError').textContent = errorMessages.githubLink;
                    valid = false;
                } else {
                    document.getElementById('githubLinkError').textContent = "";
                }

                if (linkedinLinkInput.value && !linkedinLinkInput.value.startsWith("http")) {
                    document.getElementById('linkedinLinkError').textContent = errorMessages.linkedinLink;
                    valid = false;
                } else {
                    document.getElementById('linkedinLinkError').textContent = "";
                }

                if (imageInput.files.length > 0) {
                    const file = imageInput.files[0];
                    const validImageTypes = ['image/jpeg', 'image/png', 'image/gif'];
                    if (!validImageTypes.includes(file.type)) {
                        document.getElementById('imageError').textContent = errorMessages.image;
                        valid = false;
                    } else {
                        document.getElementById('imageError').textContent = "";
                    }
                }

                if (!valid) {
                    event.preventDefault();
                }
            });
        });
    </script>
</body>
</html>
