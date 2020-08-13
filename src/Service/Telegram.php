<?php


namespace MaximKravets\OOP\Service;


class Telegram
{
    private $api;
    private $io;

    public function __construct()
    {
        $telegramConfig = new TelegramConfiguration();
        $this->api = $telegramConfig->getAPI();
    }

    public function auth()
    {
        $this->api->loop(function () {
            $phone = trim((string)  $this->io->ask('Enter phone: '));
            yield $this->api->phoneLogin($phone);

            $code = trim((string) $this->io->ask('Enter code: '));
            yield $this->api->completePhoneLogin($code);
        });
    }

    public function sendMessage(string $message)
    {
        $this->api->loop(function () {
            if (! yield $this->api->getSelf()) {
                $this->io->warning('You arn\'t authenticated in telegram. Please, run script ./bin/telegram_auth');

                die();
            }
        });

        $this->api->messages->sendMessage([
            'peer' => '@maximkravets',
            'message' => $message
        ]);
    }
}