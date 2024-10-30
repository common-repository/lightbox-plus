<?php
/**
 * @package Lightbox Plus Colorbox
 * @subpackage actions.class.php
 * @internal 2016.04.18
 * @author Programmattic LLC / Dan Zappone
 * @version 2.8
 * @$Id: actions.class.php 937945 2014-06-24 17:11:13Z dzappone $
 * @$URL: https://plugins.svn.wordpress.org/lightbox-plus/tags/2.7/classes/actions.class.php $
 */
defined( 'ABSPATH' ) or die( 'You kids get off my lawn!' );

if ( ! class_exists( 'Lightbox_Plus_Actions' ) ) {
	class Lightbox_Plus_Actions extends Lightbox_Plus_Filters {
		/**
		 * Tell WordPress to load jquery and jquery-colorbox-min.js in the front end and the admin panel
		 */
//		function getPostID() {
//			global $the_post_id;
//			global $wp_query;
//			$the_post_id = $wp_query->post->ID;
//			echo $the_post_id;
//		}

		/**
		 * Add CSS styles to site page headers to display lightboxed images
		 */
		function lbp_add_header() {
			global $post;
			global $wp_version;
			global $lbp_global_version;
			global $lbp_global_version_colorbox;
			global $lbp_global_plugin_url;
			global $lbp_global_style_url;
			global $lbp_global_style_url_custom;
			global $lbp_global_style_path;
			global $lbp_global_style_path_custom;

			if ( ! empty( $this->lbp_plugin_options ) ) {
				$lbp_plugin_options = $this->lbp_get_admin_options( $this->lbp_options_name );
			}

			/**
			 * Remove following line after a few versions or 2.8 is the prevelent version
			 */
			$lbp_plugin_options = $this->lbp_set_missing_options( $lbp_plugin_options );

			if ( ! is_admin() ) {
				$mobile_browser_list = '(?!x)x';  // initiate variable to not match anything
				if ( isset( $lbp_plugin_options['mobile_browser_settings'] ) && 'none' != $lbp_plugin_options['mobile_browser_settings'] ) {
					switch ( $lbp_plugin_options['mobile_browser_settings'] ) {
						case 'custom':
							if ( isset( $lbp_plugin_options['mobile_browsers_custom'] ) ) {
								$mobile_browser_list = $lbp_plugin_options['mobile_browsers_custom'];
							} else {
								$mobile_browser_list = 'Mobile|iP(hone|od|ad)|Android|BlackBerry|IEMobile';
							}
							break;
						case 'expanded':
							$mobile_browser_list = 'Mobile|iP(hone|od|ad)|Android|BlackBerry|IEMobile|Kindle|NetFront|Silk-Accelerated|(hpw|web)OS|Fennec|Minimo|Opera M(obi|ini)|Blazer|Dolfin|Dolphin|Skyfire|Zune';
							break;
						case 'simple':
							$mobile_browser_list = 'Mobile|iP(hone|od|ad)|Android|BlackBerry|IEMobile';
							break;
						default:
							$mobile_browser_list = '(?!x)x';
							break;
					}
				}

				if ( ! preg_match( '/^' . esc_js( $mobile_browser_list ) . '/i', $_SERVER['HTTP_USER_AGENT'] ) ) {
					wp_enqueue_script( 'jquery', '', '', '', true );
					$this->lbp_enqueue_script( 'jquery.colorbox-min.js', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.colorbox/1.6.3/jquery.colorbox-min.js', '/js/', $lbp_global_version_colorbox, 'jquery', false, $this->lbp_set_load_location( $lbp_plugin_options['load_location'] ) );

					if ( $lbp_plugin_options['use_custom_style'] ) {
						$style_path_url = $lbp_global_style_url_custom;
						$style_path_dir = $lbp_global_style_path_custom;
					} else {
						$style_path_url = $lbp_global_style_url;
						$style_path_dir = $lbp_global_style_path;
					}

					if ( $lbp_plugin_options['disable_css'] ) {
						echo "<!-- User set lightbox styles -->" . PHP_EOL;
					} else {
						wp_register_style( 'lbp_style', $style_path_url . '/' . $lbp_plugin_options['lightboxplus_style'] . '/colorbox.min.css', '', $lbp_global_version_colorbox, 'screen' );
						wp_enqueue_style( 'lbp_style' );

						if ( file_exists( $style_path_dir . '/' . $lbp_plugin_options['lightboxplus_style'] . '/helper.min.js' ) ) {
							wp_enqueue_script( 'lbp_helper', $style_path_url . '/' . $lbp_plugin_options['lightboxplus_style'] . '/helper.min.js', '', $lbp_global_version_colorbox, $this->lbp_set_load_location( $lbp_plugin_options['load_location'] ) );
						}
					}
				}
			}

			if ( isset( $post->ID ) ) {
				return $post->ID;
			} else {
				return null;
			}
		}

		/**
		 * Add JavaScript (jQuery based) to page footer to activate LBP
		 *
		 * @echo string
		 */
		function lbp_lightbox_javascript() {
			global $lbp_global_plugin_url;
			global $lbp_global_version;
			global $lbp_global_version_colorbox;
			global $post;
			if ( ! empty( $this->lbp_plugin_options ) ) {
				$lbp_plugin_options = $this->lbp_get_admin_options( $this->lbp_options_name );
				/**
				 * Remove following line after a few versions or 2.8 is the prevelent version
				 */
				$lbp_plugin_options = $this->lbp_set_missing_options( $lbp_plugin_options );

				$lightboxPlusScript     = "";
				$lightboxPlusJavaScript = "";
				$mobile_browser_list    = '(?!x)x';  // initiate variable to not match anything
				if ( isset( $lbp_plugin_options['mobile_browser_settings'] ) && 'none' != $lbp_plugin_options['mobile_browser_settings'] ) {
					switch ( $lbp_plugin_options['mobile_browser_settings'] ) {
						case 'custom':
							if ( isset( $lbp_plugin_options['mobile_browsers_custom'] ) ) {
								$mobile_browser_list = $lbp_plugin_options['mobile_browsers_custom'];
							} else {
								$mobile_browser_list = 'Mobile|iP(hone|od|ad)|Android|BlackBerry|IEMobile';
							}
							break;
						case 'expanded':
							$mobile_browser_list = 'Mobile|iP(hone|od|ad)|Android|BlackBerry|IEMobile|Kindle|NetFront|Silk-Accelerated|(hpw|web)OS|Fennec|Minimo|Opera M(obi|ini)|Blazer|Dolfin|Dolphin|Skyfire|Zune';
							break;
						case 'simple':
							$mobile_browser_list = 'Mobile|iP(hone|od|ad)|Android|BlackBerry|IEMobile';
							break;
						default:
							$mobile_browser_list = '(?!x)x';
							break;
					}
				}

				if ( ! preg_match( '/^' . esc_js( $mobile_browser_list ) . '/i', $_SERVER['HTTP_USER_AGENT'] ) ) {
					$lightboxPlusScript .= '<!-- Lightbox Plus Colorbox v' . $lbp_global_version . '/' . $lbp_global_version_colorbox . ' - 2013.01.24 - Message: ' . $lbp_plugin_options['lightboxplus_multi'] . '-->' . PHP_EOL;
					$lightboxPlusScript .= '<script type="text/javascript">' . PHP_EOL;


					$lightboxPlusJavaScript .= 'jQuery(document).ready(function($){' . PHP_EOL;
					$lbpArrayPrimary = array();
					if ( 'elastic' != $lbp_plugin_options['transition'] ) {
						$lbpArrayPrimary[] = 'transition:"' . $lbp_plugin_options['transition'] . '"';
					}
					if ( '300' != $lbp_plugin_options['speed'] ) {
						$lbpArrayPrimary[] = 'speed:' . $lbp_plugin_options['speed'];
					}
					if ( 'false' != $lbp_plugin_options['width'] ) {
						$lbpArrayPrimary[] = 'width:' . $this->lbp_set_value( $lbp_plugin_options['width'] );
					}
					if ( 'false' != $lbp_plugin_options['height'] ) {
						$lbpArrayPrimary[] = 'height:' . $this->lbp_set_value( $lbp_plugin_options['height'] );
					}
					if ( 'false' != $lbp_plugin_options['inner_width'] ) {
						$lbpArrayPrimary[] = 'innerWidth:' . $this->lbp_set_value( $lbp_plugin_options['inner_width'] );
					}
					if ( 'false' != $lbp_plugin_options['inner_height'] ) {
						$lbpArrayPrimary[] = 'innerHeight:' . $this->lbp_set_value( $lbp_plugin_options['inner_height'] );
					}
					if ( '600' != $lbp_plugin_options['initial_width'] ) {
						$lbpArrayPrimary[] = 'initialWidth:' . $this->lbp_set_value( $lbp_plugin_options['initial_width'] );
					}
					if ( '450' != $lbp_plugin_options['initial_height'] ) {
						$lbpArrayPrimary[] = 'initialHeight:' . $this->lbp_set_value( $lbp_plugin_options['initial_height'] );
					}
					if ( 'false' != $lbp_plugin_options['max_width'] ) {
						$lbpArrayPrimary[] = 'maxWidth:' . $this->lbp_set_value( $lbp_plugin_options['max_width'] );
					}
					if ( 'false' != $lbp_plugin_options['max_height'] ) {
						$lbpArrayPrimary[] = 'maxHeight:' . $this->lbp_set_value( $lbp_plugin_options['max_height'] );
					}
					if ( '1' != $lbp_plugin_options['resize'] ) {
						$lbpArrayPrimary[] = 'scalePhotos:' . $this->lbp_set_boolean( $lbp_plugin_options['resize'] );
					}
					if ( '1' == $lbp_plugin_options['rel'] ) {
						$lbpArrayPrimary[] = 'rel: false'; //$this->lbp_set_value( $lbp_plugin_options['rel'] );
					}
					if ( '0.9' != $lbp_plugin_options['opacity'] ) {
						$lbpArrayPrimary[] = 'opacity:' . $lbp_plugin_options['opacity'];
					}
					if ( '1' != $lbp_plugin_options['preloading'] ) {
						$lbpArrayPrimary[] = 'preloading:' . $this->lbp_set_boolean( $lbp_plugin_options['preloading'] );
					}
					if ( 'Image' != $lbp_plugin_options['label_image'] && 'of' != $lbp_plugin_options['label_of'] ) {
						$lbpArrayPrimary[] = 'current:"' . $lbp_plugin_options['label_image'] . ' {current} ' . $lbp_plugin_options['label_of'] . ' {total}"';
					}
					if ( 'previous' != $lbp_plugin_options['previous'] ) {
						$lbpArrayPrimary[] = 'previous:"' . $lbp_plugin_options['previous'] . '"';
					}
					if ( 'next' != $lbp_plugin_options['next'] ) {
						$lbpArrayPrimary[] = 'next:"' . $lbp_plugin_options['next'] . '"';
					}
					if ( 'close' != $lbp_plugin_options['close'] ) {
						$lbpArrayPrimary[] = 'close:"' . $lbp_plugin_options['close'] . '"';
					}
					if ( '1' != $lbp_plugin_options['overlay_close'] ) {
						$lbpArrayPrimary[] = 'overlayClose:' . $this->lbp_set_boolean( $lbp_plugin_options['overlay_close'] );
					}
					if ( '1' != $lbp_plugin_options['loop'] ) {
						$lbpArrayPrimary[] = 'loop:' . $this->lbp_set_boolean( $lbp_plugin_options['loop'] );
					}
					if ( '1' == $lbp_plugin_options['slideshow'] ) {
						$lbpArrayPrimary[] = 'slideshow:' . $this->lbp_set_boolean( $lbp_plugin_options['slideshow'] );
					}
					if ( '1' == $lbp_plugin_options['slideshow'] ) {
						if ( '1' != $lbp_plugin_options['slideshow_auto'] ) {
							$lbpArrayPrimary[] = 'slideshowAuto:' . $this->lbp_set_boolean( $lbp_plugin_options['slideshow_auto'] );
						}
						if ( $lbp_plugin_options['slideshow_speed'] ) {
							$lbpArrayPrimary[] = 'slideshowSpeed:' . $lbp_plugin_options['slideshow_speed'];
						}
						if ( $lbp_plugin_options['slideshow_start'] ) {
							$lbpArrayPrimary[] = 'slideshowStart:"' . $lbp_plugin_options['slideshow_start'] . '"';
						}
						if ( $lbp_plugin_options['slideshow_stop'] ) {
							$lbpArrayPrimary[] = 'slideshowStop:"' . $lbp_plugin_options['slideshow_stop'] . '"';
						}
					}
					if ( '1' != $lbp_plugin_options['scrolling'] ) {
						$lbpArrayPrimary[] = 'scrolling:' . $this->lbp_set_boolean( $lbp_plugin_options['scrolling'] );
					}
					if ( '1' != $lbp_plugin_options['esc_key'] ) {
						$lbpArrayPrimary[] = 'escKey:' . $this->lbp_set_boolean( $lbp_plugin_options['esc_key'] );
					}
					if ( '1' != $lbp_plugin_options['arrow_key'] ) {
						$lbpArrayPrimary[] = 'arrowKey:' . $this->lbp_set_boolean( $lbp_plugin_options['arrow_key'] );
					}
					if ( 'false' != $lbp_plugin_options['top'] ) {
						$lbpArrayPrimary[] = 'top:' . $this->lbp_set_value( $lbp_plugin_options['top'] );
					}
					if ( 'false' != $lbp_plugin_options['right'] ) {
						$lbpArrayPrimary[] = 'right:' . $this->lbp_set_value( $lbp_plugin_options['right'] );
					}
					if ( 'false' != $lbp_plugin_options['bottom'] ) {
						$lbpArrayPrimary[] = 'bottom:' . $this->lbp_set_value( $lbp_plugin_options['bottom'] );
					}
					if ( 'false' != $lbp_plugin_options['left'] ) {
						$lbpArrayPrimary[] = 'left:' . $this->lbp_set_value( $lbp_plugin_options['left'] );
					}
					if ( '1' == $lbp_plugin_options['fixed'] ) {
						$lbpArrayPrimary[] = 'fixed:' . $this->lbp_set_boolean( $lbp_plugin_options['fixed'] );
					}
					if ( ! is_admin() ) {
						$lbp_autoload = get_post_meta( $post->ID, '_lbp_autoload', true );
						if ( $lbp_autoload == '1' ) {
							$lbpArrayPrimary[] = 'open:true';
						}
					}
					switch ( $lbp_plugin_options['output_htmlv'] ) {
						case 1:
							$htmlv_prop            = 'data-' . $lbp_plugin_options['data_name'];
							$lightboxPlusFnPrimary = '{rel:$(this).attr("' . $htmlv_prop . '"),' . implode( ",", $lbpArrayPrimary ) . '}';
							switch ( $lbp_plugin_options['use_class_method'] ) {
								case 1:
									$lightboxPlusJavaScript .= '  $(".' . $lbp_plugin_options['class_name'] . '").each(function(){' . PHP_EOL;
									$lightboxPlusJavaScript .= '    $(this).colorbox(' . $lightboxPlusFnPrimary . ');' . PHP_EOL;
									$lightboxPlusJavaScript .= '  });' . PHP_EOL;
									break;
								default:
									$lightboxPlusJavaScript .= '  $("a[' . $htmlv_prop . '*=lightbox]").each(function(){' . PHP_EOL;
									$lightboxPlusJavaScript .= '    $(this).colorbox(' . $lightboxPlusFnPrimary . ');' . PHP_EOL;
									$lightboxPlusJavaScript .= '  });' . PHP_EOL;
									break;
							}
							break;
						default:
							$lightboxPlusFnPrimary = '{' . implode( ",", $lbpArrayPrimary ) . '}';
							switch ( $lbp_plugin_options['use_class_method'] ) {
								case 1:
									$lightboxPlusJavaScript .= '  $(".' . $lbp_plugin_options['class_name'] . '").colorbox(' . $lightboxPlusFnPrimary . ');' . PHP_EOL;
									break;
								default:
									$lightboxPlusJavaScript .= '  $("a[rel*=lightbox]").colorbox(' . $lightboxPlusFnPrimary . ');' . PHP_EOL;
									break;
							}
							break;
					}
					switch ( $lbp_plugin_options['lightboxplus_multi'] ) {
						case 1:
							$lbpArraySecondary = array();
							if ( 'elastic' != $lbp_plugin_options['transition_sec'] ) {
								$lbpArraySecondary[] = 'transition:"' . $lbp_plugin_options['transition_sec'] . '"';
							}
							if ( '350' != $lbp_plugin_options['speed_sec'] ) {
								$lbpArraySecondary[] = 'speed:' . $lbp_plugin_options['speed_sec'];
							}
							if ( $lbp_plugin_options['width_sec'] && 'false' != $lbp_plugin_options['width_sec'] ) {
								$lbpArraySecondary[] = 'width:' . $this->lbp_set_value( $lbp_plugin_options['width_sec'] );
							}
							if ( $lbp_plugin_options['height_sec'] && 'false' != $lbp_plugin_options['height_sec'] ) {
								$lbpArraySecondary[] = 'height:' . $this->lbp_set_value( $lbp_plugin_options['height_sec'] );
							}
							if ( $lbp_plugin_options['inner_width_sec'] && 'false' != $lbp_plugin_options['inner_width_sec'] ) {
								$lbpArraySecondary[] = 'innerWidth:' . $this->lbp_set_value( $lbp_plugin_options['inner_width_sec'] );
							}
							if ( $lbp_plugin_options['inner_height_sec'] && 'false' != $lbp_plugin_options['inner_height_sec'] ) {
								$lbpArraySecondary[] = 'innerHeight:' . $this->lbp_set_value( $lbp_plugin_options['inner_height_sec'] );
							}
							if ( $lbp_plugin_options['initial_width_sec'] && '600' != $lbp_plugin_options['initial_width_sec'] ) {
								$lbpArraySecondary[] = 'initialWidth:' . $this->lbp_set_value( $lbp_plugin_options['initial_width_sec'] );
							}
							if ( $lbp_plugin_options['initial_height_sec'] && '450' != $lbp_plugin_options['initial_height_sec'] ) {
								$lbpArraySecondary[] = 'initialHeight:' . $this->lbp_set_value( $lbp_plugin_options['initial_height_sec'] );
							}
							if ( $lbp_plugin_options['max_width_sec'] && 'false' != $lbp_plugin_options['max_width_sec'] ) {
								$lbpArraySecondary[] = 'maxWidth:' . $this->lbp_set_value( $lbp_plugin_options['max_width_sec'] );
							}
							if ( $lbp_plugin_options['max_height_sec'] && 'false' != $lbp_plugin_options['max_height_sec'] ) {
								$lbpArraySecondary[] = 'maxHeight:' . $this->lbp_set_value( $lbp_plugin_options['max_height_sec'] );
							}
							if ( '1' != $lbp_plugin_options['resize_sec'] ) {
								$lbpArraySecondary[] = 'scalePhotos:' . $this->lbp_set_boolean( $lbp_plugin_options['resize_sec'] );
							}
							if ( 'nofollow' == $lbp_plugin_options['rel_sec'] ) {
								$lbpArrayPrimary[] = 'rel:' . $this->lbp_set_value( $lbp_plugin_options['rel'] );
							}
							if ( '0.9' != $lbp_plugin_options['opacity_sec'] ) {
								$lbpArraySecondary[] = 'opacity:' . $lbp_plugin_options['opacity_sec'];
							}
							if ( '1' != $lbp_plugin_options['preloading_sec'] ) {
								$lbpArraySecondary[] = 'preloading:' . $this->lbp_set_boolean( $lbp_plugin_options['preloading_sec'] );
							}
							if ( 'Image' != $lbp_plugin_options['label_image_sec'] && 'of' != $lbp_plugin_options['label_of_sec'] ) {
								$lbpArraySecondary[] = 'current:"' . $lbp_plugin_options['label_image_sec'] . ' {current} ' . $lbp_plugin_options['label_of_sec'] . ' {total}"';
							}
							if ( 'previous' != $lbp_plugin_options['previous_sec'] ) {
								$lbpArraySecondary[] = 'previous:"' . $lbp_plugin_options['previous_sec'] . '"';
							}
							if ( 'next' != $lbp_plugin_options['next_sec'] ) {
								$lbpArraySecondary[] = 'next:"' . $lbp_plugin_options['next_sec'] . '"';
							}
							if ( 'close' != $lbp_plugin_options['close_sec'] ) {
								$lbpArraySecondary[] = 'close:"' . $lbp_plugin_options['close_sec'] . '"';
							}
							if ( '1' != $lbp_plugin_options['overlay_close_sec'] ) {
								$lbpArraySecondary[] = 'overlayClose:' . $this->lbp_set_boolean( $lbp_plugin_options['overlay_close_sec'] );
							}
							if ( '1' != $lbp_plugin_options['loop_sec'] ) {
								$lbpArrayPrimary[] = 'loop:' . $this->lbp_set_boolean( $lbp_plugin_options['loop_sec'] );
							}
							if ( '1' == $lbp_plugin_options['slideshow_sec'] ) {
								$lbpArraySecondary[] = 'slideshow:' . $this->lbp_set_boolean( $lbp_plugin_options['slideshow_sec'] );
							}
							if ( '1' == $lbp_plugin_options['slideshow_sec'] ) {
								if ( '1' != $lbp_plugin_options['slideshow_auto_sec'] ) {
									$lbpArraySecondary[] = 'slideshowAuto:' . $this->lbp_set_boolean( $lbp_plugin_options['slideshow_auto_sec'] );
								}
								if ( $lbp_plugin_options['slideshow_speed_sec'] ) {
									$lbpArraySecondary[] = 'slideshowSpeed:' . $lbp_plugin_options['slideshow_speed_sec'];
								}
								if ( $lbp_plugin_options['slideshow_start_sec'] ) {
									$lbpArraySecondary[] = 'slideshowStart:"' . $lbp_plugin_options['slideshow_start_sec'] . '"';
								}
								if ( $lbp_plugin_options['slideshow_stop_sec'] ) {
									$lbpArraySecondary[] = 'slideshowStop:"' . $lbp_plugin_options['slideshow_stop_sec'] . '"';
								}
							}
							if ( '0' != $lbp_plugin_options['iframe_sec'] ) {
								$lbpArraySecondary[] = 'iframe:' . $this->lbp_set_boolean( $lbp_plugin_options['iframe_sec'] );
							}
							if ( '1' != $lbp_plugin_options['scrolling_sec'] ) {
								$lbpArrayPrimary[] = 'scrolling:' . $this->lbp_set_boolean( $lbp_plugin_options['scrolling_sec'] );
							}
							if ( '1' != $lbp_plugin_options['esc_key_sec'] ) {
								$lbpArrayPrimary[] = 'escKey:' . $this->lbp_set_boolean( $lbp_plugin_options['esc_key_sec'] );
							}
							if ( '1' != $lbp_plugin_options['arrow_key_sec'] ) {
								$lbpArrayPrimary[] = 'arrowKey:' . $this->lbp_set_boolean( $lbp_plugin_options['arrow_key_sec'] );
							}
							if ( 'false' != $lbp_plugin_options['top_sec'] ) {
								$lbpArrayPrimary[] = 'top:' . $this->lbp_set_value( $lbp_plugin_options['top_sec'] );
							}
							if ( 'false' != $lbp_plugin_options['right_sec'] ) {
								$lbpArrayPrimary[] = 'right:' . $this->lbp_set_value( $lbp_plugin_options['right_sec'] );
							}
							if ( 'false' != $lbp_plugin_options['bottom_sec'] ) {
								$lbpArrayPrimary[] = 'bottom:' . $this->lbp_set_value( $lbp_plugin_options['bottom_sec'] );
							}
							if ( 'false' != $lbp_plugin_options['left_sec'] ) {
								$lbpArrayPrimary[] = 'left:' . $this->lbp_set_value( $lbp_plugin_options['left_sec'] );
							}
							if ( '1' == $lbp_plugin_options['fixed_sec'] ) {
								$lbpArrayPrimary[] = 'fixed:' . $this->lbp_set_boolean( $lbp_plugin_options['fixed_sec'] );
							}
							switch ( $lbp_plugin_options['output_htmlv'] ) {
								case 1:
									$htmlv_prop              = 'data-' . $lbp_plugin_options['data_name'];
									$lightboxPlusFnSecondary = '{rel:$(this).attr("' . $htmlv_prop . '"),' . implode( ",", $lbpArraySecondary ) . '}';
									$lightboxPlusJavaScript .= '  $(".' . $lbp_plugin_options['class_name_sec'] . '").each(function(){' . PHP_EOL;
									$lightboxPlusJavaScript .= '    $(this).colorbox(' . $lightboxPlusFnSecondary . ');' . PHP_EOL;
									$lightboxPlusJavaScript .= '  });' . PHP_EOL;
									break;
								default:
									$lightboxPlusFnSecondary = '{' . implode( ",", $lbpArraySecondary ) . '}';
									$lightboxPlusJavaScript .= '  $(".' . $lbp_plugin_options['class_name_sec'] . '").colorbox(' . $lightboxPlusFnSecondary . ');' . PHP_EOL;
									break;
							}
							break;
						default:
							break;
					}

					if ( $lbp_plugin_options['use_inline'] && '' != $lbp_plugin_options['inline_num'] ) {
						for ( $i = 1; $i <= $lbp_plugin_options['inline_num']; $i ++ ) {
							$inline_links            = $lbp_plugin_options['inline_links'];
							$inline_hrefs            = $lbp_plugin_options['inline_hrefs'];
							$inline_transitions      = $lbp_plugin_options['inline_transitions'];
							$inline_speeds           = $lbp_plugin_options['inline_speeds'];
							$inline_widths           = $lbp_plugin_options['inline_widths'];
							$inline_heights          = $lbp_plugin_options['inline_heights'];
							$inline_inner_widths     = $lbp_plugin_options['inline_inner_widths'];
							$inline_inner_heights    = $lbp_plugin_options['inline_inner_heights'];
							$inline_max_widths       = $lbp_plugin_options['inline_max_widths'];
							$inline_max_heights      = $lbp_plugin_options['inline_max_heights'];
							$inline_position_tops    = $lbp_plugin_options['inline_position_tops'];
							$inline_position_rights  = $lbp_plugin_options['inline_position_rights'];
							$inline_position_bottoms = $lbp_plugin_options['inline_position_bottoms'];
							$inline_position_lefts   = $lbp_plugin_options['inline_position_lefts'];
							$inline_fixeds           = $lbp_plugin_options['inline_fixeds'];
							$inline_opens            = $lbp_plugin_options['inline_opens'];
							$inline_opacitys         = $lbp_plugin_options['inline_opacitys'];
							$lightboxPlusJavaScript .= '  $(".' . $inline_links[ $i - 1 ] . '").colorbox({transition:' . $this->lbp_set_value( $inline_transitions[ $i - 1 ] ) . ', speed:' . $this->lbp_set_value( $inline_speeds[ $i - 1 ] ) . ', width:' . $this->lbp_set_value( $inline_widths[ $i - 1 ] ) . ', height:' . $this->lbp_set_value( $inline_heights[ $i - 1 ] ) . ', innerWidth:' . $this->lbp_set_value( $inline_inner_widths[ $i - 1 ] ) . ', innerHeight:' . $this->lbp_set_value( $inline_inner_heights[ $i - 1 ] ) . ', maxWidth:' . $this->lbp_set_value( $inline_max_widths[ $i - 1 ] ) . ', maxHeight:' . $this->lbp_set_value( $inline_max_heights[ $i - 1 ] ) . ', top:' . $this->lbp_set_value( $inline_position_tops[ $i - 1 ] ) . ', right:' . $this->lbp_set_value( $inline_position_rights[ $i - 1 ] ) . ', bottom:' . $this->lbp_set_value( $inline_position_bottoms[ $i - 1 ] ) . ', left:' . $this->lbp_set_value( $inline_position_lefts[ $i - 1 ] ) . ', fixed:' . $this->lbp_set_boolean( $inline_fixeds[ $i - 1 ] ) . ', open:' . $this->lbp_set_boolean( $inline_opens[ $i - 1 ] ) . ', opacity:' . $this->lbp_set_value( $inline_opacitys[ $i - 1 ] ) . ', inline:true, href:"#' . $inline_hrefs[ $i - 1 ] . '"});' . PHP_EOL;
						}
					}
					
					$lightboxPlusJavaScript .= 'function resizeColorBox()' . PHP_EOL;
					$lightboxPlusJavaScript .= '{' . PHP_EOL;
					$lightboxPlusJavaScript .= "    if (jQuery('#cboxOverlay').is(':visible')) {" . PHP_EOL;
					$lightboxPlusJavaScript .= "    jQuery.colorbox.resize({width:'100%', height:'100%'})" . PHP_EOL;
					$lightboxPlusJavaScript .= '    }' . PHP_EOL;
					$lightboxPlusJavaScript .= '}' . PHP_EOL;

					$lightboxPlusJavaScript .= '// Resize Colorbox when resizing window or changing mobile device orientation' . PHP_EOL;
					$lightboxPlusJavaScript .= 'jQuery(window).resize(resizeColorBox);' . PHP_EOL;
					$lightboxPlusJavaScript .= 'window.addEventListener("orientationchange", resizeColorBox, false);' . PHP_EOL;


					$lightboxPlusJavaScript .= '});' . PHP_EOL;

					$lightboxPlusScript .= Minifier::minify( $lightboxPlusJavaScript );

					$lightboxPlusScript .= '</script>' . PHP_EOL;

					if ( isset( $lbp_plugin_options['responsive'] ) && 0 != $lbp_plugin_options['responsive'] ) {
						$lightboxPlusScript .= "<style>@media only screen and (max-width:" . esc_attr( $lbp_plugin_options['responsive_width'] ) . "px) {#cboxLoadedContent img {max-width:100%;max-height:100%;width:auto !important;height:auto !important;}}</style>" . PHP_EOL;
					}

					echo $lightboxPlusScript;
				}
			}
		}

		/**
		 * Add new admin panel to WordPress under the Appearance category
		 */
		function lbp_add_panel() {
			$plugin_page = add_theme_page( 'Lightbox Plus Colorbox', esc_html__( 'Lightbox Plus Colorbox', 'lightboxplus' ), 'manage_options', 'lightboxplus', array( &$this, 'lbp_admin_panel' ) );
			add_action( 'admin_print_scripts-' . $plugin_page, array( &$this, 'lbp_admin_scripts' ) );
			add_action( 'admin_head-' . $plugin_page, array( &$this, 'lbp_lightbox_javascript' ) );
			add_action( 'admin_print_styles-' . $plugin_page, array( &$this, 'lbp_admin_styles' ) );
		}

		/**
		 * Tell WordPress to load the jquery, jquery-ui-core, jquery-ui-tabs, jquery-colorbox, and custom js in the lightbox plus admin panel
		 */
		function lbp_admin_scripts() {
			global $lbp_global_version;
			global $lbp_global_version_colorbox;
			global $lbp_global_enqueued_script_urls;

			wp_enqueue_script( 'jquery', '', '', '', true );
			wp_enqueue_script( 'jquery-ui-core', '', '', '', true );
			wp_enqueue_script( 'jquery-ui-tabs', '', '', '', true );
			$lbp_global_enqueued_script_urls[] = $this->lbp_enqueue_script( 'jquery.colorbox-min.js', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.colorbox/1.6.3/jquery.colorbox-min.js', '/js/', $lbp_global_version_colorbox, 'jquery' );
			$lbp_global_enqueued_script_urls[] = $this->lbp_enqueue_script( 'highlight.min.js', 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.3.0/highlight.min.js', '/js/', '9.3.0', null, null, false );
			$lbp_global_enqueued_script_urls[] = $this->lbp_enqueue_script( 'lightbox.admin.min.js', '', '/js/', $lbp_global_version, 'jquery' );
		}

		/**
		 * Add CSS styles to lightbox plus admin panel page headers to display lightboxed images
		 */
		function lbp_admin_styles() {
			global $lbp_global_enqueued_script_urls;
			global $lbp_global_style_path;
			global $lbp_global_style_path_custom;
			global $lbp_global_style_url;
			global $lbp_global_style_url_custom;
			global $lbp_global_version;

			$lbp_global_enqueued_script_urls[] = $this->lbp_enqueue_style( 'lightbox.admin.min.css', '', '/admin/', $lbp_global_version, null, 'screen' );
			$lbp_global_enqueued_script_urls[] = $this->lbp_enqueue_style( 'github.min.css', 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.3.0/styles/github.min.css', '/admin/', '9.3.0', null, 'screen' );

			if ( ! empty( $this->lbp_plugin_options ) ) {
				$lbp_plugin_options = $this->lbp_get_admin_options( $this->lbp_options_name );

				if ( $lbp_plugin_options['use_custom_style'] ) {
					$style_path_url = $lbp_global_style_url_custom;
					$style_path_dir = $lbp_global_style_path_custom;
				} else {
					$style_path_url = $lbp_global_style_url;
					$style_path_dir = $lbp_global_style_path;
				}

				if ( $lbp_plugin_options['disable_css'] ) {
					echo "<!-- User set lightbox styles -->" . PHP_EOL;
				} else {
					wp_register_style( 'lbp_style', $style_path_url . '/' . $lbp_plugin_options['lightboxplus_style'] . '/colorbox.css', '', $lbp_global_version, 'screen' );
					wp_enqueue_style( 'lbp_style' );
					if ( file_exists( $style_path_dir . '/' . $lbp_plugin_options['lightboxplus_style'] . '/helper.min.js' ) ) {
						wp_enqueue_script( 'lbp_helper', $style_path_url . '/' . $lbp_plugin_options['lightboxplus_style'] . '/helper.min.js', '', $lbp_global_version, true );
					}
				}
			}
		}

		/**
		 * Add metabox to edit post/page for per page application of lightbox plus
		 */
		function lbp_do_save_meta() {
			add_action( 'save_post', array( $this, 'lbp_save_meta' ), 10, 1 );
		}

		function lbp_save_meta_box() {
			add_meta_box( 'lbp-meta-box', esc_html__( 'Lightbox Plus Colorbox Per Page', 'lightboxplus' ), array( &$this, 'lbp_draw_meta' ), 'page', 'side', 'high' );
		}

		function lbp_draw_meta( $post ) {
			wp_nonce_field( 'lbp_meta_nonce', 'nonce_lbp' );
			$lbp_use      = get_post_meta( $post->ID, '_lbp_use', true );
			$lbp_uid      = get_post_meta( $post->ID, '_lbp_uid', true );
			$lbp_autoload = get_post_meta( $post->ID, '_lbp_autoload', true );
			?>
			<table class="form-table">
				<tr>
					<th scope="row">
						<label for="lbp_use"><?php esc_html_e( 'Use with this page/post:', 'lightboxplus' ); ?></label>:
					</th>
					<td>
						<input type="hidden" name="lbp_use" value="0">
						<input type="checkbox" name="lbp_use" id="lbp_use" value="1" <?php if ( isset( $lbp_use ) ) {
							checked( '1', $lbp_use );
						} ?> />
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="lbp_autoload"><?php esc_html_e( 'Auto launch on this page/post:', 'lightboxplus' ); ?></label>:
					</th>
					<td>
						<input type="hidden" name="lbp_autoload" value="0">
						<input type="checkbox" name="lbp_autoload" id="lbp_autoload" value="1"<?php if ( isset( $lbp_autoload ) ) {
							checked( '1', $lbp_autoload );
						} ?> />
					</td>
				</tr>
				<tr>
					<th scope="row" colspan="2"><label for="lbp_uid"><?php esc_html_e( 'Lightbox Plus Colorbox unique ID for this page:', 'lightboxplus' ); ?></label>:</th>
				</tr>
				<tr>
					<td colspan="2">
						<input type="text" id="lbp_uid" name="lbp_uid" size="40" value="<?php if ( ! empty( $lbp_uid ) ) {
							echo $lbp_uid;
						} else {
							echo $post->post_name;
						} ?>"/>
						<br/>
						<small><?php esc_html_e( '(defaults to page/post name/slug)', 'lightboxplus' ); ?></small>
					</td>
				</tr>
			</table>

			<?php
		}

		function lbp_save_meta( $post_id ) {
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return null;
			}

			if ( isset( $_POST['nonce_lbp'] ) && ! wp_verify_nonce( $_POST['nonce_lbp'], 'lbp_meta_nonce' ) ) {
				return null;
			}

			if ( isset( $_POST['post_type'] ) && $_POST['post_type'] == 'page' ) {
				if ( isset( $postid ) ) {
					if ( ! current_user_can( 'edit_page', $postid ) ) {
						return null;
					}
				}
			} else {
				if ( isset( $postid ) && ! current_user_can( 'edit_post', $postid ) ) {
					return null;
				}
			}

			if ( isset( $post_id ) ) {
				if ( isset( $_POST['lbp_use'] ) ) {
					$lbp_use = $this->sanitize_checkbox( $_POST['lbp_use'] );
					update_post_meta( $post_id, '_lbp_use', $lbp_use );
				}
				if ( isset( $_POST['lbp_autoload'] ) ) {
					$lbp_autoload = $this->sanitize_checkbox( $_POST['lbp_autoload'] );
					update_post_meta( $post_id, '_lbp_autoload', $lbp_autoload );
				}
				if ( isset( $_POST['lbp_uid'] ) ) {
					$lbp_uid = $this->sanitize_checkbox( $_POST['lbp_uid'] );
					update_post_meta( $post_id, '_lbp_uid', $lbp_uid );
				}
			}

			return $post_id;
		}
	}
}