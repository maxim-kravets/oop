<?php


namespace MaximKravets\OOP\Service;


use danog\MadelineProto\API;
use Symfony\Component\Console\Exception\LogicException;

class TelegramConfiguration
{
    private $api;

    public function __construct()
    {
        if (empty($_SERVER['TELEGRAM_API_ID'])) {
            throw new LogicException('TELEGRAM_API_ID can\'t be empty');
        }

        if (empty($_SERVER['TELEGRAM_API_HASH'])) {
            throw new LogicException('TELEGRAM_API_HASH can\'t be empty');
        }

        $settings =  [
            'app_info' => [
                'api_id' => $_SERVER['TELEGRAM_API_ID'],
                'api_hash' => $_SERVER['TELEGRAM_API_HASH'],
            ],
            'logger' => [
                'logger' => 0,
            ],
        ];

        $this->api = new API(dirname(__DIR__).'/../var/telegram/session.madeline', $settings);
    }

    public function getAPI()
    {
        return $this->api;
    }
}