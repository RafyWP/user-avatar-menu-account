<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$size               = $attributes['size'] ?: 32;
$prefix             = $attributes['prefix'] ?: '';
$is_avatar          = $attributes['isAvatar'] === 'yes';
$is_my_account_link = $attributes['isMyAccountLink'] ?: false;
$custom_link 		= $attributes['customLink'] ?: '';
$link_target 		= $attributes['linkTarget'] ?: '';
$color				= $attributes['color'] ?: '#000000';

$border_attributes  = rafy_block_core_avatar_border_attributes( $attributes );

$image_classes = ! empty( $border_attributes['class'] )
	? "wp-block-avatar__image {$border_attributes['class']}"
	: 'wp-block-avatar__image';

$image_styles = ! empty( $border_attributes['style'] )
	? sprintf( ' style="%s"', esc_attr( $border_attributes['style'] ) )
	: '';

$user_id = get_current_user_id();

if ( $user_id ) {
	$display_name = get_the_author_meta( 'display_name', $user_id ) ?: '';
	$avatar_url   = get_avatar_url( $user_id, array( 'size' => $size ) );

	if ( class_exists( 'WooCommerce' ) ) {
		$my_account_url = get_permalink( wc_get_page_id( 'myaccount' ) );
	}
}

if ( is_user_logged_in() ) {
?>

<div <?php echo get_block_wrapper_attributes(); ?>>
    <?php if ( $is_my_account_link && isset( $my_account_url ) ) : ?>
        <a href="<?php echo esc_url( $my_account_url ); ?>" target="<?php echo $link_target; ?>">
	<?php elseif ( !$is_my_account_link && $custom_link ) : ?>
		<a href="<?php echo esc_url( $custom_link ); ?>" target="<?php echo $link_target; ?>">
    <?php endif; ?>
        <div class="avatar <?php echo $image_classes; ?>">
		<?php if ( $is_avatar ) : ?>
            <img
				src="<?php echo esc_url( $avatar_url ); ?>"
				alt="<?php echo esc_attr( $display_name ); ?>"
				<?php echo $image_styles; ?>
				width="<?php echo $size; ?>"
				height="<?php echo $size; ?>"
			/>
		<?php else : ?>
			<svg
				xmlns="http://www.w3.org/2000/svg"
				viewBox="0 0 24 24"
				fill="none"
				stroke="<?php echo $color; ?>"
				stroke-linecap="round"
				stroke-linejoin="round"
				width="<?php echo $size; ?>"
				height="<?php echo $size; ?>"
				stroke-width="1.5"
			>
				<path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"/>
				<path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"/>
				<path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855"/>
			</svg>
		<?php endif; ?>
        </div>
        <div class="display-name" style="color: <?php echo $color; ?>">
			<span><?php echo esc_html( $prefix ); ?></span>
			<span class="name"><?php echo esc_html( $display_name ); ?></span>
        </div>
    <?php if ( $is_my_account_link && isset( $my_account_url ) || ( !$is_my_account_link && $custom_link ) ) : ?>
        </a>
    <?php endif; ?>
</div>
<?php
}
