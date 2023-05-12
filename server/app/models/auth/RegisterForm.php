<?php

class RegisterForm
{
    public string $fullName;
    public string $email;
    public string $password;
    public function __construct($fullName, $email, $password)
    {
        $this->fullName = $fullName;
        $this->email = $email;
        $this->password = $password;
    }
}