<?php

session_start();

//This class is just for sending emails based on the data of the templatePreview class.
/*

  echo $_SESSION['ID'];
  echo  $_SESSION['subject'];
  echo  $_SESSION['body'];
  echo  $_SESSION['tolist'];

 */

//echo '<p>before</p>';
require_once 'lib/swift_required.php';
//echo '<p>after</p>';
//$to=$this->getSendTo();
//print_r( $to);
//echo "ppp1";
// Create the Transport
$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
        ->setUsername('user-account@gmail.com')
        ->setPassword('****')
;
//echo "ppp2";
// Create the Mailer using your created Transport
$mailer = Swift_Mailer::newInstance($transport);
//echo "ppp3";
$message = Swift_Message::newInstance($_SESSION['subject'])
        ->setFrom(array("user-account@gmail.com" => "User Account Name"))
        ->setTo(array($_SESSION['tolist'] => "A name"))
        ->setBody($_SESSION['body']);
//echo "ppp4";
// Send the message
$result = $mailer->send($message);

$numSent = $mailer->send($message);
printf("Sent %d messages\n", $numSent);
$result = $mailer->send($message);
//echo "ppp";
?>
