<?php
class InitLab_Presence_Widget extends WP_Widget {
	private $options = [];

	// Set up the widget name and description.
	public function __construct() {
		parent::__construct('initlab_presence_widget', 'init Lab Presence', [
			'classname' => 'widget_initlab_presence',
			'description' => __('init Lab Presence widget', 'initlab-addons'),
		]);
		$this->options = [
            'title' => [
                'desc' => __('Title', 'initlab-addons'),
                'default' => '',
            ],
            'avatar_size' => [
                'desc' => __('Avatar size', 'initlab-addons'),
                'default' => '64',
            ],
            'refresh_time' => [
                'desc' => __('Refresh time (seconds, 0=off)', 'initlab-addons'),
                'default' => '60',
            ],
        ];
	}

	// Create the widget output.
	public function widget($args, $instance) {
		wp_enqueue_script('initlab-widget-presence', plugins_url('js/widget-presence.js', __FILE__), ['jquery']);
		wp_enqueue_style('initlab-widget-presence', plugins_url('css/widget-presence.css', __FILE__));
		
		echo $args['before_widget'];
		
		echo $args['before_title'];
		echo apply_filters('widget_title', $instance['title']);
		echo $args['after_title'];

		?>
		<div class="initlab_widget_presence_container" data-avatar-size="<?php echo esc_attr($instance['avatar_size']); ?>" data-refresh-time="<?php echo esc_attr($instance['refresh_time']); ?>"><?php _e('Loading...', 'initlab-addons'); ?></div>
		<?php
		
		echo $args['after_widget'];
	}


	// Create the admin area widget settings form.
	public function form($instance) {
		foreach ($this->options as $key => $field) {
			$value = !empty($instance[$key]) ? $instance[$key] : $field['default'];
			?>
			<p>
				<label for="<?php echo $this->get_field_id($key); ?>"><?php echo $field['desc']; ?></label>
				<input type="text" id="<?php echo $this->get_field_id($key); ?>" name="<?php echo $this->get_field_name($key); ?>" value="<?php echo esc_attr($value); ?>" />
			</p>
			<?php
		}
	}

	// Apply settings to the widget instance.
	public function update($new_instance, $old_instance) {
		foreach ($this->options as $key => $field) {
			$old_instance[$key] = strip_tags($new_instance[$key]);
		}
		
		return $old_instance;
	}
}
