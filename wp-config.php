<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'sae106' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */

define('AUTH_KEY',         '+z_>TAg-aIt;ZJ#|3np.V@_e`euIg&6)x(j?(AucB5vKXU#/]MOUhuGv:;p|t!&|');
define('SECURE_AUTH_KEY',  'cUrUV)eyzd<g)sA~6A~+A==bLa-)*,=!_TP/K^)%sD7Bz2Offt`yDfcAB.S--vr.');
define('LOGGED_IN_KEY',    '_v)Z(Y30L<SE,](mIwl+/q,tBS*yLu/^VCu,UBu@j5XWzl[R-ti:Y~ i.eM +4_M');
define('NONCE_KEY',        '#H-0fJb3>$[(-K.H B*p ^E+=-svf|a/_&;sbuv,$S3:K&~h_8XGmVVUQ3_RL }9');
define('AUTH_SALT',        '16|ymD|1)pWg? RDk4)+=V8BATOjfir=z4p-h*QQo-m}eP{&st_?-`,5|~+dJBIu');
define('SECURE_AUTH_SALT', '17;n:?zwb.!&ERv-)*~x^bR3xoa>cZ)!NigAS&7T0r5+n}l&Ee4Gt2.vtQGra}pN');
define('LOGGED_IN_SALT',   'C+c3b}vt#>sD9e8&A+t*6RCmfFv9k|N[:;/:@w(]@CpS-ne>]PUNYhm+>MBCkwAR');
define('NONCE_SALT',       '6ca/ur]33)j:YBIE,lG{^,nvq<J#UoA<:50SkK$)$sO2)[G*4N>=|!1Uq1%ROX+u');

/**#@-*/

/**
 * WordPress database table prefix.
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */

@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'memory_limit', '15M' );



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
define('FS_METHOD','direct');
