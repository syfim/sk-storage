<?php

namespace App\MessageHandler;

use App\Message\TelegramNotification;
use App\Services\TelegramService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class TelegramNotificationHandler implements MessageHandlerInterface
{
    private $telegramService;

    public function __construct(TelegramService $telegramService)
    {
        $this->telegramService = $telegramService;
    }

    /**
     * @param TelegramNotification $message
     * @throws TransportExceptionInterface
     */
    public function __invoke(TelegramNotification $message)
    {
        $this->telegramService->sendMessageToChat($message->getContent(), $message->getChat());
    }
}