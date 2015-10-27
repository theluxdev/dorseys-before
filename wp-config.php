<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'dorseyun_sitecash');

/** MySQL database username */
define('DB_USER', 'dorseyun_crashan');

/** MySQL database password */
define('DB_PASSWORD', 'T1q;kh+;DWRt');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         '-e4?R7@{fIJ2>5{2omIY*VN=5|v+6*p|}gnApp@6v ,.iS2%#HG WKR%%.F]>l&/');
define('SECURE_AUTH_KEY',  'Q,-pW&vl]OFW/kv8`Ip}-t;Lwv050=}Y_T_iaM7wy2B,fj`X(+ wosUG-oTG^+@f');
define('LOGGED_IN_KEY',    'v.5TU=Z3Nkb_Nr#]PP:Vo92,f1dgTBP/DBN=mFZw|&e]!|b-?pVY3dL7Lg_6hK@|');
define('NONCE_KEY',        '|0TD >iLUo&#qhh@dPwf+|3BZC_G]nP5<%nm|EaTLgxXG>37d *Jq{|uN{v_N!+v');
define('AUTH_SALT',        'iti&EPx08h>33c@.1F|6KT:N)%4o|%9iOijlbyMt9|=Q{N-*Z(+)_@+$x;HVZLpB');
define('SECURE_AUTH_SALT', 'H4a)5>f1Q[k?&/uyq0=Z.4bP2+H:$jN]|j-{Lr.,yma5+6.59`$n4*Q]J)-[h-Oj');
define('LOGGED_IN_SALT',   '2,D#gp*Q/B,0L<_c}fH_-u{z;TlnG[|gv3<me-4aEaf8QB_X>r=u4>z<E%Yr8RV_');
define('NONCE_SALT',       'Uvv/u7N,W=Yd:m|8|u!a(#h<Z0If=|J0Iu;dxY<u-8b-`g2%K7/BX#hz/09}4S^I');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'rb_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
