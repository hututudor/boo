<?php

require_once ROOT_DIR.'/app/services/response/IServiceResponse.php';
class Ok implements IServiceResponse
{
    private string $message;

    public function getResponseStatusCode(): int
    {
        return 200;
    }

    public function getResponseMessage(): string
    {
        return $this->message;
    }

    public function __construct($message = 'Ok')
    {
        $this->message = $message;
    }
}