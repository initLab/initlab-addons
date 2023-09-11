<?php
function initlab_load_plugin_textdomain() {
    load_plugin_textdomain('initlab-addons', false, basename(__DIR__) . '/languages');
}

add_action('plugins_loaded', 'initlab_load_plugin_textdomain');
