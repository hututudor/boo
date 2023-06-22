<?php

require_once ROOT_DIR . '/app/repositories/QuestionsRepository.php';
require_once ROOT_DIR . '/app/repositories/UserRepository.php';
require_once __DIR__ . '/../services/utils/JwtUtils.php';
require_once __DIR__ . '/../services/utils/AuthorizationUtils.php';
require_once ROOT_DIR . '/app/models/Question.php';


class QuestionsController{
    public function getAll(Request $request): void {
        $questions = QuestionsRepository::getAll();

        foreach ($questions as $question) {
            $user = UserRepository::getUserById($question->user_id);
            $question->user = ['fullName' => $user->fullName];
            $question->reply_count = QuestionsRepository::getReplyCount($question->id);
        }

        Response::success($questions);
    }

    public function getReplies(Request $request): void {
        $id = $request->params['id'];
        $question = QuestionRepository::getById($id);
    
        if (!$question) {
            Response::notFound();
            return;
        }
    
        $replies = RepliesRepository::getRepliesByQuestionId($id);
        $replyCount = count($replies);
    
        Response::success([
            'replies' => $replies,
            'reply_count' => $replyCount
        ]);
    }
    
    public function add(Request $request) {

        $is_simple_authorized = AuthorizationUtils::isSimpleAuthorized(Headers::getHeaderValue($request->headers, 'Authorization'));
        if (!$is_simple_authorized)
        {
            Response::unauthorized();
            return;
        }
    
        $question = new Question();
    
        $jwtToken = Headers::getHeaderValue($request->headers, 'Authorization');
        $decodedToken = JwtUtils::decode_jwt($jwtToken);
        $question->user_id = $decodedToken->id;
        $question->title = $request->body['title'];
        $question->content = $request->body['content'];
        $question->date = date('d.m.Y');
    
        $inserted = QuestionsRepository::insert($question);
    
        if(!$inserted) {
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
    
        $question = QuestionsRepository::getById($questionId);
    
        if (!$question) {
            Response::notFound();
            return;
        }
    
        $is_admin_authorized = AuthorizationUtils::isAdminAuthorized(Headers::getHeaderValue($request->headers, 'Authorization'));
    
        if (!($is_admin_authorized || $question->user_id == $decodedToken->id)) {
            Response::unauthorized();
            return;
        }
    
        QuestionsRepository::deleteById($questionId);
    
        Response::success();
    }
    
    
}