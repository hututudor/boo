<?php

require_once ROOT_DIR . '/app/validation.php';
require_once ROOT_DIR . '/app/services/auth/AuthService.php';

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

        if(!$response->getResponseStatusCode()==401)
        {
            Response::unauthorized();
        }

        Response::success($response->getResponseMessage());
    }

    public function register(Request $request) : void
    {
        $bodyErrors = $this->validateRegisterBody($request);
        if($bodyErrors) {
            Response::badRequest($bodyErrors);
            return;
        }

        $form = new RegisterForm(
            $request->body['email'],
            $request->body['password'],
            $request->body['firstName'],
            $request->body['lastName']
        );

        $response = AuthService::register_user($form);

        if(!$response->getResponseStatusCode()==400)
        {
            Response::badRequest();
        }

        if(!$response->getResponseStatusCode()==500)
        {
            Response::internalServerError();
        }

        Response::success($response->getResponseMessage());
    }
    private function validateLoginBody(Request $request): ?array
    {
        return validate($request->body, [
            'email' => ['required'],
            'password' => ['required']
        ]);
    }

    private function validateRegisterBody(Request $request): ?array
    {
        return validate($request->body, [
            'email' => ['required'],
            'password' => ['required'],
            'firstName' => ['required'],
            'lastName' => ['required']
        ]);
    }
}