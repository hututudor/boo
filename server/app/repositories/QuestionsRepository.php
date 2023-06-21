<?php

require_once ROOT_DIR . '/app/models/Question.php';

class QuestionsRepository{

    public static function getById(int $id): ?Question {
        $db = DB::getInstance()->getConnection();
        $statement = $db->prepare("SELECT * FROM questions WHERE id = ?");
        $statement->bind_param("i", $id);
        $statement->execute();
    
        if ($statement->error) {
            return null;
        }
    
        $result = $statement->get_result();
        $row = $result->fetch_assoc();
        if (!$row) {
            return null;
        }
    
        return self::toQuestion($row);
    }

    public static function getReplyCount(int $id): int {
        $db = DB::getInstance()->getConnection();
        $statement = $db->prepare("SELECT COUNT(*) FROM replies WHERE question_id = ?");
        $statement->bind_param("i", $id);
        $statement->execute();
        
        $result = $statement->get_result();
        if ($result === false) {
            return 0; 
        }
        
        $row = $result->fetch_assoc();
        return intval($row['COUNT(*)']);
    }
    
    public static function incrementViewCount(int $questionId): void {
        $db = DB::getInstance()->getConnection();
        $statement = $db->prepare("UPDATE questions SET view_count = view_count + 1 WHERE id = ?");
        $statement->bind_param("i", $questionId);
        $statement->execute();
    }

    public static function getRepliesByQuestionId(int $questionId): array {
        $db = DB::getInstance()->getConnection();
        $statement = $db->prepare("SELECT * FROM replies WHERE question_id = ?");
        $statement->bind_param("i", $questionId);
        $statement->execute();

        $result = $statement->get_result();
        $replies = [];

        while ($row = $result->fetch_assoc()) {
            $reply = self::toReply($row);
            $replies[] = $reply;
        }

        return $replies;
    }
    

    public static function getAll(): array {
        $db = DB::getInstance()->getConnection();
        $statement = $db->prepare("SELECT * FROM questions");
        $statement->execute();
    
        if($statement->error) {
          return [];
        }
    
        $questions = [];
        foreach ($statement->get_result() as $row) {
          $questions[] = self::toQuestion($row);
        }
    
        return $questions;
    }

    public static function insert(Question $question): ?Question {
        $db = DB::getInstance()->getConnection();
        $statement = $db->prepare("INSERT INTO questions (user_id, title, content, date, view_count) VALUES (?, ?, ?, ?, ?)");
        $statement->bind_param("isssi", $question->user_id, $question->title, $question->content, $question->date, $question->view_count);
        $statement->execute();
    
        if($statement->error) {
            return null;
        }
    
        $question->id = $statement->insert_id;
        return $question;
    }
    
    public static function deleteById(int $id): void {
        $db = DB::getInstance()->getConnection();
        $statement = $db->prepare("DELETE FROM questions WHERE id = ?");
        $statement->bind_param("i", $id);
        $statement->execute();
    }
    

    public static function toQuestion(array $row): Question {
        return new Question($row['id'], $row['user_id'], $row['title'], $row['content'], $row['date'], $row['view_count']);
    }
}