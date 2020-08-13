<?php


namespace MaximKravets\OOP\Entity;


class Notification extends ActiveRecord
{
    /** @var string */
    protected $username;

    /** @var string */
    protected $message;

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

}