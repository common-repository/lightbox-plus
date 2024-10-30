<?php
/**
 * @package Lightbox Plus Colorbox
 * @subpackage filters.class.php
 * @internal 2016.04.18
 * @author Programmattic LLC / Dan Zappone
 * @version 2.8
 * @$Id: filters.class.php 937945 2014-06-24 17:11:13Z dzappone $
 * @$URL: https://plugins.svn.wordpress.org/lightbox-plus/tags/2.7/classes/filters.class.php $
 */
if ( ! class_exists( 'Lightbox_Plus_Filters' ) ) {
//	class Lightbox_Plus_Filters extends Lightbox_Plus_Shortcode {
	class Lightbox_Plus_Filters extends	Lightbox_Plus_Utilities {
		/**
		 * Filter to call page parsing
		 *
		 * @param mixed $content
		 *
		 * @return simple_html_dom
		 */
		function lbp_filter_replace( $content ) {
			$lbp_plugin_options = get_option( 'lightboxplus_options' );

			return $this->lbp_content_replace( $content, '' );
		}

		/**
		 * New method to parse page content navigating the dom and replacing found elements with modified HTML to acomodate LBP appropriate HTML
		 *
		 * @param $html_content
		 * @param $unq_id
		 *
		 * @return mixed
		 */
		function lbp_content_replace( $html_content, $unq_id ) {
			global $post;

			if ( ! empty( $this->lbp_plugin_options ) ) {
				$lbp_plugin_options = $this->lbp_get_admin_options( $this->lbp_options_name );
			}
			/**
			 * Remove following line after a few versions or 2.8 is the prevelent version
			 */
			$lbp_plugin_options = $this->lbp_set_missing_options( $lbp_plugin_options );

			$postGroupID    = $post->ID;
			$postGroupTitle = $post->post_title;
			
			$html = htmlqp( str_replace( chr( 13 ), '', $html_content ) );

			/**
			 * Find all image links (text and images)
			 *
			 * If (autolightbox text links) then
			 */
			switch ( $lbp_plugin_options['text_links'] ) {
				case 1:
					foreach ( $html->find( "a[href*='jpg'],a[href*='gif'],a[href*='png'],a[href*='jpeg'],a[href*='bmp']" ) as $e ) {
						/**
						 * Use Class Method is selected - yes/no
						 */
						switch ( $lbp_plugin_options['output_htmlv'] ) {
							case 1:
								switch ( $lbp_plugin_options['use_class_method'] ) {
									case 1:
										if ( ! $e->hasClass( $lbp_plugin_options['class_name'] ) ) {
											$e->addClass( $lbp_plugin_options['class_name'] );
											if ( ! $e->attr( 'data-' . $lbp_plugin_options['data_name'] ) ) {
												$e->attr( 'data-' . $lbp_plugin_options['data_name'], 'lightbox[' . $postGroupID . $unq_id . ']' );
											}
										} else {
											$e->hasClass( $lbp_plugin_options['class_name'] );
											if ( ! $e->attr( 'data-' . $lbp_plugin_options['data_name'] ) ) {
												$e->attr( 'data-' . $lbp_plugin_options['data_name'], 'lightbox[' . $postGroupID . $unq_id . ']' );
											}
										}
										break;
									default:
										if ( ! $e->attr( 'data-' . $lbp_plugin_options['data_name'] ) ) {
											$e->attr( 'data-' . $lbp_plugin_options['data_name'], 'lightbox[' . $postGroupID . $unq_id . ']' );
										}
										break;
								}
								break;
							default:
								switch ( $lbp_plugin_options['use_class_method'] ) {
									case 1:
										if ( ! $e->hasClass( $lbp_plugin_options['class_name'] ) ) {
											$e->addClass( $lbp_plugin_options['class_name'] );
											if ( ! $e->attr( 'rel' ) ) {
												$e->attr( 'rel', 'lightbox[' . $postGroupID . $unq_id . ']' );
											}
										} else {
											$e->addClass( $lbp_plugin_options['class_name'] );
											if ( ! $e->attr( 'rel' ) ) {
												$e->attr( 'rel', 'lightbox[' . $postGroupID . $unq_id . ']' );
											}
										}
										break;
									default:
										if ( ! $e->attr( 'rel' ) ) {
											$e->attr( 'rel', 'lightbox[' . $postGroupID . $unq_id . ']' );
										}
										break;
								}
								break;
						}
						/**
						 * Do Not Display Title is selected - yes/no
						 */
						switch ( $lbp_plugin_options['no_display_title'] ) {
							case 1:
								$e->removeAttr( 'title' );
								break;
							default:
								/**
								 * If title doesn't exist then get a title
								 * Set to caption title->image->post title by default then set to image title if exists
								 */
								if ( ! $e->attr( 'title' ) && $e->firstChild() ) {
									if ( $e->firstChild()->attr( 'alt' ) ) {
										$e->attr( 'title', $e->firstChild()->attr( 'alt' ) );
									} else {
										$e->attr( 'title', $postGroupTitle );
									}
								}
								/**
								 * If use caption for title try to get the text from the caption - this could be wrong
								 */
								if ( $lbp_plugin_options['use_caption_title'] ) {
									if ( $e->next()->hasClass( 'wp-caption-text' ) ) {
										$e->attr( 'title', $e->next()->text() );
									} elseif ( $e->parent()->next()->hasClass( 'gallery-caption' ) ) {
										$e->attr( 'title', $e->parent()->next()->text() );
									}
								}

								break;
						}
					}
					break;
				default:
					/**
					 *  find all links with image only else if (do not autolightbox textlinks) then
					 */
					foreach ( $html->find( "a[href*='jpg'] img,a[href*='gif'] img,a[href*='png'] img,a[href*='jpeg'] img,a[href*='bmp'] img" ) as $e ) {
						/**
						 * Generate HTML5 yes/no
						 */
						switch ( $lbp_plugin_options['output_htmlv'] ) {
							case 1:
								switch ( $lbp_plugin_options['use_class_method'] ) {
									/**
									 * Use Class Method is selected - yes/no
									 */
									case 1:
										if ( ! $e->parent()->hasClass( $lbp_plugin_options['class_name'] ) ) {
											$e->parent()->addClass( $lbp_plugin_options['class_name'] );
											if ( ! $e->parent()->attr( 'data-' . $lbp_plugin_options['data_name'] ) ) {
												$e->parent()->attr( 'data-' . $lbp_plugin_options['data_name'], 'lightbox[' . $postGroupID . $unq_id . ']' );
											}
										} else {
											$e->parent()->addClass( $lbp_plugin_options['class_name'] );
											if ( ! $e->parent()->attr( 'data-' . $lbp_plugin_options['data_name'] ) ) {
												$e->parent()->attr( 'data-' . $lbp_plugin_options['data_name'], 'lightbox[' . $postGroupID . $unq_id . ']' );
											}
										}
										break;
									default:
										if ( ! $e->parent()->attr( 'data-' . $lbp_plugin_options['data_name'] ) ) {
											$e->parent()->attr( 'data-' . $lbp_plugin_options['data_name'], 'lightbox[' . $postGroupID . $unq_id . ']' );
										}
										break;
								}
								break;
							default:
								switch ( $lbp_plugin_options['use_class_method'] ) {
									/**
									 * Use Class Method is selected - yes/no
									 */
									case 1:
										if ( ! $e->parent()->hasClass( $lbp_plugin_options['class_name'] ) ) {
											$e->parent()->addClass( $lbp_plugin_options['class_name'] );
											if ( ! $e->parent()->attr( 'rel' ) ) {
												$e->parent()->attr( 'rel', 'lightbox[' . $postGroupID . $unq_id . ']' );
											}
										} else {
											$e->parent()->addClass( $lbp_plugin_options['class_name'] );
											if ( ! $e->parent()->attr( 'rel' ) ) {
												$e->parent()->attr( 'rel', 'lightbox[' . $postGroupID . $unq_id . ']' );
											}
										}
										break;
									default:
										if ( ! $e->parent()->attr( 'rel' ) ) {
											$e->parent()->attr( 'rel', 'lightbox[' . $postGroupID . $unq_id . ']' );
										}
										break;
								}
								break;
						}


						/**
						 * Do Not Display Title is select - yes/no
						 */
						switch ( $lbp_plugin_options['no_display_title'] ) {
							case 1:
								$e->parent()->removeAttr( 'title' );
								break;
							default:
								if ( ! $e->parent()->attr( 'title' ) ) {
									if ( $e->attr( 'title' ) ) {
										$e->parent()->attr( 'title', $e->attr( 'title' ) );
									} else {
										$e->parent()->attr( 'title', $postGroupTitle );
									}
								}
								if ( $lbp_plugin_options['use_caption_title'] ) {
									if ( $e->find( "img[src*=jpg$], img[src*=gif$], img[src*=png$], img[src*=jpeg$], img[src*=bmp$]" )->next()->hasClass( 'wp-caption-text' ) ) {
										$e->attr( 'title', $e->next()->text );
									} elseif ( $e->find( "img[src*=jpg$], img[src*=gif$], img[src*=png$], img[src*=jpeg$], img[src*=bmp$]" )->parent()->next->hasClass( 'gallery-caption' ) ) {
										$e->attr( 'title', $e->parent()->next()->text );
									}
								}
								break;
						}
					}
					break;
			}

			$content = $html->top( 'body' )->innerHTML();
			unset( $html );

			return $content;
		}
	}
}