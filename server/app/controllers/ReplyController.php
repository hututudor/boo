<?php

require_once ROOT_DIR . '/app/repositories/RepliesRepository.php';

require_once ROOT_DIR . '/app/repositories/QuestionsRepository.php';
require_once __DIR__ . '/../services/utils/JwtUtils.php';
require_once __DIR__ . '/../services/utils/AuthorizationUtils.php';
require_once ROOT_DIR . '/app/models/Reply.php';

Class ReplyController{
    public function getAll(Request $request): void {
        $id = $request->params['id'];
    
        $question = QuestionsRepository::getById($id);
        
        if (!$question) {
            Response::notFound();
            return;
        }
    
        $question->reply_count = QuestionsRepository::getReplyCount($question->id);
        QuestionsRepository::incrementViewCount($question->id);
        $replies = RepliesRepository::getRepliesByQuestionId($question->id);
        $question->replies = $replies;
        Response::success($question);
    }
    
    

    public function add(Request $request) {
        $is_simple_authorized = AuthorizationUtils::isSimpleAuthorized(Headers::getHeaderValue($request->headers, 'Authorization'));
        if (!$is_simple_authorized) {
            Response::unauthorized();
            return;
        }
    
        $reply = new Reply();
    
        $jwtToken = Headers::getHeaderValue($request->headers, 'Authorization');
        $decodedToken = JwtUtils::decode_jwt($jwtToken);
        $reply->user_id = $decodedToken->id;
        $reply->question_id = $request->params['id'];
        $reply->content = $request->body['content'];
        $reply->date = date('d.m.Y');
        $inserted = RepliesRepository::insert($reply);
    
        if (!$inserted) {
            Response::badRequest();
            return;
        }
    
        Response::success($inserted);
    }
    
    
    
    public function delete(Request $request): void {
        $is_simple_authorized = AuthorizationUtils::isSimpleAuthorized(Headers::getHeaderValue($request->headers, 'Authorization'));
        if (!$is_simple_authorized) {
            Response::unauthorized();
            return;
        }
    
        $questionId = $request->params['id'];
        $jwtToken = Headers::getHeaderValue($request->headers, 'Authorization');
        $decodedToken = JwtUtils::decode_jwt($jwtToken);
    
        $question = RepliesRepository::getById($questionId);
    
        if (!$question) {
            Response::notFound();
            return;
        }
    
        $is_admin_authorized = AuthorizationUtils::isAdminAuthorized(Headers::getHeaderValue($request->headers, 'Authorization'));
    
        if (!($is_admin_authorized || $question->user_id == $decodedToken->id)) {
            Response::unauthorized();
            return;
        }
    
        RepliesRepository::deleteById($questionId);
    
        Response::success();
    }
}