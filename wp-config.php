<?php

define('FS_METHOD', 'direct');

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
define( 'DB_NAME', 'dbs491582' );

/** MySQL database username */
define( 'DB_USER', 'dbu468312' );

/** MySQL database password */
define( 'DB_PASSWORD', 'arknkWTabcdHjBquJEVW' );

/** MySQL hostname */
define( 'DB_HOST', 'db5000512203.hosting-data.io' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'r,,k/^ocgRI||HPJ#Q(+$.4h:>[W*$E&EOxaj->G(</5:0;h#R_Ts{@TJVnYUjd~' );
define( 'SECURE_AUTH_KEY',   '5^=Kf`gli&j}~BYo2uEOZid&e)u(`g7=yyU*E|q5jvEJIDI@i]5<d.]K.H->GxI;' );
define( 'LOGGED_IN_KEY',     '.~^jz*Z~O<qJ/2v&.P??bI~%z]sPwD(nRAn,xE1QPbr5^jjYVSYW=w;,x_bDv3D`' );
define( 'NONCE_KEY',         '$_T/pdtdz8qX.=gt}E6^h4pACWXlq?i#K4E!BeD0Vw|KJy2fUt]U=uZZ}cs.z%]M' );
define( 'AUTH_SALT',         'RPXKWF ZarjO<(C+abkH*u2ntKvD0MS4b|,SnkaQ#:U1ztD^u^Dx})rloxY T@+I' );
define( 'SECURE_AUTH_SALT',  'lxQn8=~(nyhZKE3rW86]?oy2X*`@1>~=z-z&b_>sN6EY]=D,,x]Vm%zo-;9JEB$B' );
define( 'LOGGED_IN_SALT',    'X1$COnc6NuuDKSY}H~RxL96b)Vb0%zd]2)Fh>[w;iN%h$JIM|dd 7jSmoq7!qH-0' );
define( 'NONCE_SALT',        'd8|3reqxu_d~a^?]UQx>rJk{2>{@Y[5ZOE54n@0RMr2Wa]O55?:`;9oCE+Lo&)Sy' );
define( 'WP_CACHE_KEY_SALT', 'SW Db]bY_jx|_Sy?J0na!9)bd&|ySTa;k.k(#sBE9wW@~|x-fvWdh7by%qN?lQ{a' );

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'ZPmscXOh';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
