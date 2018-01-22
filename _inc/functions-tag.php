<?php
/**
 * Get tag
 *
 * Tries to fetch a DB item based on $_GET['id']
 * Returns false if unable
 *
 * @param  integer    id of the tag to get
 * @param  bool|true $auto_format whether to format all the posts or not
 *
 * @return object    or false
 * 
 */
function get_tag( $id = 0, $auto_format = false ) {
	// we have no id
	if ( ! $id && ! $id = segment( 2 ) ) {
		return false;
	}

	// $id must be integer
	if ( ! filter_var( $id, FILTER_VALIDATE_INT ) ) {
		return false;
	}

	global $db;

	$query = $db->prepare( create_tag_query( "WHERE p.id = :id" ) );

	$query->execute( [ 'id' => $id ] );

	if ( $query->rowCount() === 1 ) {
		$result = $query->fetch( PDO::FETCH_ASSOC );

		if ( $auto_format ) {
			$result = format_post( $result, true );
		} else {
			return (object) $result;
		}
	} else {
		$result = false;
	}

	return $result;
}


/**
 * Get tags
 *
 * Grabs all tags from the DB
 * And maybe formats them too, depending on $auto_format
 *
 * @return object
 */
function get_tags( $auto_format = true ) {
	global $db;

	$query = $db->query( "
		SELECT * FROM tags
	" );

	if ( $query->rowCount() ) {
		$results = $query->fetchAll( PDO::FETCH_ASSOC );

		if ( $auto_format ) {
			$results = array_map( 'format_tag', $results );
		}
	} else {
		$results = [ ];
	}

	return (object) $results;
}


/**
 * Format tag
 *
 * Cleans up, sanitizes, formats and generally prepares DB post for displaying
 *
 * @param  $tag
 * @param  $format_text
 *
 * @return object [id, name, link, editlink, deletelink]
 */
function format_tag( $tag, $format_text = false ) {

	// trim dat shit
	$tag = array_map( 'trim', $tag );

	// clean it up
	$tag['id']   = plain( $tag['id'] );
	$tag['name'] = plain( $tag['tag'] );
	unset($tag['tag']);

	// create link to user [ /post/:id/:slug ]
	$tag['link'] = get_tag_link( $tag['name'] );
	$tag['editlink'] = get_tag_edit_link( $tag['name'] );
	$tag['deletelink'] = get_tag_delete_link( $tag['name'] );

	return (object) $tag;
}


/**
 * Create tags query
 *
 * @param string $where
 *
 * @return string
 */
function create_tag_query( $where = '' ) {
	$query = "
		SELECT * FROM tags t
			LEFT JOIN posts_tags pt ON t.id = pt.tag_id
			LEFT JOIN posts p ON p.id = pt.post_id
	";

	if ( $where ) {
		$query .= $where;
	}

	$query .= " GROUP BY p.id";
	$query .= " ORDER BY p.created_at DESC";

	return trim( $query );

}

/**
 * zmeni znaky + na medzery z daneho segmentu
 * 
 * @param int $index
 *
 * @return string
 */
function segment_tag_decode($index) {
	return str_replace('+', ' ', segment($index));
}

/**
 * get tag link [/tag/id] or [/tag/name]
 * @param $tag
 * @param string $type
 *
 * @return mixed|string
 */
function get_tag_link( $tag, $type = 'tag' ) {

	if ( ! is_string( $tag ) ) {
		if ( is_object( $tag ) ) {
			$id = $tag->id;
		} else {
			$id = $tag['id'];
		}
		$link = BASE_URL . "/$type/$id";

	} else {
		$tag = str_replace(' ', '+', $tag);
		$link = BASE_URL . "/$type/$tag";
	}
	$link = filter_var( $link, FILTER_SANITIZE_URL );

	return $link;
}

/**
 * create add tag link
 * @param string $type
 *
 * @return string
 */
function get_tag_add_link( $type = 'add_tag' ) {
	$link = BASE_URL . "/$type";

	return $link;
}

/**
 * create tag edit link
 * @param $tag
 *
 * @return mixed|string
 */
function get_tag_edit_link( $tag ) {
	return get_tag_link( $tag, 'edit_tag' );
}

/**
 * create tag delete link
 * @param $tag
 *
 * @return mixed|string
 */
function get_tag_delete_link( $tag ) {
	return get_tag_link( $tag, 'delete_tag' );
}


/**
 * diff tags
 * porovnava tagy prispevku
 * vrati true ak su rozdielne
 * @param array $arr1
 * @param array $arr2
 *
 * @return bool
 */
function diff_tags( $arr1, $arr2 ) {

	$res1 = count( array_diff( $arr1, $arr2 ) );
	$res2 = count( array_diff( $arr2, $arr1 ) );

	if ( $res1 || $res2 ) {
		//arrays is not identically
		return true;
	} else {
		// arrays is identically
		return false;
	}
}

/**
 * Insert tags to post
 *
 * @param array $tags from form
 * @param int $post_id from form
 *
 * @return int
 */
function insert_tags_to_post( $tags, $post_id = 0 ) {

	global $db;
	
	

	if ( isset( $tags ) && $tags = array_filter( $tags ) ) {
		// kontrola ci je tag v tabulke tags
		foreach ($tags as $tag) {

			// ak nie je v tabulke tags tak sa tam vlozi
			if (!is_tag($tag)) {
				$query = $db->prepare("
					INSERT INTO tags (tag)
					VALUES (:tag)
				");
				$query->execute([
					'tag' => $tag
				]);
			}
		}
		
		$insert_tags = $db->prepare( "
				INSERT INTO posts_tags
				VALUES (:post_id, :tag_id)
			" );
		
		$tags_id = get_tags_id($tags);
		
		foreach ( $tags_id as $tag_id ) {

			$insert_tags->execute( [
				'post_id' => $post_id,
				'tag_id'  => $tag_id
			] );
		}

		return $insert_tags->rowCount();
	}
}

/**
 * Vrati true ak je tag zapisany v tabulke tags
 * ak je $get_id 1 funkcia vrati id tagu
 *
 * @param string $tag
 * @param int $get_id
 *
 * @return bool | int
 */
function is_tag($tag, $get_id = 0) {

	$tag = trim( $tag );
	$tag = filter_var( $tag, FILTER_SANITIZE_STRING );

	global $db;

	$query = $db->prepare("
		SELECT id FROM tags
		WHERE tag = :tag
	");
	
	$query->execute([
		'tag' => $tag
	]);
	
	$id = $query->fetch(PDO::FETCH_COLUMN);
	$row = $query->rowCount();
	
	if ($row) {
		if ($get_id == 1) {
			return $id;
		}
		return true;
	}
	return false;
}

/**
 * Add tag to db tab
 *
 * @param string $tag
 *
 * @return int
 */
function add_tag( $tag ) {

	$tag = trim( $tag );
	$tag = filter_var( $tag, FILTER_SANITIZE_STRING );

	global $db;

	if ( isset( $tag ) && $tag != '' ) {
		$add_tag = $db->prepare( "
				INSERT INTO tags (tag)
				VALUES (:tag)
			" );

		$add_tag->execute( [
			'tag' => $tag
		] );

		if ( $add_tag->rowCount() ) {
			return true;
		}
	}

	return false;
}

/**
 * edit tag
 *
 * @param int $tag_id
 * @param string $tag
 *
 * @return bool
 */
function edit_tag( $tag_id, $tag ) {

	$tag    = trim( $tag );
	$tag    = filter_var( $tag, FILTER_SANITIZE_STRING );
	$tag_id = filter_var( $tag_id, FILTER_VALIDATE_INT );

	global $db;

	if ( isset( $tag_id ) && is_int( $tag_id ) ) {
		$query = $db->prepare( "
				UPDATE tags
				SET tag = :tag
				WHERE id = :tag_id
			" );

		$query->execute( [
			'tag_id' => $tag_id,
			'tag'    => $tag
		] );

		if ( $query->rowCount() ) {
			return true;
		}
	}

	return false;
}

/**
 * delete tag
 *
 * @param int $tag_id
 *
 * @return bool
 */
function delete_tag( $tag_id ) {

	$tag_id = filter_var( $tag_id, FILTER_VALIDATE_INT );

	global $db;

	if ( isset( $tag_id ) && is_int( $tag_id ) ) {
		$query = $db->prepare( "
				DELETE FROM tags
				WHERE id = :tag_id
			" );

		$query->execute( [
			'tag_id' => $tag_id
		] );

		if ( $query->rowCount() ) {

			$query = $db->prepare( "
				DELETE FROM posts_tags
				WHERE tag_id = :tag_id
			" );

			$query->execute( [
				'tag_id' => $tag_id
			] );

			if ( $query->rowCount() ) {
				flash()->info('tag sa nepoužíval');
			}
				return true;
		}
	}

	return false;
}

/**
 * Get tag_id
 *
 * @param string $tag
 *
 * @return bool| (object) int tag_id
 */
function get_tag_id( $tag ) {

	$tag = trim( $tag );
	$tag = filter_var( $tag, FILTER_SANITIZE_STRING );

	if ( $tag == '' ) {
		return false;
	}

	global $db;

	$query = $db->prepare( "
		SELECT t.id FROM tags t
		WHERE t.tag = :tag
	" );

	$query->execute( [ 'tag' => $tag ] );

	if ( ! $query->rowCount() ) {
		return false;
	}
	$tag_id = $query->fetch( PDO::FETCH_OBJ );

	return $tag_id->id;

}

/**
 * Get tags_id
 *
 * @param array $tags
 *
 * @return bool| array tag_id
 */
function get_tags_id( $tags ) {

	if (empty($tags)) {
		return false;
	}

	if (is_string($tags)) {
		$tags = explode(',', $tags);
		$tags = array_map('trim', $tags);
	}

	global $db;
	$i = 0;
	$result = [];

	$query = $db->prepare( "
		SELECT t.id FROM tags t
		WHERE t.tag = :tag
	" );

	foreach ($tags as $tag) {
		$tag = trim($tag);
		if ( $tag == '' ) {
			return false;
		}
		$query->execute( [ 'tag' => $tag ] );
		$result[$i] = $query->fetch( PDO::FETCH_COLUMN );
		$i++;
	}

	if ( ! $query->rowCount() ) {
		return false;
	}
	return $result;
}

/**
 * vrati obsah db tags
 * @return array|bool
 */
function get_all_tags() {
	
	global $db;
	
	$query = $db->prepare("
		SELECT * FROM tags
	");

	$query->execute();
	
	$result = $query->fetchAll(PDO::FETCH_KEY_PAIR);
	
	if ($query->rowCount()) {
		return $result;
	}
	return false;
}


function add_tag_from_post($post_tags) {

	$all_tags = get_all_tags();

	$new_tags = array_filter($post_tags, $all_tags);
	return $new_tags;

}

