<?php

// include
require '../_inc/config.php';

if ( ! logged_in() ) {
	redirect( '/' );
}


// validate
if ( ! isset( $_POST['tag_id'] ) && ! isset( $_POST['tag'] ) ) {
	redirect( 'back' );
}

$tag_id = filter_input( INPUT_POST, 'tag_id', FILTER_VALIDATE_INT );
$tag    = filter_input( INPUT_POST, 'tag', FILTER_SANITIZE_STRING );

if ( is_admin() || is_mod() ) {
	$result = edit_tag( $tag_id, $tag );
} else {
	flash()->error( "what are you trying to pull here" );
	redirect( 'back' );
}


if ( $result ) {
	flash()->success( 'tag changed' );
	redirect( '/' );
}

flash()->warning( 'sorry girl' );
redirect( 'back' );
