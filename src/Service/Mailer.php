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
    protected $io;

    public function __construct()
    {
        $input = new ArgvInput();
        $output = new ConsoleOutput();
        $this->io = new SymfonyStyle($input, $output);

        if (empty($_SERVER['MAIL_HOST'])) {
            $this->io->error('MAIL_HOST can\'t be empty. Fill it in .env');

            die();
        }

        if (empty($_SERVER['MAIL_PORT'])) {
            $this->io->error('MAIL_PORT can\'t be empty. Fill it in .env');

            die();
        }

        if (empty($_SERVER['MAIL_USERNAME'])) {
            $this->io->error('MAIL_USERNAME can\'t be empty. Fill it in .env');

            die();
        }

        if (empty($_SERVER['MAIL_PASSWORD'])) {
            $this->io->error('MAIL_PASSWORD can\'t be empty. Fill it in .env');

            die();
        }

        if (empty($_SERVER['MAIL_FROM_ADDRESS'])) {
            $this->io->error('MAIL_FROM_ADDRESS can\'t be empty. Fill it in .env');

            die();
        }

        if (empty($_SERVER['MAIL_FROM_NAME'])) {
            $this->io->error('MAIL_FROM_NAME can\'t be empty. Fill it in .env');

            die();
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

        try {
            $this->mail->setFrom($_SERVER['MAIL_FROM_ADDRESS'], $_SERVER['MAIL_FROM_NAME']);
        } catch (Exception $e) {
            $this->io->error($e->getMessage());

            die();
        }
    }

    public function send(User $user, $message)
    {
        try {
            $this->mail->addAddress($user->getEmail(), $user->getUsername());
            $this->mail->Subject = 'Message from Space Station! 🚀';
            $this->mail->Body = $message;
            $this->mail->send();
        } catch (Exception $e) {
            $this->io->error($e->getMessage());

            die();
        }
    }
}