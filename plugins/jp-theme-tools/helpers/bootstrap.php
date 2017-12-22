<?php

/**
 * Display the Bootstrap modal
 *
 * @staticvar int $id
 * @param array $args
 */
function bootstrap_modal( $args ) {
	static $id;

	if ( empty( $id ) ) {
		$id = 0;
	}

	$id++;

	$defaults = array(
			'id' => "bs-modal-{$id}",
			'class' => '',
			'title' => '',
			'body' => '',
			'footer' => ''
	);

	$args = wp_parse_args( (array) $args, $defaults );
	?>
	<div class="modal fade <?php echo $args['class'] ?>" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">

				<?php if ( !empty( $args['title'] ) ) : ?>
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"><?php echo $args['title'] ?></h4>
					</div>
				<?php endif ?>

				<div class="modal-body">
						<?php echo $args['body'] ?>
				</div>

				<?php if ( !empty( $args['footer'] ) ) : ?>
					<div class="modal-footer">
						<?php echo $args['footer'] ?>
					</div>
				<?php endif ?>

			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<?php
}

