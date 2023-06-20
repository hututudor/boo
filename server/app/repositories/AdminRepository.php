<?php

class AdminRepository{
    public static function getAllUsers() {
        $db = DB::getInstance()->getConnection();
        $statement = $db->prepare("SELECT * FROM users");
        $statement->execute();
      
        if ($statement->error) {
            return [];
        }
      
        $users = [];
        foreach ($statement->get_result() as $row) {
            $users[] = self::toUser($row);
        }
      
        return $users;
    }

    public static function promoteUser($user_id) {
        $db = DB::getInstance()->getConnection();
        $statement = $db->prepare("UPDATE users SET is_admin = 1 WHERE id = ?");
        $statement->bind_param("i", $user_id);
        $statement->execute();
    
        if ($statement->error) {
            return false;
        }
    
        return true; 
    }

    public static function demoteUser($user_id) {
        $db = DB::getInstance()->getConnection();
        $statement = $db->prepare("UPDATE users SET is_admin = 0 WHERE id = ?");
        $statement->bind_param("i", $user_id);
        $statement->execute();
    
        if ($statement->error) {
            return false;
        }
    
        return true; 
    }

    public static function deleteUser($user_id) {
        $db = DB::getInstance()->getConnection();
        $statement = $db->prepare("DELETE FROM users WHERE id = ?");
        $statement->bind_param("i", $user_id);
        $statement->execute();
    
        if ($statement->error) {
            return false;
        }
    
        return true; 
    }
    

    private static function toUser($row) {
        return [
            'id' => $row['id'],
            'full_name' => $row['full_name'],
            'email' => $row['email'],
            'is_admin' => $row['is_admin'],
        ];
    }
}