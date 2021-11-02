<?php
/**
 * Plugin Name: Floating Chat Button
 * Plugin URI: http://www.zentcode.com
 * Description: Floating Action Button to open WhatsApp
 * Version: 1.0.0
 * Author: Zentcode
 * Author URI: https://www.zentcode.com
 */
// The widget class
class Floating_Chat_Button extends WP_Widget {

	// Main constructor
	public function __construct() {
		parent::__construct(
			'floating_chat_button',
			__( 'Floating Chat Button Widget', 'text_domain' ),
			array(
				'customize_selective_refresh' => true,
			)
		);
	}

	// The widget form (for the backend )
	public function form( $instance ) {

		// Set widget defaults
		$defaults = array(
			'text'     => '',
			'phonenumber'     => '',
		);
		
		// Parse current settings with defaults
		extract( wp_parse_args( ( array ) $instance, $defaults ) ); ?>

		<?php // Text Field ?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php _e( 'Text:', 'text_domain' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>" type="text" value="<?php echo esc_attr( $text ); ?>" />
		</p>

		<?php // Phone number Field ?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'phonenumber' ) ); ?>"><?php _e( 'Phone:', 'text_domain' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'phonenumber' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'phonenumber' ) ); ?>" type="text" value="<?php echo esc_attr( $phonenumber ); ?>" />
		</p>

	<?php }

	// Update widget settings
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['text']     = isset( $new_instance['text'] ) ? wp_strip_all_tags( $new_instance['text'] ) : '';
		$instance['phonenumber']     = isset( $new_instance['phonenumber'] ) ? wp_strip_all_tags( $new_instance['phonenumber'] ) : '';
		return $instance;
	}

	// Display the widget
	public function widget( $args, $instance ) {

		extract( $args );

		// Check the widget options
		$text     = isset( $instance['text'] ) ? $instance['text'] : '';
		$phonenumber     = isset( $instance['phonenumber'] ) ? $instance['phonenumber'] : '';

		// WordPress core before_widget hook (always include )
		echo $before_widget;

		// Display the widget
		echo '<div class="widget-text wp_widget_plugin_box">';

			// Display text field
			echo'<p>';
			if ( $text & $phonenumber) {
				echo'<a href="https://api.whatsapp.com/send?phone=' . $phonenumber . '&amp;text=' . $text . '">';
			}
			elseif ( $phonenumber ) { //phonenumber without text
				echo'<a href="https://api.whatsapp.com/send?phone=' . $phonenumber . '&amp;">';
			}
			else {
				echo'<a>';
			}
			echo'<i class="custom-whatsapp fa fa-whatsapp"></i>';
			echo'</a>';
			echo'</p>';

		echo '</div>'
		;

		// WordPress core after_widget hook (always include )
		echo $after_widget;

	}

}

// Register the widget
function my_register_custom_widget() {
	register_widget( 'Floating_Chat_Button' );
}
add_action( 'widgets_init', 'my_register_custom_widget' );

add_action('wp_enqueue_scripts', 'callback_for_setting_up_scripts');
function callback_for_setting_up_scripts() {
    wp_register_style( 'custom-whatsapp',
						plugin_dir_url( __FILE__ ).'css/custom.css',
						array(),
						'1.0'
					);
    wp_enqueue_style( 'custom-whatsapp' );
}
