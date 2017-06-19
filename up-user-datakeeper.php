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

// use UDK\DB;
// use UDK\API;
// use UDK\Ajax;

class UpUserDatakeeper{

	static $tableName;	
	private $nonceAction = 'up-user-datakeeper';
	private $nonce;
	private $debug = true;

	private function initNonce(){
		$this->nonce = wp_create_nonce($this->nonceAction);
	}

	private function initActivationHook(){		
		
		function _initActivationHook(){


		}

		register_activation_hook( __FILE__, '_initActivationHook');
	}

	private function initDeactivationHook(){

		function _initDeactivationHook(){

		}

		register_deactivation_hook( __FILE__, '_initDeactivationHook');
	}

	private function initUninstallHook(){

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

	private function initScript($handle, $scriptPath, $dependencies = [], $dataName = '', $data = []){
		wp_register_script( $handle, plugins_url( $scriptPath, __FILE__ ), $dependencies);
		if($dataName){
			wp_localize_script( $handle, $dataName, $data );
		}
		wp_enqueue_script( $handle );	
	}

	private function initStyle($handle, $scriptPath, $dependencies = []){
		wp_register_style( $handle, plugins_url( $scriptPath, __FILE__ ), $dependencies);		
		wp_enqueue_style( $handle );	
	}

	private function initScripts(){
		
		$this->initScript('up-user-datakeeper', '/js/up-user-datakeeper.js', ['jquery'], 'udk', [
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'ajaxNonce' => $this->nonce,
		]);
	}

	private function addScriptData($handle, $objectName, $object){
		wp_localize_script( $handle, $objectName, $obj );
	}	

	private function initAjax(){
		Ajax::addAction('udk_add', function(){
			$data = $_POST;
			$result = API::addUserData( $data['userId'], $data['key'], $data['value'] );

			if($this->debug === true){
				$data['result'] = $result;
			}			

			if($result['success'] === true){
				wp_send_json_success( $data );
			}
			else{
				wp_send_json_error( $data );
			}
			
		}, $this->nonceAction);	
	}

	public function initStyles(){
		$this->initStyle('up-user-datakeeper', '/css/up-user-datakeeper.css');

	}

	public function initRestAPI(){
		$rest = new REST();
		$rest->setNamespace('udk/v1');
		$rest->addRoute([
			'route' => 'add',
			'methods' => 'POST',
			'callback' => function(){
				$data = $_POST;
				$result = API::addUserData( $data['userId'], $data['key'], $data['value'] );
				wp_send_json( $result );
			}			
		]);

		$rest->addRoute([
			'route' => 'exists',
			'methods' => 'GET',
			'callback' => function(){
				$data = $_GET;
				$result = API::uExists( $data['userId'], $data['key'], $data['value'] );
				wp_send_json( $result );
			}			
		]);

		$rest->initAction();
	}
	
	public function __construct(){	
		$this->initNonce();
		$this->initActivationHook();
		$this->initDeactivationHook();
		$this->initUninstallHook();
		$this->initUserDataTable();
		$this->initScripts();	
		$this->initStyles();	
		$this->initAjax();		
		$this->initRestAPI();
	}

}

new UpUserDatakeeper();
$UDKApi = new API();