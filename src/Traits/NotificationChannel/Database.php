<?php


namespace MaximKravets\OOP\Traits\NotificationChannel;


use MaximKravets\OOP\Entity\Notification;
use MaximKravets\OOP\Entity\User;

trait Database
{
    public function send(User $user, string $message)
    {
        $notification = new Notification();
        $notification->setUsername($user->getUsername());
        $notification->setMessage($message);
        $notification->save();

        echo 'Msg sent to database successfully!'.PHP_EOL;
    }
}