<?php 

namespace UDK;

class API{
    
    public static function getUserData($userId){
        User::getData($userId);
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



}

?>