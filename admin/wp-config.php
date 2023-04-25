<?php

include __DIR__ . "/load-env.php";


/** The name of the database for WordPress */

define('DB_NAME', env('DB_NAME'));
/** Database username */
define('DB_USER', env('DB_USER'));
/** Database password */
define('DB_PASSWORD', env('DB_PASSWORD'));
/** Database hostname */
define('DB_HOST', env('DB_HOST'));
/** Database charset to use in creating database tables. */
define('DB_CHARSET', env('DB_CHARSET'));
/** The database collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');


define('AUTH_KEY',         'put your unique phrase here');
define('SECURE_AUTH_KEY',  'put your unique phrase here');
define('LOGGED_IN_KEY',    'put your unique phrase here');
define('NONCE_KEY',        'put your unique phrase here');
define('AUTH_SALT',        'put your unique phrase here');
define('SECURE_AUTH_SALT', 'put your unique phrase here');
define('LOGGED_IN_SALT',   'put your unique phrase here');
define('NONCE_SALT',       'put your unique phrase here');


$table_prefix = env('DB_PREFIX');
/**
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define('AUTOMATIC_UPDATER_DISABLED', true);
/* Add any custom values between this line and the "stop editing" line. */
/* That's all, stop editing! Happy publishing. */
/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
	define('ABSPATH', __DIR__ . '/');
}
/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
