<?php
/**
 * User Avatar & Menu Account
 * 
 * Displays the logged-in user's avatar (or icon), display name, and a customizable link (which can serve as a 'My Account' link if WooCommerce is active).
 * 
 * @link              https://litcode.store/product/user-avatar-menu-account-wordpress-block-plugin/
 * @since             1.0.0
 * @package           rafy
 * @author            Lit ✴ Code
 * @license           GPL-2.0-or-later
 * 
 * @wordpress-plugin
 * Plugin Name:       User Avatar & Menu Account
 * Plugin URI:        https://litcode.store/product/user-avatar-menu-account-wordpress-block-plugin/
 * Description:       Displays the logged-in user's avatar (or icon), display name, and a customizable link (which can serve as a 'My Account' link if WooCommerce is active).
 * Version:           1.0.0
 * Requires at least: 6.7
 * Requires PHP:      7.4
 * Author:            Lit ✴ Code
 * Author URI:        https://litcode.store
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       user-avatar-menu-account
 * Domain Path:       /languages
 * Update URI:        https://github.com/RafyWP/user-avatar-menu-account
 * Network:           true
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Generates class names and styles to apply
 * the border support styles for the block.
 *
 * @since 1.0.0
 *
 * @param array $attributes The block attributes.
 * @return array The border-related classnames and styles for the block.
 */
function rafy_block_user_avatar_menu_account_border_attributes( $attributes ) {
	$border_styles = array();

	if ( isset( $attributes['radius'] ) ) {
		$border_styles['radius'] = $attributes['radius'] . 'px';
	}

	$styles     = wp_style_engine_get_styles( array( 'border' => $border_styles ) );
	$attributes = array();
	if ( ! empty( $styles['classnames'] ) ) {
		$attributes['class'] = $styles['classnames'];
	}
	if ( ! empty( $styles['css'] ) ) {
		$attributes['style'] = $styles['css'];
	}
	return $attributes;
}

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function rafy_block_user_avatar_menu_account_init() {
	register_block_type( __DIR__ . '/build' );
}
add_action( 'init', 'rafy_block_user_avatar_menu_account_init' );
