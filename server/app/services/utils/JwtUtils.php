<?php

class JwtUtils{

    public static function decode_jwt(string $jwt): ?object
    {
        if (!$jwt)
        {
            return null;
        }
        $secret = JWT_SECRET;
        $jwtParts = explode('.', $jwt);
        if(sizeof($jwtParts) < 3) {
          return null;
        }

        $signature = self::base64url_encode(hash_hmac('sha256', $jwtParts[0] . '.' . $jwtParts[1], $secret, true));

        if ($signature != $jwtParts[2]) {
            return null;
        }

        return json_decode(self::base64url_decode($jwtParts[1]));
    }

    private static function base64url_decode($data): bool|string
    {
        $base64url = strtr($data, '-_', '+/');
        $base64 = base64_decode($base64url);
        if (!$base64) {
            return false;
        }
        return $base64;
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

        $secret = JWT_SECRET;
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