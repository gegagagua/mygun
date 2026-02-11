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
define( 'DB_NAME', 'mygun' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'DC>.d,:WlA4<_!z]<iN,^f{aqJYm};<bYVf|bMYQR1]dhohE6ec:p&(frAynET%6' );
define( 'SECURE_AUTH_KEY',  'hF0YE!7@)]L/drgG9<!8.CMSd]43VL`E(!g:AYwnPR{P.x$a6qT(h`DK(w[o6pXa' );
define( 'LOGGED_IN_KEY',    '~11}cM:$orvw=zJz`g}S(6*<GxK8,0Rt`R1V$qz`IzUpEz;c5@t-w6rX+4siTJR-' );
define( 'NONCE_KEY',        'zrS>l<t(D,cvRFIYet|p4/K5_(]fB:xh@oRI.$`jt6i~DJ8$2o<r_6d2Zqdpm,AP' );
define( 'AUTH_SALT',        'GjE1S(2*r,Zr`c,Si7 q*[Sm4NR#bW.?UPXHL9D=CNK@mftgWXTFZmZ]:1GRjTB_' );
define( 'SECURE_AUTH_SALT', 'd{eE<Cz%E@*2*9lC3&d<D/L`Q(5f<#;W$(h8XWHAISB;(M;t#p!ZC*YLEUFPgdHU' );
define( 'LOGGED_IN_SALT',   'l$.!qOG{$V9v{WZ^XH{3~:!(1BtbnOme,~OCOQ<~/Hv=%2KzC,4<mC*J*XCu_41i' );
define( 'NONCE_SALT',       '}fK|N0t)K)t)-p X^v&%}RndO[08IjbA=$er`@?#K>z%d5iNR^7uWDtYN,*}Twln' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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

/* Add any custom values between this line and the "stop editing" line. */
define( 'WP_DEBUG', false );
define('FS_METHOD', 'direct');


/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
