<?php
	
	defined( 'ABSPATH' ) or die( 'Keep Silent' );
	
	if ( ! function_exists( 'upb_accordion_inline_script' ) ):
		function upb_accordion_inline_script( $attributes, $settings, $tag ) {
			
			ob_start();
			?>
            <script>
                jQuery(function ($) {
                    $(".upb-accordion-item").upbAccordion();
                });
            </script>
			<?php
			
			return ob_get_clean();
			
		}
	endif;
	
	if ( ! function_exists( 'upb_tab_inline_script' ) ):
		function upb_tab_inline_script( $attributes, $settings, $tag ) {
			
			ob_start();
			?>
            <script>
                jQuery(function ($) {
                    $(".upb-tab-item").upbTab()
                });
            </script>
			<?php
			
			return ob_get_clean();
			
		}
	endif;
	
	if ( ! function_exists( 'upb_section_inline_style' ) ):
		function upb_section_inline_style( $selector, $attributes, $settings, $tag ) {
			ob_start();
			?>
            <style>
                [<?php echo $selector ?>] {
                <?php upb_shortcode_scoped_style_background($attributes) ?> margin : <?php echo esc_attr( upb_get_spacing_input_value('margin', $attributes, $settings) ) ?>;
                    padding                                                        : <?php echo esc_attr( upb_get_spacing_input_value('padding', $attributes, $settings) ) ?>;
                    }
            </style>
			<?php
			
			return ob_get_clean();
		}
	endif;
	
	if ( ! function_exists( 'upb_heading_inline_style' ) ):
		function upb_heading_inline_style( $selector, $attributes, $settings, $tag ) {
			ob_start();
			?>
            <style>
                [<?php echo $selector ?>] {
                    text-align : <?php echo esc_attr( $attributes[ 'align' ] ) ?>
                    }
            </style>
			<?php
			
			return ob_get_clean();
		}
	endif;

