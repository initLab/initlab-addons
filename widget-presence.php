<?php
class InitLab_Presence_Widget extends WP_Widget {
	private $options = [
		'title' => [
			'desc' => 'Title',
			'default' => '',
		],
		'avatar_size' => [
			'desc' => 'Avatar size',
			'default' => '64',
		],
		'refresh_time' => [
			'desc' => 'Refresh time (seconds, 0=off)',
			'default' => '60',
		],
	];

	// Set up the widget name and description.
	public function __construct() {
		parent::__construct('initlab_presence_widget', 'init Lab Presence', [
			'classname' => 'widget_initlab_presence',
			'description' => 'init Lab Presence widget',
		]);
	}

	// Create the widget output.
	public function widget($args, $instance) {
		wp_enqueue_script('initlab-presence', plugins_url('js/presence.js', __FILE__), ['jquery']);
		wp_enqueue_style('initlab-presence', plugins_url('css/presence.css', __FILE__));
		
		echo $args['before_widget'];
		
		echo $args['before_title'];
		echo apply_filters('widget_title', $instance['title']);
		echo $args['after_title'];

		?>
		<div class="initlab_presence_widget_container" data-avatar-size="<?php echo esc_attr($instance['avatar_size']); ?>" data-refresh-time="<?php echo esc_attr($instance['refresh_time']); ?>">Зареждане...</div>
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
