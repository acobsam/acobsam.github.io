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
define('DB_NAME', 'alpha');

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
define('AUTH_KEY',         '15<m 2c*X6u$/6v%2X:-y=rK4Hj&7PK3q[&6nkg4[3ThS^dI;rg(uR12@`B+RsYT');
define('SECURE_AUTH_KEY',  ',(#kD)6fWW`6?}v-@=1)q[=H7$sRcdW!DZP[<Vzk`SeQ1%~oX9kP!/I2Zdj4IG8A');
define('LOGGED_IN_KEY',    'D{zWu-ap{Qqs8y`g=(w1-3k(Y| WjLm;X?U`Wr D!g#5Jvv{drc.j,P`oQ7U6H@T');
define('NONCE_KEY',        '0dIz+0(=NCM?;F;aCO:*>M^6LG=b+H6i|0)wFP[ql0>tqXTA!WT)6F3#i&E G8Om');
define('AUTH_SALT',        'vFA9)B*$s# .}N{,uX?3^?H@q|WGyz^d+4eJy;R9aRyv/j$O6 @Xo~ }s?t8};sQ');
define('SECURE_AUTH_SALT', 'S~9]rWtp8T)E7Le/aetXAIWtn4lhS0Pd[ 1&Etu7(6k.7xGC/;u9quG2QK2Vu)vA');
define('LOGGED_IN_SALT',   'D{NePXQ-4?Z!m6[ QUgT1Q-O{`CCG7:2RnrA3o&8B$bCys{,AKFQ,Ys,^ u]5}.-');
define('NONCE_SALT',       'V:LmA.c.7v]Hh9C}o,2GsNH!TxXetju:||~cw8d{w;!Pm[zV [-J)lHOW/|/+?Vv');

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
