<?php

use Firebase\JWT\JWT;

require_once ROOT_DIR.'/app/services/response/IServiceResponse.php';
require_once ROOT_DIR.'/app/services/response/Ok.php';
require_once ROOT_DIR.'/app/services/response/Unauthorized.php';
require_once ROOT_DIR.'/app/repositories/UserRepository.php';
require_once ROOT_DIR.'/app/validation.php';
require_once ROOT_DIR.'/app/models/auth/LoginForm.php';
require_once ROOT_DIR.'/app/models/auth/RegisterForm.php';
require_once ROOT_DIR.'/app/vendor/firebase/php-jwt/src/JWT.php';
require_once ROOT_DIR.'/app/models/auth/User.php';

class AuthService
{
    public static function login_user(LoginForm $loginForm) : IServiceResponse
    {
        $user = UserRepository::getUserByEmail($loginForm->email);

        if($user == null)
        {
            return new Unauthorized();
        }

        if(!password_verify($loginForm->password, $user->password)) {
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
        if($registerForm->password != $registerForm->confirmPassword)
        {
            return new BadAccess('The password and the confirm password do not match');
        }

        $user = UserRepository::getUserByEmail($registerForm->email);

        if($user != null)
        {
            return new BadAccess('The user is already registered with this email');
        }

        $hashedPassword = password_hash($registerForm->password, PASSWORD_DEFAULT);

        $user = new User(
            -1,
            $registerForm->fullName,
            $registerForm->email,
            $hashedPassword
        );

        $registerCallAnswer = UserRepository::addUser($user);

        if(!$registerCallAnswer)
        {
            return new InternalServerError('Something went wrong while registering the user.\n The user is not registered');
        }

        $loginForm = new LoginForm(
            $registerForm->email,
            $registerForm->password
        );

        return self::login_user($loginForm);
    }
}