<?php

/**
 * Pros N Cons for Product Posts, this plugin will add a pre rendered HTML output table using a Wordpress shortcut based on the post ID
 *
 * @since             1.0.1
 * @package           ProsNcons
 *
 * @wordpress-plugin
 * Plugin Name:       ProsNcons
 * Description:       Create Pros and Cons for each product posts.
 * Version:           1.0.1
 * Author:            Ricardo Ambriz
 * Author URI:        https://ricardoambriz.com
 * License:           GPL-3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       pros-n-cons
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
// Pros N Cons
require plugin_dir_path( __FILE__ ) . 'classes/class-prosncons.php';

// Register Pros N Cons
function ProsNcons() {
	$plugin = new ProsNcons();
	$plugin->register();
}
// Trigger Pros N Cons
ProsNcons();