<?php

require_once __DIR__ . '/../services/utils/JwtUtils.php';
require_once __DIR__ . '/../services/utils/AuthorizationUtils.php';
require_once __DIR__ . '/../repositories/ReviewsRepository.php';
require_once __DIR__ . '/../repositories/BookRepository.php';
class HomeController
{
    public static function getAnalytics(Request $request) : void
    {
        try {

            $jwt = Headers::getHeaderValue($request->headers, 'Authorization');

            if(!AuthorizationUtils::isSimpleAuthorized($jwt)) {
                Response::unauthorized();
                return;
            }

            $readingCounter = BookRepository::countStatus('reading');
            $readCounter = BookRepository::countStatus('read');
            $toReadCounter = BookRepository::countStatus('want to read');

            $decoded = JwtUtils::decode_jwt($jwt);
            $userId = $decoded->id;

            $reviewsCounter = ReviewsRepository::countUserReviews($userId);

            $response = array(
                'reading' => $readingCounter,
                'read' => $readCounter,
                'toRead' => $toReadCounter,
                'reviews' => $reviewsCounter
            );

            Response::success($response);
        }
        catch (Exception $e) {
            Response::internalServerError($e->getMessage());
        }
    }
}