<?php

require_once ROOT_DIR . '/app/services/response/IServiceResponse.php';
require_once ROOT_DIR . '/app/services/response/Ok.php';
require_once ROOT_DIR . '/app/services/response/Unauthorized.php';
require_once ROOT_DIR . '/app/services/response/BadAccess.php';
require_once ROOT_DIR . '/app/repositories/UserRepository.php';
require_once ROOT_DIR . '/app/validation.php';
require_once ROOT_DIR . '/app/models/auth/LoginForm.php';
require_once ROOT_DIR . '/app/models/auth/RegisterForm.php';
require_once ROOT_DIR . '/app/models/auth/User.php';
require_once ROOT_DIR . '/app/services/utils/JwtUtils.php';

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

        $jwt = JwtUtils::generateJWT($user->id, $user->isAdmin);

        $decode_jwt = JwtUtils::decode_jwt($jwt);

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


}
