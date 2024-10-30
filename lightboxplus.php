<?php
/*
Plugin Name: Lightbox Plus Colorbox
Plugin URI: http://www.23systems.net/plugins/lightbox-plus/
Description: Lightbox Plus Colorbox implements Colorbox as a lightbox image overlay tool for WordPress.  <a href="http://www.jacklmoore.com/colorbox">Colorbox</a> was created by Jack Moore of Color Powered and is licensed under the <a href="http://www.opensource.org/licenses/mit-license.php">MIT License</a>.
Author: Programmattic LLC, Dan Zappone
Author URI: http://www.23systems.net/
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html.
Version: 2.8
*/
defined( 'ABSPATH' ) or die( 'You kids get off my lawn!' );
/**
 * @package Lightbox Plus Colorbox
 * @subpackage lightboxplus.php
 * @internal 2016.04.18
 * @author Programmattic LLC / Dan Zappone
 * @version 2.8
 * @$Id: lightboxplus.php 937945 2014-06-24 17:11:13Z dzappone $
 * @$URL: https://plugins.svn.wordpress.org/lightbox-plus/tags/2.7/lightboxplus.php $
 */

/**
 * WordPress Globals
 *
 * @var mixed
 */
global $post;
global $content;
global $page;
global $wp_query;
global $wp_version;
global $the_post_id;

/**
 * Lightbox Plus Colorbox Globals
 *
 * @var mixed
 */
global $lbp_global_enqueued_script_urls;
global $lbp_global_message_warning;
global $lbp_global_messages_error;
global $lbp_global_messages_info;
global $lbp_global_messages_success;
global $lbp_global_messages_title;
global $lbp_global_plugin_page;
global $lbp_global_plugin_path;
global $lbp_global_plugin_url;
global $lbp_global_style_path;
global $lbp_global_style_path_custom;
global $lbp_global_style_url;
global $lbp_global_style_url_custom;
global $lbp_global_version;
global $lbp_global_version_colorbox;
global $lbp_global_version_shortcode;
global $lbp_global_version_dom;

if ( version_compare( PHP_VERSION, '5.3', '<' ) ) {
	function lbp_admin_notice() {
		echo '<div class="notice notice-error is-dismissible"><p>' . esc_html__( "Lightbox Plus Colorbox was not activated or was deactivated because the plugin requires PHP 5.3 or greater and you are running PHP ", 'lightboxplus' ) . PHP_VERSION . '</p></div>';
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
	}

	function lbp_deactivate_self() {
		deactivate_plugins( plugin_basename( __FILE__ ) );
	}

	add_action( 'admin_notices', 'lbp_admin_notice' );
	add_action( 'admin_init', 'lbp_deactivate_self' );

	return;
} else {
	/**
	 * Instantiate Lightbox Plus Colorbox Globals
	 *
	 * @var mixed
	 */
	$lbp_global_dom_library          = '';
	$lbp_global_dom_library          = 'QueryPath';
	$lbp_global_enqueued_script_urls = array();
	$lbp_global_message_warning      = array();
	$lbp_global_messages_error       = array();
	$lbp_global_messages_info        = array();
	$lbp_global_messages_success     = array();
	$lbp_global_messages_title       = '';
	$lbp_global_plugin_page          = '';
	$lbp_global_plugin_path          = plugin_dir_path( __FILE__ );
	$lbp_global_plugin_url           = plugin_dir_url( __FILE__ );
	$lbp_global_style_path           = $lbp_global_plugin_path . '/css';
	$lbp_global_style_path_custom    = ABSPATH . 'wp-content' . '/lbp-css';
	$lbp_global_style_url            = $lbp_global_plugin_url . 'css';
	$lbp_global_style_url_custom     = content_url() . '/lbp-css';
	$lbp_global_version              = '2.8';
	$lbp_global_version_colorbox     = '1.6.3';
	$lbp_global_version_dom          = '3.0';
	$lbp_global_version_querypath    = '3.0';
	$lbp_global_version_shortcode    = '4.5';

	/**
	 * Require extended Lightbox Plus Colorbox classes
	 *
	 * Require class containing all utility functions
	 */
	require_once( 'classes/utility.class.php' );

	/**
	 * Require appropriate shortcode class depending on version of WordPress
	 */
//	require_once( 'classes/shortcode.class.php' );

	/**
	 * Require appropriate version of filters class for PHP version.
	 */
	require_once( 'classes/filters.class.php' );

	/**
	 * Require class containing all plugin actions
	 */
	require_once( 'classes/actions.class.php' );

	/**
	 * Require class containing all initializations actions
	 */
	require_once( 'classes/init.class.php' );

	/**
	 * Require appropriate 3rd Party Libraries for PHP version.
	 *
	 * Minifier.php is only compatible with PHP 5.3 or greater
	 * qp.php is only compatible with PHP 5.3 or greater
	 */
	require_once( 'lib/Minifier.php' );
	require_once( 'lib/qp.php' );

	/**
	 * On Plugin Activation initialize settings
	 */
	if ( ! function_exists( 'lbp_activate' ) ) {
		function lbp_activate() {
			$lbp_activate = new Lightbox_Plus_Init();
			$lbp_activate->lbp_initialize();
			unset( $lbp_activate );
		}
	}

	/**
	 * On plugin deactivation
	 */
	if ( ! function_exists( 'lbp_deactivate' ) ) {
		function lbp_deactivate() {
		}
	}

	/**
	 * On plugin uninastall remove settings
	 */
	if ( ! function_exists( 'lbp_uninstall' ) ) {
		function lbp_uninstall() {
			delete_option( 'lightboxplus_options' );
			delete_option( 'lightboxplus_init' );
		}
	}

	/**
	 * Register activation/deactivation hooks and text domain
	 */
	register_activation_hook( __FILE__, 'lbp_activate' );
	register_deactivation_hook( __FILE__, 'lbp_deactivate' );
	register_uninstall_hook( __FILE__, 'lbp_uninstall' );
	load_plugin_textdomain( 'lightboxplus', false, $path = $lbp_global_plugin_url . 'languages' );

	/**
	 * Ensure Lightbox_Plus_Colorbox class doesn't already exist
	 */
	if ( ! class_exists( 'Lightbox_Plus_Colorbox' ) ) {
		class Lightbox_Plus_Colorbox extends Lightbox_Plus_Init {
			/**
			 * The name the options are saved under in the database
			 *
			 * @var mixed
			 */
			var $lbp_options_name = 'lightboxplus_options';
			var $lbp_init_name = 'lightboxplus_init';
			var $lbp_style_path_name = 'lightboxplus_style_path';

			/**
			 * PHP 5 constructor
			 */
			function __construct() {
				add_action( 'init', array( $this, 'init' ) );
			}

			/**
			 * The PHP 5 Constructor - initializes the plugin and sets up panels
			 */
			function init() {
				$this->lbp_plugin_options = $this->lbp_get_admin_options( $this->lbp_options_name );

				if ( ! empty( $this->lbp_plugin_options ) ) {
					$lbp_plugin_options = $this->lbp_get_admin_options( $this->lbp_options_name );
				}

				/**
				 * If user is in the admin panel
				 */
				if ( is_admin() && current_user_can( 'administrator' ) ) {
					add_action( 'admin_menu', array( &$this, 'lbp_add_panel' ) );
					/**
					 * Check to see if the user wants to use per page/post options
					 */
					if ( ( isset( $lbp_plugin_options['use_forpage'] ) && '1' == $lbp_plugin_options['use_forpage'] ) || ( isset( $lbp_plugin_options['use_forpost'] ) && '1' == $lbp_plugin_options['use_forpost'] ) ) {
						add_action( 'save_post', array( &$this, 'lbp_save_meta' ), 10, 2 );
						add_action( 'add_meta_boxes', array( &$this, "lbp_save_meta_box" ), 10, 2 );
					}
					$this->lbp_finish();
				}
				add_action( 'template_redirect', array( &$this, 'lbp_start' ) );
				add_filter( 'plugin_row_meta', array( &$this, 'lbp_register_links' ), 10, 2 );
			}

			function lbp_start() {
				global $the_post_id;
				global $wp_query;

				$the_post_id = $wp_query->post->ID;

				if ( ! empty( $this->lbp_plugin_options ) ) {
					$lbp_plugin_options = $this->lbp_get_admin_options( $this->lbp_options_name );
				}

				/**
				 * Remove following line after a few versions or 2.8 is the prevelent version
				 */
				$lbp_plugin_options = $this->lbp_set_missing_options( $lbp_plugin_options );

				if ( isset( $lbp_plugin_options['use_perpage'] ) && '0' != $lbp_plugin_options['use_perpage'] ) {
					add_action( 'wp_print_styles', array( &$this, 'lbp_add_header' ), intval( $lbp_plugin_options['load_priority'] ) );
					if ( $lbp_plugin_options['use_forpage'] && get_post_meta( $the_post_id, '_lbp_use', true ) ) {
						$this->lbp_finish();
					}
					if ( $lbp_plugin_options['use_forpost'] && ( ( $wp_query->is_posts_page ) || is_single() ) ) {
						$this->lbp_finish();
					}
				} else {
					$this->lbp_finish();
				}
			}

			function lbp_finish() {

				/**
				 * Get lightbox options to check for auto-lightbox and gallery
				 */
				if ( ! empty( $this->lbp_plugin_options ) ) {
					$lbp_plugin_options = $this->lbp_get_admin_options( $this->lbp_options_name );
					/**
					 * Remove following line after a few versions or 2.8 is the prevelent version
					 */
					$lbp_plugin_options = $this->lbp_set_missing_options( $lbp_plugin_options );

					add_action( 'wp_print_styles', array( &$this, 'lbp_add_header' ), intval( $lbp_plugin_options['load_priority'] ) );

					/**
					 * Check to see if users wants images auto-lightboxed
					 */
					if ( 1 != $lbp_plugin_options['no_auto_lightbox'] ) {
						/**
						 * Check to see if user wants to have gallery images lightboxed
						 */
//						if ( 1 != $lbp_plugin_options['gallery_lightboxplus'] ) {

						add_filter( 'the_content', array( &$this, 'lbp_filter_replace' ), 11 );
//						} else {
//							remove_shortcode( 'gallery' );
//							add_shortcode( 'gallery', array( &$this, 'lbp_gallery_replace' ) );
//							add_filter( 'the_content', array( &$this, 'lbp_filter_replace' ), 11 );
//						}
					}
					add_action( $lbp_plugin_options['load_location'], array( &$this, 'lbp_lightbox_javascript' ), ( intval( $lbp_plugin_options['load_priority'] ) + 4 ) );
				}
			}

			/**
			 * Retrieves the options from the database.
			 *
			 * @param $lbp_options_name
			 *
			 * @return mixed
			 */
			function lbp_get_admin_options( $lbp_options_name ) {
				$lbp_options = get_option( $lbp_options_name );
				if ( ! empty( $lbp_options ) ) {
					foreach ( $lbp_options as $key => $lbp_the_option ) {
						$lbp_current_option[ $key ] = $lbp_the_option;
					}
				}
				update_option( $lbp_options_name, $lbp_current_option );

				return $lbp_current_option;
			}

			/**
			 * Saves the admin options to the database.
			 *
			 * @param $lbp_options_name
			 * @param $lbp_options
			 */
			function lbp_save_admin_options( $lbp_options_name, $lbp_options ) {
				update_option( $lbp_options_name, $lbp_options );
			}

			/**
			 * Adds links to the plugin row on the plugins page.
			 * This add_filter function must be in this file or it does not work correctly, requires plugin_basename and file match
			 *
			 * @param $lbp_links
			 * @param $lbp_filename
			 *
			 * @return array
			 */
			function lbp_register_links( $lbp_links, $lbp_filename ) {
				$lbp_base_name = plugin_basename( __FILE__ );
				if ( $lbp_base_name == $lbp_filename ) {
					$lbp_links[] = '<a href="themes.php?page=lightboxplus" title="Lightbox Plus Colorbox Settings">' . esc_html__( 'Settings', 'lightboxplus' ) . '</a>';
					$lbp_links[] = '<a href="http://www.23systems.net/wordpress-plugins/lightbox-plus-for-wordpress/frequently-asked-questions/" title="Lightbox Plus Colorbox FAQ">' . esc_html__( 'FAQ', 'lightboxplus' ) . '</a>';
					$lbp_links[] = '<a href="http://twitter.com/23systems" title="@23System on Twitter">' . esc_html__( 'Twitter', 'lightboxplus' ) . '</a>';
					$lbp_links[] = '<a href="http://www.facebook.com/23Systems" title="23Systems on Facebook">' . esc_html__( 'Facebook', 'lightboxplus' ) . '</a>';
					$lbp_links[] = '<a href="http://www.linkedin.com/company/23systems" title="23Systems on LinkedIn">' . esc_html__( 'LinkedIn', 'lightboxplus' ) . '</a>';
					$lbp_links[] = '<a href="https://plus.google.com/111641141856782935011/posts" title="23System on Google+">' . esc_html__( 'Google+', 'lightboxplus' ) . '</a>';
					$lbp_links[] = '<a href="http://www.23systems.net/donate/" title="Donate to Lightbox Plus Colorbox">' . esc_html__( 'Donate', 'lightboxplus' ) . '</a>';
				}

				return $lbp_links;
			}

			/**
			 * The admin panel function
			 * handles creating admin panel and processing of form submission
			 */
			function lbp_admin_panel() {
				global $lbp_global_dom_library;
				global $lbp_global_message_warning;
				global $lbp_global_messages_error;
				global $lbp_global_messages_info;
				global $lbp_global_messages_success;
				global $lbp_global_messages_title;
				global $lbp_global_plugin_url;
				global $lbp_global_style_path;
				global $lbp_global_style_path_custom;
				global $lbp_global_version;
				global $lbp_global_version_colorbox;
				global $lbp_global_version_dom;
				global $lbp_global_version_shortcode;

				$location = admin_url( '/admin.php?page=lightboxplus' );
				/**
				 * Check form submission and update setting
				 */
				if ( isset( $_POST['action'] ) ) {
					switch ( $_POST['sub'] ) {
						case 'settings':
							$lbp_plugin_options = array(
								"lightboxplus_multi"      => $this->sanitize_checkbox( $_POST['lightboxplus_multi'] ),
								"use_inline"              => $this->sanitize_checkbox( $_POST['use_inline'] ),
								"inline_num"              => sanitize_text_field( $_POST['inline_num'] ),
								"lightboxplus_style"      => sanitize_text_field( $_POST['lightboxplus_style'] ),
								"use_custom_style"        => $this->sanitize_checkbox( $_POST['use_custom_style'] ),
								"disable_css"             => $this->sanitize_checkbox( $_POST['disable_css'] ),
								"hide_about"              => $this->sanitize_checkbox( $_POST['hide_about'] ),
								"output_htmlv"            => $this->sanitize_checkbox( $_POST['output_htmlv'] ),
								"data_name"               => sanitize_text_field( $_POST['data_name'] ),
								"load_location"           => sanitize_text_field( $_POST['load_location'] ),
								"load_priority"           => sanitize_text_field( $_POST['load_priority'] ),
								"use_perpage"             => $this->sanitize_checkbox( $_POST['use_perpage'] ),
								"use_forpage"             => $this->sanitize_checkbox( $_POST['use_forpage'] ),
								"use_forpost"             => $this->sanitize_checkbox( $_POST['use_forpost'] ),
								"transition"              => sanitize_text_field( $_POST['transition'] ),
								"speed"                   => sanitize_text_field( $_POST['speed'] ),
								"width"                   => sanitize_text_field( $_POST['width'] ),
								"height"                  => sanitize_text_field( $_POST['height'] ),
								"inner_width"             => sanitize_text_field( $_POST['inner_width'] ),
								"inner_height"            => sanitize_text_field( $_POST['inner_height'] ),
								"initial_width"           => sanitize_text_field( $_POST['initial_width'] ),
								"initial_height"          => sanitize_text_field( $_POST['initial_height'] ),
								"max_width"               => sanitize_text_field( $_POST['max_width'] ),
								"max_height"              => sanitize_text_field( $_POST['max_height'] ),
								"resize"                  => $this->sanitize_checkbox( $_POST['resize'] ),
								"opacity"                 => sanitize_text_field( $_POST['opacity'] ),
								"preloading"              => $this->sanitize_checkbox( $_POST['preloading'] ),
								"label_image"             => sanitize_text_field( $_POST['label_image'] ),
								"label_of"                => sanitize_text_field( $_POST['label_of'] ),
								"previous"                => sanitize_text_field( $_POST['previous'] ),
								"next"                    => sanitize_text_field( $_POST['next'] ),
								"close"                   => sanitize_text_field( $_POST['close'] ),
								"overlay_close"           => $this->sanitize_checkbox( $_POST['overlay_close'] ),
								"slideshow"               => $this->sanitize_checkbox( $_POST['slideshow'] ),
								"slideshow_auto"          => $this->sanitize_checkbox( $_POST['slideshow_auto'] ),
								"slideshow_speed"         => sanitize_text_field( $_POST['slideshow_speed'] ),
								"slideshow_start"         => sanitize_text_field( $_POST['slideshow_start'] ),
								"slideshow_stop"          => sanitize_text_field( $_POST['slideshow_stop'] ),
								"use_caption_title"       => $this->sanitize_checkbox( $_POST['use_caption_title'] ),
								"gallery_lightboxplus"    => $this->sanitize_checkbox( $_POST['gallery_lightboxplus'] ),
								"multiple_galleries"      => $this->sanitize_checkbox( $_POST['multiple_galleries'] ),
								"use_class_method"        => $this->sanitize_checkbox( $_POST['use_class_method'] ),
								"class_name"              => sanitize_text_field( $_POST['class_name'] ),
								"no_auto_lightbox"        => $this->sanitize_checkbox( $_POST['no_auto_lightbox'] ),
								"text_links"              => $this->sanitize_checkbox( $_POST['text_links'] ),
								"no_display_title"        => $this->sanitize_checkbox( $_POST['no_display_title'] ),
								"scrolling"               => $this->sanitize_checkbox( $_POST['scrolling'] ),
								"photo"                   => $this->sanitize_checkbox( $_POST['photo'] ),
								"rel"                     => $this->sanitize_checkbox( $_POST['rel'] ), //Disable grouping
								"loop"                    => $this->sanitize_checkbox( $_POST['loop'] ),
								"esc_key"                 => $this->sanitize_checkbox( $_POST['esc_key'] ),
								"arrow_key"               => $this->sanitize_checkbox( $_POST['arrow_key'] ),
								"top"                     => sanitize_text_field( $_POST['top'] ),
								"bottom"                  => sanitize_text_field( $_POST['bottom'] ),
								"left"                    => sanitize_text_field( $_POST['left'] ),
								"right"                   => sanitize_text_field( $_POST['right'] ),
								"fixed"                   => $this->sanitize_checkbox( $_POST['fixed'] ),
								"mobile_browser_settings" => sanitize_text_field( $_POST['mobile_browser_settings'] ),
								"mobile_browsers_custom"  => sanitize_text_field( $_POST['mobile_browsers_custom'] ),
								"responsive"              => $this->sanitize_checkbox( $_POST['responsive'] ),
								"responsive_width"        => sanitize_text_field( $_POST['responsive_width'] )
							);

							$lbp_global_messages_title .= esc_html__( 'Lightbox Plus Colorbox Setting Saved', 'lightboxplus' );
							$lbp_global_messages_success[] = esc_html__( 'Core settings saved.', 'lightboxplus' );
							$lbp_global_messages_success[] = esc_html__( 'Primary lightbox settings saved.', 'lightboxplus' );

							if ( isset( $_POST['lightboxplus_multi'] ) && isset( $_POST['ready_sec'] ) ) {
								$lbp_plugin_secondary_options = array(
									"transition_sec"       => sanitize_text_field( $_POST['transition_sec'] ),
									"speed_sec"            => sanitize_text_field( $_POST['speed_sec'] ),
									"width_sec"            => sanitize_text_field( $_POST['width_sec'] ),
									"height_sec"           => sanitize_text_field( $_POST['height_sec'] ),
									"inner_width_sec"      => sanitize_text_field( $_POST['inner_width_sec'] ),
									"inner_height_sec"     => sanitize_text_field( $_POST['inner_height_sec'] ),
									"initial_width_sec"    => sanitize_text_field( $_POST['initial_width_sec'] ),
									"initial_height_sec"   => sanitize_text_field( $_POST['initial_height_sec'] ),
									"max_width_sec"        => sanitize_text_field( $_POST['max_width_sec'] ),
									"max_height_sec"       => sanitize_text_field( $_POST['max_height_sec'] ),
									"resize_sec"           => $this->sanitize_checkbox( $_POST['resize_sec'] ),
									"opacity_sec"          => sanitize_text_field( $_POST['opacity_sec'] ),
									"preloading_sec"       => sanitize_text_field( $_POST['preloading_sec'] ),
									"label_image_sec"      => sanitize_text_field( $_POST['label_image_sec'] ),
									"label_of_sec"         => sanitize_text_field( $_POST['label_of_sec'] ),
									"previous_sec"         => sanitize_text_field( $_POST['previous_sec'] ),
									"next_sec"             => sanitize_text_field( $_POST['next_sec'] ),
									"close_sec"            => sanitize_text_field( $_POST['close_sec'] ),
									"overlay_close_sec"    => $this->sanitize_checkbox( $_POST['overlay_close_sec'] ),
									"slideshow_sec"        => $this->sanitize_checkbox( $_POST['slideshow_sec'] ),
									"slideshow_auto_sec"   => $this->sanitize_checkbox( $_POST['slideshow_auto_sec'] ),
									"slideshow_speed_sec"  => sanitize_text_field( $_POST['slideshow_speed_sec'] ),
									"slideshow_start_sec"  => sanitize_text_field( $_POST['slideshow_start_sec'] ),
									"slideshow_stop_sec"   => sanitize_text_field( $_POST['slideshow_stop_sec'] ),
									"iframe_sec"           => $this->sanitize_checkbox( $_POST['iframe_sec'] ),
									"class_name_sec"       => sanitize_text_field( $_POST['class_name_sec'] ),
									"no_display_title_sec" => $this->sanitize_checkbox( $_POST['no_display_title_sec'] ),
									"scrolling_sec"        => $this->sanitize_checkbox( $_POST['scrolling_sec'] ),
									"photo_sec"            => $this->sanitize_checkbox( $_POST['photo_sec'] ),
									"rel_sec"              => $this->sanitize_checkbox( $_POST['rel_sec'] ), //Disable grouping
									"loop_sec"             => $this->sanitize_checkbox( $_POST['loop_sec'] ),
									"esc_key_sec"          => $this->sanitize_checkbox( $_POST['esc_key_sec'] ),
									"arrow_key_sec"        => $this->sanitize_checkbox( $_POST['arrow_key_sec'] ),
									"top_sec"              => sanitize_text_field( $_POST['top_sec'] ),
									"bottom_sec"           => sanitize_text_field( $_POST['bottom_sec'] ),
									"left_sec"             => sanitize_text_field( $_POST['left_sec'] ),
									"right_sec"            => sanitize_text_field( $_POST['right_sec'] ),
									"fixed_sec"            => $this->sanitize_checkbox( $_POST['fixed_sec'] )
								);
								$lbp_plugin_options           = array_merge( $lbp_plugin_options, $lbp_plugin_secondary_options );
								unset( $lbp_plugin_secondary_options );
								$lbp_global_messages_success[] = esc_html__( 'Secondary lightbox settings saved.', 'lightboxplus' );
							}

							if ( $_POST['use_inline'] && isset( $_POST['ready_inline'] ) ) {
								if ( ! empty( $this->lbp_plugin_options ) ) {
									$lbp_plugin_inline_options = $this->lbp_get_admin_options( $this->lbp_options_name );
								}

								if ( $lbp_plugin_inline_options['use_inline'] && '' != $lbp_plugin_inline_options['inline_num'] ) {
									$inline_links            = '';
									$inline_hrefs            = array();
									$inline_transitions      = array();
									$inline_speeds           = array();
									$inline_widths           = array();
									$inline_heights          = array();
									$inline_inner_widths     = array();
									$inline_inner_heights    = array();
									$inline_max_widths       = array();
									$inline_max_heights      = array();
									$inline_position_tops    = array();
									$inline_position_rights  = array();
									$inline_position_bottoms = array();
									$inline_position_lefts   = array();
									$inline_fixeds           = array();
									$inline_opens            = array();
									$inline_opacitys         = array();
									for ( $i = 1; $i <= $lbp_plugin_inline_options['inline_num']; $i ++ ) {
										$inline_links[]            = sanitize_text_field( $_POST["inline_link_$i"] );
										$inline_hrefs[]            = sanitize_text_field( $_POST["inline_href_$i"] );
										$inline_transitions[]      = sanitize_text_field( $_POST["inline_transition_$i"] );
										$inline_speeds[]           = sanitize_text_field( $_POST["inline_speed_$i"] );
										$inline_widths[]           = sanitize_text_field( $_POST["inline_width_$i"] );
										$inline_heights[]          = sanitize_text_field( $_POST["inline_height_$i"] );
										$inline_inner_widths[]     = sanitize_text_field( $_POST["inline_inner_width_$i"] );
										$inline_inner_heights[]    = sanitize_text_field( $_POST["inline_inner_height_$i"] );
										$inline_max_widths[]       = sanitize_text_field( $_POST["inline_max_width_$i"] );
										$inline_max_heights[]      = sanitize_text_field( $_POST["inline_max_height_$i"] );
										$inline_position_tops[]    = sanitize_text_field( $_POST["inline_position_top_$i"] );
										$inline_position_rights[]  = sanitize_text_field( $_POST["inline_position_right_$i"] );
										$inline_position_bottoms[] = sanitize_text_field( $_POST["inline_position_bottom_$i"] );
										$inline_position_lefts[]   = sanitize_text_field( $_POST["inline_position_left_$i"] );
										$inline_fixeds[]           = $this->sanitize_checkbox( $_POST["inline_fixed_$i"] );
										$inline_opens[]            = $this->sanitize_checkbox( $_POST["inline_open_$i"] );
										$inline_opacitys[]         = sanitize_text_field( $_POST["inline_opacity_$i"] );
									}
								}
							}

							$lbp_plugin_inline_options = array(
								"inline_links"            => $inline_links,
								"inline_hrefs"            => $inline_hrefs,
								"inline_transitions"      => $inline_transitions,
								"inline_speeds"           => $inline_speeds,
								"inline_widths"           => $inline_widths,
								"inline_heights"          => $inline_heights,
								"inline_inner_widths"     => $inline_inner_widths,
								"inline_inner_heights"    => $inline_inner_heights,
								"inline_max_widths"       => $inline_max_widths,
								"inline_max_heights"      => $inline_max_heights,
								"inline_position_tops"    => $inline_position_tops,
								"inline_position_rights"  => $inline_position_rights,
								"inline_position_bottoms" => $inline_position_bottoms,
								"inline_position_lefts"   => $inline_position_lefts,
								"inline_fixeds"           => $inline_fixeds,
								"inline_opens"            => $inline_opens,
								"inline_opacitys"         => $inline_opacitys
							);

							$lbp_plugin_options = array_merge( $lbp_plugin_options, $lbp_plugin_inline_options );
							unset( $lbp_plugin_inline_options );
							$lbp_global_messages_success[] = esc_html__( 'Inline lightbox settings saved.', 'lightboxplus' );


							$nonce = $_REQUEST['_wpnonce'];
							if ( ! wp_verify_nonce( $nonce, 'lbp-nonce' ) ) {
								$nonce_save_error = '<div class="notice notice-error"><p>' . esc_attr__( 'Error saving settings', 'lightboxplus' ) . '</p></div>';
								die( $nonce_save_error );
							} else {
								$this->lbp_save_admin_options( $this->lbp_options_name, $lbp_plugin_options );
							}

							/**
							 * Load options info array if not yet loaded
							 */
							if ( ! empty( $this->lbp_plugin_options ) ) {
								$lbp_plugin_options = $this->lbp_get_admin_options( $this->lbp_options_name );
							}

							/**
							 * Initialize Custom lightbox Plus Path
							 */
							if ( $_POST['use_custom_style'] && ! is_dir( $lbp_global_style_path_custom ) ) {
								$directory_creation_result = $this->lbp_custom_styles_initialize();
								if ( $directory_creation_result ) {
									$lbp_global_messages_success[] = esc_html__( 'Lightbox custom styles initialized.', 'lightboxplus' );
								} else {
									$lbp_global_messages_success[] = esc_html__( '<strong style="color:#900;">Lightbox custom styles initialization failed.</strong><br />Please create a directory called <code>lbp-css</code> in your <code>wp-content</code> directory and copy the styles located in <code>wp-content/plugins/lightbox-plus/css/</code> to <code>wp-content/lbp-css</code>', 'lightboxplus' );
								}
							}

							/**
							 * Initialize Secondary Lightbox if enabled
							 */
							if ( $_POST['lightboxplus_multi'] && ! isset( $_POST['class_name_sec'] ) ) {
								$this->lbp_secondary_initialize();
								$lbp_global_messages_success[] = esc_html__( 'Secondary lightbox settings initialized.', 'lightboxplus' );
							}
							/**
							 *  Initialize Inline Lightboxes if enabled
							 */
							if ( $_POST['use_inline'] && ! isset( $_POST['inline_link_1'] ) ) {
								$this->lbp_inline_initialize( $_POST['inline_num'] );
								$lbp_global_messages_success[] = esc_html__( 'Inline lightbox settings initialized.', 'lightboxplus' );
							}

							unset( $lbp_plugin_options );
							break;
						case
						'reset':
							$nonce = $_REQUEST['_wpnonce'];
							if ( ! wp_verify_nonce( $nonce, 'lbp-nonce' ) ) {
								$nonce_reset_error = '<div class="notice notice-error"><p>' . esc_attr__( 'Error reinitializing settings', 'lightboxplus' ) . '</p></div>';
								die( $nonce_reset_error );
							} else {
								if ( ! empty( $_POST['reinit_lightboxplus'] ) ) {
									delete_option( $this->lbp_options_name );
									delete_option( $this->lbp_init_name );
									delete_option( $this->lbp_style_path_name );
									$lbp_global_messages_title .= esc_html__( 'Lightbox Plus Colorbox Reset', 'lightboxplus' );
									$lbp_global_message_warning[] = '<strong>' . esc_html__( 'Lightbox Plus Colorbox has been completely reset to default settings.', 'lightboxplus' ) . '</strong>';

									/**
									 * Used to remove old setting from previous versions of LBP
									 *
									 * @var string
									 */
									$lbp_old_plugin_path = ( dirname( __FILE__ ) );
									if ( file_exists( $lbp_old_plugin_path . "/images" ) ) {
										$lbp_global_message_warning[] = esc_html__( 'Deleting: ', 'lightboxplus' ) . $lbp_old_plugin_path . '/images . . . ' . esc_html__( 'Removed old Lightbox Plus Colorbox style images.', 'lightboxplus' );
										$this->lbp_delete_directory( $lbp_old_plugin_path . "/images/" );
									}

									if ( file_exists( $lbp_old_plugin_path . "/js/" . "lightbox.js" ) ) {
										$lbp_global_message_warning[] = esc_html__( 'Deleting: ', 'lightboxplus' ) . $lbp_old_plugin_path . '/js/lightbox.js . . . ' . esc_html__( 'Removed old Lightbox Plus Colorbox JavaScript.', 'lightboxplus' );
										$this->lbp_delete_file( $lbp_old_plugin_path . "/js", "lightbox.js" );
									}

									$lbp_old_styles = $this->lbp_directory_list( $lbp_old_plugin_path . "/css/" );
									if ( ! empty( $lbp_old_styles ) ) {
										foreach ( $lbp_old_styles as $lbp_old_style ) {
											if ( file_exists( $lbp_old_plugin_path . "/css/" . $lbp_old_style ) ) {
												$lbp_global_message_warning[] = esc_html__( 'Deleting: ', 'lightboxplus' ) . $lbp_old_plugin_path . '/css/' . $lbp_old_style;
												$this->lbp_delete_file( $lbp_old_plugin_path . "/css", $lbp_old_style );
											}
										}
										$g_lbp_warn_messages[] = esc_html__( 'Removed old Lightbox Plus Colorbox styles.', 'lightboxplus' );
									}
								}

								/**
								 * Will reinitilize on reload where option lightboxplus_init is null
								 */
								$this->lbp_initialize();
								$lbp_global_messages_success[] = '<strong>' . esc_html__( 'Please check and update your Lightbox Plus Colorbox settings before continuing!', 'lightboxplus' ) . '</strong>';
							}
							break;
						default:
							break;
					}
				}

				/**
				 * Get options to load in form
				 */
				if ( ! empty( $this->lbp_plugin_options ) ) {
					$lbp_plugin_options = $this->lbp_get_admin_options( $this->lbp_options_name );
				}

				/**
				 * Check if there are styles
				 *
				 * @var mixed
				 */
				if ( $lbp_plugin_options['use_custom_style'] ) {
					$lbp_style_path = $lbp_global_style_path_custom;
				} else {
					$lbp_style_path = $lbp_global_style_path;
				}
				if ( $handle = opendir( $lbp_style_path ) ) {
					while ( false !== ( $lbp_file = readdir( $handle ) ) ) {
						if ( "." != $lbp_file && ".." != $lbp_file && ".DS_Store" != $lbp_file && ".svn" != $lbp_file && "index.html" != $lbp_file ) {
							$styles[ $lbp_file ] = $lbp_style_path . "/" . $lbp_file . "/";
						}
					}
					closedir( $handle );
				}
				?>
				<div class="wrap" id="lightbox">
					<script>hljs.initHighlightingOnLoad();</script>
					<h2><?php esc_html_e( 'Lightbox Plus Colorbox (v' . $lbp_global_version . ') Options', 'lightboxplus' ) ?></h2>

					<h3><?php esc_html_e( 'With Colorbox (v' . $lbp_global_version_colorbox . ') and ' . $lbp_global_dom_library . ' (v' . $lbp_global_version_dom . ')', 'lightboxplus' ) ?></h3>
					<h4><a href="http://www.23systems.net/plugins/lightbox-plus/"><?php esc_html_e( 'Visit plugin site', 'lightboxplus' ) ?></a> |
						<a href="http://www.23systems.net/wordpress-plugins/lightbox-plus-for-wordpress/frequently-asked-questions/" title="Lightbox Plus Colorbox FAQ"><?php esc_html_e( 'FAQ', 'lightboxplus' ) ?></a> |
						<a href="http://twitter.com/23systems" title="@23Systems on Twitter"><?php esc_html_e( 'Twitter', 'lightboxplus' ) ?></a> |
						<a href="http://www.facebook.com/23Systems" title="23Systems on Facebook"><?php esc_html_e( 'Facebook', 'lightboxplus' ) ?></a> |
						<a href="http://www.linkedin.com/company/23systems" title="23Systems of LinkedIn"><?php esc_html_e( 'LinkedIn', 'lightboxplus' ) ?></a> |
						<a href="https://plus.google.com/111641141856782935011/posts" title="23System on Google+"><?php esc_html_e( 'Google+', 'lightboxplus' ) ?></a> |
					                                                                                                                             Contribute to Lightbox Plus development costs -
						<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top" class="inline-donate">
							<input type="hidden" name="cmd" value="_s-xclick">
							<input type="hidden" name="hosted_button_id" value="9BKF2TJGV84S6">
							<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
							<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
						</form>
					</h4>

					<?php
					if ( $lbp_global_messages_info ) {
						$the_info_message = '';
						foreach ( $lbp_global_messages_info as $value ) {
							$the_info_message .= "$value.. ";
						}
						echo '<div id="lbp-message" class="notice notice-info is-dismissible"><p>' . $the_info_message . '</p></div>';
					}

					if ( $lbp_global_messages_error ) {
						$the_error_message = '';
						foreach ( $lbp_global_messages_error as $value ) {
							$the_error_message .= "$value, ";
						}
						echo '<div id="lbp-message" class="notice notice-error is-dismissible"><p>' . $the_error_message . '</p></div>';
					}

					if ( $lbp_global_message_warning ) {
						$the_warning_message = '';
						foreach ( $lbp_global_message_warning as $value ) {
							$the_warning_message .= "$value, ";
						}
						echo '<div id="lbp-message" class="notice notice-warning is-dismissible"><p>' . $the_warning_message . '</p></div>';
					}

					if ( $lbp_global_messages_success ) {
						$the_success_message = '';
						foreach ( $lbp_global_messages_success as $value ) {
							$the_success_message .= "$value, ";
						}
						echo '<div id="lbp-message" class="notice notice-success is-dismissible"><p>' . $the_success_message . '</p></div>';
					}

					require( 'admin/lightbox.admin.php' );
					?></div>
				<?php
			}
			/**
			 * END CLASS
			 */
		}
		/**
		 * END CLASS CHECK
		 */
	}
	/**
	 * Instantiate the class
	 */
	if ( class_exists( 'Lightbox_Plus_Colorbox' ) ) {
		$wp_lightboxplus = new Lightbox_Plus_Colorbox();
		unset( $wp_lightboxplus );
	}
}