<?php
require_once ROOT_DIR . '/app/models/Reviews.php';
require_once ROOT_DIR . '/app/validation.php';
require_once __DIR__ . '/../services/utils/JwtUtils.php';
require_once __DIR__ . '/../repositories/ReviewsRepository.php';
require_once __DIR__ . '/../services/utils/AuthorizationUtils.php';
require_once ROOT_DIR . '/app/services/rss/RssUtils.php';

class ReviewsController {
  public function add(Request $request) {
    $is_simple_authorized = AuthorizationUtils::isSimpleAuthorized(Headers::getHeaderValue($request->headers, 'Authorization'));
    if (!$is_simple_authorized)
    {
        Response::unauthorized();
        return;
    }

    $bodyErrors = $this->validateReviewBody($request);
    if($bodyErrors) {
      Response::badRequest($bodyErrors);
      return;
    }

    $review = new Review();

    $review->book_id = $request->params['book_id'];
    if (!$review->book_id)
    {
        Response::badRequest(["error"=>"no book id"]);
        return;
    }
    $book = BookRepository::getById($review->book_id);
    if(!$book)
    {
        Response::notFound(["error"=>"book not found"]);
        return;
    }
    $jwtToken = Headers::getHeaderValue($request->headers, 'Authorization');
    $decodedToken = JwtUtils::decode_jwt($jwtToken);
    $review->user_id = $decodedToken->id;

    $review->content = $request->body['content'];
    $review->review_date = date('d.m.Y');

    $inserted = ReviewsRepository::insert($review);

    if(!$inserted) {
      Response::badRequest();
      return;
    }

    Response::success($inserted);
  }

  public function getByBookId(Request $request): void {

    if(!AuthorizationUtils::isSimpleAuthorized(Headers::getHeaderValue($request->headers, 'Authorization')))
    {
        Response::unauthorized();
        return;
    }

    $bookId = $request->params['book_id'];
    $reviews = ReviewsRepository::getByBookId($bookId);

    $lastReviewId = -1;

    foreach ($reviews as &$review)
    {
      $user = UserRepository::getUserById($review->user_id);
      $review->user = $user;

      if($review->id > $lastReviewId)
      {
        $lastReviewId = $review->id;
      }
    }

    //if lastReviewId is -1, log error
    if($lastReviewId > 0)
    {
        $jwt = Headers::getHeaderValue($request->headers, 'Authorization');
        RssUtils::updateLastReviewId($bookId, $jwt, $lastReviewId);
    }

    Response::success($reviews);
  }

  public function getByUserId(Request $request): void {
    $is_simple_authorized = AuthorizationUtils::isSimpleAuthorized(Headers::getHeaderValue($request->headers, 'Authorization'));
    if (!$is_simple_authorized)
    {
        Response::unauthorized();
        return;
    }

    $jwtToken = Headers::getHeaderValue($request->headers, 'Authorization');
    $decodedToken = JwtUtils::decode_jwt($jwtToken);

    if (!$decodedToken || !isset($decodedToken->id)) {
        Response::unauthorized();
        return;
      }
    
    $userId = $decodedToken->id;
  
    $reviews = ReviewsRepository::getByUserId($userId);
    
    foreach ($reviews as &$review)
    {
      $book = BookRepository::getById($review->book_id);
      $review->book = $book;
    }

    Response::success($reviews);
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
    $jwtToken = Headers::getHeaderValue($request->headers, 'Authorization');
    $decodedToken = JwtUtils::decode_jwt($jwtToken);
    $review->user_id = $decodedToken->id;
    $review->content = $request->body['content'];
    $review->review_date = $request->body['content'];

    $updated = ReviewsRepository::update($review);

    if(!$updated) {
      Response::notFound();
    }

    Response::success(ReviewsRepository::getById($review->id));
  }

  public function delete(Request $request): void {
    $is_simple_authorized = AuthorizationUtils::isSimpleAuthorized(Headers::getHeaderValue($request->headers, 'Authorization'));
    if (!$is_simple_authorized)
    {
        Response::unauthorized();
        return;
    }
    $reviewId = $request->params['id'];
    $jwtToken = Headers::getHeaderValue($request->headers, 'Authorization');
    $decodedToken = JwtUtils::decode_jwt($jwtToken);
    
    $review = ReviewsRepository::getById($reviewId);
    
    if(!$review)
    {
        Response::notFound();
        return;
    }

    $is_admin_authorized = AuthorizationUtils::isAdminAuthorized(Headers::getHeaderValue($request->headers, 'Authorization'));

    if(!($is_admin_authorized || $review->user_id == $decodedToken->id))
    {
        Response::unauthorized();
        return;
    }

    ReviewsRepository::deleteById($reviewId);

    Response::success();
  }


  private function validateReviewBody(Request $request): ?array {
    return validate($request->body, [
      'content' => ['required']
    ]);
  }
}