<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function sendEmail($totalValue)
{
  // Customer's details
  $customerEmail = $_POST['email'];
  $street = ucfirst($_POST['street']);
  $streetnumber = $_POST['streetnumber'];
  $city = ucfirst($_POST['city']);
  $zipcode = $_POST['zipcode'];

  // Delivery
  $timeOfOrdering = date('H:i');
  $expectedDeliveryNormal = date('H:i',strtotime('+2 hour',strtotime($timeOfOrdering)));
  $expectedDeliveryExpress = date('H:i',strtotime('+45 minutes',strtotime($timeOfOrdering)));
 
    if(isset($_POST['normaldelivery'])){
        $deliveryTime = $expectedDeliveryNormal  . '.';
    } else {
        $deliveryTime = $expectedDeliveryExpress . '.';
    }

  $orderValue = $totalValue;

  // Message
  $customerMsgHTML =
    "Thank you for ordering!<br/>
    <br/>
    Your order will be delivered to:<br/>
    <b> $street $streetnumber</b>, <b>$zipcode</b> in <b>$city</b>.<br/>
    <br />
    ETA: <b>$deliveryTime<br />
    <br />
    The order total is: <b>&euro; $orderValue </b>.";

  // SEND MAIL
  $mail = new PHPMailer(true);
  try {
    // DEBUG
    // $mail->SMTPDebug = 3;
    // SERVER
    $mail->isSMTP();
    $mail->Host       = 'mail.gmx.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'nicolsaha@gmx.com';
    $mail->Password   = 'justfortesting';
    $mail->SMTPSecure = 'ssl';
    $mail->Port       =  465;
    // SENDER
    $mail->setFrom('nicolsaha@gmx.com', 'Nicol Saha');
    // RECEIVER
    $mail->addAddress($customerEmail, 'Happy Customer');
    // CONTENT
    $mail->isHTML(true);
    $mail->Subject = 'Thank you for your ordering at Rawrestaurant';
    $mail->Body    = $customerMsgHTML; // Can be HTML
    $mail->AltBody = $customerMsgHTML; // Should be plain text
    // SEND
    $mail->send();
    // INFORM USER
    return 'Email sent to <b>' . $customerEmail . '</b>.';
  } catch (Exception $e) {
    return "Email failed to send to <b>$customerEmail</b>. ";
    //To show error add= Error: {$mail->ErrorInfo}
}
}