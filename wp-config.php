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
define('DB_NAME', 'lyzeDBdmad');

/** MySQL database username */
define('DB_USER', 'lyzeDBdmad');

/** MySQL database password */
define('DB_PASSWORD', 'urXgDPRaA');

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
define('AUTH_KEY',         '_aWH#xhWaK9]pdOSG1whSC15|-ZK8C1!hRG14G4zwgG0!vgRCF0!rcRB!rgRUJ4zn');
define('SECURE_AUTH_KEY',  '5xhSD9#wtdKG:.*qXTE{+yePL2;*mXTA6<teaH2;*miT96_tpWHD;+liOL5_~pWHD');
define('LOGGED_IN_KEY',    'X^nQ*jXI<+mPA*uTH2xmLA*qiH]+qPD.tiH6+ma9;teSD_xWK5-pOD:thS1_wVK5');
define('NONCE_KEY',        't5~hWH#-aK9~pdD:_hSG|-lK8[odO:@sRC0wkJ4[oZN}@rRF00^vUJ3znY7}$cQB^');
define('AUTH_SALT',        'X^jX6{qbP*ueeTD;maA]*ePD_tiS2_xWH1#laK]-pZ9[~dOC:shG1|wVG4|kVK4z');
define('SECURE_AUTH_SALT', 't5xaH:-hO5#sZK1_oVG:-hO8|sdK0!oVG}@gR8>vcN4,rYJ0@nYF}@kRB>zgN7,vc');
define('LOGGED_IN_SALT',   'T<iL2.qxeP6#taL2_pWD;-hS9]wdO5#tZK1~lSC[-hO8|sdK4!oVG}zkR8[vcNUF}');
define('NONCE_SALT',       'E{*yqibXPIA2;<*xqieXPHA2;<*xqieXPHA6;{.+umiaTLEA2].+tqiaTPHA2;#*x');

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
