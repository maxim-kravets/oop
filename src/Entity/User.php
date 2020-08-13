<?php


namespace MaximKravets\OOP\Entity;


use MaximKravets\OOP\Traits\NotificationChannel\Database;
use MaximKravets\OOP\Traits\NotificationChannel\Email;
use MaximKravets\OOP\Traits\NotificationChannel\Telegram;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Style\SymfonyStyle;

class User extends ActiveRecord
{
    use Database, Email, Telegram {
        Database::send insteadof Email;
        Database::send insteadof Telegram;

        Database::send as sendDatabase;
        Email::send as sendEmail;
        Telegram::send as sendTelegram;
    }

    /** @var string */
    private $username;

    /** @var string */
    private $email;

    private $channel_database = false;
    private $channel_email = false;
    private $channel_telegram = false;

    public function notify(string $message)
    {
        $input = new ArgvInput();
        $output = new ConsoleOutput();
        $io = new SymfonyStyle($input, $output);

        if ($this->channel_database) {
            $this->sendDatabase($this, $message);
        }

        if ($this->channel_email) {
            $this->sendEmail($this, $message);
        }

        if ($this->channel_telegram) {
            $this->sendTelegram($message);
        }

        if (!$this->channel_database && !$this->channel_email && !$this->channel_telegram) {
            $io->error('No communication channel selected. Please select at least one.');
        }
    }

    public function selectChannelDatabase()
    {
        $this->channel_database = true;
    }

    public function deselectChannelDatabase()
    {
        $this->channel_database = false;
    }

    public function selectChannelEmail()
    {
        $this->channel_email = true;
    }

    public function deselectChannelEmail()
    {
        $this->channel_email = false;
    }

    public function selectChannelTelegram()
    {
        $this->channel_telegram = true;
    }

    public function deselectChannelTelegram()
    {
        $this->channel_telegram = false;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

}
