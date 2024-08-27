<?php
include("connection.php");
$error="";
if(isset($_SESSION['user_id'])){
    $user_id=$_SESSION['user_id'];
}
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
    if (!empty($_FILES['image']['name'])) {
        move_uploaded_file($_FILES['image']['tmp_name'], "img/profile/" . $_FILES['image']['name']);
    }
    header("location: clientprofile.php");
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
    <style>
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
                    <textarea id="bio" name="bio" placeholder="A short bio about yourself"></textarea>
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

        if (!bio) {
            bioError.textContent = 'Bio is required';
            valid = false;
        }

        if (!image) {
            imageError.textContent = 'Profile image is required';
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
