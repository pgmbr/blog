<?php

	// include
require '../_inc/config.php';

if ( ! logged_in() ) {
	redirect( '/' );
}


// validate
if ( ! $data = validate_post() ) {
	redirect( 'back' );
}

extract( $data );
$slug = slugify( $title );

// add new post to db
$query = $db->prepare( "
		INSERT INTO posts
			(user_id, title, text, slug)
		VALUES
			(:user_id, :title, :text, :slug)
	" );

$insert = $query->execute( [
	'user_id' => get_user()->uid,
	'title'   => $title,
	'text'    => $text,
	'slug'    => $slug
] );

if ( ! $insert ) {
	flash()->warning( 'sorry girl' );
	redirect( 'back' );
	}

// great success
$post_id = $db->lastInsertId();


// if we have tags, add them
insert_tags_to_post( $tagsinput, $post_id );

// let's visit new post
flash()->success( 'yay, new one!' );

redirect( get_post_link( [
	'id'   => $post_id,
	'slug' => $slug
] ) );
