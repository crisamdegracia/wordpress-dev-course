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
define('DB_NAME', 'new_wp_crz');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         '%2!(PuE@n2,hXIFN]*?hCgWE7CpTY[~Zu4mNagT38]&79s~BbC2Y>qq,fRUppQb3');
define('SECURE_AUTH_KEY',  'RPm4BDK *7V./jD8ht=8KH@KX3qGq 7Gi)2k&Z[u2nxYc`q,_i!Bx=3Z6Jsb(<Er');
define('LOGGED_IN_KEY',    '@l(XVa`/2D 4hB_Jow{JC|-XA$rXrN*{K:7uds=F5uaS|(l0!%3a;.Xl0wN/&4Rm');
define('NONCE_KEY',        'EoVs|c[acB`o-B!hg?W,rOXHyI#E^P@E}X%upzk?Q@(NR1e|B@VY<fdk$E4?gEXX');
define('AUTH_SALT',        '2Ra_sn=KL>n8ZNF<c#(N4Q5gh!1)N)N7ZmeQR{_Q!C^9BX]`N%h+f}y3[C)dk:a?');
define('SECURE_AUTH_SALT', 'Tm7%Rr+HS_gOFo~1j<HQ^!5e|4-.go-owDtRBqyB@Vz=[;dSjM]gU[l@me)GE}W<');
define('LOGGED_IN_SALT',   '2x4aOLY^0%,>AA:97LS](MfTWn)4,6T/<lC6=PlTp#(mgP`<eT}t&o$Ic<3#9d#f');
define('NONCE_SALT',       'EgYAcs>zLIKSV,G8rNTkR)DmnOy$N,$ iH~ ]Nw;:0@`!Qm^grVB#}9d^-z6M}91');

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

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
