<?php

require_once ROOT_DIR . '/app/models/auth/User.php';
require_once ROOT_DIR . '/app/models/Book.php';
require_once ROOT_DIR . '/app/models/Review.php';
require_once ROOT_DIR . '/app/repositories/UserRepository.php';
require_once ROOT_DIR . '/app/repositories/BookRepository.php';
require_once ROOT_DIR . '/app/repositories/ReviewsRepository.php';
require_once ROOT_DIR . '/app/services/response/IServiceResponse.php';
require_once ROOT_DIR . '/app/services/response/Ok.php';
require_once ROOT_DIR . '/app/services/response/BadAccess.php';
require_once ROOT_DIR . '/app/services/response/Unauthorized.php';
require_once ROOT_DIR . '/app/services/utils/AuthorizationUtils.php';
require_once ROOT_DIR . '/app/services/utils/JwtUtils.php';


class CsvService
{
    const DEFAULT_CSV_TEMP_LOCATION = ROOT_DIR.'/app/services/csv/temp';

    public static function generateCsv($jwt) : ?string
    {
        if (!AuthorizationUtils::isSimpleAuthorized($jwt)) {
            return null;
        }

        $decodedJwt = JwtUtils::decode_jwt($jwt);
        $userId = $decodedJwt->id;

        $csvFilePath = self::DEFAULT_CSV_TEMP_LOCATION . '/' . $userId . '.csv';

        $userSheet = self::generateUserSheet($userId);
        $allBooksSheet = self::generateAllBooksSheet($userId);
        $readingBooksSheet = self::generateBooksSortedByStatusSheet($userId, 'reading');
        $wantToReadBooksSheet = self::generateBooksSortedByStatusSheet($userId, 'want to read');
        $readBooksSheet = self::generateBooksSortedByStatusSheet($userId, 'read');
        $userReviewsSheet = self::generateUserReviewsSheet($userId);
        $output = $userSheet . PHP_EOL . $allBooksSheet . PHP_EOL . $readingBooksSheet . PHP_EOL . $wantToReadBooksSheet . PHP_EOL . $readBooksSheet . PHP_EOL . $userReviewsSheet . PHP_EOL;

        file_put_contents($csvFilePath, $output);

        return $csvFilePath;
    }

    public static function deleteTempFile($filePath) : void
    {
        unlink($filePath);
    }

    private static function generateUserSheet($userId) : string
    {
        $output = 'User Sheet' . PHP_EOL;

        $columns = array('Id', 'Full Name', 'Email', 'Is Admin');
        $output .= implode(',', $columns) . PHP_EOL;

        $user = UserRepository::getUserById($userId);
        $userData = $user->getFieldsAsArray();
        $output .= str_replace('\n', ' ', implode(',', $userData)) . PHP_EOL;

        return $output;
    }

    private static function generateAllBooksSheet($userId) : string
    {
        $output = 'All Books Sheet' . PHP_EOL;

        $columns = array('Id', 'Title', 'Author', 'Genre', 'Pages', 'ISBN', 'Publisher', 'Format', 'Publication Date');
        $output .= str_replace('\n', ' ', implode(',', $columns)) . PHP_EOL;

        $books = BookRepository::getAll();
        return self::setTheOutputForBooksWithReviews($books, $output);
    }

    private static function generateBooksSortedByStatusSheet(string $userId, string $status) : string
    {
        //make first letter uppercase
        $headerStatus = ucfirst($status);

        $output = $headerStatus. ' Books Sheet' . PHP_EOL;

        $columns = array('Id', 'Title', 'Author', 'Genre', 'Pages', 'ISBN', 'Publisher', 'Format', 'Publication Date');
        $output .= str_replace('\n', ' ', implode(',', $columns)) . PHP_EOL;

        $books = BookRepository::getBooksByStatus($userId, $status);

        return self::setTheOutputForBooksWithReviews($books, $output);
    }

    private static function setTheOutputForBooksWithReviews(array $books, string $output) : string
    {
        foreach ($books as $book) {
            $bookData = $book->getFieldsAsArray();
            $reviews = ReviewsRepository::getByBookId($book->id);

            $review_order_number = 1;
            foreach ($reviews as $review) {
                $bookData['review_' . $review_order_number] = $review->content;
                $review_order_number++;
            }

            $output .= str_replace('\n', ' ', implode(',', $bookData)) . PHP_EOL;
        }

        return $output;
    }

    public static function generateUserReviewsSheet(string $userId) : string
    {
        $output = 'User Reviews Sheet' . PHP_EOL;

        $columns = array('Id', 'Book Id', 'Book title', 'Book author', 'Content', 'Review Date');
        $output .= implode(',', $columns) . PHP_EOL;

        $reviews = ReviewsRepository::getByUserId($userId);

        foreach ($reviews as $review) {
            $book = BookRepository::getById($review->book_id);
            $rowData  = array($review->id, $review->book_id, $book->title, $book->author, $review->content, $review->review_date);
            $output .= str_replace('\n', ' ', implode(',', $rowData)) . PHP_EOL;
        }

        return $output;
    }

}
