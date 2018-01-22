<?php

// include
require '../_inc/config.php';

if ( ! logged_in() ) {
	redirect( '/' );
}


// validate
$user_id = filter_input( INPUT_POST, 'user_id', FILTER_VALIDATE_INT );

// id is required and has to be int
if ( ! $user_id || ! $user = get_user( $user_id ) ) {
	flash()->error( 'no such post' );
	redirect( 'back' );
}

if ( ! can_edit( $user ) ) {
	flash()->error( "what are you trying pull here" );
	redirect( 'back' );
}
die();
// add new title and text
$user = get_user( $user_id );

$delete = $db->prepare( "
		UPDATE users
		WHERE id = :user_id
	" );

$delete->execute( [
	'user_id' => $user_id
] );

if ( ! $delete ) {
	flash()->warning( 'sorry bitch' );
	redirect( 'back' );
}

flash()->success( 'goodbye, sweet post' );
redirect( '/' );

