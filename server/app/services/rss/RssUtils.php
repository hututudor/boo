<?php

require_once ROOT_DIR . '/app/repositories/RssRepository.php';
require_once ROOT_DIR . '/app/services/utils/JwtUtils.php';

class RssUtils
{
    /*
     * This method is used to update the last seen review id for a book when retrieving reviews for a page
     * This way we may know when was the last review seen by the user
     */
    public static function updateLastReviewId(string $bookId, string $jwt, string $lastReviewId): bool
    {
        if ($lastReviewId == -1) {
            return false;
        }

        $decodedToken = JwtUtils::decode_jwt($jwt);
        $userId = $decodedToken->id;

        return RssRepository::updateLastReviewId($bookId, $userId, $lastReviewId);
    }

    /*
     * This method is used as a subscribe function for RSS feed
     * It is used only when the reading status of a book is changed from 'didn't read' to 'read' or 'reading' or 'want to read'
     */
    public static function updateLastReviewIdWithLookup(string $bookId, string $userId): bool
    {
        $lastReviewId = RssRepository::selectLastReviewId($bookId);

        if ($lastReviewId == -1) {
            return false;
        }

        return RssRepository::updateLastReviewId($bookId, $userId, $lastReviewId);
    }

    public static function updateLastBookId(string $jwt): bool
    {
        $decodedToken = JwtUtils::decode_jwt($jwt);
        $userId = $decodedToken->id;

        return RssRepository::updateLastBookId($userId);
    }
}
