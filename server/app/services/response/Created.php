<?php

class Created implements IServiceResponse
{

    private array $data;

    public function getResponseStatus(): string
    {
        return "HTTP/1.0 201 Created";
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