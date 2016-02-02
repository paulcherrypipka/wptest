<?php
/**
 * Front to the WordPress application. This file doesn't do anything, but loads
 * wp-blog-header.php which does and tells WordPress to load the theme.
 *
 * @package WordPress
 */

/**
 * Tells WordPress to load the WordPress theme and output it.
 *
 * @var bool
 */

/*
// estatekonferance.no
$resource = mysqli_connect('46.38.178.136:3306', 'conf', 'Newpassw0rd');
if (!$resource) {
    die('Connection error!');
}
echo 'Connection success!!';
mysqli_close($resource);
exit();*/

define('WP_USE_THEMES', true);

/** Loads the WordPress Environment and Template */
require( dirname( __FILE__ ) . '/wp-blog-header.php' );
