<?php
/**
 * @package Lightbox Plus Colorbox
 * @subpackage lightbox.admin.php
 * @internal 2016.04.18
 * @author Programmattic LLC / Dan Zappone
 * @version 2.8
 * @$Id: lightbox.admin.php 937945 2014-06-24 17:11:13Z dzappone $
 * @$URL: https://plugins.svn.wordpress.org/lightbox-plus/tags/2.7/admin/lightbox.admin.php $
 */
defined( 'ABSPATH' ) or die( 'You kids get off my lawn!' );

if ( ! empty( $this->lbp_plugin_options ) ) {
	$lbp_plugin_options = $this->lbp_get_admin_options( $this->lbp_options_name );
}
global $lbp_global_dom_library;
global $lbp_global_enqueued_script_urls;
global $lbp_global_plugin_url;
global $lbp_global_style_url;
global $lbp_global_style_url_custom;
global $lbp_global_version;
global $lbp_global_version_colorbox;
global $lbp_global_version_shortcode;
global $lbp_global_version_dom;
global $wp_version;

/**
 * Remove following line after a few versions or 2.8 is the prevelent version
 */
if ( isset( $lbp_plugin_options ) ) {
	$lbp_plugin_options = $this->lbp_set_missing_options( $lbp_plugin_options );
}
$lbp_nonce = wp_create_nonce( 'lbp-nonce' );
?>
<!-- About Lightbox Plus Colorbox for WordPress -->
<div class="infotable" xmlns="http://www.w3.org/1999/html">
	<div class="inforow">
		<div class="lbp infosidebar-left">
			<div class="postbox">
				<div class="recommend">
					<h5>Checkout our Friends!</h5>
					<a href="http://linktrack.info/.13jgu" title="SumoMe" class="reclink"><img src="<?php echo esc_url( $lbp_global_plugin_url . 'admin/images/aflt-265x70-sumome.png' ); ?>" alt="SumoMe"></a>
					<h5>Tools to Grow Your Website’s Traffic</h5>
				</div>
			</div>
		</div>

		<div id="poststuff" class="lbp infocontent">
			<div class="postbox<?php if ( isset( $lbp_plugin_options['hide_about'] ) && '1' == $lbp_plugin_options['hide_about'] ) {
				esc_attr_e( ' close-me' );
			} ?>">
				<h3 class="handle"><?php _e( 'About Lightbox Plus Colorbox for WordPress', 'lightboxplus' ); ?></h3>
				<div class="inside toggle">
					<p style="text-align: justify;">
						<strong><?php _e( 'Thank you for downloading and installing Lightbox Plus Colorbox for WordPress', 'lightboxplus' ); ?></strong>
						<?php _e( 'Lightbox Plus Colorbox implements Colorbox as a lightbox image overlay tool for WordPress. Lightbox Plus Colorbox allows you to easily integrate and customize a powerful and light-weight lightbox plugin for jQuery into your WordPress site. You can easily create additional styles by adding a new folder to the css directory under <code>wp-content/plugins/lighbox-plus/css/</code> by duplicating and modifying any of the existing themes or using them as examples to create your own.  . Lightbox Plus Colorbox uses Colorbox created by <a href="http://www.jacklmoore.com/colorbox">Jack Moore</a> as well as the built in WordPress jQuery library and the <a href="http://simplehtmldom.sourceforge.net/" title="PHP Simple HTML DOM Parser">PHP Simple HTML DOM Parser</a> to navigate page content and add he Lightbox attributes into elements. See the <a href="https://wordpress.org/plugins/lightbox-plus/changelog/">changelog</a> for important details on this upgrade.  As of the next version Lightbox Plus Colorbox will be made and supported by Programmattic LLC and contain numerous enhancements.', 'lightboxplus' ); ?>
					</p>
					<p><strong></strong><?php _e( 'You have our sincere thanks and appreciation for using <em>Lightbox Plus Colorbox</em>.', 'lightboxplus' ); ?></strong></p>
				</div>
			</div>
		</div>

		<div class="clear"></div>
	</div>
</div>
<div class="clear"></div>
<!-- Settings/Options -->
<form name="lightboxplus_settings" method="post" action="<?php echo $location ?>&updated=settings&_wpnonce=<?php echo $lbp_nonce; ?>">
	<input type="hidden" name="action" value="action"/>
	<input type="hidden" name="sub" value="settings"/>
	<div id="poststuff" class="lbp">
		<div class="postbox">
			<h3 class="handle"><?php _e( 'Lightbox Plus Colorbox - Base Settings', 'lightboxplus' ); ?></h3>
			<div class="inside toggle">
				<div id="blbp-tabs">
					<ul>
						<li><a href="#blbp-tabs-1"><?php _e( 'General', 'lightboxplus' ); ?></a></li>
						<li><a href="#blbp-tabs-2"><?php _e( 'Styles', 'lightboxplus' ); ?></a></li>
						<li><a href="#blbp-tabs-3"><?php _e( 'Responsive/Mobile', 'lightboxplus' ); ?></a></li>
						<li><a href="#blbp-tabs-4"><?php _e( 'Advanced', 'lightboxplus' ); ?></a></li>
						<li><a href="#blbp-tabs-5"><?php _e( 'Support', 'lightboxplus' ); ?></a></li>
						<!-- li><a href="#blbp-tabs-6"><?php // _e( 'Tools','lightboxplus' ); ?></a></li -->
					</ul>
					<!-- General -->
					<div id="blbp-tabs-1">
						<table class="form-table">
							<tr>
								<th scope="row">
									<label for="lightboxplus_multi"><?php _e( 'Use Secondary Lightbox', 'lightboxplus' ) ?></label>:
								</th>
								<td>
									<input type="hidden" name="lightboxplus_multi" value="0">
									<input type="checkbox" name="lightboxplus_multi" id="lightboxplus_multi" value="1"<?php checked( '1', $lbp_plugin_options['lightboxplus_multi'] ); ?> />
									<br/>
									<span class="lbp_bigtip" id="lbp_lightboxplus_multi_tip">
										<?php _e( 'If checked, Lightbox Plus Colorbox will create a secondary lightbox with an additional set of controls.  This secondary lightbox can be used to create inline or iFramed content using a class to specify the content. <strong><em>Default: Unchecked</em></strong>', 'lightboxplus' ) ?>
									</span>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="use_inline"><?php _e( 'Add Inline Lightboxes', 'lightboxplus' ) ?></label>:
								</th>
								<td>
									<input type="hidden" name="use_inline" value="0">
									<input type="checkbox" name="use_inline" id="use_inline" value="1"<?php checked( '1', $lbp_plugin_options['use_inline'] ); ?> />
									<br/>
									<span class="lbp_bigtip" id="lbp_use_inline_tip">
										<?php _e( 'If checked, Lightbox Plus Colorbox will add the selected number of addtional lightboxes that you can use to manuall add inline lightboxed content to.  Additional controls will be available at the bottom of the Lightbox Plus Colorbox admin page. <strong><em>Default: Unchecked</em></strong>', 'lightboxplus' ) ?>
									</span>
								</td>
							</tr>
							<tr class="base_gen">
								<th scope="row">
									<label for="inline_num"><?php _e( 'Number of Inline Lightboxes:', 'lightboxplus' ) ?></label>:
								</th>
								<td>
									<select name="inline_num" id="inline_num">
										<?php for ( $i = 5; $i <= 1000; $i += 5 ) {
											?>
											<option value="<?php echo esc_attr( $i ); ?>"<?php selected( $i, $lbp_plugin_options['inline_num'] ); ?>><?php echo $i; ?></option>
											<?php
										}
										?>
									</select>
									<br/>
									<span class="lbp_bigtip" id="lbp_inline_num_tip">
										<?php _e( 'Select the number of inline lightboxes (up to 1000). <em>There is a performance hit after about 100.</em> <strong><em>Default: 5</em></strong>', 'lightboxplus' ) ?>
									</span>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="output_htmlv">
										<?php _e( 'Output Valid HTML5', 'lightboxplus' ) ?>:
									</label>
								</th>
								<td>
									<input type="hidden" name="output_htmlv" value="0">
									<input type="checkbox" name="output_htmlv" id="output_htmlv" value="1"<?php checked( '1', $lbp_plugin_options['output_htmlv'] ); ?> />
									<br/>
									<span class="lbp_bigtip" id="lbp_lightboxplus_output_htmlv_tip">
										<?php _e( 'If checked Lightbox Plus Colorbox will create valid HTML5 lightbox links. <strong><em>Default: Unchecked</em></strong>', "lightboxplus" ); ?>
									</span>
								</td>
							</tr>
							<tr class="htmlv_settings lbp-closed">
								<th scope="row">
									<label for="data_name"><?php _e( 'HTML Data attribute', 'lightboxplus' ) ?></label>:
								</th>
								<td>
									data-<input type="text" size="15" name="data_name" id="data_name" value="<?php if ( empty( $lbp_plugin_options['data_name'] ) ) {
										echo 'lightboxplus';
									} else {
										echo esc_attr( $lbp_plugin_options['data_name'] );
									} ?>"/>
									<br/>
									<span class="lbp_bigtip" id="lbp_lightboxplus_data_name_tip">
										<?php _e( 'Specify HTML5 data attribute to use or leave as default. <strong><em>Default: lightboxplus</em></strong>', "lightboxplus" ); ?>
									</span>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="hide_about"><?php _e( 'Hide "About Lightbox Plus Colorbox"', 'lightboxplus' ) ?></label>:
								</th>
								<td>
									<input type="hidden" name="hide_about" value="0">
									<input type="checkbox" name="hide_about" id="hide_about" value="1"<?php checked( '1', $lbp_plugin_options['hide_about'] ); ?> />
									<br/>
									<span class="lbp_bigtip" id="lbp_hide_about_tip">
										<?php _e( 'If checked will keep "About Lightbox Plus Colorbox for WordPress" closed. <strong><em>Default: Unchecked</em></strong>', 'lightboxplus' ) ?>
									</span>
								</td>
							</tr>
						</table>
					</div>
					<!-- Styles -->
					<div id="blbp-tabs-2">
						<table class="form-table">
							<tr valign="top">
								<th scope="row">
									<label for="lightboxplus_style"><?php _e( 'Lightbox Plus Colorbox Style', 'lightboxplus' ) ?></label>:
								</th>
								<td>
									<select name="lightboxplus_style" id="lightboxplus_style">
										<?php
										foreach ( $styles as $key => $value ) {
											echo( "<option value='" . esc_attr( urlencode( $key ) ) . "'" . selected( $lbp_plugin_options['lightboxplus_style'], urlencode( $key ) ) . ">" . esc_html( $this->lbp_set_proper_name( $key ) ) . "</option>" . PHP_EOL );
										}
										?>
									</select>
									<br/>
									<span class="lbp_bigtip" id="lbp_lightboxplus_style_tip">
										<?php _e( 'Select Lightbox Plus Colorbox theme/style here. <strong><em>Default: Shadowed</em></strong>', "lightboxplus" ); ?>
									</span>
								</td>
							</tr>
							<tr>
								<td>
									<div id="lbp-style-screenshot">
										<?php
										if ( $lbp_plugin_options['use_custom_style'] ) {
											$style_path_url = $lbp_global_style_url_custom;
										} else {
											$style_path_url = $lbp_global_style_url;
										}

										foreach ( $styles as $key => $value ) {
											if ( $lbp_plugin_options['lightboxplus_style'] == urlencode( $key ) ) {
												$path = esc_url( $style_path_url . '/' . urlencode( $key ) . '/sample.jpg' );
												$id   = esc_attr( 'lbp-sample-' . urlencode( $key ) );
												echo( "<img src='$path' class='lbp-sample-current' id='$id' />" . PHP_EOL );
											} else {
												$path = esc_url( $style_path_url . '/' . urlencode( $key ) . '/sample.jpg' );
												$id   = esc_attr( 'lbp-sample-' . urlencode( $key ) );
												echo( "<img src='$path' class='lbp-sample' id='$id' />" . PHP_EOL );
											}
										}
										?>

									</div>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="use_custom_style"><?php _e( 'Use Custom Styles', 'lightboxplus' ) ?></label>:
								</th>
								<td>
									<input type="hidden" name="use_custom_style" value="0">
									<input type="checkbox" name="use_custom_style" id="use_custom_style" value="1"<?php checked( '1', $lbp_plugin_options['use_custom_style'] ); ?> />
									<br/>
									<span class="lbp_bigtip" id="lbp_use_custom_style_tip">
										<?php _e( 'If checked, the built in stylsheets for Lightbox Plus Colorbox will be located at <code>wp-content/lbp-css</code>.  Lightbox Plus Colorbox will attempt to create this directory and copy default styles to it.  This will allow you to create custom styles in that directory with fear of the styles being deleted when you upgrade he plugin. <strong><em>Default: Unchecked</em></strong>', 'lightboxplus' ) ?>
									</span>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="disable_css"><?php _e( 'Disable Lightbox CSS', 'lightboxplus' ) ?></label>:
								</th>
								<td>
									<input type="hidden" name="disable_css" value="0">
									<input type="checkbox" name="disable_css" id="disable_css" value="1"<?php checked( '1', $lbp_plugin_options['disable_css'] ); ?> />
									<br/>
									<span class="lbp_bigtip" id="lbp_disable_css_tip">
										<?php _e( 'If checked, the built in stylsheets for Lightbox Plus Colorbox will be disabled.  This will allow you to include customized Lightbox Plus Colorbox styles in your theme stylesheets which can reduce files loaded, and making editing easier. Note, that if you do not have the Lightbox styles set in your stylesheet your Lightboxed images will appear at the top of your page. <strong><em>Default: Unchecked</em></strong>', 'lightboxplus' ) ?>
									</span>
								</td>
							</tr>
						</table>
					</div>
					<!-- Responsive/Mobile -->
					<div id="blbp-tabs-3">
						<table class="form-table">
							<tr>
								<th scope="row">
									<?php _e( 'Mobile Browser Settings', 'lightboxplus' ) ?>:
								</th>
								<td>
									<label title='mobile_browser_settings'>
										<input type="radio" name="mobile_browser_settings" id="mobile_browser_settings[none]" class="mobile_browsers_none" value="none" <?php checked( 'none', $lbp_plugin_options['mobile_browser_settings'] ); ?>/>
										<span><?php esc_attr_e( 'Do not disable for mobile browsers (none)', 'lightboxplus' ); ?></span>
											<span class="lbp_bigtip" id="lbp_mobile_browsers_simple_tip"><?php _e( 'Does not disable Lightbox Plus Colorbox for any mobile browsers (0% of mobile browsers) <strong><em>Default: Selected</em></strong>', 'lightboxplus' ) ?>
											</span>
									</label>
									<br/>
									<label title='mobile_browser_settings'>
										<input type="radio" name="mobile_browser_settings" id="mobile_browser_settings[common]" class="mobile_browsers_simple" value="common" <?php checked( 'common', $lbp_plugin_options['mobile_browser_settings'] ); ?>/>
										<span><?php esc_attr_e( 'Disable for mobile browsers (common)', 'lightboxplus' ); ?></span>
											<span class="lbp_bigtip" id="lbp_mobile_browsers_simple_tip"><?php _e( 'Disables lightbox Plus Colorbox for the most common mobile browsers (around 90% of mobile browsers)<strong><em>Default: Unselected</em></strong>', 'lightboxplus' ) ?>
											</span>
									</label>
									<a title="(details)" class="lbp_mobile_show_details">Show Details</a>
									<div class="lbp_mobile_details"><?php _e( 'Simple list of browser agents as a regular expression to disable Lightbox Plus Colorbox for covering about 90% of all mobile browsers:', 'lightboxplus' ) ?>
										<br/><span class="lbp_mobile_browsers_details"><?php esc_html_e( 'Mobile|iP(hone|od|ad)|Android|BlackBerry|IEMobile' ); ?></span>
									</div>
									<br/>
									<label title='mobile_browser_settings'>
										<input type="radio" name="mobile_browser_settings" id="mobile_browser_settings[expanded]" class="mobile_browsers_expanded" value="expanded" <?php checked( 'expanded', $lbp_plugin_options['mobile_browser_settings'] ); ?>/>
										<span><?php esc_attr_e( 'Disable for mobile browsers (expanded)', 'lightboxplus' ); ?></span>
										<span class="lbp_bigtip" id="lbp_mobile_browsers_simple_tip"><?php _e( 'If selected disables lightbox Plus Colorbox for most mobile browsers  (around 98% of mobile browsers)<strong><em>Default: Unselected</em></strong>', 'lightboxplus' ) ?></span>
									</label>
									<a title="(details)" class="lbp_mobile_show_details">Show Details</a>
									<div class="lbp_mobile_details"><?php _e( 'The xxpanded list of regular expression browser agents to disable Lightbox Plus Colorbox for covering about 98% of all mobile browsers:', 'lightboxplus' ) ?>
										<br/><span class="lbp_mobile_browsers_details"><?php esc_html_e( 'Mobile|iP(hone|od|ad)|Android|BlackBerry|IEMobile|Kindle|NetFront|Silk-Accelerated|(hpw|web)OS|Fennec|Minimo|Opera M(obi|ini)|Blazer|Dolfin|Dolphin|Skyfire|Zune' ); ?></span>
									</div>
									<br/>
									<label title='mobile_browser_settings'>
										<input type="radio" name="mobile_browser_settings" id="mobile_browser_settings[custom]" class="mobile_browsers_custom" value="custom" <?php checked( 'custom', $lbp_plugin_options['mobile_browser_settings'] ); ?>/>
										<span><?php esc_attr_e( 'Mobile browsers (custom)', 'lightboxplus' ); ?></span>
										<span class="lbp_bigtip" id="lbp_mobile_browsers_simple_tip"><?php _e( 'If selected you are able to define your own regular expression list  of browsers to treat as mobile <strong><em>Default: Unselected</em></strong>', 'lightboxplus' ) ?></span>
									</label>
									<div class="mobile_browsers_list lbp-closed">
									<textarea cols="80" rows="10" class="large-text" name="mobile_browsers_custom" id="mobile_browsers_custom"><?php if ( empty( $lbp_plugin_options['mobile_browsers_custom'] ) ) {
											echo 'Mobile|iP(hone|od|ad)|Android|BlackBerry|IEMobile';
										} else {
											echo esc_attr( $lbp_plugin_options['mobile_browsers_custom'] );
										} ?></textarea>
										<br/>
									<span class="lbp_bigtip" id="lbp_mobile_browsers_tip">
										<?php _e( 'Specify which mobile browsers to disable the lightbox for, this is in the form of a regular expression minus the outside delimiters. <strong><em>Default: Mobile|iP(hone|od|ad)|Android|BlackBerry|IEMobile</em></strong>', "lightboxplus" ); ?>
									</span>
									</div>
								</td>
							</tr>
							<tr>
								<th scope="row"><label for="responsive"><?php _e( 'Responsive', 'lightboxplus' ) ?></label>:</th>
								<td>
									<input type="hidden" name="responsive" value="0">
									<input type="checkbox" name="responsive" id="responsive" value="1"<?php checked( '1', $lbp_plugin_options['responsive'] ); ?> />
									<br/>
									<span class="lbp_bigtip" id="lbp_responsive_tip">
										<?php _e( 'If checked will disable lightboxing for display beneath the screen widths as set below. CSS can be customized for further behavior.<strong><em>Default: Unchecked</em></strong>', 'lightboxplus' ) ?>
									</span>
								</td>
							</tr>
							<tr class="responsive_settings lbp-closed">
								<th scope="row">
									<label for="responsive_width"><?php _e( 'Width for responsive', 'lightboxplus' ) ?></label>:
								</th>
								<td>
									<input type="text" class="small-text" size="15" name="responsive_width" id="responsive_width" value="<?php if ( empty( $lbp_plugin_options['responsive_width'] ) ) {
										echo 'lightboxplus';
									} else {
										echo esc_attr( $lbp_plugin_options['responsive_width'] );
									} ?>"/>px
									<br/>
									<span class="lbp_bigtip" id="lbp_lightboxplus_responsive_width_tip">
										<?php _e( 'Specify width at which the lightboxes become responsive.  Note that if the resolution starts larger than this the lightbox will not become responsive. <strong><em>Default: 960</em></strong>', "lightboxplus" ); ?>
									</span>
								</td>
							</tr>
						</table>
					</div>
					<!-- Advanced -->
					<div id="blbp-tabs-4">
						<table class="form-table">
							<tr>
								<th scope="row">
									<label for="use_perpage"><?php _e( 'Use page/post options', 'lightboxplus' ) ?></label>:
								</th>
								<td>
									<input type="hidden" name="use_perpage" value="0">
									<input type="checkbox" name="use_perpage" id="use_perpage" value="1"<?php checked( '1', $lbp_plugin_options['use_perpage'] ); ?> />
									<br/>
									<span class="lbp_bigtip" id="lbp_lightboxplus_use_perpage_tip">
										<?php _e( 'If checked allows you specify which posts or pages to load Lightbox Plus Colorbox on while writing the page or set for blog/single posts. <strong><em>Default: Unchecked</em></strong>', "lightboxplus" ); ?>
									</span>
								</td>
							</tr>
							<tr class="base_blog">
								<th scope="row">
									<label for="use_forpage"><?php _e( 'Use for page', 'lightboxplus' ) ?></label>:
								</th>
								<td>
									<input type="hidden" name="use_forpage" value="0">
									<input type="checkbox" name="use_forpage" id="use_forpage" value="1"<?php checked( '1', $lbp_plugin_options['use_forpage'] ); ?> />
									<br/>
									<span class="lbp_bigtip" id="lbp_lightboxplus_use_forpage_tip">
										<?php _e( 'If checked allows you specify which pages to load Lightbox Plus Colorbox on while writing the page. <strong><em>Default: Unchecked</em></strong>', "lightboxplus" ); ?>
									</span>
								</td>
							</tr>
							<tr class="base_blog">
								<th scope="row">
									<label for="use_forpost"><?php _e( 'Use for posts/blog', 'lightboxplus' ) ?></label>:
								</th>
								<td>
									<input type="hidden" name="use_forpost" value="0">
									<input type="checkbox" name="use_forpost" id="use_forpost" value="1"<?php checked( '1', $lbp_plugin_options['use_forpost'] ); ?> />
									<br/>
									<span class="lbp_bigtip" id="lbp_lightboxplus_use_forpost_tip">
										<?php _e( 'If checked will use for blog/posts page and all single posts but not for pages unless the above is checked. <strong><em>Default: Unchecked</em></strong>', "lightboxplus" ); ?>
									</span>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="load_location"><?php _e( 'Load in Header/Footer', 'lightboxplus' ) ?></label>:
								</th>
								<td>
									<select name="load_location" id="load_location">
										<option value="wp_footer"<?php selected( 'wp_footer', $lbp_plugin_options['load_location'] ); ?>>Footer</option>
										<option value="wp_head"<?php selected( 'wp_head', $lbp_plugin_options['load_location'] ); ?>>Header</option>
									</select>
									<br/>
									<span class="lbp_bigtip" id="lbp_load_location_tip">
										<?php _e( 'You can set whether you want to inline scripts to load in the header or footer. Footer loads at the end of page and is highly recommended. <strong><em>Default: Footer</em></strong>', "lightboxplus" ); ?>
									</span>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="load_priority"><?php _e( 'Load Priority', 'lightboxplus' ) ?></label>:
								</th>
								<td>
									<select name="load_priority" id="load_priority">
										<option value="15"<?php selected( '15', $lbp_plugin_options['load_priority'] ); ?>>Low</option>
										<option value="10"<?php selected( '10', $lbp_plugin_options['load_priority'] ); ?>>Normal</option>
										<option value="5"<?php selected( '5', $lbp_plugin_options['load_priority'] ); ?>>High</option>
									</select>
									<br/>
									<span class="lbp_bigtip" id="lbp_load_priority_tip">
										<?php _e( 'Allows you to set the priority for the load action for the inline scripts, higher will load sooner. <strong><em>Default: Normal</em></strong>', "lightboxplus" ); ?>
									</span>
								</td>
							</tr>
						</table>
					</div>
					<!-- Support -->
					<div id="blbp-tabs-5">
						<h4><?php esc_html_e( 'Support for Lightbox Plus Colorbox', 'lightboxplus' ); ?></h4>
						<p><?php _e( 'At this time Lightbox Plus Colorbox on has community support via the <a href="http://wordpress.org/support/plugin/lightbox-plus" title="Lightbox Plus Colorbox Direct Support">support forums</a>.  Please include the following information when requesting support:', 'lightboxplus' ); ?></p>
						<table width="100%" border="0" class="lbp-support-info">
							<tbody>
							<tr>
								<td width="50%" valign="top">
									<h4>WordPress Information</h4>
									<strong>WordPress Version:</strong> <?php esc_html_e( $wp_version ); ?><br/>
									<strong>jQuery Version:</strong>
									<script type="text/javascript">document.write( jQuery.fn.jquery );</script>
									<br/>
									<strong>Enqueued Scripts & Styles:</strong><br/>
									<?php
									foreach ( $lbp_global_enqueued_script_urls as $lbp_script_url ) {
										echo '<a href="' . esc_url( $lbp_script_url ) . '">' . esc_html( $lbp_script_url ) . '</a></br />';
									}
									?><br/>
									<br/>
								</td>
								<td width="50%" valign="top">
									<h4>Server Information</h4>
									<strong>Site URL:</strong> <?php echo esc_url( get_site_url() ); ?><br/>
									<strong>PHP Version:</strong> <?php esc_html_e( phpversion() ); ?><br/>
									<strong>Server Software:</strong> <?php esc_html_e( $_SERVER['SERVER_SOFTWARE'] ); ?>
								</td>
							</tr>
							<tr>
								<td width="50%" valign="top">
									<h4>Plugin Information</h4>
									<strong>Lightbox Plus Colorbox Version:</strong> <?php esc_html_e( $lbp_global_version ); ?><br/>
									<strong>LBP Shortcode Version:</strong> <?php esc_html_e( $lbp_global_version_shortcode ); ?><br/>
									<strong>Colorbox Version:</strong> <?php esc_html_e( $lbp_global_version_colorbox ); ?><br/>
									<strong><?php esc_html_e( $lbp_global_dom_library ); ?>:</strong> <?php esc_html_e( $lbp_global_version_dom ); ?>
								</td>
								<td width="50%" valign="top">
									<h4>Client Information</h4>
									<strong>Browser:</strong> <?php esc_html_e( $_SERVER['HTTP_USER_AGENT'] ); ?><br/>
									<strong>Viewport:</strong>
									<script type="text/javascript">document.write( jQuery( window ).width() + 'x' + jQuery( window ).height() );</script>
									<br/>
									<strong>Platform:</strong>
									<script type="text/javascript">document.write( navigator.platform );</script>
									<br/>
									<strong>Javascript:</strong>
									<noscript>No</noscript>
									<script type="text/javascript">document.write( 'Yes' );</script>
								</td>
							</tr>
							<tr>
								<td colspan="2" valign="top">
									<a class="button-secondary" id="lbp_setting_detail">Show/Hide Raw Settings</a>
								</td>
							</tr>
							<tr>
								<td colspan="2" valign="top" id="lbp-detail">
									<?php
									if ( version_compare( PHP_VERSION, '5.4', '<' ) ) {
										echo "<pre><code class='json'>" . json_encode( $lbp_plugin_options, JSON_PRETTY_PRINT ) . "</code></pre>";
									} else {
										echo "<pre><code class='json'>" . $this->lbp_format_json( json_encode( $lbp_plugin_options ) ) . "</code></pre>";
									}
									?>
								</td>
							</tr>
							</tbody>
						</table>
						<p><?php _e( 'It would also be a good idea to read the <a title="Lightbox Plus Colorbox Frequently Asked Questions" href="http://www.23systems.net/wordpress-plugins/lightbox-plus-for-wordpress/frequently-asked-questions/">Lightbox Plus Colorbox FAQ</a> to see if you question is answered there.', 'lightboxplus' ); ?></p>
						<p><?php _e( 'If you would like to show your support for our free WordPress plugins please consider a <a title="Help support Free and Open Source software by donating to our free plugin development" href="http://www.23systems.net/wordpress-plugins/donate/">donation</a>.', 'lightboxplus' ); ?></p>
					</div>
					<!-- Tools -->
					<!-- div id="blbp-tabs-5">
					</div -->
				</div>
				<?php submit_button( 'Save all settings', 'primary', 'reset', true, array( 'id' => 'save-all-lbp-1' ) ) ?>
			</div>

		</div>
	</div>

	<div id="poststuff" class="lbp">
		<div class="postbox tryout">
			<h5>Tools to Grow Your Website’s Traffic?&nbsp;&nbsp;Try out our friends, <a href="http://linktrack.info/.13jgz" title="SumoMe">SumoMe WordPress Plugin</a>!</h5>
		</div>
	</div>


	<?php
	require( 'lightbox.primary.php' );

	if ( $lbp_plugin_options['lightboxplus_multi'] ) {
		require( 'lightbox.secondary.php' );
	}
	if ( $lbp_plugin_options['use_inline'] ) {
		require( 'lightbox.inline.php' );
	}
	?>
</form>

<!-- Reset/Re-initialize -->
<div id="poststuff" class="lbp">
	<div class="postbox close-me">
		<h3 class="handle"><?php _e( 'Lightbox Plus Colorbox - Reset/Re-initialize', 'lightboxplus' ); ?></h3>
		<div class="inside toggle">
			<!-- Secondary Settings -->
			<div class="ui-widget">
				<div class="ui-state-error ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
					<p>
						<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
						<?php _e( 'This will immediately remove all existing settings and any files for versions of Lightbox Plus Colorbox prior to version 1.5 (if needed) and will also re-initialize the plugin with the new default options. Be absolutely certain you want to do this. <br /><br /><strong><em>If you are upgrading from a version prior to 2.0 it is <strong><em>highly</em></strong> recommended that you reinitialize Lightbox Plus Colorbox</em></strong>', 'lightboxplus' ); ?>
					</p>
					<form action="<?php echo $location ?>&updated=reset&_wpnonce=<?php echo $lbp_nonce ?>" method="post" id="lightboxplus_reset" name="lightboxplus_reset">
						<input type="hidden" name="action" value="action"/>
						<input type="hidden" name="sub" value="reset"/>

						<input type="hidden" name="reinit_lightboxplus" value="1"/>
						<?php submit_button( 'Reset/Re-initialize Lightbox Plus Colorbox', 'primary', 'reset', true, array( 'id' => 'reset-lbp' ) ) ?>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Inline Demo Form -->
<div style="display:none">
	<div id="<?php if ( isset( $inline_hrefs[0] ) ) {
		echo $inline_hrefs[0];
	} ?>" style="padding: 10px;background: #fff">
		<h3><?php _e( 'About Lightbox Plus Colorbox for WordPress', 'lightboxplus' ); ?>: </h3>
		<div class="donate">
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
				<input type="hidden" name="cmd" value="_s-xclick">
				<input type="hidden" name="hosted_button_id" value="BKVLWU2KWRNAG">
				<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!"><img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
			</form>
			<h4>&mdash; or try a 23Systems affiliate program &mdash;</h4>
			<a href="http://6e772-ccdd75pi48yf3kdqfke0.hop.clickbank.net/?tid=DIGWP" target="_top" name="Digging into WordPress - Really Learn It"><img src="<?php echo esc_url( $lbp_global_plugin_url . 'admin/images/aflt-100x26-digwp.jpg' ); ?>" alt="Digging into WordPress - Really Learn It" border="0"/></a>
			<a href="https://www.e-junkie.com/ecom/gb.php?cl=54585&c=ib&aff=107849" target="ejejcsingle" name=""><img src="<?php echo esc_url( $lbp_global_plugin_url . 'admin/images/aflt-100x26-grvfrm.jpg' ); ?>" alt="Gravity Forms - WordPress Form Management" border="0"/></a><br/>
			<a target="_blank" href="http://www.shareasale.com/r.cfm?b=241698&u=734275&m=28169&urllink=&afftrack="><img src="<?php echo esc_url( $lbp_global_plugin_url . 'admin/images/aflt-100x26-genesis.jpg' ); ?>" alt="Professionally Designed WordPress Themes" border="0"/></a>
			<a href="https://www.e-junkie.com/ecom/gb.php?ii=195647&c=ib&aff=107849&cl=12635" target="ejejcsingle" name="How to be a Rockstar WordPress Designer"><img src="<?php echo esc_url( $lbp_global_plugin_url . 'admin/images/aflt-100x26-rckstr.jpg' ); ?>" alt="How to be a Rockstar WordPress Designer" border="0"/></a>
		</div>
		<h4><?php _e( 'Thank you for downloading and installing Lightbox Plus Colorbox for WordPress', 'lightboxplus' ); ?></h4>
		<p style="text-align: justify;">
			<?php _e( 'Lightbox Plus Colorbox implements Colorbox as a lightbox image overlay tool for WordPress.  Colorbox was created by Jack Moore of <a href="http://www.jacklmoore.com/colorbox">Color Powered</a> and is licensed under the MIT License. Lightbox Plus Colorbox allows you to easily integrate and customize a powerful and light-weight lightbox plugin for jQuery into your WordPress site.  You can easily create additional styles by adding a new folder to the css directory under <code>wp-content/plugins/lighbox-plus/css/</code> by duplicating and modifying any of the existing themes or using them as examples to create your own.  See the <a href="http://www.23systems.net/plugins/lightbox-plus/">changelog</a> for important details on this upgrade.', 'lightboxplus' ); ?>
		</p>
		<p style="text-align: justify;">
			<?php _e( 'I spend as much of my spare time as possible working on <strong>Lightbox Plus Colorbox</strong> and any donation is appreciated. Donations play a crucial role in supporting Free and Open Source Software projects. So why are donations important? As a developer the more donations I receive the more time I can invest in working on <strong>Lightbox Plus Colorbox</strong>. Donations help cover the cost of hardware for development and to pay hosting bills. This is critical to the development of free software. I know a lot of other developers do the same and I try to donate to them whenever I can. As a developer I greatly appreciate any donation you can make to help support further development of quality plugins and themes for WordPress.', 'lightboxplus' ); ?>
		</p>
		<h4><?php _e( 'Once again, you have my sincere thanks and appreciation for using <em>Lightbox Plus Colorbox</em>.', 'lightboxplus' ); ?></h4>
		<div class="clear"></div>
	</div>
</div>

<!-- Fix for end of page conent -->
<div class="clear">&nbsp;</div>
