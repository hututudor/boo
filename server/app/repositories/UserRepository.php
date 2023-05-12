<?php

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

    private static function getUserById($id) : ?User
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

}