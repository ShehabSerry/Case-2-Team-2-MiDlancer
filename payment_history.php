<?php
// include 'nav+bm.php';
include("connection.php");
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}else{
    header("location:home.php");
}
$history = "SELECT `project`.*, 
                    `user`.*,
                    `freelancer`.*, 
                    `payment`.* FROM  `payment`
        JOIN `freelancer` ON `payment`.`freelancer_id` = `freelancer`.`freelancer_id`
        JOIN `project` ON `payment`.`project_id` = `project`.`project_id`
        JOIN `user` ON `payment`.`user_id` = `user`.`user_id`
        WHERE `payment`.`user_id` = '$user_id'
        ORDER BY `payment`.`date` DESC";
$result = mysqli_query($connect,$history);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment History</title>
</head>
<body>
    <h1>Payment History</h1>

    <table>
        <thead>
            <tr>
                <th>Project Name</th>
                <th>Freelancer Name</th>
                <th>Total Amount</th>
                <th>Payment Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0) { ?>
                <?php foreach ($result as $row) { ?>
                    <tr>
                    <td><?php echo htmlspecialchars($row["project_name"]) ?></td>;
                    <td><?php echo htmlspecialchars($row["freelancer_name"]) ?></td>;
                    <td><?php echo htmlspecialchars($row["amount"]) ?></td>;
                    <td><?php echo date("d-m-Y", strtotime($row["date"])) ?></td>;
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <td>No payment yet.</td>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
