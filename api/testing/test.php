<?php
// Displays errors.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once dirname(__FILE__).'/../../vendor/autoload.php';

// Create the Transport
$transport = (new Swift_SmtpTransport('smtp.mailgun.org', 587))
  ->setUsername('postmaster@soundbank.games')
  ->setPassword('12cdd9faf4e452ba01b24aef8cf2e6b8-6ae2ecad-b9141933')
;

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

// Create a message
$message = (new Swift_Message('Confirmation Email - SOUNDBANK'))
  ->setFrom(['nihad.suvalija@stu.ibu.edu.ba' => 'Soundbank'])
  ->setTo(['nihadsuvalija@gmail.com'])
  ->setBody('Please click this link to confirm your email:')
  ;

// Send the message
$result = $mailer->send($message);
print_r($result);
?>