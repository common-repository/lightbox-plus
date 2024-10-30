<?php
/**
 * @package Lightbox Plus Colorbox
 * @subpackage init.class.php
 * @internal 2016.04.18
 * @author Programmattic LLC / Dan Zappone
 * @version 2.8
 * @$Id: init.class.php 937945 2014-06-24 17:11:13Z dzappone $
 * @$URL: https://plugins.svn.wordpress.org/lightbox-plus/tags/2.7/classes/init.class.php $
 */

defined( 'ABSPATH' ) or die( 'You kids get off my lawn!' );

if ( ! class_exists( 'Lightbox_Plus_Init' ) ) {
	class Lightbox_Plus_Init extends Lightbox_Plus_Actions {
		/**
		 * Add some default options if they don't exist or if reinitialized
		 */
		function lbp_initialize() {
			global $lbp_global_plugin_url;
			$lbp_plugin_options = get_option( 'lightboxplus_options' );

			/**
			 * Call Initialize Primary Lightbox
			 * Call Initialize Secondary Lightbox if enabled
			 * Call Initialize Inline Lightboxes if enabled
			 *
			 * @var wp_lightboxplus
			 */
			if ( ! isset( $lbp_plugin_optionsSet ) || isset( $_POST['reinit_lightboxplus'] ) ) {
				$lbp_plugin_primary_options   = $this->lbp_primary_initialize();
				$lbp_plugin_secondary_options = $this->lbp_secondary_initialize();
				$lbp_plugin_inline_options    = $this->lbp_inline_initialize();

				$lbp_plugin_options = array_merge( $lbp_plugin_primary_options, $lbp_plugin_secondary_options, $lbp_plugin_inline_options );

				/**
				 * Saved options and then get them out of the db to see if they are actually there
				 */
				update_option( 'lightboxplus_options', $lbp_plugin_options );
				$lbp_saved_options = get_option( 'lightboxplus_options' );

				/**
				 * If Lightbox Plus Colorbox has been initialized - set to true
				 */
				if ( $lbp_saved_options ) {
					update_option( 'lightboxplus_init', true );
				}
			} else {
				$lbp_saved_options = $lbp_plugin_options;
			}

			return $lbp_saved_options;
		}

		/**
		 * Initialize Primary Lightbox by building array of options and committing to database
		 */
		function lbp_primary_initialize() {
			$lbp_plugin_primary_options = array(
				"lightboxplus_multi"      => '0',
				"use_inline"              => '0',
				"inline_num"              => '1',
				"lightboxplus_style"      => 'shadowed',
				"use_custom_style"        => '0',
				"disable_css"             => '0',
				"hide_about"              => '0',
				"output_htmlv"            => '0',
				"data_name"               => 'lightboxplus',
				"use_perpage"             => '0',
				"use_forpage"             => '0',
				"use_forpost"             => '0',
				"load_location"           => 'wp_footer',
				"load_priority"           => '10',
				"transition"              => 'elastic',
				"speed"                   => '300',
				"width"                   => 'false',
				"height"                  => 'false',
				"inner_width"             => 'false',
				"inner_height"            => 'false',
				"initial_width"           => '30%',
				"initial_height"          => '30%',
				"max_width"               => '90%',
				"max_height"              => '90%',
				"resize"                  => '1',
				"opacity"                 => '0.8',
				"preloading"              => '1',
				"label_image"             => 'Image',
				"label_of"                => 'of',
				"previous"                => 'previous',
				"next"                    => 'next',
				"close"                   => 'close',
				"overlay_close"           => '1',
				"slideshow"               => '0',
				"slideshow_auto"          => '0',
				"slideshow_speed"         => '2500',
				"slideshow_start"         => 'start',
				"slideshow_stop"          => 'stop',
				"use_caption_title"       => '0',
				"gallery_lightboxplus"    => '0',
				"multiple_galleries"      => '0',
				"use_class_method"        => '0',
				"class_name"              => 'lbp_primary',
				"no_auto_lightbox"        => '0',
				"text_links"              => '1',
				"no_display_title"        => '0',
				"scrolling"               => '1',
				"photo"                   => '0',
				"rel"                     => '0', //Disable grouping
				"loop"                    => '1',
				"esc_key"                 => '1',
				"arrow_key"               => '1',
				"top"                     => 'false',
				"right"                   => 'false',
				"bottom"                  => 'false',
				"left"                    => 'false',
				"fixed"                   => '0',
				"mobile_browser_settings" => 'none',
				"mobile_browsers_custom"  => 'Mobile|iP(hone|od|ad)|Android|BlackBerry|IEMobile',
				"responsive"              => '0',
				"responsive_width"        => '960'
			);

			return $lbp_plugin_primary_options;
		}

		/**
		 * Initialize Secondary Lightbox by building array of options and returning
		 *
		 * @return array $lbp_plugin_secondary_options
		 */
		function lbp_secondary_initialize() {
			$lbp_plugin_options           = get_option( 'lightboxplus_options' );
			$lbp_plugin_secondary_options = array(
				"transition_sec"       => 'elastic',
				"speed_sec"            => '300',
				"width_sec"            => 'false',
				"height_sec"           => 'false',
				"inner_width_sec"      => '50%',
				"inner_height_sec"     => '50%',
				"initial_width_sec"    => '30%',
				"initial_height_sec"   => '40%',
				"max_width_sec"        => '90%',
				"max_height_sec"       => '90%',
				"resize_sec"           => '1',
				"opacity_sec"          => '0.8',
				"preloading_sec"       => '1',
				"label_image_sec"      => 'Image',
				"label_of_sec"         => 'of',
				"previous_sec"         => 'previous',
				"next_sec"             => 'next',
				"close_sec"            => 'close',
				"overlay_close_sec"    => '1',
				"slideshow_sec"        => '0',
				"slideshow_auto_sec"   => '1',
				"slideshow_speed_sec"  => '2500',
				"slideshow_start_sec"  => 'start',
				"slideshow_stop_sec"   => 'stop',
				"iframe_sec"           => '1',
				//"use_class_method_sec" => '0',
				"class_name_sec"       => 'lbp_secondary',
				"no_display_title_sec" => '0',
				"scrolling_sec"        => '1',
				"photo_sec"            => '0',
				"rel_sec"              => '0', //Disable grouping
				"loop_sec"             => '1',
				"esc_key_sec"          => '1',
				"arrow_key_sec"        => '1',
				"top_sec"              => '0',
				"right_sec"            => '0',
				"bottom_sec"           => '0',
				"left_sec"             => '0',
				"fixed_sec"            => '0'
			);

			if ( ! empty( $lbp_plugin_options ) ) {
				$lbp_plugin_options = array_merge( $lbp_plugin_options, $lbp_plugin_secondary_options );
				update_option( 'lightboxplus_options', $lbp_plugin_options );
				unset( $lbp_plugin_options );
			}

			return $lbp_plugin_secondary_options;
		}

		/**
		 * Initialize Inline Lightbox by building array of options and committing to database
		 *
		 * @param mixed $inline_number
		 *
		 * @return array $lbp_plugin_inline_options
		 */
		function lbp_inline_initialize( $inline_number = 5 ) {
			$lbp_plugin_options = get_option( 'lightboxplus_options' );

			if ( ! empty( $inline_number ) ) {
				$inline_links            = array();
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
				for ( $i = 1; $i <= $inline_number; $i ++ ) {
					$inline_links[]            = 'lbp-inline-link-' . $i;
					$inline_hrefs[]            = 'lbp-inline-href-' . $i;
					$inline_transitions[]      = 'elastic';
					$inline_speeds[]           = '300';
					$inline_widths[]           = '80%';
					$inline_heights[]          = '80%';
					$inline_inner_widths[]     = 'false';
					$inline_inner_heights[]    = 'false';
					$inline_max_widths[]       = '80%';
					$inline_max_heights[]      = '80%';
					$inline_position_tops[]    = '';
					$inline_position_rights[]  = '';
					$inline_position_bottoms[] = '';
					$inline_position_lefts[]   = '';
					$inline_fixeds[]           = '0';
					$inline_opens[]            = '0';
					$inline_opacitys[]         = '0.8';
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

			if ( ! empty( $lbp_plugin_options ) ) {
				$lbp_plugin_options = array_merge( $lbp_plugin_options, $lbp_plugin_inline_options );
				update_option( 'lightboxplus_options', $lbp_plugin_options );
				unset( $lbp_plugin_options );
			}

			return $lbp_plugin_inline_options;
		}

		/**
		 * Initialize the external style directory
		 *
		 * @return boolean
		 */
		function lbp_custom_styles_initialize() {
			global $lbp_global_style_path, $lbp_global_style_path_custom;
			$dir_create = mkdir( $lbp_global_style_path_custom, 0755 );
			if ( $dir_create ) {
				$this->lbp_copy_directory( $lbp_global_style_path, $lbp_global_style_path_custom . '/' );

				return true;
			} else {
				return false;
			}
		}
	}
}