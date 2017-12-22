<?php

class BS_Navbar_Menu_Widget extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		parent::__construct(
						// id_base
						'bs_navbar_menu',
						// name
						'BS Navbar Menu',
						// widget_options
						array( 'description' => 'Bootstrap Navbar Menu Box' ),
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
		$term = get_term( $instance['menu'] );
		$menu_class = !empty( $instance['menu_class'] ) ? $instance['menu_class'] : '';

		require_once realpath( JPTT_BASEPATH . '/includes/class-walker-nav-menu-bootstrap.php' );
		wp_nav_menu( array(
				'menu' => $term->term_id,
				'container' => '',
				'menu_class' => 'nav navbar-nav ' . $menu_class,
				'walker' => new Walker_Nav_Menu_Bootstrap()
		) );
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		$defaults = array(
				'menu' => '',
				'menu_class' => '',
		);
		$instance = wp_parse_args( $instance, $defaults );
		$terms = get_terms( 'nav_menu' );
		$menu = $instance['menu'];
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'menu' ); ?>">Menu:</label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'menu' ); ?>" name="<?php echo $this->get_field_name( 'menu' ); ?>">
					<?php
					foreach ( $terms as $term ) {
						printf( '<option value="%d" %s>%s</option>', $term->term_id, selected( $menu, $term->term_id, false ), $term->name );
					}
					?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'menu_class' ); ?>">Menu class:</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'menu_class' ); ?>" name="<?php echo $this->get_field_name( 'menu_class' ); ?>" value="<?php echo esc_attr( $instance['menu_class'] ) ?>">
			<br>
			<small>navbar-right, navbar-left or custom class</small>
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
		$instance['menu'] = strip_tags( $new_instance['menu'] );
		$instance['menu_class'] = strip_tags( $new_instance['menu_class'] );
		return $instance;
	}

}

add_action( 'widgets_init', function() {
	register_widget( 'BS_Navbar_Menu_Widget' );
} );
