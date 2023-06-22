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

        $csvFile = fopen($csvFilePath, 'w');
        if (!$csvFile) {
            return null;
        }

        $user = UserRepository::getUserById($userId);
        self::writeCSVHeader($csvFile, "User Sheet");
        self::writeCSVData($csvFile, [$user->getFieldsAsArray()]);

        self::addBooksWithReviews($csvFile, $userId, "all");
        self::addBooksWithReviews($csvFile, $userId, "read");
        self::addBooksWithReviews($csvFile, $userId, "reading");
        self::addBooksWithReviews($csvFile, $userId, "want to read");
        self::addMyReviews($csvFile, $userId);

        fclose($csvFile);

        return $csvFilePath;
    }

    public static function deleteTempFile($filePath) : void
    {
        unlink($filePath);
    }

    private static function addMyReviews($csvFile, $userId) : void
    {
        $myReviews = ReviewsRepository::getByUserId($userId);
        self::writeCSVHeader($csvFile, "My Reviews");

        foreach ($myReviews as $review) {
            $book = BookRepository::getById($review->book_id);

            // Prepare the review data
            $rowData = [
                'id' => $book->id,
                'title' => $book->title,
                'author' => $book->author,
                'content' => $review->content
            ];

            self::writeCSVData($csvFile, [$rowData]); // Convert $rowData into an array

        }
    }

    private static function addBooksWithReviews($csvFile, $userId, $sheet_type = "all") : void
    {
        $books = [];
        $sheetName = "";

        switch ($sheet_type) {
            case "read":
                $books = BookRepository::getBooksByStatus($userId, "read");
                $sheetName = "Read Books";
                break;
            case "reading":
                $books = BookRepository::getBooksByStatus($userId, "reading");
                $sheetName = "Reading Books";
                break;
            case "want to read":
                $books = BookRepository::getBooksByStatus($userId, "want to read");
                $sheetName = "Want to Read Books";
                break;
            default:
                $books = BookRepository::getAll();
                $sheetName = "All Books";
                break;
        }

        self::writeCSVHeader($csvFile, $sheetName);

        foreach ($books as $book) {
            $reviews = ReviewsRepository::getByBookId($book->id);
            self::writeBooksWithReviewsData($csvFile, $book, $reviews);
        }
    }

    private static function writeCSVHeader($file, $sheetName) : void
    {
        fputcsv($file, [$sheetName], ',', '"');
    }

    private static function writeCSVData($file, $data) : void
    {
        if (!empty($data)) {
            foreach ($data as $row) {
                fputcsv($file, $row, ',', '"');
            }
        }
    }

    private static function writeBooksWithReviewsData($file, Book $book, array $reviews) : void
    {
        $rowData = array_values($book->getFieldsAsArray());
        $reviewContent = array_column($reviews, 'content');
        $rowData = array_merge($rowData, $reviewContent);
        fputcsv($file, $rowData, ',', '"');
    }
}
