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
define( 'DB_NAME', 'eec5tyug8hxutsk4' );

/** MySQL database username */
define( 'DB_USER', 'eec5tyug8hxutsk4' );

/** MySQL database password */
define( 'DB_PASSWORD', 'eec5tyug8hxutsk4' );

/** MySQL hostname */
define( 'DB_HOST', 'f2fbe0zvg9j8p9ng.cbetxkdyhwsb.us-east-1.rds.amazonaws.com' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'l/}+nWy}z0!]<4pFbf_ps7Me 90$~6M<wle}098h#?z}tbAaKzD`%fNcu!]|/g?j' );
define( 'SECURE_AUTH_KEY',  ']a_v3O9qp2?J`Ac*.+x&Kf)KQr+P2JXi=e8&$PY2]PCmNqly[u:z[E(9pyy:1~~g' );
define( 'LOGGED_IN_KEY',    'QVK<_(+}ET*X|EKLho?~btHAusCZNe.V[bJ^ u+Mkld`OIq@voQLc~kYEfy|!i_1' );
define( 'NONCE_KEY',        '1QUjy[<ZqS8kPaF`T;=zcIf%Xy] tZi!,~70BjZhw4DuAf~mEInM1#VKsWNrDy>+' );
define( 'AUTH_SALT',        '4~bSjNpFRtO)Jwbcju&&8;i/}?UPb->MJ++}:`Y$H JI{gkxA:FK%O^s{IHI sk@' );
define( 'SECURE_AUTH_SALT', ')(.6qeiUnrn0<<I FycUt+1)_/X),/)[npkg* (r(!jb@mgWBO`<|G^gd1(<H&dB' );
define( 'LOGGED_IN_SALT',   '4ek~Y]t60C_]v7M=2@;UJkEpmsG>I1)($.1vcSDWv;luqGZ9-wPuJEt;e13wewci' );
define( 'NONCE_SALT',       'Y=6!:$>uaVDLM}VubCOdF;aRTh-;DN:-f-RL1!O8a_3ZA~lNeojJx|8<*%9%#0>L' );

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
