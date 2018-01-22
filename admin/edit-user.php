<?php

// include
require '../_inc/config.php';


// var_dump( $_POST );

if ( ! logged_in() ) {
	redirect( '/' );
}


// validate [$user_id, $username, $email, $role]
if ( ! $data = validate_user() ) {
	redirect( 'back' );
}
// extract [$user_id, $username, $email, $role]
extract( $data );

// add new title and text
if ( ! $user = get_user( $user_id, false ) ) {
	flash()->error( "no such user" );
	redirect( 'back' );
}

if ( ! can_edit( $user ) ) {
	flash()->error( "what are you trying to pull here" );
	redirect( 'back' );
}
// create query
$query = "UPDATE users SET ";

$query_username = 'username = :username';
$query_email    = 'email = :email';
$query_role     = 'role = :role';

$execute = [ 'user_id' => $user_id ];

// update username
if ( $user->username !== $_POST['username'] ) {
	$query .= $query_username . ', ';
	$execute['username'] = $username;
}
if ( $user->email !== $_POST['email'] ) {
	$query .= $query_email . ', ';
	$execute['email'] = $email;
}
if ( $user->role !== $_POST['role'] ) {
	$query .= $query_role . ', ';
	$execute['role'] = $role;
}
$query = rtrim( $query, ' ,' );
$query .= " WHERE id = :user_id";


if ( $user->username === $_POST['username'] && $user->email === $_POST['email'] && $user->role === $_POST['role'] ) {
	flash()->warning( "You changed nothing, you fuck" );
	redirect( 'back' );
} else {
	$update_user = $db->prepare( $query );
	$update_user->execute( $execute );
}

if ( $update_user->rowCount() ) {
	flash()->success( 'edit user done' );
	redirect( '/' );
} else {
	flash()->warning( 'sorry, wrong write to db' );
	redirect( 'back' );
}


