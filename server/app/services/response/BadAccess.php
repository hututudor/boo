<?php

require_once ROOT_DIR . '/app/services/response/IServiceResponse.php';
class BadAccess implements IServiceResponse
{
    private string $message;

    public function getResponseStatusCode(): int
    {
        return 400;
    }

    public function getResponseMessage(): string
    {
        return $this->message;
    }

    public function __construct($message = 'BadAccess')
    {
        $this->message = $message;
    }
}