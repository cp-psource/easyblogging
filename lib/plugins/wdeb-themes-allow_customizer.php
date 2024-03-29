<?php
/*
Plugin Name: Customizer zulassen
Description: Ermöglicht den Zugriff auf WP3.4 + Theme Customizer. <b>Benötigt ClassicPress v3.4 oder besser.</b>
Plugin URI: https://n3rds.work/piestingtal_source/easy-blogging-plugin/
Version: 1.0
Author: WMS N@W
*/

class Wdeb_Themes_AllowCustomizer {

	private $_version_sattisfied = false;

	private function __construct () {
		global $wp_version;
		$version = preg_replace('/-.*$/', '', $wp_version);
		$this->_version_sattisfied = version_compare($version, '3.4', '>=');
	}

	public static function serve () {
		$me = new Wdeb_Themes_AllowCustomizer;
		$me->_add_hooks();
	}

	private function _add_hooks () {
		if (!$this->_version_sattisfied) return false;
		add_action('wdeb_style-custom_stylesheet_rules', array($this, 'style_overrides'));
		add_action('wdeb_script-custom_javascript', array($this, 'script_init'));
	}

	function style_overrides () {
		echo '#primary_right td.available-theme p, #primary_right #current-theme .theme-options, #primary_right .appearance_page_premium-themes #current-theme p {  display: block; }';
	}

	function script_init () {
		echo '$(window).on("load", function () {
			$(".hide-if-no-customize").show();
			$(".hide-if-customize").hide();
		});';
	}

	
}

if (is_admin()) Wdeb_Themes_AllowCustomizer::serve();