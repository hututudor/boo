<?php

require_once ROOT_DIR . '/app/services/utils/JwtUtils.php';
require_once ROOT_DIR . '/app/services/utils/AuthorizationUtils.php';
require_once ROOT_DIR . '/app/services/response/Ok.php';
require_once ROOT_DIR . '/app/services/response/Unauthorized.php';
require_once ROOT_DIR . '/app/services/response/BadAccess.php';
require_once ROOT_DIR . '/app/services/response/Created.php';
require_once ROOT_DIR . '/app/services/response/IServiceResponse.php';

class ReadingStatusService
{
    public static function getReadingStatus(string $bookId, string $jwtToken) : IServiceResponse
    {
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

        if($newStatus == 'didn\'t read'){
            return self::deleteReadingStatus($bookId, $userId);
        }

        if($status == $newStatus){
            return new OK((array)'updated');
        }

        BookRepository::updateReadingStatus($bookId, $userId, $newStatus);
        return new Ok((array)'updated');
    }

    private static function addReadingStatus(string $bookId, string $userId, string $status) : IServiceResponse
    {
        try {
            BookRepository::insertReadingStatus($bookId, $userId, $status);
            return new Created((array)'inserted');
        }catch (Exception $e){
            return new InternalServerError((array)$e->getMessage());
        }
    }

    private static function deleteReadingStatus(string $bookId, string $userId) : IServiceResponse
    {
        try {
            BookRepository::deleteReadingStatus($bookId, $userId);
            return new Ok((array)'deleted');
        }catch (Exception $e){
            return new InternalServerError((array)$e->getMessage());
        }
    }

}