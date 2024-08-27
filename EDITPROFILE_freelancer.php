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
        header("location:freelancerprofile.php");

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

    const nameError = document.createElement('div');
    const jobTitleError = document.createElement('div');
    const phoneError = document.createElement('div');
    const bioError = document.createElement('div');
    const priceError = document.createElement('div');
    const availableHoursError = document.createElement('div');
    const githubLinkError = document.createElement('div');
    const linkedinLinkError = document.createElement('div');
    const imageError = document.createElement('div');

    const errorClass = 'error-message';
    nameError.className = errorClass;
    jobTitleError.className = errorClass;
    phoneError.className = errorClass;
    bioError.className = errorClass;
    priceError.className = errorClass;
    availableHoursError.className = errorClass;
    githubLinkError.className = errorClass;
    linkedinLinkError.className = errorClass;
    imageError.className = errorClass;

    nameInput.parentNode.insertBefore(nameError, nameInput.nextSibling);
    jobTitleInput.parentNode.insertBefore(jobTitleError, jobTitleInput.nextSibling);
    phoneInput.parentNode.insertBefore(phoneError, phoneInput.nextSibling);
    bioInput.parentNode.insertBefore(bioError, bioInput.nextSibling);
    priceInput.parentNode.insertBefore(priceError, priceInput.nextSibling);
    availableHoursInput.parentNode.insertBefore(availableHoursError, availableHoursInput.nextSibling);
    githubLinkInput.parentNode.insertBefore(githubLinkError, githubLinkInput.nextSibling);
    linkedinLinkInput.parentNode.insertBefore(linkedinLinkError, linkedinLinkInput.nextSibling);
    imageInput.parentNode.insertBefore(imageError, imageInput.nextSibling);

    function validateField() {
        const name = nameInput.value.trim();
        const jobTitle = jobTitleInput.value.trim();
        const phone = phoneInput.value.trim();
        const bio = bioInput.value.trim();
        const price = priceInput.value.trim();
        const availableHours = availableHoursInput.value.trim();
        const githubLink = githubLinkInput.value.trim();
        const linkedinLink = linkedinLinkInput.value.trim();
        const image = imageInput.files.length > 0;

        let valid = true;

        nameError.textContent = '';
        jobTitleError.textContent = '';
        phoneError.textContent = '';
        bioError.textContent = '';
        priceError.textContent = '';
        availableHoursError.textContent = '';
        githubLinkError.textContent = '';
        linkedinLinkError.textContent = '';
        imageError.textContent = '';

        if (!name) {
            nameError.textContent = 'Name is required';
            valid = false;
        }
        if (!jobTitle) {
            jobTitleError.textContent = 'Job title is required';
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
        if (!price || price <= 0) {
            priceError.textContent = 'Price per hour must be a positive number';
            valid = false;
        }
        if (!availableHours || availableHours <= 0) {
            availableHoursError.textContent = 'Available hours must be a positive number';
            valid = false;
        }
        if (githubLink && !/^https?:\/\/.*github\.com\/.*$/.test(githubLink)) {
            githubLinkError.textContent = 'Invalid GitHub link format';
            valid = false;
        }
        if (linkedinLink && !/^https?:\/\/.*linkedin\.com\/.*$/.test(linkedinLink)) {
            linkedinLinkError.textContent = 'Invalid LinkedIn link format';
            valid = false;
        }
        if (!image) {
            imageError.textContent = 'Profile image is required';
            valid = false;
        }

        return valid;
    }

    nameInput.addEventListener('blur', validateField);
    jobTitleInput.addEventListener('blur', validateField);
    phoneInput.addEventListener('blur', validateField);
    bioInput.addEventListener('blur', validateField);
    priceInput.addEventListener('blur', validateField);
    availableHoursInput.addEventListener('blur', validateField);
    githubLinkInput.addEventListener('blur', validateField);
    linkedinLinkInput.addEventListener('blur', validateField);
    imageInput.addEventListener('change', validateField);

    nameInput.addEventListener('input', validateField);
    jobTitleInput.addEventListener('input', validateField);
    phoneInput.addEventListener('input', validateField);
    bioInput.addEventListener('input', validateField);
    priceInput.addEventListener('input', validateField);
    availableHoursInput.addEventListener('input', validateField);
    githubLinkInput.addEventListener('input', validateField);
    linkedinLinkInput.addEventListener('input', validateField);

    form.addEventListener('submit', function (event) {
        if (!validateField()) {
            event.preventDefault();
        }
    });
});
</script>

</body>
</html>
