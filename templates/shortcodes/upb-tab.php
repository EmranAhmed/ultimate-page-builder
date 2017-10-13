<?php defined( 'ABSPATH' ) or die( 'Keep Silent' );
	
	// $shortcode_atts, $attributes, $contents, $settings, $tag
	
	if ( ! upb_is_shortcode_enabled( $attributes ) ) {
		return;
	}
?>

<div <?php upb_shortcode_attribute_id( $attributes ) ?> class="<?php upb_shortcode_class( $attributes, $tag ) ?>">
    <div class="upb-tab">
		<?php
			global $upb_tabs;
			$tab_contents = do_shortcode( $contents );
		?>

        <ul class="upb-tab-items">
			<?php foreach ( $upb_tabs as $index => $tab ): ?>
                <li class="upb-tab-item <?php echo ( $tab[ 'active' ] ) ? 'active' : '' ?>"><?php echo esc_html( $tab[ 'title' ] ) ?></li>
			<?php endforeach; ?>
        </ul>

        <div class="upb-tab-contents">
			<?php echo $tab_contents ?>
        </div>
		
		<?php $upb_tabs = array(); ?>

    </div>
</div>