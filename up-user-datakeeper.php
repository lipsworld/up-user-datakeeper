<?php
/*
Plugin Name: WordPress.org Plugin
Plugin URI:  https://developer.wordpress.org/plugins/the-basics/
Description: Basic WordPress Plugin Header Comment
Version:     20160911
Author:      WordPress.org
Author URI:  https://developer.wordpress.org/
Text Domain: wporg
Domain Path: /languages
License:     GPL2
 
{Plugin Name} is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
{Plugin Name} is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with {Plugin Name}. If not, see {License URI}.
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

	function __construct(){
		$this->initActivationHook();
		$this->initDeactivationHook();
	}

}

new UpUserDatakeeper();