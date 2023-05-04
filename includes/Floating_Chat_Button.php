<?php

class Floating_Chat_Button extends WP_Widget {

private $baseURL = 'https://wa.me/';

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
    $url = '';//default value
    // WordPress core before_widget hook (always include )
    echo $before_widget;

    // Display the widget
    echo '<div class="widget-text wp_widget_plugin_box">';

        // Display text field
        echo'<p>';
        if ( $text & $phonenumber) {
            $url = $this->baseURL.$phonenumber."&amp;text=".$text;
        }
        elseif ( $phonenumber ) { //phonenumber without text
            $url = $this->baseURL.$phonenumber."";
        }
        echo'<a href="'.esc_url( $url ).'">';
        echo'<i class="custom-whatsapp fa fa-whatsapp"></i>';
        echo'</a>';
        echo'</p>';

    echo '</div>'
    ;

    // WordPress core after_widget hook (always include )
    echo $after_widget;

}

}