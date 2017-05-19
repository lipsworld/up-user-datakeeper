<?php
/*
Plugin Name: Up User Datakeeper
Plugin URI:  https://developer.wordpress.org/plugins/up-user-datakeeper
Description: Basic WordPress Plugin Header Comment
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

class UpUserDatakeeper{
	function initActivationHook(){
		register_activation_hook( __FILE__,  function(){

		});
	}

	function initDeactivationHook(){
		register_deactivation_hook( __FILE__,  function(){

		});
	}

	function initUninstallHook(){
		register_uninstall_hook(__FILE__, function(){

		});
	}

	function __construct(){
		$this->initActivationHook();
		$this->initDeactivationHook();
		$this->initUninstallHook();
	}

}

new UpUserDatakeeper();