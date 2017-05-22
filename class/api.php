<?php 

namespace UDK;

class API{
    
    public static function getUserData($userId){
        User::getData($userId);
    }    

    public static function addUserData($userId, $key, $value){
       return User::addData($userId, $key, $value);        
    }

    public static function removeUserData($userId, $key, $value){
       return User::removeData($userId, $key, $value);        
    }

}

?>