<?php

require_once ROOT_DIR . '/app/services/response/IServiceResponse.php';
class BadAccess implements IServiceResponse
{
    private string $message;

    public function getResponseStatus(): string
    {
        return "HTTP/1.0 404 Not Found";
    }

    public function getResponseData(): array
    {
        return [
            'message' => $this->message
        ];
    }

    public function __construct($message = 'BadAccess')
    {
        $this->message = $message;
    }
}
