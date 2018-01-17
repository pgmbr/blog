<?php

	// include
require '../_inc/config.php';

if ( ! logged_in() ) {
	redirect( '/' );
}


// validate
$post_id = filter_input( INPUT_POST, 'post_id', FILTER_VALIDATE_INT );

// id is required and has to be int
if ( ! $post_id || ! $post = get_post( $post_id, false ) ) {
	flash()->error( 'no such post' );
	redirect( 'back' );
}

if ( ! can_edit( $post ) ) {
	flash()->error( "what are you trying pull here" );
	redirect( 'back' );
}

// add new title and text
$post = get_post( $post_id, false );

$delete = $db->prepare( "
		DELETE FROM posts
		WHERE id = :post_id
	" );

$delete->execute( [
	'post_id' => $post_id
] );

if ( ! $delete ) {
	flash()->warning( 'sorry bitch' );
	redirect( 'back' );
}

$query = $db->prepare( "
						DELETE FROM posts_tags
						WHERE post_id = :post_id
				" );

$query->execute( [
	'post_id' => $post_id
] );

flash()->success( 'goodbye, sweet post' );
redirect( '/' );

