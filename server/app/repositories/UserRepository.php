<?php
require_once ROOT_DIR . '/app/models/auth/User.php';

class UserRepository
{
    public static function addUser($user) :? bool
    {
        $db = DB::getInstance()->getConnection();
        $statement = $db->prepare("INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)");

        $statement->bind_param("sss", $user->fullName, $user->email, $user->password);
        $statement->execute();

        if($statement->error) {
            return false;
        }

        return true;
    }
    public static function getUserByEmail($email) : ?User
    {
        $db = DB::getInstance()->getConnection();
        $statement = $db->prepare("SELECT * FROM users WHERE email = ?");

        $statement->bind_param("s", $email);
        $statement->execute();

        if($statement->error) {
            return null;
        }

        $row = $statement->get_result()->fetch_assoc();
        if(!$row) {
            return null;
        }

        return self::toUser($row);
    }

    public static function getUserById($id) : ?User
    {
        $db = DB::getInstance()->getConnection();
        $statement = $db->prepare("SELECT * FROM users WHERE id = ?");

        $statement->bind_param("i", $id);
        $statement->execute();

        if($statement->error) {
            return null;
        }

        $row = $statement->get_result()->fetch_assoc();
        if(!$row) {
            return null;
        }

        return self::toUser($row);
    }

    private static function toUser(array $row) : ?User{
       return new User(
           $row['id'],
           $row['full_name'],
           $row['email'],
           $row['password'],
           $row['is_admin']);
    }

    public static function updateEmail($userId, $updatedEmail) {
        $user = self::getUserById($userId);
        if (!$user) {
            return false; 
        }
    
        $db = DB::getInstance()->getConnection();
        
        $checkStatement = $db->prepare("SELECT * FROM users WHERE email = ?");
        $checkStatement->bind_param("s", $updatedEmail);
        $checkStatement->execute();
        $checkResult = $checkStatement->get_result();
    
        if ($checkResult->num_rows > 0) {
            return false;
        }
    
        $statement = $db->prepare("UPDATE users SET email = ? WHERE id = ?");
        $statement->bind_param("si", $updatedEmail, $userId);
        $statement->execute();
    
        if ($statement->error) {
            return false; 
        }
    
        return true; 
    }

    public static function updateName($userId, $updatedName) {
        $user = self::getUserById($userId);
        if (!$user) {
            return false;
        }
    
        $db = DB::getInstance()->getConnection();
    
        $statement = $db->prepare("UPDATE users SET full_name = ? WHERE id = ?");
        $statement->bind_param("si", $updatedName, $userId);
        $statement->execute();
    
        if ($statement->error) {
            return false; 
        }
    
        return true; 
    }
    
    public static function updatePassword($userId, $updatedPassword) {
        $user = self::getUserById($userId);
        if (!$user) {
            return false;
        }
    
        $db = DB::getInstance()->getConnection();
    
        $hashedPassword = password_hash($updatedPassword, PASSWORD_DEFAULT);
        $statement = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
        $statement->bind_param("si", $hashedPassword, $userId);
        $statement->execute();
    
        if ($statement->error) {
            return false; 
        }
    
        return true; 
    }
    
}