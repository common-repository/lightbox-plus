<?php
/**
 * @package Lightbox Plus Colorbox
 * @subpackage utility.class.php
 * @internal 2016.04.18
 * @author Programmattic LLC / Dan Zappone
 * @version 2.8
 * @$Id: utility.class.php 937945 2014-06-24 17:11:13Z dzappone $
 * @$URL: https://plugins.svn.wordpress.org/lightbox-plus/tags/2.7/classes/utility.class.php $
 */

defined( 'ABSPATH' ) or die( 'You kids get off my lawn!' );

if ( ! class_exists( 'Lightbox_Plus_Utilities' ) ) {

	/**
	 * Lightbox Plus Colorbox Utility Functions used throughout plugin
	 *
	 * Not sure if WordPress has equivalents but cannot locate in API docs if so
	 */
	class Lightbox_Plus_Utilities {

		/**
		 * Create dropdown name from stylesheet listing - make user friendly
		 *
		 * @param mixed $lbp_style_name
		 *
		 * @return string
		 */
		function lbp_set_proper_name( $lbp_style_name ) {
			$lbp_style_name = str_replace( '.css', '', $lbp_style_name );
			$lbp_style_name = ucfirst( $lbp_style_name );

			return $lbp_style_name;
		}

		/**
		 * Check load location and determine whether or not it's should be loaded in the header (false) or footer (true)
		 *
		 * @param $lbp_load_location
		 *
		 * @return bool
		 */
		function lbp_set_load_location( $lbp_load_location ) {
			if ( 'wp_head' == $lbp_load_location ) {
				return false;
				exit;
			} else {
				return true;
				exit;
			}
		}

		/**
		 * Add the missing options to the plugin when updated if they are missing
		 * TODO: Make this while process more graceful - this is the legacy method.  Leave in until replaced.
		 *
		 * @param $lbp_array_options
		 *
		 * @return mixed
		 */
		function lbp_set_missing_options( $lbp_array_options ) {
			if ( ! isset( $lbp_array_options['output_htmlv'] ) || ( array_key_exists( 'output_htmlv', $lbp_array_options ) == false ) ) {
				$lbp_array_options['output_htmlv'] = '0';
				$lbp_array_options['data_name']    = 'lightboxplus';
			}
			if ( ! isset( $lbp_array_options['load_location'] ) || ( array_key_exists( 'load_location', $lbp_array_options ) == false ) ) {
				$lbp_array_options['load_location'] = 'wp_footer';
			}
			if ( ! isset( $lbp_array_options['load_priority'] ) || ( array_key_exists( 'load_priority', $lbp_array_options ) == false ) ) {
				$lbp_array_options['load_priority'] = '10';
			}
			if ( ! isset( $lbp_array_options['responsive'] ) || ( array_key_exists( 'responsive', $lbp_array_options ) == false ) ) {
				$lbp_array_options['responsive']       = '0';
				$lbp_array_options['responsive_width'] = '640';
			}

			return $lbp_array_options;
		}


		/**
		 * Convert DB booleans to text for use with JavaScript (jQuery) parameters
		 *
		 * @param mixed $lbp_number_value
		 *
		 * @return mixed
		 */
		function lbp_set_boolean( $lbp_number_value ) {
			switch ( $lbp_number_value ) {
				case 1:
					return 'true';
					break;
				default:
					return 'false';
					break;
			}
		}

		/**
		 * Convert DB booleans to text for use with JavaScript (jQuery) parameters
		 *
		 * @param $lbp_number_value
		 *
		 * @return string
		 */
		function lbp_set_value( $lbp_number_value ) {
			if ( $lbp_number_value == '' || $lbp_number_value == 'false' ) {
				$tmpValue = 'false';
			} else {
				$tmpValue = '"' . $lbp_number_value . '"';
			}

			return $tmpValue;
		}

		/**
		 * Delete directory function used to remove old directories during upgrade from versions prior to 1.4
		 *
		 * @param $lbp_directory_name
		 *
		 * @return bool
		 */
		function lbp_delete_directory( $lbp_directory_name ) {
			if ( is_dir( $lbp_directory_name ) ) {
				$lbp_directory_handle = opendir( $lbp_directory_name );
			}

			if ( ! isset( $lbp_directory_handle ) ) {
				return false;
			}

			while ( $lbp_file = readdir( $lbp_directory_handle ) ) {
				if ( $lbp_file != '.' && $lbp_file != '..' ) {
					if ( ! is_dir( $lbp_directory_name . '/' . $lbp_file ) ) {
						unlink( $lbp_directory_name . '/' . $lbp_file );
					} else {
						delete_directory( $lbp_directory_name . '/' . $lbp_file );
					}
				}
			}

			closedir( $lbp_directory_handle );
			rmdir( $lbp_directory_name );

			return true;
		}

		/**
		 * Delete directory function used to remove old directories during upgrade from versions prior to 1.4
		 *
		 * @param $lbp_directory_name
		 * @param $lbp_file
		 *
		 * @return bool
		 */
		function lbp_delete_file( $lbp_directory_name, $lbp_file ) {
			if ( $lbp_file != '.' && $lbp_file != '..' ) {
				if ( ! is_dir( $lbp_directory_name . '/' . $lbp_file ) ) {
					unlink( $lbp_directory_name . '/' . $lbp_file );
				}

				return true;
			}
		}

		/**
		 * List directory function used to iterate theme directories
		 *
		 * @param $lbp_directory_name
		 *
		 * @return array
		 */
		function lbp_directory_list( $lbp_directory_name ) {
			$lbp_file_types             = array( 'css', );
			$lbp_directory_list_results = array();
			$lbp_directory_handle       = opendir( $lbp_directory_name );
			while ( $lbp_file = readdir( $lbp_directory_handle ) ) {
				$lbp_file_type = strtolower( substr( strrchr( $lbp_file, '.' ), 1 ) );
				if ( in_array( $lbp_file_type, $lbp_file_types ) ) {
					array_push( $lbp_directory_list_results, $lbp_file );
				}
			}
			closedir( $lbp_directory_handle );
			sort( $lbp_directory_list_results );

			return $lbp_directory_list_results;
		}

		/**
		 * Used to do a boolean check against PHP version
		 *
		 * @param $lbp_php_version_required
		 *
		 * @return bool
		 */
		function lbp_php_version_check( $lbp_php_version_required ) {
			$lbp_php_current_version = PHP_VERSION;

			if ( $lbp_php_current_version[0] >= $lbp_php_version_required[0] ) {
				if ( empty( $lbp_php_version_required[2] ) || $lbp_php_version_required[2] == '*' ) {
					return true;
				} elseif ( $lbp_php_current_version[2] >= $lbp_php_version_required[2] ) {
					if ( empty( $lbp_php_version_required[4] ) || $lbp_php_version_required[4] == '*' || $lbp_php_current_version[4] >= $lbp_php_version_required[4] ) {
						return true;
					}
				}
			}

			return false;
		}

		/**
		 * Recursively copy a directory
		 *
		 * @param mixed $lbp_copy_source
		 * @param mixed $lbp_copy_destination
		 */
		function lbp_copy_directory( $lbp_copy_source, $lbp_copy_destination ) {
			if ( is_dir( $lbp_copy_source ) ) {
				@mkdir( $lbp_copy_destination );
				$lbp_directory_to_copy = dir( $lbp_copy_source );
				while ( false !== ( $lbp_read_directory = $lbp_directory_to_copy->read() ) ) {
					if ( $lbp_read_directory == '.' || $lbp_read_directory == '..' ) {
						continue;
					}
					$lbp_directory_path = $lbp_copy_source . '/' . $lbp_read_directory;
					if ( is_dir( $lbp_directory_path ) ) {
						$this->lbp_copy_directory( $lbp_directory_path, $lbp_copy_destination . '/' . $lbp_read_directory );
						continue;
					}
					copy( $lbp_directory_path, $lbp_copy_destination . '/' . $lbp_read_directory );
				}

				$lbp_directory_to_copy->close();
			} else {
				copy( $lbp_copy_source, $lbp_copy_destination );
			}
		}

		/**
		 * @return mixed
		 */
		function post_thumbnail_caption() {
			extract( shortcode_atts( array(
				'id'      => '',
				'align'   => 'alignnone',
				'width'   => '',
				'caption' => ''
			), $attr ) );

			return $caption;
		}

		/**
		 * @param $lbp_checkbox_value
		 *
		 * @return int
		 */
		function sanitize_checkbox( $lbp_checkbox_value ) {
			return ( isset( $lbp_checkbox_value ) && ! empty( $lbp_checkbox_value ) ) ? 1 : 0;
		}

		/**
		 * @param $lbp_isset_value
		 *
		 * @return mixed
		 */
		function check_isset( $lbp_isset_value ) {
			if ( isset( $lbp_isset_value ) ) {
				return $lbp_isset_value;
			}
		}

		function return_array_as_string( $lbp_array_value ) {
			if ( is_array( $lbp_array_value ) ) {
				return '(' . implode( ',', $lbp_array_value ) . ')';
			} else {
				return $lbp_array_value;
			}
		}

		/**
		 * Formats a JSON string for pretty printing for older versions of PHP
		 * @WHEEL No need to reinvent the wheel - changed function name to fit plugin
		 *
		 * ---- ORIGINAL COMMENTS ----
		 * jsonpp - Pretty print JSON data
		 *
		 * In versions of PHP < 5.4.x, the json_encode() function does not yet provide a
		 * pretty-print option. In lieu of forgoing the feature, an additional call can
		 * be made to this function, passing in JSON text, and (optionally) a string to
		 * be used for indentation.
		 *
		 * @param string $json The JSON data, pre-encoded
		 * @param string $istr The indentation string
		 *
		 * @link https://github.com/ryanuber/projects/blob/master/PHP/JSON/jsonpp.php
		 *
		 * @return string
		 */
		function lbp_format_json( $json, $istr = '  ' ) {
			$result = '';
			for ( $p = $q = $i = 0; isset( $json[ $p ] ); $p ++ ) {
				$json[ $p ] == '"' && ( $p > 0 ? $json[ $p - 1 ] : '' ) != '\\' && $q = ! $q;
				if ( ! $q && strchr( " \t\n\r", $json[ $p ] ) ) {
					continue;
				}
				if ( strchr( '}]', $json[ $p ] ) && ! $q && $i -- ) {
					strchr( '{[', $json[ $p - 1 ] ) || $result .= "\n" . str_repeat( $istr, $i );
				}
				$result .= $json[ $p ];
				if ( strchr( ',{[', $json[ $p ] ) && ! $q ) {
					$i += strchr( '{[', $json[ $p ] ) === false ? 0 : 1;
					strchr( '}]', $json[ $p + 1 ] ) || $result .= "\n" . str_repeat( $istr, $i );
				}
			}

			return $result;
		}

		function lbp_strip_extension( $lbp_filename ) {

			$lbp_extenstions_to_strip = array( '.js', '.css', '.min', '-min' );

			foreach ( $lbp_extenstions_to_strip as $lbp_extension ) {
				$lbp_filename = preg_replace( '/^' . $lbp_extension . '/i', '', $lbp_filename );
			}

			return $lbp_filename;
		}

		/**
		 * @param $lbp_script_name -- the full name of the script - ( e.g. jquery.min.js )
		 * @param $lbp_remote_script_url -- the full url to the remote script ( e.g. https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.3/jquery.min.js )
		 * @param string $lbp_local_script_path -- the path to the local script in the plugin directory ( e.g. /js/ )
		 * @param string $lbp_script_version -- the version of the script being enqueued ( e.g. 1.12.3 )
		 * @param null $lbp_script_dependency -- the script that the enqueued script it dependent upon and should be loaded after ( e.g. jquery )
		 * @param null $lbp_wp_core -- is the script you are replacing part of the WordPress core scripts and should it be deregistered? ( e.g. true )
		 * @param bool $lbp_load_location -- load the script in the footer? (e.g. true/false)
		 *
		 * @return string
		 */
		function lbp_enqueue_script( $lbp_script_name, $lbp_remote_script_url, $lbp_local_script_path = '/', $lbp_script_version = '0', $lbp_script_dependency = null, $lbp_wp_core = null, $lbp_load_location = true ) {
			global $lbp_global_plugin_url;

			$lbp_script_handle = $this->lbp_strip_extension( $lbp_script_name );

			// Setup Local URL for fallback
			if ( $lbp_wp_core ) {
				$lbp_local_script_url = get_bloginfo( 'wpurl' ) . '/wp-includes/js' . $lbp_local_script_path . $lbp_script_name . '.js';
			} else {
				$lbp_local_script_url = $lbp_global_plugin_url . $lbp_local_script_path . $lbp_script_name;
			}

			// Deregister WordPress default script if the script is replacing a core script
			if ( ! is_null( $lbp_wp_core ) ) {
				wp_deregister_script( $lbp_script_name );
			}

			// Check transient, if false, get rid of it and set URL to Local URL
			delete_transient( $lbp_script_name );

			if ( 'false' == ( $lbp_cdn = get_transient( $lbp_script_name ) ) ) {
				$lbp_remote_script_url = $lbp_local_script_url;
			} // Transient failed
			elseif ( false === $lbp_cdn ) {
				// Check if there is a response from the CDN
				$lbp_cdn_response = wp_remote_head( $lbp_remote_script_url );

				// Default to use CDN Script and set transient timeout for 20 minutes
				if ( ! is_wp_error( $lbp_cdn_response ) && 200 == $lbp_cdn_response['response']['code'] ) {

					set_transient( $lbp_script_name, 'true', 60 * 20 );
				} else {  // Set transient timeout for 20 minutes and use local script
					set_transient( $lbp_script_name, 'false', 60 * 20 );
					$lbp_remote_script_url = $lbp_local_script_url;
				}
			}

			// Register script with dependencies or not...
			if ( $lbp_script_dependency ) {
				wp_register_script( $lbp_script_handle, $lbp_remote_script_url, array( $lbp_script_dependency ), $lbp_script_version, $lbp_load_location );
			} else {
				wp_register_script( $lbp_script_handle, $lbp_remote_script_url, '', $lbp_script_version, $lbp_load_location );
			}

			// Enqueue Remote or Local script based on results aboce
			wp_enqueue_script( $lbp_script_handle );

			return $lbp_remote_script_url;
		}

		/**
		 * @param $lbp_style_name
		 * @param $lbp_remote_style_url
		 * @param string $lbp_local_style_path
		 * @param string $lbp_style_version
		 * @param null $lbp_style_dependency
		 * @param string $lbp_style_media
		 *
		 * @return string
		 */
		function lbp_enqueue_style( $lbp_style_name, $lbp_remote_style_url, $lbp_local_style_path = '/', $lbp_style_version = '0', $lbp_style_dependency = null, $lbp_style_media = 'all' ) {
			global $lbp_global_plugin_url;

			$lbp_style_handle = $this->lbp_strip_extension( $lbp_style_name );

			// Setup Local URL for fallback
			$lbp_local_style_url = $lbp_global_plugin_url . $lbp_local_style_path . $lbp_style_name;

			// Check transient, if false, get rid of it and set URL to Local URL
			delete_transient( $lbp_style_name );

			if ( 'false' == ( $lbp_cdn = get_transient( $lbp_style_name ) ) ) {
				$lbp_remote_style_url = $lbp_local_style_url;
			} // Transient failed
			elseif ( false === $lbp_cdn ) {
				// Check if there is a response from the CDN
				$lbp_cdn_response = wp_remote_head( $lbp_remote_style_url );

				// Default to use CDN Script and set transient timeout for 20 minutes
				if ( ! is_wp_error( $lbp_cdn_response ) && 200 == $lbp_cdn_response['response']['code'] ) {

					set_transient( $lbp_style_name, 'true', 60 * 20 );
				} else {  // Set transient timeout for 20 minutes and use local script
					set_transient( $lbp_style_name, 'false', 60 * 20 );
					$lbp_remote_style_url = $lbp_local_style_url;
				}
			}

			// Register script with dependencies or not...
			if ( $lbp_style_dependency ) {
				wp_register_style( $lbp_style_handle, $lbp_remote_style_url, array( $lbp_style_dependency ), $lbp_style_version, $lbp_style_media );
			} else {
				wp_register_style( $lbp_style_handle, $lbp_remote_style_url, '', $lbp_style_version, $lbp_style_media );
			}

			// Enqueue Remote or Local script based on results aboce
			wp_enqueue_style( $lbp_style_handle );

			return $lbp_remote_style_url;
		}

	}
}