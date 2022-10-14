<?php
/*
Plugin Name: CarlFelton Sample Module
Plugin URI:  https://google.com
Description: Sample module for divi engine
Version:     1.0.0
Author:      Carl Felton
Author URI:  https://google.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: cfsm-carlfelton-sample-module
Domain Path: /languages

CarlFelton Sample Module is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

CarlFelton Sample Module is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with CarlFelton Sample Module. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

if ( ! function_exists( 'cfsm_initialize_extension' ) ) {
	function cfsm_initialize_extension() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/CarlfeltonSampleModule.php';
	}

	add_action( 'divi_extensions_init', 'cfsm_initialize_extension' );
}

