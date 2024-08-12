<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'mail/src/Exception.php';
require 'mail/src/PHPMailer.php';
require 'mail/src/SMTP.php';
require './connection.php';

$mail = new PHPMailer();
$mail->isSMTP();                                            //Send using SMTP
$mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
$mail->SMTPAuth   = true;                                   //Enable SMTP authentication

// OLD $mail->Username   = "taskify49@gmail.com";                     //SMTP username OLD
// OLD $mail->Password   = "qdvb cmpa phsm mwxm";                          //SMTP password OLD

$mail->Username   = "MiDlancerTeam@gmail.com";                     //SMTP username
$mail->Password   = "nvrv jfzr kdga ysjw ";                          //SMTP password
$mail->SMTPSecure = "ssl";                                      //Enable implicit TLS encryption
$mail->Port       = 465;
$mail->isHTML(true);                                  //Set email format to HTML
$mail ->CharSet ="UTF-8";
?>