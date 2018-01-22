<?php
/**
 * Created by PhpStorm.
 * User: gmbr
 * Date: 7.1.18
 * Time: 1:27
 */
require_once 'config.php';

/**
 * @param $data
 *
 * @return bool
 */
function do_login( $data ) {

	global $config;

	return setcookie(
		$config->cookie_name,
		$data['hash'],
		$data['expire'],
		$config->cookie_path,
		$config->cookie_domain,
		$config->cookie_secure,
		$config->cookie_http
	);
}

/**
 * Is user logged in?
 * @return bool
 */
function logged_in() {

	global $auth, $config;

	return
		isset( $_COOKIE[ $config->cookie_name ] ) &&
		$auth->checkSession( $_COOKIE[ $config->cookie_name ] );
}

/**
 * @return bool
 */
function do_logout() {

	if ( ! logged_in() ) {
		return true;
	}

	global $auth, $config;

	return $auth->logout( $_COOKIE[ $config->cookie_name ] );
}

/**
 * get user data from users table
 *
 * @param int $user_id
 *
 * @return array [id, username, email, isactive, dt, role, uid]
 */
function get_user( $user_id = 0 ) {

	global $auth, $config;

	if ( ! $user_id && logged_in() ) {
		$user_id = $auth->getSessionUID( $_COOKIE[ $config->cookie_name ] );
	}

	return (object) $auth->getUser( $user_id );
}

/**
 * kontroluje prava vlastnika postu
 * na editaciu, mazanie
 *
 * @param $post cislo postu
 *
 * @return bool true = vlastnik postu
 */
function post_permition( $post ) {

	if ( get_author_uid( $post ) == get_user()->uid ) {
		return true;
	} else {
		return false;
	}
}

function can_edit( $post ) {

	if ( ! logged_in() ) {
		return false;
	}

	if ( is_object( $post ) ) {
		$post_user_id = (int) $post->user_id;
	} else {
		$post_user_id = (int) $post['user_id'];
	}

	$user = get_user();
	if ( $post_user_id === $user->uid || $user->role === 'mod' || $user->role === 'admin' ) {
		return true;
	} else {
		return false;
	}

}

function get_role( $user_id = 0 ) {
	return get_user( $user_id )->role;
}


/**
 * Get Users
 *
 * Grabs all users from the DB
 * And maybe formats them too, depending on $auto_format
 *
 * @param  bool|true $auto_format whether to format all the posts or not
 *
 * @return array
 */
function get_users( $auto_format = true ) {
	global $db;

	$query = $db->query( "
		SELECT * FROM users
	" );

	if ( $query->rowCount() ) {
		$results = $query->fetchAll( PDO::FETCH_ASSOC );

		if ( $auto_format ) {
			$results = array_map( 'format_user', $results );
		}
	} else {
		$results = [ ];
	}

	return $results;
}


/**
 * Format User
 *
 * Cleans up, sanitizes, formats and generally prepares DB post for displaying
 *
 * @param  $user
 * @param  $format_text
 *
 * @return object
 */
function format_user( $user, $format_text = false ) {

	// trim dat shit
	$user = array_map( 'trim', $user );

	// clean it up
	$user['id']   = plain( $user['id'] );
	$user['name'] = plain( $user['name'] );

	// create link to user [ /post/:id/:slug ]
	$user['link'] = get_user_link( $user );

	// let's go on some dates
	$user['timestamp'] = strtotime( $user['dt'] );
	$user['time']      = str_replace( ' ', '&nbsp', date( 'j M Y, G:i', $user['timestamp'] ) );
	$user['date']      = date( 'Y-m-d', $user['timestamp'] );

	$user['email']     = filter_var( $user['email'], FILTER_SANITIZE_EMAIL );
	$user['user_link'] = BASE_URL . '/user/' . $user['user_id'];
	$user['user_link'] = filter_var( $user['user_link'], FILTER_SANITIZE_URL );

	return (object) $user;
}

function get_user_link( $user, $type = 'user' ) {

	global $auth, $config;

	if ( is_object( $user ) ) {
		$id = $user->id;
	} else {
		$id = $user['id'];
	}

	$link = BASE_URL . "/$type/$id";

	$link = filter_var( $link, FILTER_SANITIZE_URL );

	return $link;
}

function get_edit_user_link( $user ) {
	return get_user_link( $user, 'editUser' );
}

function get_ban_user_link( $user ) {
	return get_user_link( $user, 'banUser' );
}


function get_delete_user_link( $user ) {
	return get_user_link( $user, 'deleteUser' );
}

function can_edit_user( $user ) {

	if ( ! logged_in() ) {
		return false;
	}

	if ( is_object( $user ) ) {
		$edit_user = (int) $user->id;
		if ( $edit_user === get_user()->uid || get_user()->role === 'admin' ) {
			return true;
		} else {
			return false;
		}
	} else {
		$edit_user = (int) $user['id'];
		if ( $edit_user === get_user()['uid'] || get_user()['role'] === 'admin' ) {
			return true;
		} else {
			return false;
		}
	}


}


/**
 * Validate user
 *
 * Sanitize and Validate
 *
 * @return array|bool [$user_id, $username, $email, $role]
 */
function validate_user() {


	$username = filter_input( INPUT_POST, 'username', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES );
	$email    = filter_input( INPUT_POST, 'email', FILTER_SANITIZE_EMAIL, FILTER_FLAG_NO_ENCODE_QUOTES );
	$role     = filter_input( INPUT_POST, 'role', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES );

	if ( isset( $_POST['user_id'] ) ) {
		$user_id = filter_input( INPUT_POST, 'user_id', FILTER_VALIDATE_INT );

		// id is required and has to be int
		if ( ! $user_id ) {
			flash()->error( 'what are you trying to pull here' );
		}
	} else {
		$user_id = false;
	}


	// username is required
	if ( ! $username = trim( $username ) ) {
		flash()->error( 'you forgot your username dummy' );
	}

	// email is required
	if ( ! $email = trim( $email ) ) {
		flash()->error( 'you forgot your email dummy' );
	}

	// role is required
	if ( ! $role = trim( $role ) ) {
		flash()->error( 'you forgot your role dummy' );
	}

	// if we have error messages, validation didn't well
	if ( flash()->hasMessages() ) {
		$_SESSION['form_data'] = [
			'username' => $username,
			'email'    => $email,
			'role'     => $role
		];

		return false;
	}

	return compact(
		'user_id', 'username', 'email', 'role',
		$user_id, $username, $email, $role
	);
}

/**
 * Return true if is logged user admin
 *
 * @return bool
 */
function is_admin() {

	global $auth, $config;

	$user = $auth->getUser( $auth->getSessionUID( $_COOKIE[ $config->cookie_name ] ) );

	if ( $user['role'] === 'admin' ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Return true if is logged user mod
 *
 * @return bool
 */
function is_mod() {

	global $auth, $config;

	$user = $auth->getUser( $auth->getSessionUID( $_COOKIE[ $config->cookie_name ] ) );

	if ( $user['role'] === 'mod' ) {
		return true;
	} else {
		return false;
	}
}




