<?php
namespace UDK;


class Utils{

    public static function sendSuccess($obj){
        return [
            'success' => true,
            'data' => $obj
        ];
    }

    public static function sendError($obj){
        return [
            'success' => false,
            'data' => $obj
        ];
    }

    public static function encode($data){
        return base64_encode( serialize($data) );
    }

    public static function decode($data){
        return unserialize( base64_decode($data) );
    }
}

?>