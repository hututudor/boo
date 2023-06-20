<?php

require_once ROOT_DIR . '/app/repositories/UserRepository.php';

require_once __DIR__ . '/../services/utils/JwtUtils.php';
require_once __DIR__ . '/../services/utils/AuthorizationUtils.php';

class UserController{
    public function updateEmail(Request $request): void {
        $isSimpleAuthorized = AuthorizationUtils::isSimpleAuthorized(Headers::getHeaderValue($request->headers, 'Authorization'));
        if (!$isSimpleAuthorized) {
            Response::unauthorized();
            return;
        }
    
        $jwtToken = Headers::getHeaderValue($request->headers, 'Authorization');
        $decodedToken = JwtUtils::decode_jwt($jwtToken);
    
        if (!$decodedToken || !isset($decodedToken->id)) {
            Response::unauthorized();
            return;
        }
    
        $userId = $decodedToken->id;
        $updatedEmail = $request->body['email'];
    
        $updateResult = UserRepository::updateEmail($userId, $updatedEmail);
        if (!$updateResult) {
            Response::badRequest(['message' => 'Failed to update email. Try a different one.']);
            return;
        }
    
        Response::success(['message' => 'Email updated successfully']);
    }
    
    public function updateName(Request $request): void {
        $isSimpleAuthorized = AuthorizationUtils::isSimpleAuthorized(Headers::getHeaderValue($request->headers, 'Authorization'));
        if (!$isSimpleAuthorized) {
            Response::unauthorized();
            return;
        }
    
        $jwtToken = Headers::getHeaderValue($request->headers, 'Authorization');
        $decodedToken = JwtUtils::decode_jwt($jwtToken);
    
        if (!$decodedToken || !isset($decodedToken->id)) {
            Response::unauthorized();
            return;
        }
    
        $userId = $decodedToken->id;
        $updatedName = $request->body['full_name'];
    
        $updateResult = UserRepository::updateName($userId, $updatedName);
        if (!$updateResult) {
            Response::badRequest(['message' => 'Failed to update name.']);
            return;
        }
    
        Response::success(['message' => 'Name updated successfully']);
    }    

    public function updatePassword(Request $request): void {
        $isSimpleAuthorized = AuthorizationUtils::isSimpleAuthorized(Headers::getHeaderValue($request->headers, 'Authorization'));
        if (!$isSimpleAuthorized) {
            Response::unauthorized();
            return;
        }
    
        $jwtToken = Headers::getHeaderValue($request->headers, 'Authorization');
        $decodedToken = JwtUtils::decode_jwt($jwtToken);
    
        if (!$decodedToken || !isset($decodedToken->id)) {
            Response::unauthorized();
            return;
        }
    
        $userId = $decodedToken->id;
        $updatedPassword = $request->body['password'];
    
        $updateResult = UserRepository::updatePassword($userId, $updatedPassword);
        if (!$updateResult) {
            Response::badRequest(['message' => 'Failed to update password. Try a different one.']);
            return;
        }
    
        Response::success(['message' => 'Password updated successfully']);
    }

    public function getProfile(Request $request): ?array {
        $isSimpleAuthorized = AuthorizationUtils::isSimpleAuthorized(Headers::getHeaderValue($request->headers, 'Authorization'));
        if (!$isSimpleAuthorized) {
            Response::unauthorized();
            return null;
        }
    
        $jwtToken = Headers::getHeaderValue($request->headers, 'Authorization');
        $decodedToken = JwtUtils::decode_jwt($jwtToken);
    
        if (!$decodedToken || !isset($decodedToken->id)) {
            Response::unauthorized();
            return null;
        }
    
        $userId = $decodedToken->id;
        $user = UserRepository::getUserById($userId);
        if (!$user) {
            return null;
        }
        print_r($user->email);
        return [
            'name' => $user->fullName,
            'email' => $user->email
        ];
    }
}
