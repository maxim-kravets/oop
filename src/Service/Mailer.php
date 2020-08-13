<?php


namespace MaximKravets\OOP\Service;


use MaximKravets\OOP\Entity\User;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Style\SymfonyStyle;

class Mailer
{
    protected $mail;

    public function __construct()
    {
        $mailConfig = new MailerConfiguration();
        $this->mail = $mailConfig->getMail();
    }

    public function send(User $user, $message)
    {
        $this->mail->addAddress($user->getEmail(), $user->getUsername());
        $this->mail->Subject = 'Message from Space Station! 🚀';
        $this->mail->Body = $message;
        $this->mail->send();
    }
}