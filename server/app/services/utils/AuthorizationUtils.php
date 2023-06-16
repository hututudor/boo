<?php

require_once ROOT_DIR . '/app/services/utils/JwtUtils.php';

class AuthorizationUtils{

    public static function isSimpleAuthorized(string $jwt): bool
    {
        $decoded = JwtUtils::decode_jwt($jwt);
        return $decoded != null;
    }

    public static function isAdminAuthorized(string $jwt): bool
    {

        $decoded = JwtUtils::decode_jwt($jwt);

        if($decoded == null) {
            return false;
        }

        return $decoded->isAdmin;
    }
}