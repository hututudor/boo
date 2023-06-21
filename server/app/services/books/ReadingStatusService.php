<?php

require_once ROOT_DIR . '/app/services/utils/JwtUtils.php';
require_once ROOT_DIR . '/app/services/utils/AuthorizationUtils.php';
require_once ROOT_DIR . '/app/services/response/Ok.php';
require_once ROOT_DIR . '/app/services/response/Unauthorized.php';
require_once ROOT_DIR . '/app/services/response/BadAccess.php';
require_once ROOT_DIR . '/app/services/response/Created.php';
require_once ROOT_DIR . '/app/services/response/IServiceResponse.php';
require_once ROOT_DIR . '/app/services/response/InternalServerError.php';
require_once ROOT_DIR . '/app/services/rss/RssUtils.php';
require_once ROOT_DIR . '/app/repositories/BookRepository.php';

class ReadingStatusService
{
    const DEFAULT = 'didn\'t read';
    const READ = 'read';
    const READING = 'reading';
    const WANT_TO_READ = 'want to read';

    public static function getReadingStatus(string $bookId, string $jwtToken) : IServiceResponse
    {
        if(!AuthorizationUtils::isSimpleAuthorized($jwtToken)) {
            return new Unauthorized((array)'The user is not logged in');
        }

        $decoded = JwtUtils::decode_jwt($jwtToken);
        $userId = $decoded->id;

        $status = BookRepository::getReadingStatus($bookId, $userId);

        if($status == null){
            return new Ok(array(self::DEFAULT));
        }

        $status_to_array = (array) $status;

        return new Ok($status_to_array);
    }

    public static function updateReadingStatus(string $bookId, string $newStatus, string $jwtToken) : IServiceResponse
    {
        if (!AuthorizationUtils::isSimpleAuthorized($jwtToken)) {
            return new Unauthorized((array)'The user is not logged in');
        }

        $decoded = JwtUtils::decode_jwt($jwtToken);
        $userId = $decoded->id;

        if ($newStatus == self::DEFAULT) {
            return self::deleteReadingStatus($bookId, $userId);
        }

        if ($newStatus != self::READ && $newStatus != self::READING && $newStatus != self::WANT_TO_READ) {
            return new BadAccess('Invalid status');
        }

        $status = BookRepository::getReadingStatus($bookId, $userId);

        if ($status == null) {
            return self::addReadingStatus($bookId, $userId, $newStatus);
        }

        if ($status == $newStatus) {
            return new OK((array)'Same status. No operation performed');
        }
        BookRepository::updateReadingStatus($bookId, $userId, $newStatus);
        RssUtils::updateLastReviewIdWithLookup($bookId, $userId);
        return new Ok((array)'updated');
    }

    private static function addReadingStatus(string $bookId, string $userId, string $status) : IServiceResponse
    {
        BookRepository::insertReadingStatus($bookId, $userId, $status);
        RssUtils::updateLastReviewIdWithLookup($bookId, $userId);
        return new Created((array)'inserted');
    }

    private static function deleteReadingStatus(string $bookId, string $userId) : IServiceResponse
    {
        BookRepository::deleteReadingStatus($bookId, $userId);
        return new Ok((array)'deleted');
    }

}