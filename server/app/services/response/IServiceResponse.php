<?php

namespace services\response;

interface IServiceResponse
{
    public function getResponseStatusCode() : int;
    public function getResponseMessage() : string;
}