<?php
require __DIR__ . '/widget-presence.php';

function initlab_register_widgets() {
    register_widget('InitLab_Presence_Widget');
}

add_action('widgets_init', 'initlab_register_widgets');
