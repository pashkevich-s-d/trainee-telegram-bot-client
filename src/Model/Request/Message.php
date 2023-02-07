<?php

namespace PashkevichSD\TraineeTelegramBotClient\Model\Request;

class Message
{
    private int $chatId;

    private string $text;

    private string $parseMode;

    public function getChatId(): int
    {
        return $this->chatId;
    }

    public function setChatId(int $chatId): Message
    {
        $this->chatId = $chatId;

        return $this;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): Message
    {
        $this->text = $text;

        return $this;
    }
}
