<?php


namespace App\Message;


use App\Entity\TelegramChat;

class TelegramNotification
{
    private $message;
    private $chat;

    public function __construct(string $message, TelegramChat $chat)
    {
        $this->message = $message;
        $this->chat = $chat;
    }

    public function getContent(): string
    {
        return $this->message;
    }

    public function getChat(): TelegramChat
    {
        return $this->chat;
    }

}