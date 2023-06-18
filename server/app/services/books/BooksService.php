<?php

require_once ROOT_DIR . '/app/services/utils/JwtUtils.php';
require_once ROOT_DIR . '/app/services/utils/AuthorizationUtils.php';
require_once ROOT_DIR . '/app/services/response/Ok.php';
require_once ROOT_DIR . '/app/services/response/Unauthorized.php';
require_once ROOT_DIR . '/app/services/response/BadAccess.php';
require_once ROOT_DIR . '/app/services/response/Created.php';
require_once ROOT_DIR . '/app/services/response/IServiceResponse.php';

class BooksService
{
    public static function getReadingStatus(string $bookId, string $jwtToken) : IServiceResponse
    {
        //create a const variable called DEFAULT_STATUS

        $DEFAULT_READING_STATUS = array('didn\'t read');

        if(!AuthorizationUtils::isSimpleAuthorized($jwtToken)) {
            return new Unauthorized((array)'The user is not logged in');
        }

        $decoded = JwtUtils::decode_jwt($jwtToken);
        $userId = $decoded->id;

        $status = BookRepository::getReadingStatus($bookId, $userId);

        if($status == null){
            return new Ok($DEFAULT_READING_STATUS);
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
            return self::addReadingStatus($bookId, $newStatus, $jwtToken, true);
        }

        BookRepository::updateReadingStatus($bookId, $userId, $newStatus);
        return new Ok((array)'updated');
    }

    public static function addReadingStatus(string $bookId, string $newStatus, string $jwtToken, bool $force = false) : IServiceResponse
    {
        if(!AuthorizationUtils::isSimpleAuthorized($jwtToken)) {
            return new Unauthorized((array)'The user is not logged in');
        }

        $decoded = JwtUtils::decode_jwt($jwtToken);
        $userId = $decoded->id;

        if($force)
        {
            BookRepository::insertReadingStatus($bookId, $userId, $newStatus);
            return new Created((array)'inserted');
        }

        $status = BookRepository::getReadingStatus($bookId, $userId);

        if($status != null){
            return new BadAccess('The row already exists. Try applying the update operation');
        }

        BookRepository::insertReadingStatus($bookId, $userId, $newStatus);
        return new Created((array)'inserted');
    }

}