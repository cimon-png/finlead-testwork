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
define( 'DB_NAME', 'u1601676_finlead' );

/** Database username */
define( 'DB_USER', 'u1601676_fin-adm' );

/** Database password */
define( 'DB_PASSWORD', 'lY1tI2qU3vvM0kK9' );

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
define( 'AUTH_KEY',         'R#_y1$M=9a_:YYi,W1,Zg.n15%`ZmmT+ld>_iD!%ZaOGGOF%w$;>1lbk?g2myUTM' );
define( 'SECURE_AUTH_KEY',  'qPc$LL&Vl(zuWxWj`?_%AY(,@R,j4aw>qIXX#_|Y}&Pt58z;5y`Q$^Uxcxr68k^v' );
define( 'LOGGED_IN_KEY',    'O=XAR 5(o14uB,.=SOaK$tJ1y~K4?`0kO}@ogY914V8nP:Wka3i$g*a.9:pQJM,}' );
define( 'NONCE_KEY',        ' d47bh$;G-<:kbhv>{vJO`g3/SD~.%pGi,-[,AW|`4hcg!IXcZ^R$)9zHU(8v[HD' );
define( 'AUTH_SALT',        'Hiso> L8D66^8Itke`-`&*t_wq^G1J[]D4.(!p7k6%}qqH Q[l];)]TyT1v{|@sb' );
define( 'SECURE_AUTH_SALT', '@)Vwadi_Ht1zvL`rRr$tBBAYcz]Ep=w)0AZ0?[@BgWportt,Y2=NHab6dQcZJBlb' );
define( 'LOGGED_IN_SALT',   '`^wn4xzgCIRZC8C|.p^C|H:_q2_NWBiMAf<s7gRTFHizx![v|r+OM2AU!u$HzS<G' );
define( 'NONCE_SALT',       'iVvRl7&b*9IgV y`~<Yc.U^4Nzhfa#j4d9:*qf*_?A8emsAmq2q<e4R#Q{)m5BJ%' );

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



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
