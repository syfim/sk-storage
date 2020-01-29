<?php


namespace App\Services;


use App\Entity\TelegramChat;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class TelegramService
{
    public const TELEGRAM_BOT_BASE_API_URL = 'https://api.telegram.org/bot';

    private $client;
    private $proxyUrl;

    public function __construct(HttpClientInterface $client, $proxyUrl)
    {
        $this->client = $client;
        $this->proxyUrl = $proxyUrl;
    }

    /**
     * @param string $message
     * @param TelegramChat $chat
     * @throws TransportExceptionInterface
     */
    public function sendMessageToChat(string $message, TelegramChat $chat)
    {
        $options = [
            'body' => [
                'chat_id' => $chat->getChatId(),
                'text' => $message
            ]
        ];

        if (!empty($this->proxyUrl)) {
            $options['proxy'] = $this->proxyUrl;
        }

        $response = $this->client->request(
            'POST',
            self::TELEGRAM_BOT_BASE_API_URL . $chat->getBotId() . ':' . $chat->getBotToken() . '/sendMessage',
            $options
        );

        $response->getStatusCode();
    }

}