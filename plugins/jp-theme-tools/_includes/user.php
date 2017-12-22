<?php

/**
 * Retorna TRUE si el usuario es autor del post
 * @param type $post_id
 * @param type $user_id
 * @return boolean
 */
function is_post_author( $post_id = NULL, $user_id = NULL ) {
	$post_id = ((int) $post_id)? : get_the_ID();
	$user_id = ((int) $user_id)? : get_current_user_id();

	if ( !$user_id && !$post_id ) {
		return FALSE;
	}

	$post = get_post( $post_id );

	return (bool) ( $user_id == $post->post_author );
}
