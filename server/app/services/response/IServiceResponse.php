<?php
interface IServiceResponse
{
    public function getResponseStatus(): string;
    public function getResponseData(): array;
}
