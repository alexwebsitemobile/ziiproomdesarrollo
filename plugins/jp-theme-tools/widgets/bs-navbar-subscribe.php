<?php

class BS_Navbar_Subscribe_Widget extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		parent::__construct(
						// id_base
						'bs_navbar_subscribe',
						// name
						'BS Navbar Subscribe',
						// widget_options
						array( 'description' => 'Bootstrap Navbar Subscribe Box' ),
						// control_options
						array() );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		$template = locate_template( 'jp-theme-tools/widgets/navbar-subscribe.php' );
		if ( empty( $template ) ) {
			$template = JPTT_BASEPATH . '/templates/widgets/navbar-subscribe.php';
		}
		include apply_filters( 'bs_navbar_subscribe_template', $template );
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		$defaults = array(
				'placeholder' => '',
				'button_text' => '',
				'form_class' => ''
		);
		$instance = wp_parse_args( $instance, $defaults );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'placeholder' ); ?>">Placeholder:</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'placeholder' ); ?>" name="<?php echo $this->get_field_name( 'placeholder' ); ?>" value="<?php echo $instance['placeholder'] ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'form_class' ); ?>">Form class:</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'form_class' ); ?>" name="<?php echo $this->get_field_name( 'form_class' ); ?>" value="<?php echo esc_attr( $instance['form_class'] ) ?>">
			<br>
			<small>navbar-right, navbar-left or custom class</small>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'button_text' ); ?>">Button:</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'button_text' ); ?>" name="<?php echo $this->get_field_name( 'button_text' ); ?>" value="<?php echo esc_attr( $instance['button_text'] ) ?>">
		</p>
		<?php
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['placeholder'] = strip_tags( $new_instance['placeholder'] );
		$instance['button_text'] = $new_instance['button_text'];
		$instance['form_class'] = strip_tags( $new_instance['form_class'] );
		return $instance;
	}

}

add_action( 'widgets_init', function() {
	register_widget( 'BS_Navbar_Subscribe_Widget' );
} );
