<?php
	defined( 'ABSPATH' ) or die( 'Keep Silent' );
	
	if ( ! class_exists( 'UPB_Elements_Props' ) ):
		
		class UPB_Elements_Props {
			
			public function filterOptions( $options, $tag = '' ) {
				
				$options[ 'desc' ]         = isset( $options[ 'desc' ] ) ? $options[ 'desc' ] : FALSE;
				$options[ 'default' ]      = isset( $options[ 'default' ] ) ? $options[ 'default' ] : '';
				$options[ 'placeholder' ]  = isset( $options[ 'placeholder' ] ) ? $options[ 'placeholder' ] : '';
				$options[ 'device-value' ] = isset( $options[ 'device-value' ] ) ? $options[ 'device-value' ] : FALSE;
				$options[ 'settings' ]     = isset( $options[ 'settings' ] ) ? $options[ 'settings' ] : array();
				
				if ( $options[ 'type' ] == 'select2' || $options[ 'type' ] == 'icon-select' || $options[ 'type' ] == 'select-icon' || $options[ 'type' ] == 'ajax-icon-select' || $options[ 'type' ] == 'ajax-select' ) {
					$options[ 'settings' ][ 'placeholder' ] = $options[ 'placeholder' ];
				}
				
				switch ( $options[ 'type' ] ) {
					case 'editor':
						if ( isset( $options[ 'value' ] ) && ! empty( $options[ 'value' ] ) ) {
							$options[ 'value' ] = wp_kses_post( $options[ 'value' ] );
						}
						break;
					
					case 'media-image':
					case 'background-image':
						// $options[ 'placeholder-image' ] = ! empty( $options[ 'placeholder-image' ] ) ? $options[ 'placeholder-image' ] : FALSE;
						$options[ 'placeholder' ] = ! empty( $options[ 'placeholder' ] ) ? $options[ 'placeholder' ] : esc_html__( 'No Image', 'ultimate-page-builder' );
						$options[ 'size' ]        = isset( $options[ 'size' ] ) ? $options[ 'size' ] : 'full'; // ‘thumbnail’, ‘medium’, ‘large’, ‘full’
						$options[ 'attribute' ]   = isset( $options[ 'attribute' ] ) ? $options[ 'attribute' ] : 'src'; // id, src
						$options[ 'library' ]     = isset( $options[ 'library' ] ) ? $options[ 'library' ] : 'image'; // image, audio, video
						$options[ 'buttons' ]     = isset( $options[ 'buttons' ] )
							? $options[ 'buttons' ]
							: array(
								'add'    => esc_html__( 'Use Image', 'ultimate-page-builder' ),
								'remove' => esc_html__( 'Remove', 'ultimate-page-builder' ),
								'choose' => esc_html__( 'Select', 'ultimate-page-builder' ),
							);
						break;
					case 'icon-popup':
						//$options[ 'attribute' ]   = isset( $options[ 'attribute' ] ) ? $options[ 'attribute' ] : 'src'; // id, src
						$options[ 'buttons' ] = isset( $options[ 'buttons' ] )
							? $options[ 'buttons' ]
							: array(
								'add'    => esc_html__( 'Add Icon', 'ultimate-page-builder' ),
								'remove' => esc_html__( 'Remove', 'ultimate-page-builder' ),
								'choose' => esc_html__( 'Choose Icon', 'ultimate-page-builder' ),
							);
						
						$options[ 'providers' ] = isset( $options[ 'providers' ] ) ? $options[ 'providers' ] : upb_icon_providers();
						break;
					
					case 'color':
						
						if ( ! isset( $options[ 'options' ] ) ) {
							$options[ 'options' ] = array();
						}
						$options[ 'options' ][ 'alpha' ] = isset( $options[ 'options' ][ 'alpha' ] ) ? $options[ 'options' ][ 'alpha' ] : FALSE;
						
						$palettes = apply_filters( 'upb_color_input_option_palettes', array( '#000', '#fff', '#d33', '#d93', '#ee2', '#81d742', '#1e73be', '#8224e3' ) );
						
						$options[ 'options' ][ 'palettes' ] = isset( $options[ 'options' ][ 'palettes' ] ) ? $options[ 'options' ][ 'palettes' ] : $palettes;
						
						// Example:
						// $options[ 'options' ][ 'palettes' ] = array('rgba(0,0,0,0.45)', '#000')
						break;
					
					case 'toggle':
						$options[ 'value' ] = upb_return_boolean( $options[ 'value' ] );
						break;
					
					case 'spacing':
						
						$options[ 'delimiter' ] = isset( $options[ 'delimiter' ] ) ? $options[ 'delimiter' ] : ',';
						$options[ 'unit' ]      = isset( $options[ 'unit' ] ) ? esc_attr( $options[ 'unit' ] ) : 'px';
						$options[ 'initial' ]   = isset( $options[ 'initial' ] ) ? esc_attr( $options[ 'initial' ] ) : '0px'; // auto
						$options[ 'min' ]       = isset( $options[ 'min' ] ) ? $options[ 'min' ] : 0;
						$options[ 'max' ]       = isset( $options[ 'max' ] ) ? $options[ 'max' ] : 999;
						$options[ 'step' ]      = isset( $options[ 'step' ] ) ? $options[ 'step' ] : 1;
						
						// Should maintain serial: 1. top, 2. right, 3. bottom, 4. left
						$options[ 'options' ] = isset( $options[ 'options' ] )
							? $options[ 'options' ]
							: array(
								'top'    => TRUE,
								'right'  => TRUE,
								'bottom' => TRUE,
								'left'   => TRUE
							);
						
						$options[ 'titles' ] = isset( $options[ 'titles' ] )
							? $options[ 'titles' ]
							: array(
								'top'    => esc_html__( 'Top', 'ultimate-page-builder' ),
								'right'  => esc_html__( 'Right', 'ultimate-page-builder' ),
								'bottom' => esc_html__( 'Bottom', 'ultimate-page-builder' ),
								'left'   => esc_html__( 'Left', 'ultimate-page-builder' ),
							);
						
						
						// Processing saved attributes
						if ( is_null( $options[ 'value' ] ) ) {
							$options[ 'value' ] = $options[ 'default' ];
						}
						
						if ( ! is_array( $options[ 'value' ] ) ) {
							$options[ 'value' ] = explode( $options[ 'delimiter' ], $options[ 'value' ] );
						}
						
						$i = 0;
						foreach ( $options[ 'options' ] as $key => $isTrue ) {
							if ( ! $options[ 'options' ][ $key ] && ( $options[ 'value' ][ $i ] == '' ) ) {
								$options[ 'value' ][ $i ] = $options[ 'initial' ];
							}
							$i ++;
						}
						
						$options[ 'value' ] = array_map( 'strval', $options[ 'value' ] );
						break;
					
					case 'ajax-icon-select':
					case 'ajax-select':
						
						$options[ 'options' ] = array();
						
						if ( isset( $options[ 'multiple' ] ) && $options[ 'multiple' ] ) {
							$options[ 'delimiter' ] = isset( $options[ 'delimiter' ] ) ? $options[ 'delimiter' ] : ',';
							
							// Processing saved attributes
							if ( is_null( $options[ 'value' ] ) ) {
								$options[ 'value' ] = $options[ 'default' ];
							}
							
							if ( ! is_array( $options[ 'value' ] ) ) {
								$options[ 'value' ] = explode( $options[ 'delimiter' ], $options[ 'value' ] );
							}
						} else {
							if ( ! isset( $options[ 'settings' ] ) || ! isset( $options[ 'settings' ][ 'allowClear' ] ) ) {
								$options[ 'settings' ][ 'allowClear' ] = TRUE;
							}
						}
						
						if ( ! isset( $options[ 'hooks' ] ) ) {
							$options[ 'hooks' ] = array();
						}
						
						// _upb_element_[tag]_[id]_search
						// _upb_element_[tag]_[id]_load
						
						// wp_ajax__upb_element_[tag]_[id]_search
						// wp_ajax__upb_element_[tag]_[id]_load
						
						if ( ! isset( $options[ 'hooks' ][ 'ajaxOptions' ] ) ) {
							$options[ 'hooks' ][ 'ajaxOptions' ] = NULL;
						}
						
						if ( ! isset( $options[ 'extra' ] ) ) {
							$options[ 'extra' ] = FALSE;
						}
						
						if ( ! isset( $options[ 'hooks' ][ 'search' ] ) ) {
							$options[ 'hooks' ][ 'search' ] = sprintf( '_upb_element_%s_%s_search', $tag, $options[ 'id' ] );
						}
						
						if ( ! isset( $options[ 'hooks' ][ 'load' ] ) ) {
							$options[ 'hooks' ][ 'load' ] = sprintf( '_upb_element_%s_%s_load', $tag, $options[ 'id' ] );
						}
						break;
					
					case 'range':
					case 'number':
						
						if ( ! isset( $options[ 'options' ] ) ) {
							$options[ 'options' ] = array();
						}
						
						$options[ 'options' ][ 'min' ]    = isset( $options[ 'options' ][ 'min' ] ) ? (int) $options[ 'options' ][ 'min' ] : 0;
						$options[ 'options' ][ 'max' ]    = isset( $options[ 'options' ][ 'max' ] ) ? (int) $options[ 'options' ][ 'max' ] : 999;
						$options[ 'options' ][ 'step' ]   = isset( $options[ 'options' ][ 'step' ] ) ? $options[ 'options' ][ 'step' ] : 1;
						$options[ 'options' ][ 'size' ]   = isset( $options[ 'options' ][ 'size' ] ) ? $options[ 'options' ][ 'size' ] : 3;
						$options[ 'options' ][ 'prefix' ] = isset( $options[ 'options' ][ 'prefix' ] ) ? esc_html( $options[ 'options' ][ 'prefix' ] ) : '';
						$options[ 'options' ][ 'suffix' ] = isset( $options[ 'options' ][ 'suffix' ] ) ? esc_html( $options[ 'options' ][ 'suffix' ] ) : '';
						// $options[ 'options' ][ 'unit' ]   = isset( $options[ 'options' ][ 'unit' ] ) ? esc_html( $options[ 'options' ][ 'unit' ] ) : '';
						
						$options[ 'value' ] = (int) $options[ 'value' ];
						break;
					
					case 'select':
					case 'select2':
					case 'select-icon':
						if ( isset( $options[ 'multiple' ] ) && $options[ 'multiple' ] ) {
							$options[ 'delimiter' ] = isset( $options[ 'delimiter' ] ) ? $options[ 'delimiter' ] : ',';
							
							// Processing saved attributes
							if ( is_null( $options[ 'value' ] ) ) {
								$options[ 'value' ] = $options[ 'default' ];
							}
							
							if ( ! is_array( $options[ 'value' ] ) ) {
								$options[ 'value' ] = explode( $options[ 'delimiter' ], $options[ 'value' ] );
							}
						} else {
							
							if ( is_null( $options[ 'value' ] ) ) {
								$options[ 'value' ] = $options[ 'default' ];
							}
							
							if ( ! isset( $options[ 'settings' ] ) || ! isset( $options[ 'settings' ][ 'allowClear' ] ) ) {
								$options[ 'settings' ][ 'allowClear' ] = TRUE;
							}
						}
						break;
					
					case 'checkbox':
					case 'checkbox-icon':
						
						$options[ 'delimiter' ] = isset( $options[ 'delimiter' ] ) ? $options[ 'delimiter' ] : ',';
						
						if ( is_null( $options[ 'value' ] ) ) {
							$options[ 'value' ] = $options[ 'default' ];
						}
						
						if ( ! is_array( $options[ 'value' ] ) ) {
							$options[ 'value' ] = explode( $options[ 'delimiter' ], $options[ 'value' ] );
						}
						
						break;
					
					case 'device-hidden':
						
						$options[ 'delimiter' ] = isset( $options[ 'delimiter' ] ) ? $options[ 'delimiter' ] : ',';
						
						if ( is_null( $options[ 'value' ] ) ) {
							$options[ 'value' ] = $options[ 'default' ];
						}
						
						if ( ! isset( $options[ 'suffix' ] ) || ! is_array( $options[ 'suffix' ] ) ) {
							$options[ 'suffix' ] = array( '' => '&equals;' );
						}
						
						if ( ! isset( $options[ 'disable' ] ) ) {
							$options[ 'disable' ] = array();
						}
						
						if ( ! isset( $options[ 'split' ] ) ) {
							$options[ 'split' ] = 4;
						}
						
						if ( ! is_array( $options[ 'value' ] ) ) {
							$options[ 'value' ] = explode( $options[ 'delimiter' ], $options[ 'value' ] );
						}
						
						break;
					
					case 'textarea':
						$options[ 'value' ] = empty( $options[ 'value' ] ) ? esc_textarea( $options[ 'default' ] ) : esc_textarea( $options[ 'value' ] );
						
						if ( ! isset( $options[ 'options' ] ) ) {
							$options[ 'options' ][ 'rows' ] = 5;
							//$options[ 'options' ][ 'cols' ] = 5;
							$options[ 'options' ][ 'wrap' ] = 'soft'; // soft, hard
						}
						break;
					
					case 'message':
						$options[ 'value' ] = NULL;
						if ( ! isset( $options[ 'style' ] ) ) {
							$options[ 'style' ] = 'info'; // info, success, warning, error
						}
						break;
					
					case 'heading':
						$options[ 'value' ] = NULL;
						break;
					
					default:
						if ( ! isset( $options[ 'value' ] ) ) {
							$options[ 'value' ] = NULL;
						}
						if ( is_null( $options[ 'value' ] ) ) {
							$options[ 'value' ] = esc_html( $options[ 'default' ] );
						}
						break;
				}
				
				return apply_filters( 'upb_elements_filter_option', $options, $tag );
			}
			
			public function modifyOptions( $options, $tag = '' ) {
				
				switch ( $options[ 'type' ] ) {
					case 'device-hidden':
						$option = array();
						
						if ( ! isset( $options[ 'suffix' ] ) || ! is_array( $options[ 'suffix' ] ) ) {
							$options[ 'suffix' ] = array( '' => '&equals;' );
						}
						
						foreach ( $options[ 'suffix' ] as $k => $v ) {
							foreach ( $options[ 'options' ] as $val ) {
								$option[] = array(
									'id'       => $val[ 'id' ] . $k,
									'title'    => $val[ 'title' ],
									'icon'     => $val[ 'icon' ],
									'suffix'   => $k,
									'symbol'   => $v,
									'disabled' => FALSE
								);
							}
						}
						
						$options[ 'options' ] = $option;
						break;
				}
				
				return $options;
			}
		}
	endif;