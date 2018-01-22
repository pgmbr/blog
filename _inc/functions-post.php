<?php
	/**
	 * Get Post
	 *
	 * Tries to fetch a DB item based on $_GET['id']
	 * Returns false if unable
	 *
	 * @param  integer    id of the post to get
	 * @param  bool|true  $auto_format  whether to format all the posts or not
	 * @return DB item    or false
	 */
	function get_post( $id = 0, $auto_format = true )
	{
		// we have no id
		if ( !$id && !$id = segment(2) ) {
			return false;
		}

		// $id must be integer
		if ( ! filter_var( $id, FILTER_VALIDATE_INT ) ) {
			return false;
		}

		global $db;

		$query = $db->prepare( create_posts_query( "WHERE p.id = :id" ) );

		$query->execute([ 'id' => $id ]);

		if ( $query->rowCount() === 1 )
		{
			$result = $query->fetch(PDO::FETCH_ASSOC);

			if ( $auto_format ) {
				$result = format_post( $result, true );
			} else {
				return (object) $result;
			}
		}
		else
		{
			$result = false;
		}

		return $result;
	}



	/**
	 * Get Posts
	 *
	 * Grabs all posts from the DB
	 * And maybe formats them too, depending on $auto_format
	 *
	 * @param  bool|true  $auto_format  whether to format all the posts or not
	 * @return array
	 */
function get_posts( $auto_format = true )
	{
		global $db;

		$query = $db->query( create_posts_query() );

		if ( $query->rowCount() )
		{
			$results = $query->fetchAll(PDO::FETCH_ASSOC);

			if ( $auto_format ) {
				$results = array_map('format_post', $results);
			}
		}
		else
		{
			$results = [];
		}

		return $results;
	}

/**
 * Get Posts by user
 *
 * Tries to fetch a DB item based on $_GET['id']
 * Returns false if unable
 *
 * @param  int    user of the post to get
 * @param  bool|true $auto_format whether to format all the posts or not
 *
 * @return DB item    or false
 */
function get_posts_by_user( $user_id = 0, $auto_format = true ) {
	// we have no id
	if ( ! $user_id ) {
		flash()->warning( "User don't exist" );

		return [ ];
	}

	global $db;

	$query = $db->prepare( create_posts_query( "WHERE u.id = :uid" ) );

	$query->execute( [ 'uid' => $user_id ] );

	if ( $query->rowCount() ) {
		$results = $query->fetchAll( PDO::FETCH_ASSOC );

		if ( $auto_format ) {
			$results = array_map( 'format_post', $results );
		}
	} else {
		$results = [ ];
	}

	return $results;
}

/**
 * Get Posts by tag
 *
 * Tries to fetch a DB item based on $_GET['id']
 * Returns false if unable
 *
 * @param  string    tag name of the post to get
 * @param  bool|true $auto_format whether to format all the posts or not
 *
 * @return DB item    or false
 */
function get_posts_by_tag( $tag = '', $auto_format = true ) {
	// we have no id
	if ( ! $tag && ! $tag = segment( 2 ) ) {
		return false;
	}

	$tag = urldecode( $tag );
	$tag = filter_var( $tag, FILTER_SANITIZE_STRING );

	global $db;

	$query = $db->prepare( create_posts_query( "WHERE t.tag = :tag" ) );

	$query->execute( [ 'tag' => $tag ] );

	if ( $query->rowCount() ) {
		$results = $query->fetchAll( PDO::FETCH_ASSOC );

		if ( $auto_format ) {
			$results = array_map( 'format_post', $results );
		}
	} else {
		$results = [ ];
	}

	return $results;
}


/**
 * Get Posts by user
 *
 * Tries to fetch a DB item based on $_GET['id']
 * Returns false if unable
 *
 * @param  string    tag of the post to get
 * @param  bool|true $auto_format whether to format all the posts or not
 *
 * @return DB item    or false
 */
function get_posts_by_user2( $uid, $auto_format = true ) {
	// we have no id
	if ( ! $uid && ! $uid = segment( 2 ) ) {
		return false;
	}

	$uid = urldecode( $uid );
	$uid = filter_var( $uid, FILTER_SANITIZE_STRING );

	global $db;

	$query = $db->prepare( "
		SELECT p.*
		    FROM posts p
		    LEFT JOIN users u ON (p.user_id = u.id)
		    WHERE u.id = :uid
		    ORDER BY p.created_at DESC		    	
	" );

	$query->execute( [ 'uid' => $uid ] );

	if ( $query->rowCount() ) {
		$results = $query->fetchAll( PDO::FETCH_ASSOC );

		if ( $auto_format ) {
			$results = array_map( 'format_post', $results );
		}
	} else {
		$results = [ ];
	}

	return $results;
}


/**
 * Format Post
 *
 * Cleans up, sanitizes, formats and generally prepares DB post for displaying
 *
 * @param  $post
 * @param  $format_text
 *
 * @return object
 */
function format_post( $post, $format_text = false ) {

	// trim dat shit
	$post = array_map( 'trim', $post );

	// clean it up
	$post['title'] = plain( $post['title'] );
	$post['text']  = plain( $post['text'] );
	$post['tags']  = $post['tags'] ? explode( '~||~', $post['tags'] ) : [ ];
	$post['tags']  = array_map( 'plain', $post['tags'] );
	
	// create string of tags
	$post['strtags'] = implode(', ', $post['tags']);
	$post['strtags'] = trim($post['strtags'], ' ,');

	// create link to tag [ /tag/id ]
	if ( $post['tags'] ) {
		foreach ( $post['tags'] as $tag ) {
			$post['tag_links'][ $tag ] = BASE_URL . '/tag/' . urlencode( $tag );
			$post['tag_links'][ $tag ] = filter_var( $post['tag_links'][ $tag ], FILTER_SANITIZE_URL );
		}
	}

	// create link to post [ /post/:id/:slug ]
	$post['link'] = get_post_link( $post );

	// let's go on some dates
	$post['timestamp'] = strtotime( $post['created_at'] );
	$post['time']      = str_replace( ' ', '&nbsp', date( 'j M Y, G:i', $post['timestamp'] ) );
	$post['date']      = date( 'Y-m-d', $post['timestamp'] );

	// don't tease me, bro
	$post['teaser'] = word_limiter( $post['text'], 40 );

	// format text
	if ( $format_text ) {
		$post['text'] = filter_url( $post['text'] );
		$post['text'] = add_paragraphs( $post['text'] );
	}

	$post['email']     = filter_var( $post['email'], FILTER_SANITIZE_EMAIL );
	$post['user_link'] = BASE_URL . '/user/' . $post['user_id'];
	$post['user_link'] = filter_var( $post['user_link'], FILTER_SANITIZE_URL );

	return (object) $post;
}

/**
 * Create posts query
 *
 * @param string $where
 *
 * @return string
 */
function create_posts_query( $where = '' ) {
	$query = "
		SELECT p.*, u.username, u.email, u.role, GROUP_CONCAT(t.tag SEPARATOR '~||~') AS tags
	    FROM posts p
	    LEFT JOIN posts_tags pt ON (p.id = pt.post_id)
	    LEFT JOIN tags t ON (t.id = pt.tag_id)
	    LEFT JOIN users u ON (u.id = p.user_id)
	";

	if ( $where ) {
		$query .= $where;
	}

	$query .= " GROUP BY p.id";
	$query .= " ORDER BY p.created_at DESC";

	return trim( $query );

}

function get_post_link( $post, $type = 'post' ) {

	if ( is_object( $post ) ) {
		$id   = $post->id;
		$slug = $post->slug;
	} else {
		$id   = $post['id'];
		$slug = $post['slug'];
	}

	$link = BASE_URL . "/$type/$id";

	if ( $type === 'post' ) {
		$link .= "/$slug";
	}

	$link = filter_var( $link, FILTER_SANITIZE_URL );

	return $link;
}

function get_edit_link( $post ) {
	return get_post_link( $post, 'edit' );
}

function get_delete_link( $post ) {
	return get_post_link( $post, 'delete' );
}

function get_author_link( $post ) {

	if ( is_object( $post ) ) {
		$user_id = $post->user_id;
	} else {
		$user_id = $post['user_id'];
	}

	$link = BASE_URL . "/user/$user_id";

	$link = filter_var( $link, FILTER_SANITIZE_URL );

	return $link;
}

function get_author( $post ) {

	if ( is_object( $post ) ) {
		$user_id = $post->user_id;
	} else {
		$user_id = $post['user_id'];
	}

	global $auth;

	$user = $auth->getUser( $user_id );

	return $user['email'];
}

function get_author_uid( $post ) {

	if ( is_object( $post ) ) {
		$user_id = $post->user_id;
	} else {
		$user_id = $post['user_id'];
	}

	global $auth;

	$user = $auth->getUser( $user_id );

	return $user['uid'];
}

function get_post_tags( $post_id = 0 ) {

	global $db;

	$query = $db->query( "
		SELECT * FROM tags
	" );

	$results = $query->rowCount() ? $query->fetchAll( PDO::FETCH_OBJ ) : [ ];

	if ( $post_id ) {
		$query = $db->prepare( "
			SELECT t.id FROM tags t
			JOIN posts_tags pt ON t.id = pt.tag_id
			WHERE pt.post_id = :pid
		" );

		$query->execute( [
			'pid' => $post_id
		] );

		if ( $query->rowCount() ) {

			$tags_for_post = $query->fetchAll( PDO::FETCH_COLUMN );

			foreach ( $results as $key => $tag ) {
				if ( in_array( $tag->id, $tags_for_post ) ) {
					$results[ $key ]->checked = true;
				}
			}
		}
	}

	return $results;
}

/**
 * Validate post
 *
 * Sanitize and Validate
 *
 * @return array|bool [$post_id, $title, $text, $tags, $tagsinput]
 */
function validate_post() {


	$title = filter_input( INPUT_POST, 'title', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES );
	$text  = filter_input( INPUT_POST, 'text', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES );
	$tags  = filter_input( INPUT_POST, 'tags', FILTER_VALIDATE_INT, FILTER_REQUIRE_ARRAY );
	$tagsinput = filter_input(INPUT_POST, 'tagsinput', FILTER_SANITIZE_STRING);
	$tagsinput = explode(',', $tagsinput);
	$tagsinput = array_map('trim', $tagsinput);

	if (!empty($tagsinput)) {
		
	}

	if ( isset( $_POST['post_id'] ) ) {
		$post_id = filter_input( INPUT_POST, 'post_id', FILTER_VALIDATE_INT );

		// id is required and has to be int
		if ( ! $post_id ) {
			flash()->error( 'what are you trying to pull here' );
		}
	} else {
		$post_id = false;
	}


	// title is required
	if ( ! $title = trim( $title ) ) {
		flash()->error( "you forgot your title dummy" );
	}

	// text is required
	if ( ! $text = trim( $text ) ) {
		flash()->error( 'you forgot your text dummy' );
	}

	// if we have error messages, validation didn't well
	if ( flash()->hasMessages() ) {
		$_SESSION['form_data'] = [
			'title' => $title,
			'text'  => $text,
			'tags'  => $tags ?: [ ]
		];

		return false;
	}

	return compact(
		'post_id', 'title', 'text', 'tags', 'tagsinput',
		$post_id, $title, $text, $tags, $tagsinput
	);
}

/**
 * Get tags for post
 * vracia ciselne hodnoty tagov priradenych k postu
 *
 * @param int $post_id - cislo postu
 * @param int $type - ak je 'string' vracia hodnoty pola ako stringy, inak int
 *
 * @return array|bool
 */
function get_tags_by_post( $post_id, $type = 0 ) {

	global $db;

	if ( $post_id ) {

		if ($type === 'string') {

			$query = $db->prepare("
				SELECT t.tag FROM posts_tags pt
				JOIN tags t ON t.id = pt.tag_id
				WHERE pt.post_id = :post_id
			");

			$query->execute( [
				'post_id' => $post_id
			] );
			$result = $query->fetchAll( PDO::FETCH_COLUMN );
			// $result = array_map('strval', $result);

		} else {
			$query = $db->prepare( "
				SELECT tag_id FROM posts_tags
				WHERE post_id = :post_id
			" );

			$query->execute( [
				'post_id' => $post_id
			] );
			$result = $query->fetchAll( PDO::FETCH_COLUMN );

		}



		return $result;
	}

	return false;
}

