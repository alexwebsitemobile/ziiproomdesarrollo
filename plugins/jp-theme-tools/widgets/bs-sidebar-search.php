<?php

class BS_Sidebar_Search_Widget extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		parent::__construct(
						// id_base
						'bs_sidebar_search',
						// name
						'BS Sidebar Search',
						// widget_options
						array( 'description' => 'Bootstrap Sidebar Search Box' ),
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
		$template = locate_template( 'jp-theme-tools/widgets/sidebar-search.php' );
		if ( empty( $template ) ) {
			$template = JPTT_BASEPATH . '/templates/widgets/sidebar-search.php';
		}
		include apply_filters( 'bs_sidebar_search_template', $template );
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		$defaults = array(
				'placeholder' => '',
				'button_text' => ''
		);
		$instance = wp_parse_args( $instance, $defaults );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'placeholder' ); ?>">Placeholder:</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'placeholder' ); ?>" name="<?php echo $this->get_field_name( 'placeholder' ); ?>" value="<?php echo $instance['placeholder'] ?>">
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
		return $instance;
	}

}

add_action( 'widgets_init', function() {
	register_widget( 'BS_Sidebar_Search_Widget' );
} );
