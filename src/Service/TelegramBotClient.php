<?php

namespace PashkevichSD\TraineeTelegramBotClient\Service;

use Exception;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\Multipart\FormDataPart;
use PashkevichSD\TraineeTelegramBotClient\Model\Request\Message;
use PashkevichSD\TraineeTelegramBotClient\Exception\TelegramBotClientException;

class TelegramBotClient
{
    private const API = 'https://api.telegram.org/bot';
    private const SEND_MESSAGE = 'sendMessage';
    private const GET_UPDATES = 'getUpdates';
    private const SEND_DOCUMENT = 'sendDocument';

    private HttpClientInterface $httpClient;

    private string $token;

    public function __construct(
        string $token
    ) {
        $this->token = $token;
        $this->httpClient = HttpClient::create();
    }

    public function sendMessage(Message $message): array
    {
        try {
            $response = $this->httpClient->request(
                Request::METHOD_GET,
                sprintf(
                    '%s?chat_id=%s&text=%s', 
                    $this->getMethodUrl(self::SEND_MESSAGE), 
                    $message->getChatId(), 
                    $message->getText()
                )
            );
        } catch (Exception $exception) {
            throw new TelegramBotClientException(
                $exception->getMessage(),
                $exception->getCode(),
                $exception->getPrevious()
            );
        }

        return $response->toArray();
    }

    public function getUpdates(): array
    {
        try {
            $response = $this->httpClient->request(Request::METHOD_GET, $this->getMethodUrl(self::GET_UPDATES));
        } catch (Exception $exception) {
            throw new TelegramBotClientException(
                $exception->getMessage(),
                $exception->getCode(),
                $exception->getPrevious()
            );
        }

        return json_decode($response->getContent(), true);
    }

    public function sendDocument(
        string $chatId,
        string $filePath
    ): array {
        $formFields = [
            'chat_id' => $chatId,
            'document' => DataPart::fromPath($filePath),
        ];
        $formData = new FormDataPart($formFields);

        try {
            $response = $this->httpClient->request(
                Request::METHOD_POST,
                $this->getMethodUrl(self::SEND_DOCUMENT),
                [
                    'headers' => $formData->getPreparedHeaders()->toArray(),
                    'body' => $formData->bodyToIterable(),
                ]
            );
        } catch (Exception $exception) {
            throw new TelegramBotClientException(
                $exception->getMessage(),
                $exception->getCode(),
                $exception->getPrevious()
            );
        }

        return $response->toArray();
    }

    private function getMethodUrl(string $method): string
    {
        return sprintf(
            '%s%s/%s',
            self::API,
            $this->token,
            $method
        );
    }
}
