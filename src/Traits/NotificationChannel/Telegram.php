<?php

namespace MaximKravets\OOP\Traits\NotificationChannel;


use MaximKravets\OOP\Service\Telegram as TelegramService;

trait Telegram
{
    protected function send(string $message)
    {
        $telegramService = new TelegramService();
        $telegramService->sendMessage($message);

        echo 'Msg sent to telegram successfully!'.PHP_EOL;
    }
}