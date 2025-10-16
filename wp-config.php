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
define( 'DB_NAME', 'wordpress_683' );

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
define( 'AUTH_KEY',         'P5Y.l#4*{>X6LwGMO+:XaoZAGz<p{{[tL9:]W) |Gcr+o^Z(hFkR`s9o 5*H]#}O' );
define( 'SECURE_AUTH_KEY',  'g8l,?TQ1!8sX053pnF3-^6j(8eS}6U)--ki/Mwenw)bA5sFXh)7|9oe%[{5-rCW2' );
define( 'LOGGED_IN_KEY',    '@2(8|Rj,@1Rp7Vv9?Ni;()v{~(#AqtcnR4f]wn<c(-6Rlr}TKrsd%cdAI,`};dVw' );
define( 'NONCE_KEY',        'u, 7<);wnJnn+3b2xJF_/qRE8Wc}yW!= SrSH6[KO:!C+83GT5$xN(ugn|,ys,;O' );
define( 'AUTH_SALT',        ',>vra/XE[M3o}ux7Ej.M_dt5k_8`9[a3e$0n]vWR>)Ti>XCLGAZ35MO`bBg,ZWqW' );
define( 'SECURE_AUTH_SALT', '9#2rF99E,vZR{4GS-7>.R8=<v[WOhS8K>`Y95x170%14%7AV*rr(Rr4W1D@.zcw:' );
define( 'LOGGED_IN_SALT',   '7weUS_q4Q3d-%hu-<1F*wt<`4vKi7MRxq=H3vAc0a)79B:]f+-AVn_q~w]Kb<,3i' );
define( 'NONCE_SALT',       '~}ixRo_QVSeIR+zh1^+L P#I$pzO(&nCE3R=<.Eb.k3-nHobq3T9?)G^O_8FhQ!3' );

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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
