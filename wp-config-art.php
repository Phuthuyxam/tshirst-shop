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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'thaocanart' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '|!YM1^?/MgA;gC|[ac^6va1ibVanZw|0s!1R.dMz8:(>A5>PdS}YgH`DkfG*Ft%N');
define('SECURE_AUTH_KEY',  '(~xD+E~~|RkKD?Ajch8X^}!:gZ3f;}.{{Hvh4DJp`4jIM28|t_tYjn1kwW8*BD&;');
define('LOGGED_IN_KEY',    '1G1B)Cy-Ed_dQt*A-8*jCCQ)GMZ@YxSELmy1Ju9PBnynhi2sKQ%K8S1_Ja2IoW;1');
define('NONCE_KEY',        'bdiY9+kqE1pTDf27QEizHT9Y*-Aq%j|!aT=$$bj5`G|}DYPm|)7SV*R6G_K@v+Y*');
define('AUTH_SALT',        'm?U+OAHj(5+8d-jA#aI*+F<cRS_8=RS;45E`Q@O3@`+8S bVo~BrDcE&>wnu#R87');
define('SECURE_AUTH_SALT', 'iDgqR4K@m$[5$Ij$DUaq9T~SR*u/Nn@*U,[LJh_7voa_sg(X-TJx6~;fa<+X+GZT');
define('LOGGED_IN_SALT',   '1rCb[t7Fp0a+o1%md-zlTV<WJShquqXJZmZc0y*dt*(ZL!]pKiWcxy+uQYq.wqBW');
define('NONCE_SALT',       '9uC5EZZ?{L--*nR-2m_)J}H5IHyC:|Vx>_u-PKl]HXX8w.$%QHUa,SRr-ct_h]A;');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
