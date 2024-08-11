<?php
// include("connection.php");

// if(isset($_GET['edit_experience'])){
//     $experience_id=$_GET['edit_experience'];
//     $select_experience="SELECT * FROM `experience` WHERE `experience_id`= $experience_id ";
//     $run_select_experience=mysqli_query($connect,$select_experience);
// }
// if(isset($_POST['edit']))
//     $experience_text=mysqli_real_escape_string($connect,$_POST['experience-text']);
//     $experience_img=mysqli_real_escape_string($connect,$_FILES['experience-image']['name']);
//     $edit_exp = "UPDATE `experience`
//                 SET `experience_text` = '$experience_text' , `experience_image` = '$experience_img'
//                 WHERE `experience_id` = '$experience_id'";
//     $run_edit_experience=mysqli_query($connect,$edit_exp);
//     $move_file= move_uploaded_file($_FILES['experience-image']['tmp_name'],"img/".$_FILES['experience-image']['name']);
//     if($move_file){
//         header("location: freelancer_profile.php");
//     }

include("connection.php");

if (isset($_GET['edit_experience'])) {
    $experience_id = $_GET['edit_experience'];
    $select_experience = "SELECT * FROM `experience` WHERE `experience_id`= $experience_id";
    $run_select_experience = mysqli_query($connect, $select_experience);

}

if (isset($_POST['edit'])) {
$experience_text = mysqli_real_escape_string($connect, $_POST['experience-text']);

if (isset($_FILES['experience-image']['name']) && !empty($_FILES['experience-image']['name'])) {
    $experience_img = mysqli_real_escape_string($connect, $_FILES['experience-image']['name']);
    $move_file = move_uploaded_file($_FILES['experience-image']['tmp_name'], "img/" . $experience_img);

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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Experience</title>
    <link rel="stylesheet" href="./css/edit_alaa.css">
</head>
<body>
    <div class="container">
        <form class="experience-form" method="POST" enctype="multipart/form-data">
            <h2>Edit Experience</h2>
        <?php foreach($run_select_experience as $data){ ?>
            <label for="name">Experience:</label>
            <input type="text" id="name" value="<?php echo $data['experience_text']?>" name="experience-text" placeholder="Experience Name" required>

            <label for="image">Image:</label>
            <input type="file" id="image" name="experience-image" accept="image/*">

            <button type="submit" name="edit">Submit</button>
        <?php } ?>
        </form>
    </div>
</body>
</html>

