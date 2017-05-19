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


require 'vendor/autoload.php';

use UDK\DB;
use UDK\API;

class UpUserDatakeeper{

	private $tableName;

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
		$this->tableName = $wpdb->prefix . "udk_user_data"; 

		if( DB::tableExists($this->tableName) ){
			//silence is golden

		}
		else{
			DB::createTable($this->tableName, [				
				'id int(11) NOT NULL AUTO_INCREMENT',
				'user_id int(11) NOT NULL',
				'_key text NOT NULL',
				'_value text NOT NULL',
				'PRIMARY KEY  (id)'
			]);
		}


	}

	public function __construct(){
		$this->initActivationHook();
		$this->initDeactivationHook();
		$this->initUninstallHook();
		$this->initUserDataTable();
		new API();
		$x = 1;
	}

}

new UpUserDatakeeper();