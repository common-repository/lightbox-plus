/**
 * @package Lightbox Plus Colorbox
 * @subpackage lightbox.admin.js
 * @internal 2016.04.18
 * @author Programmattic LLC / Dan Zappone
 * @version 2.8
 * @$Id: lightbox.admin.js 937945 2014-06-24 17:11:13Z dzappone $
 * @$URL: https://plugins.svn.wordpress.org/lightbox-plus/tags/2.7/classes/lightbox.admin.js $
 */
jQuery( document ).ready( function ( $ ) {

	/**
	 * LBP Admin Panel - Section Controls
	 */
	$( '.close-me' ).each( function () { $( this ).addClass( "closed" ); } );
	$( '#lbp_message' ).each( function () { $( this ).fadeOut( 5000 ); } );
	$( '.notice' ).each( function () { $( this ).fadeOut( 5000 ); } );
	$( '.postbox h3' ).click( function () { $( this ).next( '.toggle' ).slideToggle( 'fast' ); } );

	/**
	 * LBP Admain Panel - Section Tabs
	 */
	$( "#blbp-tabs" ).tabs( { fx: { height: 'toggle', duration: 'fast' } } );
	$( "#plbp-tabs" ).tabs( { fx: { height: 'toggle', duration: 'fast' } } );
	$( "#slbp-tabs" ).tabs( { fx: { height: 'toggle', duration: 'fast' } } );
	$( "#ilbp-tabs" ).tabs( { fx: { height: 'toggle', duration: 'fast' } } );

	/**
	 * Base Settings - General
	 */
	if ( !$( '#use_inline' ).attr( 'checked' ) ) { $( '.base_gen' ).hide(); }
	if ( $( "#output_htmlv" ).attr( 'checked' ) ) { $( '.htmlv_settings' ).show(); }
	$( "#use_inline" ).click( function () { if ( $( "#use_inline" ).attr( "checked" ) ) { $( ".base_gen" ).show( "fast" ); } else { $( ".base_gen" ).hide( "fast" ); } } );
	$( "#output_htmlv" ).click( function () { if ( $( "#output_htmlv" ).attr( 'checked' ) ) { $( ".htmlv_settings" ).show( "fast" ); } else { $( ".htmlv_settings" ).hide( "fast" ); } } );

	/**
	 * Base Settings - Styles
	 */
	$( "#lightboxplus_style" ).change( function () {
		var style = $( this ).attr( 'value' )
		$( '#lbp-style-screenshot' ).find( ".lbp-sample-current" ).hide( 0 ).removeClass( 'lbp-sample-current' ).addClass( 'lbp-sample' );
		$( '#lbp-style-screenshot' ).find( "#lbp-sample-" + style ).show( 0 ).addClass( 'lbp-sample-current' ).removeClass( 'lbp-sample' );
	} );

	/**
	 *  Base Settings - Mobile/Responsive
	 */
	if ( $( ".mobile_browsers_custom" ).attr( 'checked' ) ) { $( '.mobile_browsers_list' ).show(); } else { $( '.mobile_browsers_list' ).hide(); }
	if ( $( "#responsive" ).attr( 'checked' ) ) { $( '.responsive_settings' ).show(); }
	$( ".mobile_browsers_simple" ).click( function () { if ( $( ".mobile_browsers_simple" ).attr( 'checked' ) ) { $( ".mobile_browsers_list" ).hide( "fast" ); } } );
	$( ".mobile_browsers_expanded" ).click( function () { if ( $( ".mobile_browsers_expanded" ).attr( 'checked' ) ) { $( ".mobile_browsers_list" ).hide( "fast" ); } } );
	$( ".mobile_browsers_custom" ).click( function () { if ( $( ".mobile_browsers_custom" ).attr( 'checked' ) ) { $( ".mobile_browsers_list" ).show( "fast" ); } else { $( ".mobile_browsers_list" ).hide( "fast" ); } } );
	$( "#responsive" ).click( function () { if ( $( "#responsive" ).attr( 'checked' ) ) { $( ".responsive_settings" ).show( "fast" ); } else { $( ".responsive_settings" ).hide( "fast" ); } } );
	$( "#lbp_setting_detail" ).click( function () { $( '#lbp-detail' ).toggle( 'fast' ) } );
	$( ".lbp_mobile_show_details" ).click( function () {
		if ( $( ".lbp_mobile_details" ).is( ':visible' ) ) { $( this ).next().hide( "fast" ); } else {
			$( this ).next().show( "fast" );
		}
	} );

	/**
	 * Base Settings - Advanced
	 */
	if ( !$( '#use_perpage' ).attr( 'checked' ) ) { $( '.base_blog' ).hide(); }
	$( "#use_perpage" ).click( function () { if ( $( "#use_perpage" ).attr( 'checked' ) ) { $( ".base_blog" ).show( "fast" ); } else { $( ".base_blog" ).hide( "fast" ); } } );

	/**
	 * Primary Settings - Interface
	 */
	if ( $( '#rel' ).attr( 'checked' ) ) { $( '.grouping_prim' ).hide(); }
	if ( $( "#use_class_method" ).attr( 'checked' ) ) { $( '.primary_class_name' ).show(); }
	$( "#rel" ).click( function () { if ( $( "#rel" ).attr( 'checked' ) ) { $( ".grouping_prim" ).hide( "fast" ); } else { $( ".grouping_prim" ).show( "fast" ); } } );
	$( "#use_class_method" ).click( function () { if ( $( "#use_class_method" ).attr( "checked" ) ) { $( ".primary_class_name" ).show( "fast" ); } else { $( ".primary_class_name" ).hide( "fast" ); } } );

	/**
	 * Primary Settings - Slideshow
	 */
	if ( !$( '#slideshow' ).attr( 'checked' ) ) { $( '.slideshow_prim' ).hide(); }
	$( "#slideshow" ).click( function () { if ( $( "#slideshow" ).attr( 'checked' ) ) { $( ".slideshow_prim" ).show( "fast" ); } else { $( ".slideshow_prim" ).hide( "fast" ); } } );

	/**
	 * Secondary Settings - Interface
	 */
	if ( $( '#rel_sec' ).attr( 'checked' ) ) { $( '.grouping_sec' ).hide(); }
	$( "#rel_sec" ).click( function () { if ( $( "#rel_sec" ).attr( 'checked' ) ) { $( ".grouping_sec" ).hide( "fast" ); } else { $( ".grouping_sec" ).show( "fast" ); } } );

	/**
	 * Secondary Settings - Slideshow
	 */
	if ( !$( '#slideshow_sec' ).attr( 'checked' ) ) { $( '.slideshow_sec' ).hide(); }
	$( "#slideshow_sec" ).click( function () { if ( $( "#slideshow_sec" ).attr( 'checked' ) ) { $( ".slideshow_sec" ).show( "fast" ); } else { $( ".slideshow_sec" ).hide( "fast" ); } } );

} );