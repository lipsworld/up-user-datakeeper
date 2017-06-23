<?php

    namespace UDK;


    use Respect\Validation\Validator as v;

    class User{

        private static $model = [
            [
                'column' => 'id',
                'dataType' => 'int(11) NOT NULL AUTO_INCREMENT',
                'type' => 'field'
            ],
            [
                'column' => '_key',
                'dataType' => 'text NOT NULL',
                'type' => 'field'
            ],
            [
                'column' => '_value',
                'dataType' => 'text NOT NULL',
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

            $sql = $wpdb->prepare("SELECT * FROM $tableName WHERE user_id = %d", [
                $userId
            ]);

            $userData = $wpdb->get_results($sql, OBJECT);
        
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

            if( v::ArrayVal()->validate($data) ){
                $assert = in_array($value, $data);                
            }
            else{
                $assert = $value == $data;                
            }

            if($assert){
                return Utils::sendSuccess([
                    'exists' => true
                ]);
            }
            else{
                return Utils::sendSuccess([
                    'exists' => false
                ]);
            }            
        }


        public function addData($userId, $key, $value){

            global $wpdb;
            $tableName = UpUserDatakeeper::$tableName;
                 
            if( !v::Numeric()->validate($userId) ){
                return Utils::sendError([
                    'message' => "Invalid user id!",
                    'id' => $userId
                ]);
                
            }
            elseif( !v::StringType()->validate($key) ){
                return Utils::sendError([
                    'message' => "Invalid key!",
                    'key' => $key                    
                ]);
            }
            elseif(!v::StringType()->validate($value) ){
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

                $wpdb->flush();
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
                    return Utils::sendError([
                        'message' => "Error in database, check the mysql query!"
                    ]);
                }                             

            }           

        }

        public function getCol($key, $userId){
            $tableName = UpUserDatakeeper::$tableName;
            $query = "SELECT _key FROM $tableName WHERE _key LIKE %s AND user_id = %d";
            $args = [ $key, $userId ];  
            return DB::getCol($query, $args);
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