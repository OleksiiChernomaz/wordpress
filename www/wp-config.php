<?php
/**
 * just to keep global scope empty from variables and garbage
 */
$configurator = function() {
    //be careful when removing items from this config - it can cause errors with undefined constants usage
    //all those constants treated as MUST have for WP and would be either defined with actual value, or with default one
    $config = [
        'DB_NAME' => '',
        'DB_USER' => '',
        'DB_PASSWORD' => '',
        'DB_HOST' => 'db',
        'DB_CHARSET' => 'utf8',
        'DB_COLLATE' => '',
        'AUTH_KEY' => '',
        'SECURE_AUTH_KEY' => '',
        'LOGGED_IN_KEY' => '',
        'NONCE_KEY' => '',
        'AUTH_SALT' => '',
        'SECURE_AUTH_SALT' => '',
        'LOGGED_IN_SALT' => '',
        'NONCE_SALT' => '',
        'WP_DEBUG' => false,
        'ABSPATH' => '',
        'WP_TABLE_PREFIX' => 'wp_'
    ];

    //check required by WP constants
    foreach ($config as $constName => $defaultValue) {
        $value = getenv($constName);
        define($constName, $value !== false ? $value : $defaultValue);
    }

    //inject additional optional constants (if any), which start from "WP_"
    $prefix = 'WP_';
    foreach ($_ENV as $constName => $value) {
        $constName = strtoupper($constName);
        if (0 !== strpos($constName, $prefix)) {
            continue;
        }

        $constName = str_replace($prefix, '', $constName);
        if (defined($constName)) {
            continue;
        }

        define($constName, $value);
    }
};
$configurator();
unset($configurator);

############### here are leftovers from original config ######################################
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = WP_TABLE_PREFIX;

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
    define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
