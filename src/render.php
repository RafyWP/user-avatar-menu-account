<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$size               = $attributes['size'] ?? 32;
$prefix             = $attributes['prefix'] ?? '';
$is_avatar          = isset( $attributes['isAvatar'] ) && $attributes['isAvatar'] === 'yes';
$is_my_account_link = $attributes['isMyAccountLink'] ?? false;
$custom_link        = $attributes['customLink'] ?? '';
$link_target        = $attributes['linkTarget'] ?? '';
$color              = $attributes['color'] ?? '#000000';

$border_attributes = rafy_block_user_avatar_menu_account_border_attributes( $attributes );
$image_classes     = ! empty( $border_attributes['class'] )
	? "wp-block-rafy-user-avatar-menu-account {$border_attributes['class']}"
	: 'wp-block-rafy-user-avatar-menu-account';
$image_styles      = ! empty( $border_attributes['style'] )
	? sprintf( ' style="%s"', esc_attr( $border_attributes['style'] ) )
	: '';

$user_id = is_user_logged_in() ? get_current_user_id() : null;
if ( ! $user_id ) {
	return;
}

$display_name = get_the_author_meta( 'display_name', $user_id ) ?: '';
$avatar_url   = get_avatar_url( $user_id, array( 'size' => $size ) );

$my_account_url = '';
if ( class_exists( 'WooCommerce' ) ) {
	$my_account_page_id = wc_get_page_id( 'myaccount' );
	if ( $my_account_page_id ) {
		$my_account_url = get_permalink( $my_account_page_id );
	}
}

$link_url = '';
if ( $is_my_account_link && ! empty( $my_account_url ) ) {
	$link_url = $my_account_url;
} elseif ( ! $is_my_account_link && ! empty( $custom_link ) ) {
	$link_url = $custom_link;
}
?>
<div <?php echo get_block_wrapper_attributes(); ?>>
	<?php if ( ! empty( $link_url ) ) : ?>
		<a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>">
	<?php endif; ?>

		<div class="avatar <?php echo esc_attr( $image_classes ); ?>">
			<?php if ( $is_avatar ) : ?>
				<img
					src="<?php echo esc_url( $avatar_url ); ?>"
					alt="<?php echo esc_attr( $display_name ); ?>"
					width="<?php echo esc_attr( $size ); ?>"
					height="<?php echo esc_attr( $size ); ?>"
					<?php echo $image_styles; ?>
				/>
			<?php else : ?>
				<svg
					xmlns="http://www.w3.org/2000/svg"
					viewBox="0 0 24 24"
					fill="none"
					stroke="<?php echo esc_attr( $color ); ?>"
					stroke-linecap="round"
					stroke-linejoin="round"
					width="<?php echo esc_attr( $size ); ?>"
					height="<?php echo esc_attr( $size ); ?>"
					stroke-width="1.5"
				>
					<path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"/>
					<path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"/>
					<path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855"/>
				</svg>
			<?php endif; ?>
		</div>

		<div class="display-name" style="color: <?php echo esc_attr( $color ); ?>">
			<span><?php echo esc_html( $prefix ); ?></span>
			<span class="name"><?php echo esc_html( $display_name ); ?></span>
		</div>

	<?php if ( ! empty( $link_url ) ) : ?>
		</a>
	<?php endif; ?>
</div>
