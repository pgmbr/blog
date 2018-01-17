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
// extract $post_id, $title, $text, $tags
extract( $data );

// add new title and text
if ( ! $post = get_post( $post_id, false ) ) {
	flash()->error( "no such post" );
	redirect( 'back' );
}

if ( ! can_edit( $post ) ) {
	flash()->error( "what are you trying to pull here" );
	redirect( 'back' );
}

$row_post = 0;
$row_tags = 0;

/**
 * diff tags
 */
$arr1 = $_POST['tags'];
$arr2 = get_tags_by_post( $post_id, 'string' );


if ( $post->title === $_POST['title'] && $post->text === $_POST['text'] && ! diff_tags( $arr1, $arr2 ) ) {
	flash()->warning( "You changed nothing, you fuck" );
	redirect( 'back' );
} elseif ( $post->title !== $_POST['title'] && $post->text === $_POST['text'] ) {

	$update_post = $db->prepare( "
			UPDATE  posts
			SET 
				title = :title
			WHERE 
				id = :post_id
		" );

	$update_post->execute( [
		'title'   => $title,
		'post_id' => $post_id
	] );

	$row_post = $update_post->rowCount();

} elseif ( $post->title === $_POST['title'] && $post->text !== $_POST['text'] ) {

	$update_post = $db->prepare( "
			UPDATE  posts
			SET 
				text = :text
			WHERE 
				id = :post_id
		" );

	$update_post->execute( [
		'text'    => $text,
		'post_id' => $post_id
	] );

	$row_post = $update_post->rowCount();

} elseif ( $post->title !== $_POST['title'] && $post->text !== $_POST['text'] ) {

	$update_post = $db->prepare( "
			UPDATE  posts
			SET 
				title = :title, 
				text = :text
			WHERE 
				id = :post_id
		" );

	$update_post->execute( [
		'title'   => $title,
		'text'    => $text,
		'post_id' => $post_id
	] );

	$row_post = $update_post->rowCount();


}

if ( diff_tags( $arr1, $arr2 ) ) {
	// remove all tags for this post
	$delete_post = $db->prepare( "
					DELETE FROM posts_tags
					WHERE post_id = :post_id
			" );

	$delete_post->execute( [
		'post_id' => $post_id
	] );

	// if we have tags, add them

	$row_tags = insert_tags( $tags, $post->id );
}


// redirect
if ( $row_post || $row_tags ) {
	flash()->success( 'yay, changed it!' );
	redirect( get_post_link( $post ) );
}


flash()->warning( 'sorry girl' );
	redirect('back');
