<?php

class RssRepository
{
    public static function updateLastReviewId(string $bookId, string $userId, $lastReviewId) : bool
    {
        $db = DB::getInstance()->getConnection();

        //create a statement that updates the field last_seen_review_id in the users_books table if the row identified by bookId and userId exists

        $statement = $db->prepare("UPDATE user_books SET last_seen_review_id = ? WHERE book_id = ? AND user_id = ?");
        $statement->bind_param("iii", $lastReviewId, $bookId, $userId);
        $statement->execute();

        return !$statement->error;
    }

    public static function selectLastReviewId(string $bookId, string $userId) : int
    {
        $db = DB::getInstance()->getConnection();
        $statement = $db->prepare("SELECT id FROM reviews WHERE book_id = ? AND user_id = ? ORDER BY id DESC LIMIT 1");
        $statement->bind_param("ii", $bookId, $userId);
        $statement->execute();

        if ($statement->error) {
            return -1;
        }

        $row = $statement->get_result()->fetch_assoc();
        if (!$row) {
            return -1;
        }

        return $row['id'];
    }

    public static function updateLastBookId($userId) : bool
    {
        $db = DB::getInstance()->getConnection();
        $statement = $db->prepare("UPDATE rss_books SET last_seen_book_id = (SELECT MAX(id) from books) WHERE id = ?");
        $statement->bind_param("i", $userId);
        $statement->execute();

        return !$statement->error;
    }

}