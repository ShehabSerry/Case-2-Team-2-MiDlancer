<?php
include "mail.php";


$freelancer_id = $_SESSION['freelancer_id'];
if (isset($_GET['project_id'])) {
    // $project_id = $_GET['project_id'];
    $project_id=1;

    $select = "SELECT * FROM `request` WHERE `status` = 'pending'";
    $runselect = mysqli_query($connect, $select);

    if (isset($_GET['accept'])) {

        $request_id = $_GET['accept'];
        $update = "UPDATE `request` SET `status` = 'accept' WHERE `request_id` = $request_id";
        $runupdate = mysqli_query($connect, $update);

        if ($runupdate) {
            $select = "SELECT 
                        `freelancer`.`email` AS 'freelancer_email',
                        `user`.`email` AS 'user_email',
                        `freelancer`.`name` AS 'freelancer_name',
                        `user`.`name` AS 'user_name',
                        `project`.`name` AS 'project_name',
                        `project`.`description` AS 'description',
                        `project`.`type` AS 'type',
                        `project`.`deadline_date` AS 'deadline_date',
                        `project`.`price_per_hr` AS 'price_per_hr',
                        `project`.`total_hours` AS 'total_hours'
                       FROM `request` 
                       JOIN `project` ON `request`.`project_id` = `project`.`project_id`
                       JOIN `freelancer` ON `request`.`freelancer_id` = `freelancer`.`freelancer_id`
                       JOIN `user` ON `project`.`user_id` = `user`.`user_id`
                       WHERE `request`.`request_id` = '$request_id'";

            $runq = mysqli_query($connect, $select);

            if (mysqli_num_rows($runq) > 0) {
                $fetch = mysqli_fetch_assoc($runq);
                $freelancer_name = $fetch['freelancer_name'];
                $user_name = $fetch['user_name'];
                $user_email = $fetch['user_email'];
                $freelancer_email = $fetch['freelancer_email'];
                $project_name = $fetch['project_name'];
                $project_description = $fetch['description'];
                $project_type = $fetch['type'];
                $project_deadline = $fetch['deadline_date'];
                $price_per_hr = $fetch['price_per_hr'];
                $total_hours = $fetch['total_hours'];

                $total_price = $price_per_hr * $total_hours;

                $message = "
                <body style='padding: 0; margin: 0;'>
                    <div class='main' style='width: 100%; background-color: #d6d9e0; color: #1d1d27;'>
                        <div class='head' style='width: 100%; background-color: #06085e; text-align: center; color: #d6d9e0;'>
                            <h1 style='font-size: 70px; padding-top: 2%;'>MiDlancer</h1>
                            <h3 style='font-size: 50px; font-weight: 300;'>Contract</h3>
                        </div>
                        
                        <div class='first' style='width: 100%; margin-top: 2%;'>
                            <p style='font-size: 30px; padding: 0 8%;'>I undersigned, hereby acknowledge my comprehension and acceptance of the terms and conditions delineated below.</p>
                        </div>
                        <div class='fees' style='width: 100%; margin-top: 2%;'>
                            <h2 style='padding: 0 6%; color: #06085e;'> Fees & Deadline</h2>
                            <p style='font-size: 25px; padding: 8px 8%;'>Payment of fees <span style='color: red;'>$total_price</span> for <span style='color: red;'>$project_name</span></p>
                            <p style='font-size: 25px; padding: 8px 8%;'>Payment is expected to be rendered prior to the commencement of the project on <span style='color: red;'>dd/mm/yy</span>, and the stipulated deadline for this project is <span style='color: red;'>$project_deadline</span>.</p>
                        </div>
                        <div class='requirements' style='width: 100%; margin-top: 2%;'>
                            <h2 style='padding: 0 6%; color: #06085e;'>Client’s Requirements</h2>
                            <ul style='padding: 0 9%;'>
                                <li style='font-size: 23px; padding-top: 8px;'>$project_name</li>
                                <li style='font-size: 23px; padding-top: 8px;'>$project_description</li>
                                <li style='font-size: 23px; padding-top: 8px;'>$total_hours hours</li>
                            </ul>
                        </div>
                        <div class='cancelation' style='width: 100%; margin-top: 2%;'>
                            <h2 style='padding: 0 6%; color: #06085e;'>Cancellation & Return or Delay</h2>
                            <ul style='padding: 9px 9%;'>
                                <li style='font-size: 23px;padding-top: 8px;'>Cancellations must be made by passing <span style='color: red;'>25%</span> of the whole duration.</li>
                                <li style='font-size: 23px;padding-top: 8px;'>If the cancellation happens after that, all the amount of money is returned to the client directly.</li>
                                <li style='font-size: 23px;padding-top: 8px;'>If the client wants to cancel the project, he has only <span style='color: red;'>20%</span> of the duration to get back all his money. If he passes this period, he will not be able to get his money back.</li>
                                <li style='font-size: 23px;padding-top: 8px;'>If the freelancer delays deadlines, it will lead to a reduction in his rate on the website.</li>
                                <li style='font-size: 23px;padding-top: 8px;'>Any party that cancels before the approved time will be charged a <span style='color: red;'>7%</span> (Half the commission) as a cancellation fee.</li>
                                <li style='font-size: 23px;padding-top: 8px;'>If a cancellation is made after the agreed-upon cancellation deadline, the hours worked by the freelancer will be calculated and the amount due will be paid. A commission fee of <span style='color: red;'>15%</span> will be deducted, and the client will receive the remaining amount.</li>
                                <li style='font-size: 23px;padding-top: 8px;'>In terms of the freelancer, their rating will decrease, and there will be a penalty resulting in a ban that will be <span style='color: red;'>between 1 day to 3 days</span>. Additionally, they will be subject to a fee of <span style='color: red;'>7%</span> of the commission.</li>
                                <li style='font-size: 23px;padding-top: 8px;'>Any cancellation after the approved time to cancel from any party will result in payment of half of the commission, which amounts to <span style='color: red;'>7%</span>.</li>
                            </ul>
                        </div>
                        <div class='names' style='width: 100%; display: flex; margin-top: 4%;'>
                            <div class='name' style='width: 50%;'>
                                <h2 style='font-size: 35px; padding: 0 17%; color: #06085e;'>Client Name:<span style='font-size: 25px; font-weight: 200; padding-left: 5px; color: black;'>$user_name</span></h2>
                            </div>
                            <div class='name2' style='width: 50%;'>
                                <h2 style='font-size: 35px; padding: 0 17%; color: #06085e;'>Freelancer Name:<span style='font-size: 25px; font-weight: 200; padding-left: 5px; color: black;'>$freelancer_name</span></h2>
                            </div>
                        </div>
                        <div class='signature' style='width: 100%; display: flex; justify-content: space-between; margin-top: 4%;'>
                            <div class='client' style='width: 50%;'>
                                <p style='font-size: 28px; padding: 5% 25%;'>$user_name</p>
                                <h2 style='font-size: 35px; padding: 0 22%; color: #06085e;'>Client Signature</h2>
                            </div>
                            <div class='freelancer' style='width: 50%;'>
                                <p style='font-size: 28px; padding: 5% 28%;'>$freelancer_name</p>
                                <h2 style='font-size: 35px; padding: 0 22%; color: #06085e;'>Freelancer Signature</h2>
                            </div>
                        </div>
                    </div>
                </body>";
                $mail->setFrom('MiDlancerTeam@gmail.com', 'MiDlancer');
                $mail->addAddress($email);      
                $mail->isHTML(true);
                $mail->Subject = 'Password Reset Successfully';             
                $mail->Body = ($$message);                  
                $mail->send();

               {
                    header("location: income-request.php");
                }
            }
        }
    }

    if (isset($_GET['decline'])) {
        $request_id = $_GET['decline'];

        // Update the request status to 'decline'
        $update2 = "UPDATE `request` SET `status` = 'decline' WHERE `request_id` = $request_id";
        $runupdate2 = mysqli_query($connect, $update2);

        if ($runupdate2) {
            $select = "SELECT 
                        `freelancer`.`email` AS 'freelancer_email',
                        `user`.`email` AS 'user_email',
                        `freelancer`.`name` AS 'freelancer_name',
                        `user`.`name` AS 'user_name'
                       FROM `request` 
                       JOIN `project` ON `request`.`project_id` = `project`.`project_id`
                       JOIN `freelancer` ON `request`.`freelancer_id` = `freelancer`.`freelancer_id`
                       JOIN `user` ON `project`.`user_id` = `user`.`user_id`
                       WHERE `request`.`request_id` = '$request_id'";

            $runq = mysqli_query($connect, $select);

            if (mysqli_num_rows($runq) > 0) {
                $fetch = mysqli_fetch_assoc($runq);
                $freelancer_name = $fetch['freelancer_name'];
                $user_name = $fetch['user_name'];
                $user_email = $fetch['user_email'];
                $freelancer_email = $fetch['freelancer_email'];

                $message = "<body>
                            <h4>Hi $user_name,</h4>
                            <p>Your request for the project has been declined.</p>
                            </body>";
                            $mail->setFrom('MiDlancerTeam@gmail.com', 'MiDlancer');
                            $mail->addAddress($email);      
                            $mail->isHTML(true);
                            $mail->Subject = 'Password Reset Successfully';             
                            $mail->Body = ($message);                  
                            $mail->send();

                {
                    header("location: income-request.php");
                }
            }
        }
    }
}
?>
