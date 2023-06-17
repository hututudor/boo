<?php

require_once ROOT_DIR . '/app/validation.php';
require_once ROOT_DIR . '/app/services/auth/AuthService.php';
require_once ROOT_DIR . '/app/services/utils/AuthorizationUtils.php';

class AuthController
{
    public function login(Request $request): void
    {
        $bodyErrors = $this->validateLoginBody($request);
        if ($bodyErrors) {
            Response::badRequest($bodyErrors);
            return;
        }

        $form = new LoginForm(
            $request->body['email'],
            $request->body['password']
        );

        $response = AuthService::login_user($form);


       Response::custom($response->getResponseStatus(), $response->getResponseData());
    }

    private function validateLoginBody(Request $request): ?array
    {
        return validate($request->body, [
            'email' => ['required'],
            'password' => ['required']
        ]);
    }

    public function register(Request $request): void
    {
        $bodyErrors = $this->validateRegisterBody($request);
        if ($bodyErrors) {
            Response::badRequest($bodyErrors);
            return;
        }

        $form = new RegisterForm(
            $request->body['fullName'],
            $request->body['email'],
            $request->body['password']
        );

        $response = AuthService::register_user($form);

        Response::custom($response->getResponseStatus(), $response->getResponseData());
    }
    private function validateRegisterBody(Request $request): ?array
    {
        return validate($request->body, [
            'fullName' => ['required'],
            'email' => ['required'],
            'password' => ['required'],
        ]);
    }
}
