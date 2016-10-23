<?php

	defined( 'ABSPATH' ) or die( 'Keep Silent' );


	if ( ! class_exists( 'UPB_Customizer_Panel' ) ):

		class UPB_Customizer_Panel extends WP_Customize_Panel {

			public $type = 'upb_panel';

			public function active_callback() {
				return is_page();
			}

			public function content_template() { ?>
				<li class="panel-meta customize-info accordion-section <# if ( ! data.description ) { #> cannot-expand<# } #>">
					<button class="customize-panel-back" tabindex="-1"><span class="screen-reader-text"><?php _e( 'Back' ); ?></span></button>
					<div class="accordion-section-title">
				<span class="preview-notice"><?php
						/* translators: %s: the site/panel title in the Customizer */
						echo sprintf( __( 'You are customizing %s' ), '<strong class="panel-title">{{ data.title }}</strong>' );
					?></span>

						<button type="button" class="customize-page-builder-options-toggle" aria-expanded="false"><span class="screen-reader-text"><?php _e( 'Builder Options' ); ?></span></button>

						<# if ( data.description ) { #>
							<button class="customize-help-toggle dashicons dashicons-editor-help" tabindex="0" aria-expanded="false"><span class="screen-reader-text"><?php _e( 'Help' ); ?></span>
							</button>
							<# } #>
					</div>

					<# if ( data.description ) { #>
						<div class="description customize-panel-description">
							{{{ data.description }}}
						</div>
						<# } #>

							<div id="page-builder-options-wrap" class="hidden" tabindex="-1">
								<?php $this->options(); ?>
							</div>
				</li>
				<?php
			}

			public function options() {
				?>
				<fieldset class="metabox-prefs">
					<legend><?php esc_html_e( 'Show Options' ) ?></legend>
					<label><input class="hide-column-tog" type="checkbox" id="enable-page-builder" value="1">Enable Page Builder</label>
				</fieldset>
				<?php
			}

		}

	endif;