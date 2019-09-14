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
define('DB_NAME', 'travellers_forum');

/** MySQL database username */
define('DB_USER', 'ruslan');

/** MySQL database password */
define('DB_PASSWORD', 'ruslan');

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
define('AUTH_KEY', '1KDYBSdwJRZ3xojqoiqqXOqA2Vu0hKi9uig3xQ/p0HK89egaLViUoCTY4SJqSy+6');
define('SECURE_AUTH_KEY', 'ZATihe2UirWffu0ZvYT/qnXIcq8N0TSCgGyactSCPd6Q23XudotZ2VQDIq/RKqqy');
define('LOGGED_IN_KEY', 'eojdWtOR5vzXLIkncRSl33ra7Uue4XgtLa3alS29yGQ9FJRok1U1/9GqB6crVMU3');
define('NONCE_KEY', 'YwGMCMoYovsnHybYoUr9htwYggLfJzetj64AyO5/UWmH2y/c0sr/BF2sRR1asz/n');
define('AUTH_SALT', '/H12Vyh1XOsrB1zRSeTQYmxZD3kIWI0/7ko7WDahTaTFN2RPF8cfm+97w0AdBk0x');
define('SECURE_AUTH_SALT', 'Qdptk6EcbwvwZC0DrJYVioaPblKM08ZMR5OCMVoVuveJ4JaIyo7i4E0OFvAvMVLF');
define('LOGGED_IN_SALT', 'JXIR5lUfgCCkGsM3dz1WwMbDLfICYxImJ+wi97i2SxM9hiJRxAnxHUBJoelcZmIw');
define('NONCE_SALT', 'psztNbLkVKKiEopRrgjl81+gPIicVZKw+1ARQw8CnZYvceV/gHP/Khff2mT+Cr82');

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
* visit the Codex.
*
* @link https://codex.wordpress.org/Debugging_in_WordPress
*/
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
