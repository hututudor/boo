<?php

namespace app\models\auth;
class User
{
    public int $id;
    public string $fullName;
    public string $email;
    public string $password;
    public bool $isAdmin;
    public function __construct($id, $fullName, $email, $password, $isAdmin)
    {
        $this->id = $id;
        $this->fullName = $fullName;
        $this->email = $email;
        $this->password = $password;
        $this->isAdmin = $isAdmin;
    }
}