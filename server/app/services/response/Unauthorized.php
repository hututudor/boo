<?php

namespace services\response;

class Unauthorized implements IServiceResponse
{
    private string $message;

    public function getResponseStatusCode(): int
    {
        return 401;
    }

    public function getResponseMessage(): string
    {
        return $this->message;
    }
    public function __construct($message = 'Unauthorized')
    {
        $this->message = $message;
    }
}