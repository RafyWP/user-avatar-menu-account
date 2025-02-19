<?php
/**
 * User Avatar & Menu Account
 * 
 * Displays the logged-in user's avatar (or icon), display name, and a customizable link (which can serve as a 'My Account' link if WooCommerce is active).
 * 
 * @link              https://litcode.store/product/user-avatar-menu-account-wordpress-block-plugin/
 * @since             1.0.0
 * @package           rafy
 * @author            Rafy @ LitCode
 * @license           GPL-2.0-or-later
 * 
 * @wordpress-plugin
 * Plugin Name:       User Avatar & Menu Account
 * Plugin URI:        https://litcode.store/product/user-avatar-menu-account-wordpress-block-plugin/
 * Description:       Displays the logged-in user's avatar (or icon), display name, and a customizable link (which can serve as a 'My Account' link if WooCommerce is active).
 * Version:           1.0.0
 * Requires at least: 6.7
 * Requires PHP:      7.4
 * Author:            Rafy @ LitCode
 * Author URI:        https://litcode.store
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       user-avatar-menu-account
 * Domain Path:       /languages
 * Update URI:        https://litcode.store/product/user-avatar-menu-account-wordpress-block-plugin/
 * Network:           true
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Registers all block assets so that they can be enqueued through the block editor
 * in the corresponding context.
 * 
 * @since 1.0.0
 * 
 * @return void
 */
function rafy_user_avatar_menu_account_block_init() {
	$dir = __DIR__;

	$index_js = 'index.js';
	wp_register_script(
		'rafy-user-avatar-menu-account-block-editor',
		plugins_url( $index_js, __FILE__ ),
		array(
			'wp-block-editor',
			'wp-blocks',
			'wp-i18n',
			'wp-element',
		),
		filemtime( "$dir/$index_js" )
	);
	wp_set_script_translations( 'rafy-user-avatar-menu-account-block-editor', 'user-avatar-menu-account' );

	$editor_css = 'editor.css';
	wp_register_style(
		'rafy-user-avatar-menu-account-block-editor',
		plugins_url( $editor_css, __FILE__ ),
		array(),
		filemtime( "$dir/$editor_css" )
	);

	$style_css = 'style.css';
	wp_register_style(
		'rafy-user-avatar-menu-account-block',
		plugins_url( $style_css, __FILE__ ),
		array(),
		filemtime( "$dir/$style_css" )
	);

	register_block_type(
		$dir,
		array(
			'editor_script' => 'rafy-user-avatar-menu-account-block-editor',
			'editor_style'  => 'rafy-user-avatar-menu-account-block-editor',
			'style'         => 'rafy-user-avatar-menu-account-block',
		)
	);
}
add_action( 'init', 'rafy_user_avatar_menu_account_block_init' );

/**
 * Generates class names and styles to apply the border support styles for
 * the User Avatar & Menu Account block.
 *
 * @since 1.0.0
 *
 * @param array $attributes The block attributes.
 * @return array The border-related classnames and styles for the block.
 */
function rafy_block_core_avatar_border_attributes( $attributes ) {
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
