<?php

require_once ROOT_DIR . '/app/repositories/QuestionsRepository.php';

Class RepliesRepository{
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
    

    public static function getById(int $id): ?Reply {
        $db = DB::getInstance()->getConnection();
        $statement = $db->prepare("SELECT * FROM replies WHERE id = ?");
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
    
        return self::toReply($row);
    }
      

    private static function toReply(array $row): Reply {
        return new Reply($row['id'], $row['user_id'], $row['question_id'], $row['content'], $row['date']);
    }

    public static function insert(Reply $reply): ?Reply {
        $db = DB::getInstance()->getConnection();
        $statement = $db->prepare("INSERT INTO replies (user_id, question_id, content, date) VALUES (?, ?, ?, ?)");
        $statement->bind_param("iiss", $reply->user_id, $reply->question_id, $reply->content, $reply->date);
        $statement->execute();
    
        if ($statement->error) {
            return null;
        }
    
        $reply->id = $statement->insert_id;
        return $reply;
    }
    
    public static function deleteById(int $id): void {
        $db = DB::getInstance()->getConnection();
        $statement = $db->prepare("DELETE FROM replies WHERE id = ?");
        $statement->bind_param("i", $id);
        $statement->execute();
    }
}