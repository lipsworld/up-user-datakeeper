<?php
/*
Plugin Name: Up User Datakeeper
Plugin URI:  https://developer.wordpress.org/plugins/up-user-datakeeper
Description: A plugin to keep the info of users in wordpress
Version:     1.0.0
Author:      WordPress.org
Author URI:  http://viewup.com.br/
Text Domain: up-user-datakeeper
Domain Path: /languages
License:     GPL2
 
Up User Datakeeper is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
Up User Datakeeper is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with Up User Datakeeper. If not, see https://www.gnu.org/licenses/old-licenses/gpl-2.0.html.
*/

namespace UDK;


require 'vendor/autoload.php';


use UDK\DB;
use UDK\API;

class UpUserDatakeeper{

	static $tableName;

	public function initActivationHook(){		
		
		function _initActivationHook(){


		}

		register_activation_hook( __FILE__, '_initActivationHook');
	}

	public function initDeactivationHook(){

		function _initDeactivationHook(){

		}

		register_deactivation_hook( __FILE__, '_initDeactivationHook');
	}

	public function initUninstallHook(){

		function _initUninstallHook(){

		}

		register_uninstall_hook(__FILE__, '_initUninstallHook');
	}

	private function initUserDataTable(){
		global $wpdb;
		self::$tableName = $wpdb->prefix . "udk_user_data"; 
		

		if( DB::tableExists(self::$tableName) ){
			//silence is golden

		}
		else{		

			$arrFields = DB::getModelArray( User::getModel() );
			DB::createTable(self::$tableName, $arrFields);
		}


	}

	public function initScript($handle, $scriptPath, $dependencies = [], $dataName = '', $data = []){
		wp_register_script( $handle, plugins_url( $scriptPath, __FILE__ ), $dependencies);
		if($dataName){
			wp_localize_script( $handle, $dataName, $data );
		}
		wp_enqueue_script( $handle );	
	}

	public function initScripts(){
		
		$this->initScript('up-user-datakeeper', '/js/up-user-datakeeper.js', ['jquery'], 'udk', [
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'ajaxNonce' => wp_create_nonce('silence is golden!'),
		]);
	}

	public function addScriptData($handle, $objectName, $object){
		wp_localize_script( $handle, $objectName, $obj );
	}

	public function initAjaxAddUserData(){

		function udk_add() {
			$result = getPosts();
			echo json_encode($result, true);
			wp_die(); //ajax handlers die when finished
		}

		add_action( 'wp_ajax_nopriv_udk_add', 'udk_add' );
		add_action( 'wp_ajax_udk_add', 'udk_add' );	
		
		
	}
	
	public function __construct(){		
		
		$this->initActivationHook();
		$this->initDeactivationHook();
		$this->initUninstallHook();
		$this->initUserDataTable();
		$this->initScripts();
		$this->initAjaxAddUserData();
		
	}

}

new UpUserDatakeeper();
$UDKApi = new API();