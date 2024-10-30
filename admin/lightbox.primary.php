<?php
/**
 * Created by PhpStorm.
 * User: dzappone
 * Date: 4/20/16
 * Time: 9:03 AM
 */
defined( 'ABSPATH' ) or die( 'You kids get off my lawn!' );
?>
<!-- Primary Lightbox Settings -->
<div id="poststuff" class="lbp">
	<div class="postbox">
		<h3 class="handle"><?php _e( 'Lightbox Plus Colorbox - Primary Lightbox Settings', 'lightboxplus' ); ?></h3>
		<div class="inside toggle">
			<div id="plbp-tabs">
				<ul>
					<li><a href="#plbp-tabs-1"><?php _e( 'General', 'lightboxplus' ); ?></a></li>
					<li><a href="#plbp-tabs-2"><?php _e( 'Size', 'lightboxplus' ); ?></a></li>
					<li><a href="#plbp-tabs-3"><?php _e( 'Postition', 'lightboxplus' ); ?></a></li>
					<li><a href="#plbp-tabs-4"><?php _e( 'Interface', 'lightboxplus' ); ?></a></li>
					<li><a href="#plbp-tabs-5"><?php _e( 'Slideshow', 'lightboxplus' ); ?></a></li>
					<li><a href="#plbp-tabs-6"><?php _e( 'Other', 'lightboxplus' ); ?></a></li>
					<li><a href="#plbp-tabs-7"><?php _e( 'Usage', 'lightboxplus' ); ?></a></li>
					<li><a href="#plbp-tabs-8"><?php _e( 'Demo/Test', 'lightboxplus' ); ?></a></li>
				</ul>
				<!-- General -->
				<div id="plbp-tabs-1">
					<table class="form-table">
						<tr>
							<th scope="row">
								<label for="transition"><?php _e( 'Transition Type', 'lightboxplus' ) ?></label>:
							</th>
							<td>
								<select name="transition" id="transition">
									<option value="elastic"<?php selected( 'elastic', $lbp_plugin_options['transition'] ); ?>>Elastic</option>
									<option value="fade"<?php selected( 'fade', $lbp_plugin_options['transition'] ); ?>>Fade</option>
									<option value="none"<?php selected( 'none', $lbp_plugin_options['transition'] ); ?>>None</option>
								</select>
								<br/>
									<span class="lbp_bigtip" id="lbp_transition_tip">
										<?php _e( 'Specifies the transition type. Can be set to "elastic", "fade", or "none". <strong><em>Default: Elastic</em></strong>', 'lightboxplus' ) ?>
									</span>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="speed"><?php _e( 'Resize Speed', 'lightboxplus' ) ?></label>:
							</th>
							<td>
								<select name="speed" id="speed">
									<?php
									for ( $i = 0; $i <= 5001; ) { ?>
										<option value="<?php echo esc_attr( $i ); ?>"<?php selected( $lbp_plugin_options['speed'], strval( $i ) ); ?>><?php echo $i; ?></option>
										<?php
										if ( $i >= 2000 ) {
											$i = $i + 500;
										} elseif ( $i >= 1250 ) {
											$i = $i + 250;
										} else {
											$i = $i + 50;
										}
									}
									?>
								</select>
								<br/>
									<span class="lbp_bigtip" id="lbp_speed_tip">
										<?php _e( 'Controls the speed of the fade and elastic transitions, in milliseconds. <strong><em>Default: 300</em></strong>', 'lightboxplus' ) ?>
									</span>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="opacity"><?php _e( 'Overlay Opacity', 'lightboxplus' ) ?></label>:
							</th>
							<td>
								<select name="opacity" id="opacity">
									<?php
									for ( $i = 0; $i <= 1.01; $i = $i + .05 ) { ?>
										<option value="<?php echo esc_attr( $i ); ?>"<?php selected( $lbp_plugin_options['opacity'], strval( $i ) ); ?>><?php echo( $i * 100 ); ?>%</option>
										<?php
									}
									?>
								</select>
								<br/>
									<span class="lbp_bigtip" id="lbp_opacity_tip">
										<?php _e( 'Controls transparency of shadow overlay. Lower numbers are more transparent. <strong><em>Default: 80%</em></strong>', 'lightboxplus' ) ?>
									</span>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="preloading"><?php _e( 'Pre-load images', 'lightboxplus' ) ?></label>:
							</th>
							<td>
								<input type="hidden" name="preloading" value="0">
								<input type="checkbox" name="preloading" id="preloading" value="1"<?php checked( '1', $lbp_plugin_options['preloading'] ); ?> />
								<br/>
									<span class="lbp_bigtip" id="lbp_preloading_tip">
										<?php _e( 'Allows for preloading of "Next" and "Previous" content in a shared relation group (same values for the "rel" attribute), after the current content has finished loading. Uncheck to disable. <strong><em>Default: Checked</em></strong>', 'lightboxplus' ) ?>
									</span>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="gallery_lightboxplus"><?php _e( 'Use For WordPress Galleries', 'lightboxplus' ) ?></label>:
							</th>
							<td>
								<input type="hidden" name="gallery_lightboxplus" value="0">
									<span class="lbp_bigtip" id="lbp_gallery_lightboxplus_tip">
										<?php _e( 'In order for Lightbox Plus Colorbox to add a lightbox to WordPress galleries you must set <strong>Link thumbnails to: Image File</strong> when creating galleries or use <code>[gallery link="file"</code> in the gallery shortcode.  Galleries should automatically have a lightbox added to them.', 'lightboxplus' ) ?>
									</span>
							</td>
						</tr>
						<tr>
						<tr>
							<th scope="row">
								<label for="multiple_galleries"><?php _e( 'Separate Galleries in Post?', 'lightboxplus' ) ?></label>:
							</th>
							<td>
								<input type="hidden" name="multiple_galleries" value="0">
								<input type="checkbox" name="multiple_galleries" id="multiple_galleries" value="1"<?php checked( '1', $lbp_plugin_options['multiple_galleries'] ); ?> />
								<br/>
									<span class="lbp_bigtip" id="lbp_multiple_galleries_tip">
										<?php _e( 'If the option to separate multiple gallries in a single post is check Lightbox Plus Colorbox will create separate sets of lightbox display for each gallery in the post. <strong><em>Default: Unchecked</em></strong>', 'lightboxplus' ) ?>
									</span>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="lbp_nextgen_gallery_tip"><?php _e( 'NextGEN Galleries Usage', 'lightboxplus' ) ?></label>:
							</th>
							<td>
									<span class="lbp_bigtip" id="lbp_nextgen_gallery_tip">
										<?php $lbp_primary_class_name = esc_html( $lbp_plugin_options['class_name'] ); ?>
										<?php _e( "In NextGEN settings, go to <strong><em>Gallery --> Other Options --> Lightbox</em></strong> choose Custom. For <strong>Code</strong> add <code>class='lbp_primary' rel='lightbox[%GALLERY_NAME%]'</code> if you are using Lightbox Plus Colorbox default settings.  If <strong>Use Class Method</strong> is checked add <code>class='$lbp_primary_class_name' rel='lightbox[%GALLERY_NAME%]'</code> to lightbox your NextGEN Gallery images.", 'lightboxplus' ) ?>
									</span>
							</td>
						</tr>

					</table>
				</div>
				<!-- Size -->
				<div id="plbp-tabs-2">
					<table class="form-table">
						<tr>
							<th scope="row">
								<label for="width"><?php _e( 'Width', 'lightboxplus' ) ?></label>:
							</th>
							<td>
								<input type="text" size="15" name="width" id="width" value="<?php if ( ! empty( $lbp_plugin_options['width'] ) ) {
									echo esc_attr( $lbp_plugin_options['width'] );
								} else {
									echo '';
								} ?>"/>
								<br/>
									<span class="lbp_bigtip" id="lbp_width_tip">
										<?php _e( 'Set a fixed total width. This includes borders and buttons. Example: "100%", "500px", or 500, or false for no defined width.  <strong><em>Default: false</em></strong>', 'lightboxplus' ) ?>
									</span>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="height"><?php _e( 'Height', 'lightboxplus' ) ?></label>:
							</th>
							<td>
								<input type="text" size="15" name="height" id="height" value="<?php if ( ! empty( $lbp_plugin_options['height'] ) ) {
									echo esc_attr( $lbp_plugin_options['height'] );
								} else {
									echo '';
								} ?>"/>
								<br/>
									<span class="lbp_bigtip" id="lbp_height_tip">
										<?php _e( 'Set a fixed total height. This includes borders and buttons. Example: "100%", "500px", or 500, or false for no defined height. <strong><em>Default: false</em></strong>', 'lightboxplus' ) ?>
									</span>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="inner_width"><?php _e( 'Inner Width', 'lightboxplus' ) ?></label>:
							</th>
							<td>
								<input type="text" size="15" name="inner_width" id="inner_width" value="<?php if ( ! empty( $lbp_plugin_options['inner_width'] ) ) {
									echo esc_attr( $lbp_plugin_options['inner_width'] );
								} else {
									echo '';
								} ?>"/>
								<br/>
									<span class="lbp_bigtip" id="lbp_inner_width_tip">
										<?php _e( 'This is an alternative to "width" used to set a fixed inner width. This excludes borders and buttons. Example: "50%", "500px", or 500, or false for no inner width.  <strong><em>Default: false</em></strong>', 'lightboxplus' ) ?>
									</span>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="inner_height"><?php _e( 'Inner Height', 'lightboxplus' ) ?></label>:
							</th>
							<td>
								<input type="text" size="15" name="inner_height" id="inner_height" value="<?php if ( ! empty( $lbp_plugin_options['inner_height'] ) ) {
									echo esc_attr( $lbp_plugin_options['inner_height'] );
								} else {
									echo '';
								} ?>"/>
								<br/>
									<span class="lbp_bigtip" id="lbp_inner_height_tip">
										<?php _e( 'This is an alternative to "height" used to set a fixed inner height. This excludes borders and buttons. Example: "50%", "500px", or 500 or false for no inner height. <strong><em>Default: false</em></strong>', 'lightboxplus' ) ?>
									</span>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="initial_width"><?php _e( 'Initial Width', 'lightboxplus' ) ?></label>:
							</th>
							<td>
								<input type="text" size="15" name="initial_width" id="initial_width" value="<?php if ( ! empty( $lbp_plugin_options['initial_width'] ) ) {
									echo esc_attr( $lbp_plugin_options['initial_width'] );
								} else {
									echo '';
								} ?>"/>
								<br/>
									<span class="lbp_bigtip" id="lbp_initial_width_tip">
										<?php _e( 'Set the initial width, prior to any content being loaded.  <strong><em>Default: 300</em></strong>', 'lightboxplus' ) ?>
									</span>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="initial_height"><?php _e( 'Initial Height', 'lightboxplus' ) ?></label>:
							</th>
							<td>
								<input type="text" size="15" name="initial_height" id="initial_height" value="<?php if ( ! empty( $lbp_plugin_options['initial_height'] ) ) {
									echo esc_attr( $lbp_plugin_options['initial_height'] );
								} else {
									echo '';
								} ?>"/>
								<br/>
									<span class="lbp_bigtip" id="lbp_initial_height_tip">
										<?php _e( 'Set the initial height, prior to any content being loaded. <strong><em>Default: 100</em></strong>', 'lightboxplus' ) ?>
									</span>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="max_width"><?php _e( 'Maximum Width', 'lightboxplus' ) ?></label>:
							</th>
							<td>
								<input type="text" size="15" name="max_width" id="max_width" value="<?php if ( ! empty( $lbp_plugin_options['max_width'] ) ) {
									echo esc_attr( $lbp_plugin_options['max_width'] );
								} else {
									echo '';
								} ?>"/>
								<br/>
									<span class="lbp_bigtip" id="lbp_max_width_tip">
										<?php _e( 'Set a maximum width for loaded content.  Example: "75%", "500px", 500, or false for no maximum width.  <strong><em>Default: false</em></strong>', 'lightboxplus' ) ?>
									</span>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="max_height"><?php _e( 'Maximum Height', 'lightboxplus' ) ?></label>:
							</th>
							<td>
								<input type="text" size="15" name="max_height" id="max_height" value="<?php if ( ! empty( $lbp_plugin_options['max_height'] ) ) {
									echo esc_attr( $lbp_plugin_options['max_height'] );
								} else {
									echo '';
								} ?>"/>
								<br/>
									<span class="lbp_bigtip" id="lbp_max_height_tip">
										<?php _e( 'Set a maximum height for loaded content.  Example: "75%", "500px", 500, or false for no maximum height. <strong><em>Default: false</em></strong>', 'lightboxplus' ) ?>
									</span>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="resize"><?php _e( 'Resize', 'lightboxplus' ) ?></label>:
							</th>
							<td>
								<input type="hidden" name="resize" value="0">
								<input type="checkbox" name="resize" id="resize" value="1"<?php checked( '1', $lbp_plugin_options['resize'] ); ?> />
								<br/>
									<span class="lbp_bigtip" id="lbp_resize_tip">
										<?php _e( 'If checked and if Maximum Width or Maximum Height have been defined, Lightbox Plus will resize photos to fit within the those values. <strong><em>Default: Checked</em></strong>', 'lightboxplus' ) ?>
									</span>
							</td>
						</tr>
					</table>
				</div>
				<!-- Position -->
				<div id="plbp-tabs-3">
					<table class="form-table">
						<tr>
							<th scope="row">
								<label for="top"><?php _e( 'Top', 'lightboxplus' ) ?></label>:
							</th>
							<td>
								<input name="top" type="text" id="top" size="8" maxlength="8" value="<?php if ( ! empty( $lbp_plugin_options['top'] ) ) {
									echo esc_attr( $lbp_plugin_options['top'] );
								} else {
									echo '';
								} ?>"/>
								<br/>
									<span class="lbp_bigtip" id="lbp_top_tip">
										<?php _e( 'Accepts a pixel or percent value (50, "50px", "10%"). Controls vertical positioning instead of using the default position of being centered in the viewport. <strong><em>Default: null</em></strong>', 'lightboxplus' ) ?>
									</span>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="right"><?php _e( 'Right', 'lightboxplus' ) ?></label>:
							</th>
							<td>
								<input name="right" type="text" id="right" size="8" maxlength="8" value="<?php if ( ! empty( $lbp_plugin_options['right'] ) ) {
									echo esc_attr( $lbp_plugin_options['right'] );
								} else {
									echo '';
								} ?>"/>
								<br/>
									<span class="lbp_bigtip" id="lbp_top_tip">
										<?php _e( 'Accepts a pixel or percent value (50, "50px", "10%"). Controls horizontal positioning instead of using the default position of being centered in the viewport. <strong><em>Default: null</em></strong>', 'lightboxplus' ) ?>
									</span>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="bottom"><?php _e( 'Bottom', 'lightboxplus' ) ?></label>:
							</th>
							<td>
								<input name="bottom" type="text" id="bottom" size="8" maxlength="8" value="<?php if ( ! empty( $lbp_plugin_options['bottom'] ) ) {
									echo esc_attr( $lbp_plugin_options['bottom'] );
								} else {
									echo '';
								} ?>"/>
								<br/>
									<span class="lbp_bigtip" id="lbp_top_tip">
										<?php _e( 'SetAccepts a pixel or percent value (50, "50px", "10%"). Controls vertical positioning instead of using the default position of being centered in the viewport. <strong><em>Default: false</em></strong>', 'lightboxplus' ) ?>
									</span>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="left"><?php _e( 'Left', 'lightboxplus' ) ?></label>:
							</th>
							<td>
								<input name="left" type="text" id="left" size="8" maxlength="8" value="<?php if ( ! empty( $lbp_plugin_options['left'] ) ) {
									echo esc_attr( $lbp_plugin_options['left'] );
								} else {
									echo '';
								} ?>"/>
								<br/>
									<span class="lbp_bigtip" id="lbp_top_tip">
										<?php _e( 'SetAccepts a pixel or percent value (50, "50px", "10%"). Controls horizontal positioning instead of using the default position of being centered in the viewport. <strong><em>Default: false</em></strong>', 'lightboxplus' ) ?>
									</span>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="fixed"><?php _e( 'Fixed', 'lightboxplus' ) ?></label>:
							</th>
							<td>
								<input type="hidden" name="fixed" value="0">
								<input type="checkbox" name="fixed" id="fixed" value="1"<?php checked( '1', $lbp_plugin_options['fixed'] ); ?> />
								<br/>
									<span class="lbp_bigtip" id="lbp_fixed_tip">
										<?php _e( 'If check, the lightbox will always be displayed in a fixed position within the viewport. In otherwords it will stay within the viewport while scolling on the page.  This is unlike the default absolute positioning relative to the document. <strong><em>Default: Unchecked</em></strong>', 'lightboxplus' ) ?>
									</span>
							</td>
						</tr>
					</table>
				</div>
				<!-- Interface -->
				<div id="plbp-tabs-4">
					<table class="form-table">
						<tr>
							<th scope="row" colspan="2"><strong><?php _e( 'General Interface Options', 'lightboxplus' ) ?></strong></th>
						</tr>
						<tr>
							<th scope="row">
								<label for="close"><?php _e( 'Close image text', 'lightboxplus' ) ?></label>:
							</th>
							<td>
								<input type="text" size="15" name="close" id="close" value="<?php if ( empty( $lbp_plugin_options['close'] ) ) {
									echo '';
								} else {
									echo esc_attr( $lbp_plugin_options['close'] );
								} ?>"/>
								<br/>
									<span class="lbp_bigtip" id="lbp_close_tip">
										<?php _e( 'Text for the close button.  If Overlay Close or ESC Key Close are check those options will also close the lightbox. <strong><em>Default: close</em></strong>', 'lightboxplus' ) ?>
									</span>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="overlay_close"><?php _e( 'Overlay Close', 'lightboxplus' ) ?></label>:
							</th>
							<td>
								<input type="hidden" name="overlay_close" value="0">
								<input type="checkbox" name="overlay_close" id="overlay_close" value="1"<?php checked( '1', $lbp_plugin_options['overlay_close'] ); ?> />
								<br/>
									<span class="lbp_bigtip" id="lbp_overlay_close_tip">
										<?php _e( 'If checked, enables closing Lightbox Plus Colorbox by clicking on the background overlay. <strong><em>Default: Checked</em></strong>', 'lightboxplus' ) ?>
									</span>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="esc_key"><?php _e( 'ESC Key Close', 'lightboxplus' ) ?></label>:
							</th>
							<td>
								<input type="hidden" name="esc_key" value="0">
								<input type="checkbox" name="esc_key" id="esc_key" value="1"<?php checked( '1', $lbp_plugin_options['esc_key'] ); ?> />
								<br/>
									<span class="lbp_bigtip" id="lbp_esc_key_tip">
										<?php _e( 'If checked, enables closing Lightbox Plus Colorbox using the ESC key. <strong><em>Default: Checked</em></strong>', 'lightboxplus' ) ?>
									</span>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="scrolling"><?php _e( 'Scroll Bars', 'lightboxplus' ) ?></label>:
							</th>
							<td>
								<input type="hidden" name="scrolling" value="0">
								<input type="checkbox" name="scrolling" id="scrolling" value="1"<?php checked( '1', $lbp_plugin_options['scrolling'] ); ?> />
								<br/>
									<span class="lbp_bigtip" id="lbp_scrolling_tip">
										<?php _e( 'If unchecked, Lightbox Plus Colorbox will hide scrollbars for overflowing content. <strong><em>Default: Checked</em></strong>', 'lightboxplus' ) ?>
									</span>
							</td>
						</tr>
						<tr>
							<th scope="row" colspan="2"><strong><?php _e( 'Image Grouping', 'lightboxplus' ) ?></strong></th>
						</tr>
						<tr>
							<th scope="row">
								<label for="rel"><?php _e( 'Disable grouping', 'lightboxplus' ) ?></label>:
							</th>
							<td>
								<input type="hidden" name="rel" value="0">
								<input type="checkbox" name="rel" id="rel" value="1"<?php checked( '1', $lbp_plugin_options['rel'] ); ?> />
								<br/>
									<span class="lbp_bigtip" id="lbp_nogrouping_tip">
										<?php _e( 'If checked will disable grouping of images and previous/next label. <strong><em>Default: Unchecked</em></strong>', 'lightboxplus' ) ?>
									</span>
							</td>
						</tr>
						<tr class="grouping_prim">
							<th scope="row">
								<label for="label_image"><?php _e( 'Grouping Labels', 'lightboxplus' ) ?></label>:
							</th>
							<td>
								<input type="text" size="15" name="label_image" id="label_image" value="<?php if ( empty( $lbp_plugin_options['label_image'] ) ) {
									echo '';
								} else {
									echo esc_attr( $lbp_plugin_options['label_image'] );
								} ?>"/>
								<label for="label_of">#</label>
								<input type="text" size="15" name="label_of" id="label_of" value="<?php if ( empty( $lbp_plugin_options['label_of'] ) ) {
									echo '';
								} else {
									echo esc_attr( $lbp_plugin_options['label_of'] );
								} ?>"/>
								#
								<br/>
									<span class="lbp_bigtip" id="lbp_label_image_tip">
										<?php _e( 'Text format for the content group / gallery count. {current} and {total} are detected and replaced with actual numbers while Colorbox runs. <strong><em>Default: Image {current} of {total}</em></strong>', 'lightboxplus' ) ?>
									</span>
							</td>
						</tr>
						<tr class="grouping_prim">
							<th scope="row">
								<label for="previous"><?php _e( 'Previous image text', 'lightboxplus' ) ?></label>:
							</th>
							<td>
								<input type="text" size="15" name="previous" id="previous" value="<?php if ( empty( $lbp_plugin_options['previous'] ) ) {
									echo '';
								} else {
									echo esc_attr( $lbp_plugin_options['previous'] );
								} ?>"/>
								<br/>
									<span class="lbp_bigtip" id="lbp_previous_tip">
										<?php _e( 'Text for the previous button in a shared relation group (same values for "rel" attribute). <strong><em>Default: previous</em></strong>', 'lightboxplus' ) ?>
									</span>
							</td>
						</tr>
						<tr class="grouping_prim">
							<th scope="row">
								<label for="next"><?php _e( 'Next image text', 'lightboxplus' ) ?></label>:
							</th>
							<td>
								<input type="text" size="15" name="next" id="next" value="<?php if ( empty( $lbp_plugin_options['next'] ) ) {
									echo '';
								} else {
									echo esc_attr( $lbp_plugin_options['next'] );
								} ?>"/>
								<br/>
									<span class="lbp_bigtip" id="lbp_next_tip">
										<?php _e( 'Text for the next button in a shared relation group (same values for "rel" attribute).  <strong><em>Default: next</em></strong>', 'lightboxplus' ) ?>
									</span>
							</td>
						</tr>
						<tr class="grouping_prim">
							<th scope="row">
								<label for="arrow_key"><?php _e( 'Arrow key navigation', 'lightboxplus' ) ?></label>:
							</th>
							<td>
								<input type="hidden" name="arrow_key" value="0">
								<input type="checkbox" name="arrow_key" id="arrow_key" value="1"<?php checked( '1', $lbp_plugin_options['arrow_key'] ); ?> />
								<br/>
									<span class="lbp_bigtip" id="lbp_arrow_key_tip">
										<?php _e( 'If checked, enables the left and right arrow keys for navigating between the items in a group. <strong><em>Default: Checked</em></strong>', 'lightboxplus' ) ?>
									</span>
							</td>
						</tr>
						<tr class="grouping_prim">
							<th scope="row">
								<label for="loop"><?php _e( 'Loop image group', 'lightboxplus' ) ?></label>:
							</th>
							<td>
								<input type="hidden" name="loop" value="0">
								<input type="checkbox" name="loop" id="loop" value="1"<?php checked( '1', $lbp_plugin_options['loop'] ); ?> />
								<br/>
									<span class="lbp_bigtip" id="lbp_loop_tip">
										<?php _e( 'If checked, enables the ability to loop back to the beginning of the group when on the last element. <strong><em>Default: Checked</em></strong>', 'lightboxplus' ) ?>
									</span>
							</td>
						</tr>
					</table>
				</div>
				<!-- Slideshow -->
				<div id="plbp-tabs-5">
					<table class="form-table">
						<tr>
							<th scope="row">
								<label for="slideshow"><?php _e( 'Slideshow', 'lightboxplus' ) ?></label>:
							</th>
							<td>
								<input type="hidden" name="slideshow" value="0">
								<input type="checkbox" name="slideshow" id="slideshow" value="1"<?php checked( '1', $lbp_plugin_options['slideshow'] ); ?> />
								<br/>
									<span class="lbp_bigtip" id="lbp_slideshow_tip">
										<?php _e( 'If checked, adds slideshow capablity to a content group / gallery. <strong><em>Default: Unchecked</em></strong>', 'lightboxplus' ) ?>
									</span>
							</td>
						</tr>
						<tr class="slideshow_prim">
							<th scope="row">
								<label for="slideshow_auto"><?php _e( 'Auto-Start Slideshow', 'lightboxplus' ) ?></label>:
							</th>
							<td>
								<input type="hidden" name="slideshow_auto" value="0">
								<input type="checkbox" name="slideshow_auto" id="slideshow_auto" value="1"<?php checked( '1', $lbp_plugin_options['slideshow_auto'] ); ?> />
								<br/>
									<span class="lbp_bigtip" id="lbp_slideshow_auto_tip">
										<?php _e( 'If checked, the slideshows will automatically start to play when content group opened. <strong><em>Default: Checked</em></strong>', 'lightboxplus' ) ?>
									</span>
							</td>
						</tr>
						<tr class="slideshow_prim">
							<th scope="row">
								<label for="slideshow_speed"><?php _e( 'Slideshow Speed', 'lightboxplus' ) ?></label>:
							</th>
							<td>
								<select name="slideshow_speed" id="slideshow_speed">
									<?php
									for ( $i = 500; $i <= 20001; ) {
										?>
										<option value="<?php echo esc_attr( $i ); ?>"<?php selected( $lbp_plugin_options['slideshow_speed'], strval( $i ) ); ?>><?php echo $i; ?></option>
										<?php
										if ( $i >= 15000 ) {
											$i = $i + 5000;
										} elseif ( $i >= 10000 ) {
											$i = $i + 1000;
										} else {
											$i = $i + 500;
										}
									}
									?>
								</select>
								<br/>
									<span class="lbp_bigtip" id="lbp_slideshow_speed_tip">
										<?php _e( 'Controls the speed of the slideshow, in milliseconds. <strong><em>Default: 2500</em></strong>', 'lightboxplus' ) ?>
									</span>
							</td>
						</tr>
						<tr class="slideshow_prim">
							<th scope="row">
								<label for="slideshow_start"><?php _e( 'Slideshow start text', 'lightboxplus' ) ?></label>:
							</th>
							<td>
								<input type="text" size="15" name="slideshow_start" id="slideshow_start" value="<?php if ( ! empty( $lbp_plugin_options['slideshow_start'] ) ) {
									echo esc_attr( $lbp_plugin_options['slideshow_start'] );
								} else {
									echo 'start';
								} ?>"/>
								<br/>
									<span class="lbp_bigtip" id="lbp_slideshow_start_tip">
										<?php _e( 'Text for the slideshow start button. <strong><em>Default: start</em></strong>', 'lightboxplus' ) ?>
									</span>
							</td>
						</tr>
						<tr class="slideshow_prim">
							<th scope="row">
								<label for="slideshow_stop"><?php _e( 'Slideshow stop text', 'lightboxplus' ) ?></label>:
							</th>
							<td>
								<input type="text" size="15" name="slideshow_stop" id="slideshow_stop" value="<?php if ( ! empty( $lbp_plugin_options['slideshow_stop'] ) ) {
									echo esc_attr( $lbp_plugin_options['slideshow_stop'] );
								} else {
									echo 'stop';
								} ?>"/>
								<br/>
									<span class="lbp_bigtip" id="lbp_slideshow_stop_tip">
										<?php _e( 'Text for the slideshow stop button.  <strong><em>Default: stop</em></strong>', 'lightboxplus' ) ?>
									</span>
							</td>
						</tr>
					</table>
				</div>
				<!-- Other -->
				<div id="plbp-tabs-6">
					<table class="form-table">
						<tr>
							<th scope="row">
								<label for="photo"><?php _e( 'File as photo', 'lightboxplus' ) ?></label>:
							</th>
							<td>
								<input type="hidden" name="photo" value="0">
								<input type="checkbox" name="photo" id="photo" value="1"<?php checked( '1', $lbp_plugin_options['photo'] ); ?> />
								<br/>
									<span class="lbp_bigtip" id="lbp_photo_tip">
										<?php _e( 'If checked, this setting forces Lightbox Plus Colorbox to display a link as a photo. Use this when automatic photo detection fails (such as using a url like "photo.php" instead of "photo.jpg"). <strong><em>Default: Unchecked</em></strong>', 'lightboxplus' ) ?>
									</span>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="use_caption_title"><?php _e( 'Use WP Caption for LBP Caption', 'lightboxplus' ) ?></label>:
							</th>
							<td>
								<input type="hidden" name="use_caption_title" value="0">
								<input type="checkbox" name="use_caption_title" id="use_caption_title" value="1"<?php checked( '1', $lbp_plugin_options['use_caption_title'] ); ?> />
								<br/>
									<span class="lbp_bigtip" id="lbp_use_caption_title_tip">
										<?php _e( 'If checked, Lightbox Plus Colorbox will attempt to use the displayed caption for the image on the page as the caption for the image in the Lightbox Plus Colorbox overlay. <strong><em>Default: Unchecked</em></strong>', 'lightboxplus' ) ?>
									</span>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="use_class_method"><?php _e( 'Use Class Method', 'lightboxplus' ) ?></label>:
							</th>
							<td>
								<input type="hidden" name="use_class_method" value="0">
								<input type="checkbox" name="use_class_method" id="use_class_method" value="1"<?php checked( '1', $lbp_plugin_options['use_class_method'] ); ?> />
								<br/>
									<span class="lbp_bigtip" id="lbp_use_class_method_tip">
										<?php _e( 'If checked, Lightbox Plus Colorbox will only lightbox images using a class instead of the <code>rel=lightbox[]</code> or <code>data-attr</code> attributes.  Using this method you can manually control which images are affected by Lightbox Plus Colorbox by adding the class to the Advanced Link Settings in the WordPress Edit Image tool or by adding it to the image link URL and checking the <strong>Do Not Auto-Lightbox Images</strong> option. You can also specify the name of the class instead of using the default. <strong><em>Default: Unchecked / Default cboxModal</em></strong>', 'lightboxplus' ) ?>
									</span>
							</td>
						</tr>
						<tr class="primary_class_name lbp-closed">
							<th scope="row">
								<label for="class_name"><?php _e( 'Class name', 'lightboxplus' ) ?></label>:
							</th>
							<td>
								<input type="text" size="15" name="class_name" id="class_name" value="<?php if ( empty( $lbp_plugin_options['class_name'] ) ) {
									echo 'lbp_primary';
								} else {
									echo esc_attr( $lbp_plugin_options['class_name'] );
								} ?>"/>
								<br/>
									<span class="lbp_bigtip" id="lbp_use_class_name_tip">
										<?php _e( 'You can also specify the name of the class instead of using the default. <strong><em>Default lbp_primary</em></strong>', 'lightboxplus' ) ?>
									</span>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="text_links"><?php _e( 'Auto-Lightbox Text Links', 'lightboxplus' ) ?></label>:
							</th>
							<td>
								<input type="hidden" name="text_links" value="0">
								<input type="checkbox" name="text_links" id="text_links" value="1"<?php checked( '1', $lbp_plugin_options['text_links'] ); ?> />
								<br/>
									<span class="lbp_bigtip" id="lbp_text_links_tip">
										<?php _e( 'If checked, Lightbox Plus Colorbox will lightbox images that are linked to images via text as well as those link by images.  Use with care as there is a small possibility that you will get double or triple images in the lightbox display if you have invalidly nested html. <strong><em>Default: Unchecked</em></strong>', 'lightboxplus' ) ?>
									</span>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="no_auto_lightbox"><?php _e( '<strong>Do Not</strong> Auto-Lightbox Images', 'lightboxplus' ) ?></label>:
							</th>
							<td>
								<input type="hidden" name="no_auto_lightbox" value="0">
								<input type="checkbox" name="no_auto_lightbox" id="no_auto_lightbox" value="1"<?php checked( '1', $lbp_plugin_options['no_auto_lightbox'] ); ?> />
								<br/>
									<span class="lbp_bigtip" id="lbp_no_auto_lightbox_tip">
										<?php _e( 'If checked, Lightbox Plus Colorbox <em>will not</em> automatically add appropriate attibutes (either <code>rel="lightbox[postID]"</code> or <code>class: cboxModal</code>) to Image URL.  You will need to manually add the appropriate attribute for Lightbox Plus Colorbox to work. <strong><em>Default: Unchecked</em></strong>', 'lightboxplus' ) ?>
									</span>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="no_display_title"><?php _e( '<strong>Do Not</strong> Display Image Title', 'lightboxplus' ) ?></label>:
							</th>
							<td>
								<input type="hidden" name="no_display_title" value="0">
								<input type="checkbox" name="no_display_title" id="no_display_title" value="1"<?php checked( '1', $lbp_plugin_options['no_display_title'] ); ?> />
								<br/>
									<span class="lbp_bigtip" id="lbp_no_display_title_tip">
										<?php _e( 'If checked, Lightbox Plus Colorbox <em>will not</em> display image titles automatically.  This has no effect if the <strong>Do Not Auto-Lightbox Images</strong> option is checked. <strong><em>Default: Unchecked</em></strong>', 'lightboxplus' ) ?>
									</span>
							</td>
						</tr>
					</table>
				</div>
				<!-- Usage -->
				<div id="plbp-tabs-7">
					<table class="form-table">
						<tr>
							<td>
								<h4><?php _e( 'Basic Usage of Lightbox Plus Colorbox' ); ?></h4>
								<p><?php _e( 'All of the settings described here also apply to the secondary lightbox', 'lightboxplus' ) ?></p>
								<h5 class="subhelp"><?php _e( 'General Tab', 'lightboxplus' ) ?></h5>
								<p><?php _e( 'Lets you specify basic functions of how Lightbox Plus Colorbox works.', 'lightboxplus' ) ?></p>
								<h5 class="subhelp"><?php _e( 'Size Tab', 'lightboxplus' ) ?></h5>
								<p><?php _e( 'Allows you to set all the different size options and whether to automatically resize images.', 'lightboxplus' ) ?></p>
								<h5 class="subhelp"><?php _e( 'Position Tab', 'lightboxplus' ) ?></h5>
								<p><?php _e( 'Lets you set the specific position of where the lightbox appears in the browser viewport and whether to keep it in the viewport while scrolling', 'lightboxplus' ) ?></p>
								<h5 class="subhelp"><?php _e( 'Interface Tab', 'lightboxplus' ) ?></h5>
								<p><?php _e( 'Set the options for how the user interacts with the lightbox and whether to group images or not.', 'lightboxplus' ) ?></p>
								<h5 class="subhelp"><?php _e( 'Slideshow Tab', 'lightboxplus' ) ?></h5>
								<p><?php _e( 'Lightbox Plus Colorbox supports simple slideshows, here you can the the timings and if it should startr automatically.', 'lightboxplus' ) ?></p>
								<h5 class="subhelp"><?php _e( 'Other Tab', 'lightboxplus' ) ?></h5>
								<p><?php _e( 'All additional options for lightboxes such as using for galleries, alternate methods for triggering, etc.', 'lightboxplus' ) ?></p>
								<h5 class="subhelp"><?php _e( 'Usage Tab', 'lightboxplus' ) ?></h5>
								<p><?php _e( 'This tab, general help.', 'lightboxplus' ) ?></p>
								<h5 class="subhelp"><?php _e( 'Demo/Test Tab', 'lightboxplus' ) ?></h5>
								<p><?php _e( 'Tests of your current settings for Lightbox Plus Colorbox.', 'lightboxplus' ) ?></p>
						</tr>
					</table>
				</div>
				<!-- Demo/Test -->
				<div id="plbp-tabs-8">
					<table class="form-table">
						<tr valign="top">
							<td>
								<?php _e( 'Here you can test your settings for Lightbox Plus Colorbox using image and text links.  If they do not work please check your settings and ensure that you have transition type and resize speed set ', "lightboxplus" ); ?>
							</td>
						</tr>
						<tr>
							<td>
								<div class="ui-state-highlight ui-corner-all lbp_demo" style="padding-top: 20px; padding: 0 .7em;">
									<h4><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span><?php esc_html_e( 'Simple image test', 'lightboxplus' ); ?></h4>
									<p><?php esc_html_e( 'This is the most basic feature of Lightbox Plus Colorbox in which it automatically add the lightbox to linked image.', 'lightboxplus' ); ?></p>
									<?php if ( $lbp_plugin_options['output_htmlv'] ) { ?>
										<p class="primary_test_item"><a href="<?php echo $lbp_global_plugin_url ?>screenshot-1.jpg" <?php if ( $lbp_plugin_options['use_class_method'] ) {
												echo 'class="' . $lbp_plugin_options['class_name'] . '"';
											} else {
												echo 'data-' . $lbp_plugin_options['data_name'] . '="lightbox[test demo]"';
											} ?> title="Screenshot 1"><img title="Screenshot 1" src="<?php echo $lbp_global_plugin_url ?>screenshot-1.jpg" alt="Screenshot 1" width="120" height="90"/></a></p>
									<?php } else { ?>
										<p class="primary_test_item"><a href="<?php echo $lbp_global_plugin_url ?>screenshot-1.jpg" <?php if ( $lbp_plugin_options['use_class_method'] ) {
												echo 'class="' . $lbp_plugin_options['class_name'] . '"';
											} else {
												echo 'rel="lightbox[test demo]"';
											} ?> title="Screenshot 1"><img title="Screenshot 1" src="<?php echo $lbp_global_plugin_url ?>screenshot-1.jpg" alt="Screenshot 1" width="120" height="90"/></a></p>
									<?php } ?>

									<h4><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span><?php esc_html_e( 'Simple text link to image test', 'lightboxplus' ); ?></h4>
									<p><?php esc_html_e( 'This is a basic feature of Lightbox Plus Colorbox in which it automatically add the lightbox to text links to images assuming the option is selected.', 'lightboxplus' ); ?></p>
									<?php if ( $lbp_plugin_options['output_htmlv'] ) { ?>
										<p class="primary_test_item"><a href="<?php echo $lbp_global_plugin_url ?>screenshot-2.jpg" <?php if ( $lbp_plugin_options['use_class_method'] ) {
												echo 'class="' . $lbp_plugin_options['class_name'] . '"';
											} else {
												echo 'data-' . $lbp_plugin_options['data_name'] . '="lightbox[test demo]"';
											} ?> title="Screenshot 2">Screenshot 2 Text Link</a></p>
									<?php } else { ?>
										<p class="primary_test_item"><a href="<?php echo $lbp_global_plugin_url ?>screenshot-2.jpg" <?php if ( $lbp_plugin_options['use_class_method'] ) {
												echo 'class="' . $lbp_plugin_options['class_name'] . '"';
											} else {
												echo 'rel="lightbox[test demo]"';
											} ?> title="Screenshot 2">Screenshot 2 Text Link</a></p>
									<?php } ?>
								</div>
							</td>
						</tr>
					</table>
				</div>
			</div>
			<?php submit_button( 'Save all settings', 'primary', 'reset', true, array( 'id' => 'save-all-lbp-2' ) ) ?>
		</div>
	</div>
</div>