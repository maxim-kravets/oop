<?php


namespace MaximKravets\OOP\Service;


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Symfony\Component\Console\Exception\LogicException;

class MailerConfiguration
{
    private $mail;

    public function __construct()
    {
        if (empty($_SERVER['MAIL_HOST'])) {
            throw new LogicException('MAIL_HOST can\'t be empty. Fill it in .env');
        }

        if (empty($_SERVER['MAIL_PORT'])) {
            throw new LogicException('MAIL_PORT can\'t be empty. Fill it in .env');
        }

        if (empty($_SERVER['MAIL_USERNAME'])) {
            throw new LogicException('MAIL_USERNAME can\'t be empty. Fill it in .env');
        }

        if (empty($_SERVER['MAIL_PASSWORD'])) {
            throw new LogicException('MAIL_PASSWORD can\'t be empty. Fill it in .env');
        }

        if (empty($_SERVER['MAIL_FROM_ADDRESS'])) {
            throw new LogicException('MAIL_FROM_ADDRESS can\'t be empty. Fill it in .env');
        }

        if (empty($_SERVER['MAIL_FROM_NAME'])) {
            throw new LogicException('MAIL_FROM_NAME can\'t be empty. Fill it in .env');
        }

        $this->mail = new PHPMailer(true);
        $this->mail->SMTPDebug = SMTP::DEBUG_OFF;
        $this->mail->isSMTP();
        $this->mail->CharSet = 'UTF-8';
        $this->mail->Host = $_SERVER['MAIL_HOST'];
        $this->mail->SMTPAuth = true;
        $this->mail->Username = $_SERVER['MAIL_USERNAME'];
        $this->mail->Password = $_SERVER['MAIL_PASSWORD'];
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port = $_SERVER['MAIL_PORT'];
        $this->mail->setFrom($_SERVER['MAIL_FROM_ADDRESS'], $_SERVER['MAIL_FROM_NAME']);
    }

    public function getMail()
    {
        return $this->mail;
    }
}