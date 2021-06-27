<?php

require_once dirname(__FILE__)."/../../vendor/autoload.php";
require_once dirname(__FILE__)."/../config.php";

/* 
  I used MailGun here, but you can also use Gmail SMTP Server.
  Google how to configure it!
*/

class SMTPClient {

    private $mailer;
    public function __construct() {

    // Create the Transport
    $transport = (new Swift_SmtpTransport(Config::SMTP_HOST(), Config::SMTP_PORT()))
    ->setUsername(Config::SMTP_USER())
    ->setPassword(Config::SMTP_PASSWORD())
    ;

    // Create the Mailer using your created Transport
    $this->mailer = new Swift_Mailer($transport);
    }

    private function create_message($email_title, $from_address, $to_address, $body) {
        // Create a message
        $message = (new Swift_Message($email_title))
        ->setFrom([$from_address => 'Soundbank'])
        ->setTo([$to_address])
        ->setBody($body);

        return $message;
    }

    public function send_register_account_token($account) {
        $message = $this->create_message("Confirmation email", "nihad.suvalija@stu.ibu.edu.ba", $account['email'], "Click this link for confirmation: https://www.soundbank.games/confirm.html?token=". $account['token']);
        $this->mailer->send($message);
    }

    public function send_recovery_account_token($account) {
        $message = $this->create_message("Recovery email", "nihad.suvalija@stu.ibu.edu.ba", $account['email'], "Recovery link: https://www.soundbank.games/new_password.html?token=". $account['token']);
        $this->mailer->send($message);
    }
}
?>
