<?php

require_once ROOT_DIR . '/app/services/response/IServiceResponse.php';
class InternalServerError implements IServiceResponse
{
    private string $message;

    public function getResponseStatus(): string
    {
        return "HTTP/1.0 500 Internal Server Error";
    }

    public function getResponseData(): array
    {
        return [
            'message' => $this->message
        ];
    }
    public function __construct($message = 'InternalServerError')
    {
        $this->message = $message;
    }
}
