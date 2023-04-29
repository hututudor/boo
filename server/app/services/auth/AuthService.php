<?php

namespace services\auth;

use LoginForm;
use RegisterForm;
use services\response\IServiceResponse;
use services\response\Unauthorized;
use UserRepository;

use firebase\JWT\JWT;

class AuthService
{
    public static function login_user(LoginForm $loginForm) : IServiceResponse
    {
        $user = UserRepository::getUserByEmail($loginForm->email);

        if(!!$user)
        {
            return new Unauthorized();
        }

        $hashedPassword = password_hash($loginForm->password, PASSWORD_DEFAULT);

        if(!password_verify($hashedPassword, $user->password)) {
            return new Unauthorized();
        }

        //Set JWT payload
        $payload = [
            'id' => $user->id,
            'isAdmin' => $user->isAdmin
        ];

        // Generate JWT token
        $jwt = JWT::encode($payload, JWT_SECRET);

        // Return the JWT token as a response

        return new OK($jwt);
    }

    public static function register_user(RegisterForm $registerForm) : IServiceResponse
    {
        return new Unauthorized();
    }
}