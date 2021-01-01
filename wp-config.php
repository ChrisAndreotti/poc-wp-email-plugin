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
define( 'DB_NAME', 'wp_demosite' );

/** MySQL database username */
define( 'DB_USER', 'wp_demosite' );

/** MySQL database password */
define( 'DB_PASSWORD', 'wp_demosite' );

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
define('AUTH_KEY',         'w|2<)8nsQ2sm}HX?/$r<Ra:uxO=C=~ m§_Ps8yQ-[O1^I%, )<;) 6rk@I/(~b}$');
define('SECURE_AUTH_KEY',  '[ISk4h!I|vp}e@$y:Unx</&PWK1=;PWbad$9!<%o<{]b5s8I9RX0mOzto%!/3>c-');
define('LOGGED_IN_KEY',    'KTi=jXf2;AB{Jd~d-SVknRAkz|MH§VvRp0Z~pQAaB>FoE@JIozB-)o5]~2f2 Bj@');
define('NONCE_KEY',        '4)Iw)NFT7DgrQC}+z4zYDWrm/4+aY{ZHdG/re7^uZ,a4jN<v)yU5TrZ=X{|e!Eez');
define('AUTH_SALT',        '+5t^+~u?-.x>wyQ}|`R5]B1YLlg?juVf;x ~]^&`U,ob_BUkqUoTTX:]x]2~$Z?z');
define('SECURE_AUTH_SALT', '6&dTAuS@94rnf1Q;JL§3 §pnpUIC3:MEdKVjE§Lym|K~C%o^@tJ&6nP4.C3hvLg?');
define('LOGGED_IN_SALT',   'ToyY;_5]T$A_aKFU?;b)@W KJKAMoeLM%4?~G|:)§Jg|`5OD+,N[(a}Y`fp9]1Q:');
define('NONCE_SALT',       'nRVg{R:jsoXvlWKRyjHa;=P§!<L/belR6$Dj+YPK]Ew E<cOwFD[qHKW}Q L@Q;[');

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
