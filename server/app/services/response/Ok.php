<?php

require_once ROOT_DIR . '/app/services/response/IServiceResponse.php';
class Ok implements IServiceResponse
{
    private array $data;

    public function getResponseStatus(): string
    {
        return "HTTP/1.0 200 Ok";
    }

    public function getResponseData(): array
    {
        return $this->data;
    }

    public function __construct($data)
    {
        $this->data = $data;
    }
}
