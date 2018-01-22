<?php

// include
require '../_inc/config.php';

if ( ! logged_in() ) {
	redirect( '/' );
}


// validate
if ( ! isset( $_POST['tag'] ) ) {
	redirect( 'back' );
}

$tag = filter_input( INPUT_POST, 'tag', FILTER_SANITIZE_STRING );

if ( is_admin() || is_mod() ) {
	$result = add_tag( $tag );
} else {
	flash()->error( "what are you trying to pull here" );
	redirect( 'back' );
}


if ( $result ) {
	flash()->success( 'tag added' );
	redirect( '/' );
}

flash()->warning( 'sorry girl' );
redirect( 'back' );
