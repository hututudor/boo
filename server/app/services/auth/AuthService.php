<?php

use Firebase\JWT\JWT;

require_once ROOT_DIR . '/app/services/response/IServiceResponse.php';
require_once ROOT_DIR . '/app/services/response/Ok.php';
require_once ROOT_DIR . '/app/services/response/Unauthorized.php';
require_once ROOT_DIR . '/app/services/response/BadAccess.php';
require_once ROOT_DIR . '/app/repositories/UserRepository.php';
require_once ROOT_DIR . '/app/validation.php';
require_once ROOT_DIR . '/app/models/auth/LoginForm.php';
require_once ROOT_DIR . '/app/models/auth/RegisterForm.php';
require_once ROOT_DIR . '/app/models/auth/User.php';

class AuthService
{
    public static function login_user(LoginForm $loginForm): IServiceResponse
    {
        $user = UserRepository::getUserByEmail($loginForm->email);

        if ($user == null) {
            return new Unauthorized();
        }

        if (!password_verify($loginForm->password, $user->password)) {
            return new Unauthorized();
        }

        $jwt = self::generateJWT($user->id, $user->isAdmin);

        return new OK(['token' => $jwt]);
    }

    public static function register_user(RegisterForm $registerForm): IServiceResponse
    {
        $user = UserRepository::getUserByEmail($registerForm->email);

        if ($user != null) {
            return new BadAccess('The email is already in use');
        }

        $hashedPassword = password_hash($registerForm->password, PASSWORD_DEFAULT);

        $user = new User(
            -1,
            $registerForm->fullName,
            $registerForm->email,
            $hashedPassword
        );

        $registerCallAnswer = UserRepository::addUser($user);

        if (!$registerCallAnswer) {
            return new InternalServerError('Something went wrong while registering the user.\n The user is not registered');
        }

        $loginForm = new LoginForm(
            $registerForm->email,
            $registerForm->password
        );

        return self::login_user($loginForm);
    }

    public static function generateJWT(int $userID, bool $isAdmin): string
    {
        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT'
        ];

        $payload = [
            'id' => $userID,
            'isAdmin' => $isAdmin
        ];

        $headerEncoded = self::base64url_encode(json_encode($header));
        $payloadEncoded = self::base64url_encode(json_encode($payload));

        $secret = JWT_SECRET; // Replace with your own secret key
        $signature = self::base64url_encode(hash_hmac('sha256', $headerEncoded . '.' . $payloadEncoded, $secret, true));

        return $headerEncoded . '.' . $payloadEncoded . '.' . $signature;
    }

    private static function base64url_encode($data): bool|string
    {
        $base64 = base64_encode($data);
        if (!$base64) {
            return false;
        }
        $base64url = strtr($base64, '+/', '-_');
        return rtrim($base64url, '=');
    }
}
