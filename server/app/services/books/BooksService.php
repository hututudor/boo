<?php

require_once ROOT_DIR . '/app/services/utils/JwtUtils.php';
require_once ROOT_DIR . '/app/services/utils/AuthorizationUtils.php';
require_once ROOT_DIR . '/app/services/response/Ok.php';
require_once ROOT_DIR . '/app/services/response/Unauthorized.php';
require_once ROOT_DIR . '/app/services/response/BadAccess.php';

class BooksService
{
    public static function getReadingStatus(string $bookId, string $jwtToken) : IServiceResponse
    {
        if(!AuthorizationUtils::isSimpleAuthorized($jwtToken)) {
            return new Unauthorized((array)'The user is not logged in');
        }

        $decoded = JwtUtils::decode_jwt($jwtToken);
        $userId = $decoded->id;

        $status = BookRepository::getReadingStatus($bookId, $userId);

        if($status == null){
            return new Ok((array)'didn\'t read');
        }

        $status_to_array = (array) $status;

        return new Ok($status_to_array);
    }

    public static function updateReadingStatus(string $bookId, string $newStatus, string $jwtToken) : IServiceResponse
    {
        if(!AuthorizationUtils::isSimpleAuthorized($jwtToken)) {
            return new Unauthorized((array)'The user is not logged in');
        }

        $decoded = JwtUtils::decode_jwt($jwtToken);
        $userId = $decoded->id;

        $status = BookRepository::getReadingStatus($bookId, $userId);

        if($status == null){
            $response = self::addReadingStatus($bookId, $newStatus, $jwtToken);
        }

        BookRepository::updateReadingStatus($bookId, $userId, $newStatus);
        return new Ok((array)'updated');
    }

    public static function addReadingStatus(string $bookId, string $newStatus, string $jwtToken) : IServiceResponse
    {
        if(!AuthorizationUtils::isSimpleAuthorized($jwtToken)) {
            return new Unauthorized((array)'The user is not logged in');
        }

        $decoded = JwtUtils::decode_jwt($jwtToken);
        $userId = $decoded->id;

        $status = BookRepository::getReadingStatus($bookId, $userId);

        if($status != null){
            return new BadAccess('The row already exists. Try applying the update operation');
        }

        BookRepository::insertReadingStatus($bookId, $userId, $newStatus);
        return new Ok((array)'inserted');
    }

}