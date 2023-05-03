<?php

require_once ROOT_DIR.'/app/services/response/IServiceResponse.php';
class InternalServerError implements IServiceResponse
{
    private string $message;

    public function getResponseStatusCode(): int
    {
        return 500;
    }

    public function getResponseMessage(): string
    {
        return $this->message;
    }
    public function __construct($message = 'InternalServerError')
    {
        $this->message = $message;
    }
}