<?php

require_once ROOT_DIR . '/app/repositories/AdminRepository.php';
require_once __DIR__ . '/../services/utils/JwtUtils.php';
require_once __DIR__ . '/../services/utils/AuthorizationUtils.php';

class AdminController {
    public function getAllUsers(Request $request): void {
        $is_admin_authorized = AuthorizationUtils::isAdminAuthorized(Headers::getHeaderValue($request->headers, 'Authorization'));
        if (!$is_admin_authorized) {
            Response::unauthorized();
            return;
        }

        $users = AdminRepository::getAllUsers();

        Response::success(['users' => $users]);
    }

    public function promote(Request $request): void {
        $is_admin_authorized = AuthorizationUtils::isAdminAuthorized(Headers::getHeaderValue($request->headers, 'Authorization'));
        if (!$is_admin_authorized) {
            Response::unauthorized();
            return;
        }
        $user_id = $request->params['id'];
        $promoteResult = AdminRepository::promoteUser($user_id);
        if (!$promoteResult) {
            Response::badRequest(['message' => 'Failed to promote user.']);
            return;
        }

        Response::success(['message' => 'User promoted successfully']);
    }

    public function demote(Request $request): void {
        $is_admin_authorized = AuthorizationUtils::isAdminAuthorized(Headers::getHeaderValue($request->headers, 'Authorization'));
        if (!$is_admin_authorized) {
            Response::unauthorized();
            return;
        }
        $user_id = $request->params['id'];
        $demoteResult = AdminRepository::demoteUser($user_id);
        if (!$demoteResult) {
            Response::badRequest(['message' => 'Failed to demote user.']);
            return;
        }

        Response::success(['message' => 'User demoted successfully']);
    }

    public function delete(Request $request): void {
        $is_admin_authorized = AuthorizationUtils::isAdminAuthorized(Headers::getHeaderValue($request->headers, 'Authorization'));
        if (!$is_admin_authorized) {
            Response::unauthorized();
            return;
        }
        $user_id = $request->params['id'];
        $deleteResult = AdminRepository::deleteUser($user_id);
        if (!$deleteResult) {
            Response::badRequest(['message' => 'Failed to delete user.']);
            return;
        }

        Response::success(['message' => 'User deleted successfully']);
    }
}