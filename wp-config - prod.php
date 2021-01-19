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
define( 'DB_NAME', 'dbnge53zdy3ptz' );

/** MySQL database username */
define( 'DB_USER', 'ut48u5sq6mmy3' );

/** MySQL database password */
define( 'DB_PASSWORD', 'njwz24dfnge5' );

/** MySQL hostname */
define( 'DB_HOST', '127.0.0.1' );

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
define( 'AUTH_KEY',          'g$MweAg9}`RQ#Jw{+*P9vg+2>xq? m>#{:$7Y2P{Ya(%/uqT*`BG><@_:sA=s.M;' );
define( 'SECURE_AUTH_KEY',   'Ga~wVCtNiz4fBk~u,IlY(WiZs[9H!R=*5$fROhr.8?%Qy1_ :E*ftXf.}j6Ej1Lx' );
define( 'LOGGED_IN_KEY',     ';v^{>4jlDWyueABRNp.Xvt3g ?:2pXpwK>+=LR{Xj96$8aMF.FoD@yKVXNlqi|49' );
define( 'NONCE_KEY',         '0L^>QyE[PZ9_pk%E>,;R.lj;:J1%ZN KB|:0}*GfsT@^?4, M`@t*YKEX?Qkht0m' );
define( 'AUTH_SALT',         'Xxy(^Gh}K<U0aG`LT6;S0<Rrjp-YCzy#H6;l 7c^ )D2~5h(Ur%pA`cNhgQ6^@?V' );
define( 'SECURE_AUTH_SALT',  'W.VZCEen/ -jTz>d`aeiMun$.Yp{iG^B?k=c.Ig#<;J}EP4~tZ4e2qRq)9LPxE5U' );
define( 'LOGGED_IN_SALT',    '+>i+CKDigQ{4qm94^K@PzUk;rX00Z)=hKVqxiTa$>hu(H<IE13-*ygTH].~AVeRd' );
define( 'NONCE_SALT',        'PWPPvik9R]nM)}$sWlhv]VrLbjG6ooUOq+($9j&%r6.PNJynJ)A BDjIulOq]l`Q' );
define( 'WP_CACHE_KEY_SALT', '|u@cAe<7%:i!~sy T?S]Guhpzu,U)ld@e%th*y1qwJl=TDu{]_lg(YY4[e|Ev<:/' );

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'hgm_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
@include_once('/var/lib/sec/wp-settings.php'); // Added by SiteGround WordPress management system
