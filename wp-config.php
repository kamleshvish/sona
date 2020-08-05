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
define( 'DB_NAME', 'cars' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'rf1N>>Lf9I _Nf%yeH&$r`$d5{TxK4Yd(4c}hGkCGA-bqLr>7lZ1=&mn}W_I|gs%' );
define( 'SECURE_AUTH_KEY',  '9}Shqo-U[tJ[Rj#I[)n}bXDRAnE&e&hnF(z&>X83WEv1hma|#<BRE^(f*:<~deP-' );
define( 'LOGGED_IN_KEY',    '`L|yOCI@Cxcy0cRFRZMlJX4Sv%oZN$d}=FIzi-LjTbnz@)G[0aG|fxQI9ME:X$n1' );
define( 'NONCE_KEY',        'kq:7IvYe1cW@w/A-&yu;%X}e%X(T}ACHPB5$ W`n7$L=NRWPxwVECo&=0#<Y]yjz' );
define( 'AUTH_SALT',        'BySwBfq|@Q(jM1X?)R^`W/@+n:}]:}jQgf%47R+wb)I^=N@3-EY+05Hmd-pS<nI~' );
define( 'SECURE_AUTH_SALT', '3J`KOl|Q%qWs>B :}yR8@*(u;z6CAkMR9?:C#B/+#8@1qWKIK4z1/qxjHAo:U>Q<' );
define( 'LOGGED_IN_SALT',   'VddodV}tdYT,$1utwHJ@4!`x(XiGajAg(x@uSa#lUsQ+69^BUplpHPGW^Ya}t*!g' );
define( 'NONCE_SALT',       '8d i.UF3LeY*Rv3cw4dj21%Y^~TC/~o0|+C3/<YvHS/%:g{7*rYm1c6l#4b9qupL' );

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
