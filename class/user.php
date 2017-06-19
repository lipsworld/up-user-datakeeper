<?php

    namespace UDK;

    class User{

        private static $model = [
            [
                'column' => 'id',
                'dataType' => 'int(11) NOT NULL AUTO_INCREMENT',
                'type' => 'field'
            ],
            [
                'column' => '_key',
                'dataType' => 'varchar(20) NOT NULL',
                'type' => 'field'
            ],
            [
                'column' => '_value',
                'dataType' => 'varchar(20) NOT NULL',
                'type' => 'field'
            ],
            [
                'column' => 'user_id',
                'dataType' => 'int(11) NOT NULL',
                'type' => 'field'
            ],
            [
                'column' => 'PRIMARY KEY',
                "dataType" => '(id)',
                'type' => 'statement'
            ]
        ];

        public static function getColumns(){

            $arrFilter = array_filter($arr, function($item){
  
                if($item['type'] == 'field'){
                    return true;
                }
            
            });

            $arrMap = array_map( function($item){            
                return $item['column'];
            }, $filter);

            return $arrMap;         
        }

        public static function getModel(){
            return self::$model;
        }

        public static function getData($userId){
            global $wpdb;
            $tableName = UpUserDatakeeper::$tableName;
            $userData = $wpdb->get_results( "SELECT * FROM $tableName WHERE user_id = $userId", OBJECT);
        
            $userDataArr = [];

            foreach($userData as $data){

                $key = $data->_key;
                $value = $data->_value;

                if( in_array($key, array_keys($userDataArr) ) ){

                    $valueArr = $userDataArr[$key];

                    if( gettype($valueArr) == 'string' ){
                        $userDataArr[$key] = [ $valueArr ];                    
                    }

                    $userDataArr[$key][] = $value;

                }
                else{
                    $userDataArr[$key] = $value;
                }           
                
            }

            return $userDataArr;
        }

        private static function _verifyDuplicity($userId, $key, $value){
            global $wpdb;
            $tableName = UpUserDatakeeper::$tableName;        
            $userData = $wpdb->get_results( "SELECT * FROM $tableName WHERE _key = '$key' AND _value = '$value' AND user_id = '$userId'", OBJECT);

            if( count($userData) ){
                return true;
            }
            else{
                return false;
            }
            
        }

        public static function verifyDataExists($userId, $key, $value){
            $data = self::getData($userId);
            $data = $data[$key];

            if( gettype($data) == 'array'){
                $assert = in_array($value, $data);                
            }
            else{
                $assert = $value == $data;                
            }

            if($assert){
                return true;
            }
            else{
                return false;
            }            
        }


        public function addData($userId, $key, $value){

            global $wpdb;
            $tableName = UpUserDatakeeper::$tableName;


            if( !ctype_digit($userId) ){
                return Utils::sendError([
                    'message' => "Invalid user id!"
                ]);
                
            }      
            elseif( !ctype_digit($userId) ){
                return Utils::sendError([
                    'message' => "Invalid user id!",
                    'id' => $userId
                ]);
                
            }
            elseif(!$key){
                return Utils::sendError([
                    'message' => "Invalid key!",
                    'key' => $key                    
                ]);
            }
            elseif(!$value){
                return Utils::sendError([
                    'message' => "Invalid value!",
                    'value' => $value                    
                ]);
            }
            elseif( self::_verifyDuplicity($userId, $key, $value) ){

                return Utils::sendError([
                    'message' => "Value '$value' already exists in key '$key'."
                ]);

            }
            else{                

                $result = $wpdb->insert( 
                    $tableName, 
                    array( 
                        'user_id' => $userId,
                        '_key' => $key, 
                        '_value' => $value 
                    ), 
                    array( 
                        '%s', 
                        '%s',
                        '%s' 
                    ) 
                );

                if($result === 1){
                    return Utils::sendSuccess([
                        'message' => "Value '$value' added successfully to key '$key'."
                    ]);
                }
                else{

                }                             

            }           

        }

        public function removeData($userId, $key, $value){
            global $wpdb;
            $tableName = UpUserDatakeeper::$tableName;  

            $result = $wpdb->delete( $tableName, [ 
                'user_id' => $userId,
                '_key' => $key,
                '_value' => $value
            ], [
                '%d',
                '%s',
                '%s'
            ]);

            if($result !== false){
                return true;
            }
            else{
                return false;
            }

        }

    }

?>