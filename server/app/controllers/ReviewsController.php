<?php
require_once ROOT_DIR . '/app/models/Review.php';
require_once ROOT_DIR . '/app/validation.php';

class ReviewsController {
  public function add(Request $request) {
    $bodyErrors = $this->validateReviewBody($request);
    if($bodyErrors) {
      Response::badRequest($bodyErrors);
      return;
    }

    $review = new Review();

    $review->book_id = $request->params['book_id'];
    $review->user_id = $request->body['user_id'];
    $review->description = $request->body['description'];

    $inserted = ReviewRepository::insert($review);

    if(!$inserted) {
      Response::badRequest();
      return;
    }

    Response::success($inserted);
  }

  public function getByBookId(Request $request): void {
    $bookId = $request->params['book_id'];
    $reviews = ReviewRepository::getByBookId($bookId);

    if(empty($reviews)) {
      Response::notFound();
      return;
    }

    Response::success($reviews);
  }

  public static function getByUserId(string $userId): array {
    $db = DB::getInstance()->getConnection();
    $statement = $db->prepare("SELECT * FROM reviews WHERE user_id = ?");
    $statement->bind_param("i", $userId);
    $statement->execute();

    if ($statement->error) {
      return [];
    }

    $reviews = [];
    foreach ($statement->get_result() as $row) {
      $reviews[] = self::toReview($row);
    }

    return $reviews;
  }

  public function update(Request $request): void {
    $bodyErrors = $this->validateReviewBody($request);
    if($bodyErrors) {
      Response::badRequest($bodyErrors);
      return;
    }

    $review = new Review();
    $review->id = $request->params['id'];
    $review->book_id = $request->params['book_id'];
    $review->user_id = $request->body['user_id'];
    $review->description = $request->body['description'];

    $updated = ReviewRepository::update($review);

    if(!$updated) {
      Response::notFound();
    }

    Response::success(ReviewRepository::getById($review->id));
  }

  public function delete(Request $request): void {
    $reviewId = $request->params['id'];
    $userId = $request->params['user_id'];
    $bookId = $request->params['book_id']
  
    ReviewRepository::deleteById($reviewId, $userId, $bookId);
  
    Response::success();
  }
  

  private function validateReviewBody(Request $request): ?array {
    return validate($request->body, [
      'book_id' => ['required', 'number'],
      'user_id' => ['required', 'number'],
      'description' => ['required']
    ]);
  }
}