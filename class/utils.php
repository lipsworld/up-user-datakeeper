<?php
namespace UDK;

class Utils{

    public function sendSuccess($obj){
        return [
            'success' => true,
            'data' => $obj
        ];
    }

    public function sendError($obj){
        return [
            'success' => false,
            'data' => $obj
        ];
    }
}

?>