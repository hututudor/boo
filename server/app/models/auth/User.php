<?php

class User
{
    public int $id;
    public string $fullName;
    public string $email;
    public string $password;
    public bool $isAdmin;
    public function __construct($id, $fullName, $email, $password, $isAdmin = false)
    {
        $this->id = $id;
        $this->fullName = $fullName;
        $this->email = $email;
        $this->password = $password;
        $this->isAdmin = $isAdmin;
    }

    public function getFieldsAsArray() : array
    {
        return array(
            'id' => $this->id,
            'fullName' => $this->fullName,
            'email' => $this->email,
            'password' => $this->password,
            'isAdmin' => $this->isAdmin
        );
    }
}