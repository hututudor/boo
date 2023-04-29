<?php

namespace app\models\auth;
class RegisterForm
{
    public string $fullName;
    public string $email;
    public string $password;
    public string $confirmPassword;
    public function __construct($fullName, $email, $password, $confirmPassword)
    {
        $this->fullName = $fullName;
        $this->email = $email;
        $this->password = $password;
        $this->confirmPassword = $confirmPassword;
    }
}