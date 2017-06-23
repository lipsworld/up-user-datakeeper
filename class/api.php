<?php 

namespace UDK;


class API{
    
    public static function getUserData($userId){
        return User::getData($userId);
    }    

    public static function verifyUserDataExists($userId, $key, $value){
        return User::verifyDataExists($userId, $key, $value);
    }

    public static function addUserData($userId, $key, $value){
       return User::addData($userId, $key, $value);        
    }

    public static function removeUserData($userId, $key, $value){
       return User::removeData($userId, $key, $value);        
    }

    //alias
    public static function uExists($userId, $key, $value){
        return self::verifyUserDataExists($userId, $key, $value);
    }

    public static function encode($data){
        return Utils::encode($data);
    }

    public static function decode($data){
        return Utils::decode($data);
    }

    public static function getCol($key, $userId){
        return User::getCol($key, $userId);
    }
}

?>