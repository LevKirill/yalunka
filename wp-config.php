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
define( 'DB_NAME', 'local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',         '[8r>.0MCI|#K^H+Yco]111AwAP+cY3.spxj!{!~ICgO,^ZbDo<mKjqRs7d@:!P!/' );
define( 'SECURE_AUTH_KEY',  'w60YFfoXSh/>i/ 5vDRSDv[~)Gsq]YSmQmn =.c@swv5{uD+xsY0CZ%?6[5L;j9-' );
define( 'LOGGED_IN_KEY',    ':b^cO-$o%{s.2AGVi.,_ot?pSg`n[ =dEL!TlVyc*uzAD?]cchT|Lp]f.cKrnnxI' );
define( 'NONCE_KEY',        'bfFA}p:97^Da~Jb1<RRFB>Idjor$4hk8:P@.bKjjl`8d(::7~dks$]e1Mc9wpgMK' );
define( 'AUTH_SALT',        'Ln}*8JruPM6[Hq30Z`ySrej,ndk~Pw1?ttThbfUj)6$uA*JdU(d[!+J+]7!E/jQ3' );
define( 'SECURE_AUTH_SALT', 'U-FuA%_kfHTLSL,dDosN8HtB14RfD|?A^]ZL^6ow_0=*?LVHk;[|Xou8msleXT-I' );
define( 'LOGGED_IN_SALT',   'Bjv5fX.3T7G;^N0L+$YLAg+Yqr+_$SRnGVSW_DoA=q&??D5bauP~)9(h&oQAiP,Z' );
define( 'NONCE_SALT',       'V)IhwqFbr+M7qlX+)D33Z@/5En9+<|EfyV<r7svklBHH?0Nl*##1cf>EpX`%[1zx' );

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
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', false);
define('WP_DEBUG_DISPLAY', false);




define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
