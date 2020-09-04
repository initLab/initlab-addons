<?php
/**
 * Plugin Name: init Lab Addons
 * Plugin URI:  https://github.com/initlab/initlab-addons
 * Description: Widgets and other features for init Lab's website
 * Version:     2.0
 * Author:      Vencislav Atanasov
 * Author URI:  https://github.com/user890104
 * Text Domain: initlab-addons
 * Domain Path: /languages
 */

require __DIR__ . '/widget-presence.php';

function initlab_load_plugin_textdomain() {
    load_plugin_textdomain('initlab-addons', false, basename(__DIR__) . '/languages');
}

add_action('plugins_loaded', 'initlab_load_plugin_textdomain');

function initlab_register_widgets() {
	register_widget('InitLab_Presence_Widget');
}

add_action('widgets_init', 'initlab_register_widgets');
