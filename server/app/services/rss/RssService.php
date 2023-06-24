<?php

require_once ROOT_DIR . '/app/repositories/RssRepository.php';
require_once ROOT_DIR . '/app/services/utils/JwtUtils.php';
require_once ROOT_DIR . '/app/repositories/ReviewsRepository.php';
require_once ROOT_DIR . '/app/repositories/BookRepository.php';
class RssService
{
    const DEFAULT_BOOK_PAGE = PUBLIC_URL . "/books";
    public static function generateRssFeed(string $userId) : string
    {
        $book_reviewIds = RssRepository::selectLastSeenBook_ReviewIds($userId);

        $reviews = [];
        foreach ($book_reviewIds as $book_reviewId)
        {
            $newReviews = ReviewsRepository::getAllAboveFromId($book_reviewId['last_seen_review_id'], $book_reviewId['book_id']);
            $reviews = array_merge($reviews, $newReviews);
        }

        $lastSeenBookId = RssRepository::selectLastSeenBookId($userId);

        if($lastSeenBookId != -1)
        $books = BookRepository::getAllAboveFromId($lastSeenBookId);
        else
            $books = [];

        if(count($reviews) == 0 && count($books) == 0)
            return self::createDefaultXml();
        return self::createXml($reviews, $books);
    }

    private static function createXml(array $reviews, array $books) : string
    {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><rss version="2.0"></rss>');
        $channel = $xml->addChild('channel');
        $channel->addChild('title', 'New Books and Reviews');

        foreach ($books as $book) {
            $item = $channel->addChild('item');
            $item->addChild('title', $book->title);
            $item->addChild('author', $book->author);
            $item->addChild('link', self::DEFAULT_BOOK_PAGE. '/' . $book->id);
            $item->addChild('description', $book->description);
        }

        foreach ($reviews as $review) {
            $item = $channel->addChild('item');
            $item->addChild('title', 'New Review');
            $item->addChild('date', $review->review_date);
            $item->addChild('content', $review->content);
            $item->addChild('link', self::DEFAULT_BOOK_PAGE. '/' . $review->book_id);
        }

        return $xml->asXML();
    }

    private static function createDefaultXml() : string
    {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><rss version="2.0"></rss>');
        $channel = $xml->addChild('channel');
        $channel->addChild('title', 'No new books or reviews');
        $item = $channel->addChild('item');
        $item->addChild('title', 'Visit the website!');
        $item->addChild('link', self::DEFAULT_BOOK_PAGE);
        return $xml->asXML();
    }
}