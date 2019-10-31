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
define('DB_NAME', 'adhischools_mockup');

/** MySQL database username */
define('DB_USER', 'mockup');

/** MySQL database password */
define('DB_PASSWORD', 'RhIN0Tt#15');

/** MySQL hostname */
define('DB_HOST', '172.30.1.143');

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
define('AUTH_KEY',         'St_8lM`(o3)0LI|%|HUJ!x[rzO#$4T,K^1Grxl@0t3xta{g25>f%evA-E=[.:}8I');
define('SECURE_AUTH_KEY',  'z!;-9wM9}4%e9.0B2]?0w3*xnZHwwA-%n+$qf31Sx.$rh+Y4e*1+>o&MW/8YjBb:');
define('LOGGED_IN_KEY',    '(|(~&bR0Zc1~^nX/{a`>IRCwSe$l4fVeolIA@b|E|Uukv_YbY7xL3E;.DvfJ+WaN');
define('NONCE_KEY',        'NbgC!s0Xo?v#iGGhcKOa~=6|S.wZW2LcSJ9-UHC5QpV0(#M?ae=5iDkA^+M51iDZ');
define('AUTH_SALT',        'v<8q*P-[G5!Z^%UEJ:y+Z!<?Pf-un`e7!]NH]I#3+LA-Zk}Rk8yQX<*M>+AtDU(V');
define('SECURE_AUTH_SALT', 'uS3lPpwp~8q(0t+k:EC_u)aV|/2mkd{pF+:+GT3h=nAc~s+OS5:aW!<j+[1#:[]y');
define('LOGGED_IN_SALT',   'M+Y^EMl-PPXs?fRa<<-&5/u>RDD/n| q0h&&L6?G^#3.MN{?K> -^+XkOiAo-Fll');
define('NONCE_SALT',       'pk0N?eTM)du9f)B8z<3/?8-Yw)h^^[QO%$?Z*Yaf+ABP&UeWNyy{1HE?:-M}OPB<');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'blog_wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress.  A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de.mo to wp-content/languages and set WPLANG to 'de' to enable German
 * language support.
 */
define ('WPLANG', '');

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
