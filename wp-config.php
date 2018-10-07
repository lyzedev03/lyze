<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'locallyzDBgoazl');

/** MySQL database username */
define('DB_USER', 'locallyzDBgoazl');

/** MySQL database password */
define('DB_PASSWORD', '8hNB0qfQI3');

/** MySQL hostname */
define('DB_HOST', '127.0.0.1');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'taa]A2LxNY>B8R!@0cvo8NUj3IBy},3fzr^Ngn$IXQ^<7j$u,Ujq*PeXm6Eq*y{');
define('SECURE_AUTH_KEY',  'i+Pie]DKa#91Ht#~;aWl1HOd:C5O-[_5hdp9SVo4JCR!0[Co@wGVcrBQJY>70Fv|@');
define('LOGGED_IN_KEY',    'crFBR!47Q$,7jfrBQMY>7ET.2{Aq*yIXQfELa]A2Hx<*Pebm6LSi1LDS~+]Wmix');
define('NONCE_KEY',        ':rFcUk4JBR!z>Yov,Ujcr7QFY,^0cr${XqjyIXQf>7jyetAPHa<6;Hu.+LbhxHWP');
define('AUTH_SALT',        'Gs[dFY>}Fvs|VkdsCJY,70Fr^z}YrkzJQf{E7M$,7jyrBQXm6LET.3{Aq^y<XetD');
define('SECURE_AUTH_SALT', 'g00Gw[!1gw@NcUk4JBR@0>8k@^3jcr7QJY,70Fr,{AmjyETQf{E7My{;Huq*LbXm2');
define('LOGGED_IN_SALT',   'gzNJZ[8J$}Fvr,URg0JU,73n^$Qnj3MXmA6P*^fyuEXm6TL*2;e+yLep9SO_92l');
define('NONCE_SALT',       '{qLM*2Eu*2iexHaX]DAu<W#95l*.Wpm9Th15O~~1hh+OZsCCR!_5l~-OhsFJc0:J');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);
define('FS_METHOD', 'direct');

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
