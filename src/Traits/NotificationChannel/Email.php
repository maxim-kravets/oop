<?php


namespace MaximKravets\OOP\Traits\NotificationChannel;


use MaximKravets\OOP\Entity\User;
use MaximKravets\OOP\Service\Mailer;

trait Email
{
    public function send(User $user, string $message)
    {
        $mailerService = new Mailer();
        $mailerService->send($user, $message);

        echo 'Msg sent to email successfully!' . PHP_EOL;
    }
}