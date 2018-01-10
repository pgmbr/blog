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

		$query = $db->prepare("
			SELECT p.*, GROUP_CONCAT(t.tag SEPARATOR '~||~') AS tags
		    FROM posts p
		    LEFT JOIN posts_tags pt ON (p.id = pt.post_id)
		    LEFT JOIN tags t ON (t.id = pt.tag_id)
		    WHERE p.id = :id
		    GROUP BY p.id
		");

		$query->execute([ 'id' => $id ]);

		if ( $query->rowCount() === 1 )
		{
			$result = $query->fetch(PDO::FETCH_ASSOC);

			if ( $auto_format ) {
				$result = format_post( $result );
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

		$query = $db->query("
			SELECT p.*, GROUP_CONCAT(t.tag SEPARATOR '~||~') AS tags
		    FROM posts p
		    LEFT JOIN posts_tags pt ON (p.id = pt.post_id)
		    LEFT JOIN tags t ON (t.id = pt.tag_id)
		    GROUP BY p.id
		");

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
	 * Format Post
	 *
	 * Cleans up, sanitizes, formats and generally prepares DB post for displaying
	 *
	 * @param  $post
	 * @return object
	 */
	function format_post( $post )
	{
		// trim dat shit
		$post = array_map('trim', $post);

		// clean it up
		$post['title'] = plain( $post['title'] );
		$post['text']  = plain( $post['text'] );
		$post['tags']  = $post['tags'] ? explode('~||~', $post['tags']) : [];
		$post['tags']  = array_map('plain', $post['tags']);

		// create link to post [ /post/:id/:slug ]
		$post['link'] = BASE_URL . "/post/{$post['id']}/{$post['slug']}";
		$post['link'] = filter_var( $post['link'], FILTER_SANITIZE_URL );

		// let's go on some dates
		$post['timestamp'] = strtotime( $post['created_at'] );
		$post['time'] = str_replace( ' ', '&nbsp', date( 'j M Y, G:i', $post['timestamp'] ) );
		$post['date'] = date( 'Y-m-d', $post['timestamp'] );

		// don't tease me, bro
		$post['teaser'] = word_limiter( $post['text'], 40 );

		// format text
		$post['text'] = filter_url( $post['text'] );
		$post['text'] = add_paragraphs( $post['text'] );

		return (object) $post;
	}