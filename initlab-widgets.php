<?php
/**
 * Plugin Name:   init Lab Widgets
 * Plugin URI:    https://github.com/initlab/initlab-widgets
 * Description:   Widgets used by init Lab's website
 * Version:       1.0
 * Author:        Vencislav Atanasov
 * Author URI:    https://github.com/user890104
 */

require __DIR__ . '/widget-presence.php';

function initlab_register_widgets() {
	register_widget('InitLab_Presence_Widget');
}

add_action('widgets_init', 'initlab_register_widgets');
