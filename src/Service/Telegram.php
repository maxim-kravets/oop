<?php


namespace MaximKravets\OOP\Service;


use danog\MadelineProto\API;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Style\SymfonyStyle;

class Telegram
{
    private $api;
    private $io;

    public function __construct()
    {
        $input = new ArgvInput();
        $output = new ConsoleOutput();
        $this->io = new SymfonyStyle($input, $output);

        if (empty($_SERVER['APP_API_ID'])) {
            $this->io->error('APP_API_ID can\'t be empty');

            die();
        }

        if (empty($_SERVER['APP_API_HASH'])) {
            $this->io->error('APP_API_HASH can\'t be empty');

            die();
        }

        $settings =  [
            'app_info' => [
                'api_id' => $_SERVER['APP_API_ID'],
                'api_hash' => $_SERVER['APP_API_HASH'],
            ],
            'logger' => [
                'logger' => 0,
            ],
        ];

        $this->api = new API(dirname(__DIR__).'/../var/telegram/session.madeline', $settings);
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