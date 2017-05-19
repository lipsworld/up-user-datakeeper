<?php 

namespace UDK;

class API{
    
    static function getUserData($userId){

        global $wpdb;
        $tableName = UpUserDatakeeper::$tableName;
        $userData = $wpdb->get_row( "SELECT * FROM $tableName WHERE id = $userId" );
        return $userData;

    }

}

?>