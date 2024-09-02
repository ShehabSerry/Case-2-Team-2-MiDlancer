<?php
include("connection.php");
$popup = false; 
$error="";
if(isset($_SESSION['user_id']))
    $user_id=$_SESSION['user_id'];
else
    header("Location: home.php");
// SELECT USER INFO
$select_user = "SELECT * FROM `user` 
                JOIN `nationality` ON `nationality`.`nationality_id` = `user`.`nationality_id`
                WHERE `user_id` = $user_id ";
$run_user = mysqli_query($connect,$select_user);
$user_data = mysqli_fetch_assoc($run_user);
if(isset($_POST['update'])){
    $user_name =mysqli_real_escape_string($connect,$_POST['name']);
    $user_image =mysqli_real_escape_string($connect,$_FILES['image']['name']);
    $phone_number=mysqli_real_escape_string($connect,$_POST['phone']);
    $bio =mysqli_real_escape_string($connect,$_POST['bio']);
if(strlen($phone_number)!=11){
    $error= "Please enter a valid Phone number";
}else{
    if(empty($user_image)){
        $user_image = $user_data['user_image'];
    }
    else
    {
        $check_image_query = "SELECT user_image FROM user WHERE user_image = '$user_image'
                              UNION SELECT freelancer_image FROM freelancer
                              WHERE freelancer_image = '$user_image'
                             "; // Tarek suggested random name insert - I'll go with my stupid search (2 tables)
        $run_check_image = mysqli_query($connect, $check_image_query);

        if(mysqli_num_rows($run_check_image) > 0)
            $user_image = pathinfo($user_image, PATHINFO_FILENAME) . "(C$user_id)." . pathinfo($user_image, PATHINFO_EXTENSION); // def (CF28) .png

        move_uploaded_file($_FILES['image']['tmp_name'], "img/profile/" . $user_image);
    }
    if(empty($bio)){
        $bio = $user_data['bio'];
    }
    $update="UPDATE `user`
            SET `user_name`= '$user_name',
                `phone_number`= '$phone_number',
                `user_image` = '$user_image',
                `bio` = '$bio' 
            WHERE `user_id` = '$user_id'";
    $run_update=mysqli_query($connect,$update);
    $popup = true;
    header("refresh:2; url= clientprofile.php");
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/editprofile_client.css">
    <link href="imgs/logo.png" rel="icon">
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
            /*background-color: #fff;*/
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            /*padding: 20px;*/
            z-index: 1000;
        }
        input[type="file"] {
            background-color: white;
            position: relative;
            top: 10px;
            color: black;
            height: auto;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="profile-container  ">
        <div class="profile-card">
            <a href="./clientprofile.php" class="close"><i class="fa-solid fa-x "></i></a>
            <h2>Edit Your Profile</h2>
            <form class="profile-form" method="POST" enctype="multipart/form-data">
                <?php foreach($run_user as $row){ ?>
                <div class="profile-image">
                        <img src="<?php echo "img/profile/". $row['user_image']?>" alt="Profile Image" id="image-preview">
                </div>

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" value="<?php echo $row['user_name'] ?>" placeholder="Your Name">
                </div>

                <div class="form-group">
                    <label for="phone-number">Phone Number</label>
                    <input type="number" id="phone-number" name="phone" value="<?php echo $row['phone_number'] ?>" placeholder="Your Phone Number">
                </div>

                <div class="form-group">
                    <label for="bio">Bio</label>
                    <textarea id="bio" name="bio" placeholder="A short bio about yourself"><?php echo $row['bio']; ?></textarea>
                </div>

                <div class="form-group">
                    <label for="name">Edit profile photo</label>
                    <input type="file" id="profile photo" name="image" value="<?php echo $row['user_image'] ?>" placeholder="profile photo">
                </div>
                
                <?php if(!empty($error)) { ?>
                    <div class="alert alert-warning" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php } ?>

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
    const phoneInput = document.querySelector('input[name="phone"]');
    const bioInput = document.querySelector('textarea[name="bio"]');
    const imageInput = document.querySelector('input[name="image"]');

    const nameError = document.createElement('div');
    const phoneError = document.createElement('div');
    const bioError = document.createElement('div');
    const imageError = document.createElement('div');

    const errorClass = 'error-message';
    nameError.className = errorClass;
    phoneError.className = errorClass;
    bioError.className = errorClass;
    imageError.className = errorClass;

    nameInput.parentNode.insertBefore(nameError, nameInput.nextSibling);
    phoneInput.parentNode.insertBefore(phoneError, phoneInput.nextSibling);
    bioInput.parentNode.insertBefore(bioError, bioInput.nextSibling);
    imageInput.parentNode.insertBefore(imageError, imageInput.nextSibling);

    function validateField() {
        const name = nameInput.value.trim();
        const phone = phoneInput.value.trim();
        const bio = bioInput.value.trim();
        const image = imageInput.files.length > 0;

        let valid = true;

        nameError.textContent = '';
        phoneError.textContent = '';
        bioError.textContent = '';
        imageError.textContent = '';

        if (!name) {
            nameError.textContent = 'Name is required';
            valid = false;
        }

        if (!phone || phone.length !== 11) {
            phoneError.textContent = 'Phone number must be 11 digits';
            valid = false;
        }

        return valid;
    }

    nameInput.addEventListener('blur', validateField);
    phoneInput.addEventListener('blur', validateField);
    bioInput.addEventListener('blur', validateField);
    imageInput.addEventListener('change', validateField);

    nameInput.addEventListener('input', validateField);
    phoneInput.addEventListener('input', validateField);
    bioInput.addEventListener('input', validateField);

    form.addEventListener('submit', function (event) {
        if (!validateField()) {
            event.preventDefault();
        }
    });
});
</script>



</body>
</html>
