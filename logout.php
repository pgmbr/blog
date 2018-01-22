<?php
/**
 * Created by PhpStorm.
 * User: gmbr
 * Date: 7.1.18
 * Time: 2:28
 */
require_once '_inc/config.php';

/*if (!logged_in()) {
	redirect('/');
}*/

do_logout();
flash()->success( 'Bye, bye' );
redirect( '/' );