<?php


namespace UDK;

// use NilPortugues\Sql\QueryBuilder\Builder\GenericBuilder;

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

		$fieldsImploded = implode(',', $fields);

		$sql = "CREATE TABLE $tableName ($fieldsImploded) $charsetCollate;";		
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		$result = dbDelta( $sql );
		$x = 1;
	}

}


?>