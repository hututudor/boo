<?php
interface IServiceResponse
{
    public function getResponseStatusCode() : int;
    public function getResponseMessage() : string;
}