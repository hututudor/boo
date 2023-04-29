<?php

use services\auth\AuthService;

require_once ROOT_DIR . '/app/validation.php';

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
    private function validateLoginBody(Request $request): ?array
    {
        return validate($request->body, [
            'email' => ['required'],
            'password' => ['required']
        ]);
    }
}