<?php


namespace UDK;


class DB{

    static function tableExists($tableName){
		global $wpdb;
		if( $wpdb->get_var("SHOW TABLES LIKE '$tableName'") == $tableName){
			return true;
		}
		else{
			return false;
		}
	}

	static function createTable($tableName, $fields){
		global $wpdb;

		$charsetCollate = $wpdb->get_charset_collate();

		$fieldsImploded = implode(",\n", $fields);
		
		$sql = $wpdb->prepare('CREATE TABLE %s ( \n%s\n ) $charsetCollate;"', [
			$tableName,
			$fieldsImploded
		]);
		return self::_runDbDelta($sql);
	}

	private static function _runDbDelta($sql){
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		$result = dbDelta( $sql );
		return $result;
	}

	private static function _runQuery($sql){
		global $wpdb;
		return $wpdb->query($sql);	
	}

	static function dropTable($table){
		$sql = $wpdb->prepare("DROP TABLE IF EXISTS %s", [$table]);
		return self::_runQuery($sql);
	}

	public static function countQuery($sql){
		global $wpdb;
		$count = $wpdb->get_var( trim($sql) );

		if(ctype_digit($count)){
			return intval($count);
		}
		else{
			return 0;
		}
		
	}

	static function getModelArray($model){

		foreach( $model as $field){
			$arrFields[] = implode(' ', [
				$field['column'],
				$field['dataType']
			]);
		}

		return $arrFields;
	}

	static function getCol($query, $args){
		global $wpdb;
		
		$sql = $wpdb->prepare($query, $args);
		return $wpdb->get_col($sql);
	}

}


?>