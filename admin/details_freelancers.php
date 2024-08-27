<?php
include "connection.php";
$admin_id=$_SESSION['admin_id'];

$select="SELECT `freelancer_id`,`freelancer_name`, `email`, `job_title`, `career`.`career_path`, `fl_join_date`, `price/hr`
FROM `freelancer`
JOIN `career` ON `freelancer`.`career_id`=  `career`.`career_id`
 ORDER BY `freelancer`.`fl_join_date` ASC";
$runQ=mysqli_query($connect, $select);

if (isset($_GET['delete'])) {
    $freelancer_id = $_GET['delete'];
    $delete = "DELETE FROM `freelancer` WHERE `freelancer_id` = $freelancer_id";
    $run_delete = mysqli_query($connect, $delete);
    header("Location: details_freelancers.php");
    
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- css -->
    <link rel="stylesheet" href="">
    <title>Freelancers Table</title>
</head>

<body>

    <div class="table_div">

        <table class="table table-striped">
            <thead>
                <tr>
                    <th><h3>Freelancer Name</h3></th>
                    <th><h3>Email</h3></th>
                    <th><h3>job_title</h3></th>
                    <th><h3>Career_path</h3></th>
                    <th><h3>Join_date</h3></th>
                    <th><h3>Price/Hr</h3></th>
                    <th><h3>Action</h3></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($runQ as $data) {
                ?> 
                <tr>
                    <td><?php echo $data['freelancer_name']; ?></td>
                    <td><?php echo $data['email']; ?></td>
                    <td><?php echo $data['job_title']; ?></td>
                    <td><?php echo $data['career_path']; ?></td>
                    <td><?php echo $data['fl_join_date']; ?></td>
                    <td><?php echo $data['price/hr']; ?></td>
                    <td><a href="details_freelancers.php?delete=<?php echo $data['freelancer_id']; ?>">DELETE</a></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</body>
</html>
