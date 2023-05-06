<?php

require_once ROOT_DIR . '/app/services/response/IServiceResponse.php';
class Unauthorized implements IServiceResponse
{
    private string $message;

    public function getResponseStatus(): string
    {
        return "HTTP/1.0 401 Unauthorized";
    }

    public function getResponseData(): array
    {
        return [
            'message' => $this->message
        ];
    }
    public function __construct($message = 'Unauthorized')
    {
        $this->message = $message;
    }
}
