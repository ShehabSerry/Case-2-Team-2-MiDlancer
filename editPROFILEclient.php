<?php
include("connection.php");
if(isset($_SESSION['user_id'])){
    $user_id=$_SESSION['user_id'];
}
$error_msg="";
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
        echo "Please enter a valid Phone number";
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
            move_uploaded_file($_FILES['image']['tmp_name'], "img/" . $_FILES['image']['name']);
        }
        header("location: client_profile.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Client Profile</title>
    <link rel="stylesheet" href="css/EDITPROFILE.css">
</head>
<body>
    <div class="profile-container">
        <div class="profile-card">
            <h2>Edit Your Profile</h2>
            <form class="profile-form" method="POST" enctype="multipart/form-data">
                <?php foreach($run_user as $row){ ?>
                <div class="profile-image">
                        <img src="<?php echo "img/".$row['user_image'] ?>" alt="Profile Image" id="image-preview">
                    <input type="file" id="image" name="image" accept="image/*" onchange="previewImage(event)">
                </div>

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" value="<?php echo $row['user_name'] ?>" placeholder="Your Name">
                </div>

                <div class="form-group">
                    <label for="bio">Bio</label>
                    <textarea id="bio" name="bio" placeholder="A short bio about yourself"></textarea>
                </div>

                <div class="form-group">
                    <label for="phone_number">Phone Number</label>
                    <input type="number" id="phone_number" value="<?php echo $row['phone_number'] ?>" name="phone" placeholder="Phone Number">
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

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('image-preview');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>
</html>