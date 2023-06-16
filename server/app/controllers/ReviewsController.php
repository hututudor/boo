<?php
require_once ROOT_DIR . '/app/models/Reviews.php';
require_once ROOT_DIR . '/app/validation.php';
require_once __DIR__ . '/../services/utils/JwtUtils.php';
require_once __DIR__ . '/../repositories/ReviewsRepository.php';
require_once __DIR__ . '/../services/utils/AuthorizationUtils.php';



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

    $review->description = $request->body['description'];

    $inserted = ReviewsRepository::insert($review);

    if(!$inserted) {
      Response::badRequest();
      return;
    }

    Response::success($inserted);
  }

  public function getByBookId(Request $request): void {
    $is_simple_authorized = AuthorizationUtils::isSimpleAuthorized(Headers::getHeaderValue($request->headers, 'Authorization'));
    if (!$is_simple_authorized)
    {
        Response::unauthorized();
        return;
    }

    $bookId = $request->params['book_id'];
    $reviews = ReviewsRepository::getByBookId($bookId);

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
    $review->description = $request->body['description'];

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
      'description' => ['required']
    ]);
  }
}