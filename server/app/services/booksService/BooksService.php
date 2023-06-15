<?php
class BooksService
{

    public static function getUserStatusForBook(string $bookId, string $jwtToken)
    {
        $userId = AuthService::getUserIdFromToken($jwtToken);
    }

}