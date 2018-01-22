<?php

// include
require '../_inc/config.php';

if ( ! logged_in() ) {
	redirect( '/' );
}


// validate
if ( ! isset( $_POST['tag_id'] ) ) {
	redirect( 'back' );
}

$tag_id = filter_input( INPUT_POST, 'tag_id', FILTER_VALIDATE_INT );

if ( is_admin() || is_mod() ) {
	$result = delete_tag( $tag_id );
} else {
	flash()->error( "what are you trying to pull here" );
	redirect( 'back' );
}

if ( $result ) {
	flash()->success( 'tag deleted' );
	redirect( '/' );
}

flash()->warning( 'sorry girl' );
redirect( 'back' );
