<?php
	//add_action('admin_menu', 'create_shortcode_submenu');
function create_shortcode_submenu() {
	add_submenu_page(
		'edit.php?post_type=km_testimonial',__( 'Generate Shortcode', 'km_testimonial' ),__( 'Generate Shortcode', 'km_testimonial' ),'manage_options','books-shortcode-ref','show_settings');
}

add_action( 'add_meta_boxes', 'wpt_add_testimonial_metabox' );
function wpt_add_testimonial_metabox(){
	add_meta_box( 'setting_testimonial_metaboxes','Generate Shortcode','setting_testimonial_metaboxes','kmeasy_shortcode','normal','default' );

	add_meta_box( 'setting_testimonial_color_metabox','Color Management','setting_testimonial_color_metabox','kmeasy_shortcode','normal','default' );

	add_meta_box( 'setting_testimonial_metabox','Shortcode','setting_testimonial_metabox','kmeasy_shortcode','side','default' );
}

$view = "";
function setting_testimonial_metaboxes($post){
	global $post;
	$shortcode_fields = get_post_meta( $post->ID );
	$cate = $shortcode_fields['select_category'][0];
	$selecat = unserialize($cate);
	$readmore_btn_text = (isset($shortcode_fields["readmore_btn_text"][0])) ? $shortcode_fields["readmore_btn_text"][0] : '';
	$container_custom_class = (isset($shortcode_fields["container_custom_class"][0])) ? $shortcode_fields["container_custom_class"][0] : ''; ?>

	<!-- Container Class -->
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<div class="col-md-6">
					<label for="container_custom_class" class="control-label">Container Class Name</label>
					<span class="help-block"><i>(A block of help text that breaks onto a new line and may extend beyond one line.)</i></span>
				</div>
				<div class="col-md-6 setting_element">
					<input type="text" class="form-control" value="<?php echo $container_custom_class; ?>" name="container_custom_class" id="container_custom_class" placeholder="Class Name" aria-describedby="sizing-addon2">
				</div>
			</div>
		</div>
	</div>
	
	<!-- Select View -->
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<div class="col-md-6">
					<label for="view" class="control-label">View</label>
					<span class="help-block"><i>(A block of help text that breaks onto a new line and may extend beyond one line.)</i></span>
				</div>
				<div class="col-md-6 setting_element">
					<?php $view = $shortcode_fields['view'][0];
					if(empty($view)){
						$view = 'view_grid';
					}
					if($view == 'view_grid') {
						$grid_active = 'active';
					}
					if($view == 'view_listing') {
						$listing_active = 'active';
					}
					if($view == 'view_carousel') {
						$carousel_active = 'active';
					} ?>
					<div class="btn-group" data-toggle="buttons">
						<label class="btn btn-success <?php echo $grid_active; ?>">
							<input type="radio" name="view" id="view_grid" value="view_grid" autocomplete="off" <?php echo ($shortcode_fields['view'][0] == 'view_grid')? 	'checked="checked"' : '' ; ?>> Grid
						</label>
						<label class="btn btn-success <?php echo $listing_active; ?>">
							<input type="radio" name="view" id="view_listing" value="view_listing" autocomplete="off" <?php echo ($shortcode_fields['view'][0] == 'view_listing')? 'checked="checked"':''; ?>> Listing
						</label>
						<label class="btn btn-success <?php echo $carousel_active; ?>">
							<input type="radio" name="view" id="view_carousel" value="view_carousel" autocomplete="off" <?php echo ($shortcode_fields['view'][0] == 'view_carousel')? 'checked="checked"':''; ?>> Carousel
						</label>
					</div>
				</div>
			</div>
		</div>
	</div>	

	<!-- Select Category-->
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<div class="col-md-6">
					<label for="category_sel" class="control-label">Category</label>
					<span class="help-block"><i>(A block of help Select Category.)</i></span>
				</div>
				<div class="col-md-6">
					<div class="input-group">
						<?php $categories = get_terms( 
							'testimonial_category', array(
								'orderby'    => 'count',
								'hide_empty' => 0,
							) 
						); ?>
						<select class="limitedNumbSelect2" name="category_sel[] ?>" multiple="true" style="width:400px;">
							<?php foreach($categories as $cat) {
								$slug = $cat->slug;
								$name = $cat->name;?>
								<option value="<?php echo $slug; ?>" <?php if(is_array($selecat)) {selected( in_array( $cat->slug, $selecat ) ); }?>><?php echo $name ?></option>
							<?php } ?>
						</select>					  
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- title info -->
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<div class="col-md-6">
					<label for="title_show_hide" class="control-label">Title</label>
					<span class="help-block"><i>(A block of help text that breaks onto a new line and may extend beyond one line.)</i></span>
				</div>
				<div class="col-md-6 setting_element">
					<input id="title_show_hide" name="title_show_hide" data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-onstyle="success" data-offstyle="danger" type="checkbox" value="false" <?php if ( isset ( $shortcode_fields['title_show_hide'] ) ) checked( $shortcode_fields['title_show_hide'][0], 'true' ); ?> >
				</div>
			</div>
		</div>
	</div>
	
	<!-- Title Position -->
	<div class="title_detail">
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<div class="col-md-6">
						<label for="title_position" class="control-label">Title Position</label>
						<span class="help-block"><i>(A block of help text that breaks onto a new line and may extend beyond one line.)</i></span>
					</div>
					<div class="col-md-6 setting_element">
						
						<?php $title_position = $shortcode_fields['title_position'][0];
						if(empty($title_position)){
							$title_position = 'before_description';
						}
						if($title_position == 'before_description') {
							$before_description_active = 'active';
						}
						if($title_position == 'after_description') {
							$after_description_active = 'active';
						} ?>
						
						<div class="btn-group" data-toggle="buttons">
							<label class="btn btn-success <?php echo $before_description_active; ?>">
								<input type="radio" name="title_position" id="before_description" value="before_description" autocomplete="off" <?php echo ($shortcode_fields['title_position'][0] == 'before_description')? 'checked="checked"' : '' ; ?>> Before Description
							</label>
							<label class="btn btn-success <?php echo $after_description_active; ?>">
								<input type="radio" name="title_position" id="after_description" value="after_description" autocomplete="off" <?php echo ($shortcode_fields['title_position'][0] == 'after_description')? 	'checked="checked"':''; ?>> After Description
							</label>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Apply Link on title -->
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<div class="col-md-6">
						<label for="apply_link_on_title" class="control-label">Link on Title</label>
						<span class="help-block"><i>(A block of help text that breaks onto a new line and may extend beyond one line.)</i></span>
					</div>
					<div class="col-md-6 setting_element">
						<input id="apply_link_on_title" name="apply_link_on_title" data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-onstyle="success" data-offstyle="danger" type="checkbox" value="false" <?php if ( isset ( $shortcode_fields['apply_link_on_title'] ) ) checked( $shortcode_fields['apply_link_on_title'][0], 'true' ); ?> >
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Description info -->
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<div class="col-md-6">
					<label for="description_show_hide" class="control-label">Description</label>
					<span class="help-block"><i>(A block of help text that breaks onto a new line and may extend beyond one line.)</i></span>
				</div>
				<div class="col-md-6 setting_element">
					<input id="description_show_hide" name="description_show_hide" data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-onstyle="success" class="description_show_hide" data-offstyle="danger" type="checkbox" value="false" <?php if ( isset ( $shortcode_fields['description_show_hide'] ) ) checked( $shortcode_fields['description_show_hide'][0], 'true' ); ?> >
				</div>
			</div>
		</div>
	</div>

	<!-- Description Length -->
	<div class="description_detail">			
		<!-- Description Length-->
		<div class="row decript_len">
			<div class="col-md-12">
				<div class="form-group">
					<div class="col-md-6">
						<label for="description_length" class="control-label">Description Length</label>
						<span class="help-block"><i>(A block of help text that breaks onto a new line and may extend beyond one line.)</i></span>
					</div>
					<div class="col-md-6 setting_element">
						<?php $desc_count = (isset($shortcode_fields["description_count"][0])) ? $shortcode_fields["description_count"][0] : '150'; ?>
						<span class="desc_count"><?php echo $desc_count; ?></span>
						<input type="range" name="description_count" min="-1" max="250" value="<?php echo $desc_count; ?>" class="rangeslider" id="description_count">
					</div>
				</div>
			</div>
		</div>	

		<!-- Read More -->
		<div class="row readmore">
			<div class="col-md-12">
				<div class="form-group">
					<div class="col-md-6">
						<label for="readmore_show_hide" class="control-label">Read More Button</label>
						<span class="help-block"><i>(A block of help text that breaks onto a new line and may extend beyond one line.)</i></span>
					</div>
					<div class="col-md-6 setting_element">
						<input id="readmore_show_hide" name="readmore_show_hide" data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-onstyle="success" class="readmore_show_hide" data-offstyle="danger" type="checkbox" value="false" <?php if ( isset ( $shortcode_fields['readmore_show_hide'] ) ) checked( $shortcode_fields['readmore_show_hide'][0], 'true' ); ?> >
					</div>
				</div>
			</div>
		</div>	
	</div>

	<!-- Read More Button Text -->
	<div class="readmore_detail">
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<div class="col-md-6">
						<label for="readmore_btn_text" class="control-label">Read More Button Text</label>
						<span class="help-block"><i>(A block of help text that breaks onto a new line and may extend beyond one line.)</i></span>
					</div>
					<div class="col-md-6 setting_element">
						<input type="text" class="form-control" value="<?php echo $readmore_btn_text; ?>" name="readmore_btn_text" id="readmore_btn_text" placeholder="Read More" aria-describedby="sizing-addon2">
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Featured Image -->
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<div class="col-md-6">
					<label for="featuredimage_show_hide" class="control-label">Featured Image</label>
					<span class="help-block"><i>(A block of help text that breaks onto a new line and may extend beyond one line.)</i></span>
				</div>
				<div class="col-md-6 setting_element">
					<input id="featuredimage_show_hide" name="featuredimage_show_hide" data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-onstyle="success" class="featuredimage_show_hide" data-offstyle="danger" type="checkbox" value="false" <?php if ( isset ( $shortcode_fields['featuredimage_show_hide'] ) ) checked( $shortcode_fields['featuredimage_show_hide'][0], 'true' ); ?> >
				</div>
			</div>
		</div>
	</div>

	<!-- Apply Link on Featuered Image -->
	<div class="featueredimg_detail">
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<div class="col-md-6">
						<label for="apply_link_on_featuered_image" class="control-label">Link on Featured Image</label>
						<span class="help-block"><i>(A block of help text that breaks onto a new line and may extend beyond one line.)</i></span>
					</div>
					<div class="col-md-6 setting_element">
						<input id="apply_link_on_featuered_image" name="apply_link_on_featuered_image" data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-onstyle="success" data-offstyle="danger" type="checkbox" value="false" <?php if ( isset ( $shortcode_fields['apply_link_on_featuered_image'] ) ) checked( $shortcode_fields['apply_link_on_featuered_image'][0], 'true' ); ?> >
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Designation -->
	<!-- <div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<div class="col-md-6">
					<label for="designation_show_hide" class="control-label">Designation</label>
					<span class="help-block"><i>(A block of help text that breaks onto a new line and may extend beyond one line.)</i></span>
				</div>
				<div class="col-md-6 setting_element">
					<input id="designation_show_hide" name="designation_show_hide" data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-onstyle="success" class="designation_show_hide" data-offstyle="danger" type="checkbox" value="false" <?php if ( isset ( $shortcode_fields['designation_show_hide'] ) ) checked( $shortcode_fields['designation_show_hide'][0], 'true' ); ?> >
				</div>
			</div>
		</div>
	</div>	 -->


	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<div class="col-md-6">
					<label for="km_country_show_hide" class="control-label">Country</label>
					<span class="help-block"><i>(A block of help text that breaks onto a new line and may extend beyond one line.)</i></span>
				</div>
				<div class="col-md-6 setting_element">
					<input id="km_country_show_hide" name="km_country_show_hide" data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-onstyle="success" class="designation_show_hide" data-offstyle="danger" type="checkbox" value="false" <?php if ( isset ( $shortcode_fields['km_country_show_hide'] ) ) checked( $shortcode_fields['km_country_show_hide'][0], 'true' ); ?> >
				</div>
			</div>
		</div>
	</div>


	<!-- Company Name -->
	<!-- <div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<div class="col-md-6">
					<label for="companyname_show_hide" class="control-label">Company Name</label>
					<span class="help-block"><i>(A block of help text that breaks onto a new line and may extend beyond one line.)</i></span>
				</div>
				<div class="col-md-6 setting_element">
					<input id="companyname_show_hide" name="companyname_show_hide" data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-onstyle="success" class="companyname_show_hide" data-offstyle="danger" type="checkbox" value="false" <?php if ( isset ( $shortcode_fields['companyname_show_hide'] ) ) checked( $shortcode_fields['companyname_show_hide'][0], 'true' ); ?> >
				</div>
			</div>
		</div>
	</div>	 -->


	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<div class="col-md-6">
					<label for="companyname_show_hide" class="control-label">City</label>
					<span class="help-block"><i>(A block of help text that breaks onto a new line and may extend beyond one line.)</i></span>
				</div>
				<div class="col-md-6 setting_element">
					<input id="km_city_show_hide" name="km_city_show_hide" data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-onstyle="success" class="companyname_show_hide" data-offstyle="danger" type="checkbox" value="false" <?php if ( isset ( $shortcode_fields['km_city_show_hide'] ) ) checked( $shortcode_fields['km_city_show_hide'][0], 'true' ); ?> >
				</div>
			</div>
		</div>
	</div>		

	<!-- Display Rating -->
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<div class="col-md-6">
					<label for="rating_show_hide" class="control-label">Display Rating</label>
					<span class="help-block"><i>(A block of help text that breaks onto a new line and may extend beyond one line.)</i></span>
				</div>
				<div class="col-md-6 setting_element">
					<input id="rating_show_hide" name="rating_show_hide" data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-onstyle="success" class="rating_show_hide" data-offstyle="danger" type="checkbox" value="false" <?php if ( isset ( $shortcode_fields['rating_show_hide'] ) ) checked( $shortcode_fields['rating_show_hide'][0], 'true' ); ?> >
				</div>
			</div>
		</div>
	</div>

	<!-- perrow items -->
	<div class="row per_row_item">
		<div class="col-md-12">
			<div class="form-group">
				<div class="col-md-6">
					<label for="per_row_item" class="control-label">Per Row Items</label>
					<span class="help-block"><i>(A block of help text that breaks onto a new line and may extend beyond one line.)</i></span>
				</div>
				<div class="col-md-6 setting_element">
					<?php $per_row_item = (isset($shortcode_fields["per_row_item"][0])) ? $shortcode_fields["per_row_item"][0] : '3'; ?>
					<span class="per_row_item_count"><?php echo $per_row_item; ?></span>
					<input type="range" name="per_row_item" min="2" max="6" value="<?php echo $per_row_item; ?>" class="rangeslider" id="per_row_item">
				</div>
			</div>
		</div>
	</div>

	<!-- per page item -->
	<div class="row per_page_item_outer">
		<div class="col-md-12">
			<div class="form-group">
				<div class="col-md-6">
					<label for="per_page_item" class="control-label">Per Page Items</label>
					<span class="help-block"><i>(A block of help text that breaks onto a new line and may extend beyond one line.)</i></span>
				</div>
				<div class="col-md-6 setting_element">
					<?php $per_page_item = (isset($shortcode_fields["per_page_item"][0])) ? $shortcode_fields["per_page_item"][0] : '10'; ?>
					<span class="per_page_item_count"><?php echo $per_page_item; ?></span>
					<input type="range" name="per_page_item" min="-1" max="100" value="<?php echo $per_page_item; ?>" class="rangeslider" id="per_page_item">
				</div>
			</div>
		</div>
	</div>
	
	<!-- show pagination -->
	<div class="row show_pagination">
		<div class="col-md-12">
			<div class="form-group">
				<div class="col-md-6">
					<label for="show_pagination" class="control-label">Show Pagination</label>
					<span class="help-block"><i>(A block of help text that breaks onto a new line and may extend beyond one line.)</i></span>
				</div>
				<div class="col-md-6 setting_element">
					<input id="pagination_show_hide" name="pagination_show_hide" data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-onstyle="success" class="pagination_show_hide" data-offstyle="danger" type="checkbox" value="false" <?php if ( isset ( $shortcode_fields['pagination_show_hide'] ) ) checked( $shortcode_fields['pagination_show_hide'][0], 'true' ); ?> >
				</div>
			</div>
		</div>
	</div>

	<!-- Carousel Setting -->
	<div class="carousel_setting">
		<fieldset class="form-group">
			<div class="row">
				<div class="form-group">
					<div class="col-md-12">
						<legend>
							<span>Carousel Settings</span>
						</legend>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group">
					<div class="col-md-4">
						<div class="col-md-12" style="height:85px;">
						</div>
						<label for="carousel_speed" class="control-label">Carousel Speed</label>
						<span class="help-block"><i>(A block of help text that breaks onto a new line and may extend beyond one line.)</i></span>
					</div>	
					<div class="col-md-2">
						
						<div class="col-md-12" style="height:85px;">
							<b>Desktop Setting</b>
						</div>
						<?php $carousel_speed = (isset($shortcode_fields["carousel_speed"][0])) ? $shortcode_fields["carousel_speed"][0] : '2000'; ?>
						<span class="carousel_speed_count"><?php echo $carousel_speed; ?></span>
						<input type="range" name="carousel_speed" min="100" max="10000" step="100" value="<?php echo $carousel_speed; ?>" class="rangeslider" id="carousel_speed">
					</div>
					<div class="col-md-2">
						
						<div class="col-md-12" style="height:85px;">
							<b>BreakPoint 1024</b>
						</div>	
						
						<?php $carousel_speed_1024 = (isset($shortcode_fields["carousel_speed_1024"][0])) ? $shortcode_fields["carousel_speed_1024"][0] : '2000'; ?>
						<span class="carousel_speed_1024_count"><?php echo $carousel_speed_1024; ?></span>
						<input type="range" name="carousel_speed_1024" min="100" max="10000" step="100" value="<?php echo $carousel_speed_1024; ?>" class="rangeslider" id="carousel_speed_1024">
					</div>					
					<div class="col-md-2">
						<div class="col-md-12" style="height:85px;">
							<b>BreakPoint 767</b>
						</div>	
						<?php $carousel_speed_767 = (isset($shortcode_fields["carousel_speed_767"][0])) ? $shortcode_fields["carousel_speed_767"][0] : '2000'; ?>

						<span class="carousel_speed_767_count"><?php echo $carousel_speed_767; ?></span>
						<input type="range" name="carousel_speed_767" min="100" max="10000" step="100" value="<?php echo $carousel_speed_767; ?>" class="rangeslider" id="carousel_speed_767">
					</div>
					<div class="col-md-2">
						<div class="col-md-12" style="height:85px;"><b>BreakPoint 480</b>
						</div>	
						<?php $carousel_speed_480 = (isset($shortcode_fields["carousel_speed_480"][0])) ? $shortcode_fields["carousel_speed_480"][0] : '2000'; ?>

						<span class="carousel_speed_480_count"><?php echo $carousel_speed_480; ?></span>
						<input type="range" name="carousel_speed_480" min="100" max="10000" step="100" value="<?php echo $carousel_speed_480; ?>" class="rangeslider" id="carousel_speed_480">
					</div>
				</div>
			</div>

			<div class="row">
				<div class="form-group">
					<div class="col-md-4">
						<label for="slide_item" class="control-label">Slide to Show</label>
						<span class="help-block"><i>(A block of help text that breaks onto a new line and may extend beyond one line.)</i></span>
					</div>	
					<div class="col-md-2">
						<?php $slide_item = (isset($shortcode_fields["slide_item"][0])) ? $shortcode_fields["slide_item"][0] : '4'; ?>
						<input type="number" name="slide_item" min="1" max="6" value="<?php echo $slide_item; ?>" class="form-control" id="slide_item">
					</div>
					<div class="col-md-2">
						<?php $slide_item_1024 = (isset($shortcode_fields["slide_item_1024"][0])) ? $shortcode_fields["slide_item_1024"][0] : '4'; ?>
						<input type="number" name="slide_item_1024" min="1" max="6" value="<?php echo $slide_item_1024; ?>" class="form-control" id="slide_item_1024">
					</div>					
					<div class="col-md-2">
						<?php $slide_item_767 = (isset($shortcode_fields["slide_item_767"][0])) ? $shortcode_fields["slide_item_767"][0] : '4'; ?>
						<input type="number" name="slide_item_767" min="1" max="6" value="<?php echo $slide_item_767; ?>" class="form-control" id="slide_item_767">
					</div>
					<div class="col-md-2">
						<?php $slide_item_480 = (isset($shortcode_fields["slide_item_480"][0])) ? $shortcode_fields["slide_item_480"][0] : '4'; ?>
						<input type="number" name="slide_item_480" min="1" max="6" value="<?php echo $slide_item_480; ?>" class="form-control" id="slide_item_480">
					</div>
				</div>
			</div>

			<div class="row">
				<div class="form-group">
					<div class="col-md-4">
						<label for="scroll_item" class="control-label">Slide to Scroll</label>
						<span class="help-block"><i>(A block of help text that breaks onto a new line and may extend beyond one line.)</i></span>
					</div>	
					<div class="col-md-2">
						<?php $scroll_item = (isset($shortcode_fields["scroll_item"][0])) ? $shortcode_fields["scroll_item"][0] : '1'; ?>
						<input type="number" name="scroll_item" min="1" max="4" value="<?php echo $scroll_item; ?>" class="form-control" id="scroll_item">
					</div>
					<div class="col-md-2">
						<?php $scroll_item_1024 = (isset($shortcode_fields["scroll_item_1024"][0])) ? $shortcode_fields["scroll_item_1024"][0] : '1'; ?>
						<input type="number" name="scroll_item_1024" min="1" max="4" value="<?php echo $scroll_item_1024; ?>" class="form-control" id="scroll_item_1024">
					</div>					
					<div class="col-md-2">
						<?php $scroll_item_767 = (isset($shortcode_fields["scroll_item_767"][0])) ? $shortcode_fields["scroll_item_767"][0] : '1'; ?>
						<input type="number" name="scroll_item_767" min="1" max="4" value="<?php echo $scroll_item_767; ?>" class="form-control" id="scroll_item_767">
					</div>
					<div class="col-md-2">
						<?php $scroll_item_480 = (isset($shortcode_fields["scroll_item_480"][0])) ? $shortcode_fields["scroll_item_480"][0] : '1'; ?>
						<input type="number" name="scroll_item_480" min="1" max="4" value="<?php echo $scroll_item_480; ?>" class="form-control" id="scroll_item_480">
					</div>
				</div>
			</div>

			<div class="row">
				<div class="form-group">
					<div class="col-md-4">
						<label for="arrows_show_hide" class="control-label">Show Arrows</label>
						<span class="help-block"><i>(A block of help text that breaks onto a new line and may extend beyond one line.)</i></span>
					</div>	
					<div class="col-md-2">
						<input id="arrows_show_hide" name="arrows_show_hide" data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-onstyle="success" class="arrows_show_hide" data-offstyle="danger" type="checkbox" value="false" <?php if ( isset ( $shortcode_fields['arrows_show_hide'] ) ) checked( $shortcode_fields['arrows_show_hide'][0], 'true' ); ?> >
					</div>
					<div class="col-md-2">
						<input id="arrows_show_hide_1024" name="arrows_show_hide_1024" data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-onstyle="success" class="arrows_show_hide_1024" data-offstyle="danger" type="checkbox" value="false" <?php if ( isset ( $shortcode_fields['arrows_show_hide_1024'] ) ) checked( $shortcode_fields['arrows_show_hide_1024'][0], 'true' ); ?> >
					</div>					
					<div class="col-md-2">
						<input id="arrows_show_hide_767" name="arrows_show_hide_767" data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-onstyle="success" class="arrows_show_hide_767" data-offstyle="danger" type="checkbox" value="false" <?php if ( isset ( $shortcode_fields['arrows_show_hide_767'] ) ) checked( $shortcode_fields['arrows_show_hide_767'][0], 'true' ); ?> >
					</div>
					<div class="col-md-2">
						<input id="arrows_show_hide_480" name="arrows_show_hide_480" data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-onstyle="success" class="arrows_show_hide_480" data-offstyle="danger" type="checkbox" value="false" <?php if ( isset ( $shortcode_fields['arrows_show_hide_480'] ) ) checked( $shortcode_fields['arrows_show_hide_480'][0], 'true' ); ?> >
					</div>
				</div>
			</div>

			<div class="row">
				<div class="form-group">
					<div class="col-md-4">
						<label for="dots_show_hide" class="control-label">Show Dots</label>
						<span class="help-block"><i>(A block of help text that breaks onto a new line and may extend beyond one line.)</i></span>
					</div>	
					<div class="col-md-2">
						<input id="dots_show_hide" name="dots_show_hide" data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-onstyle="success" class="dots_show_hide" data-offstyle="danger" type="checkbox" value="false" <?php if ( isset ( $shortcode_fields['dots_show_hide'] ) ) checked( $shortcode_fields['dots_show_hide'][0], 'true' ); ?> >
					</div>
					<div class="col-md-2">
						<input id="dots_show_hide_1024" name="dots_show_hide_1024" data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-onstyle="success" class="dots_show_hide_1024" data-offstyle="danger" type="checkbox" value="false" <?php if ( isset ( $shortcode_fields['dots_show_hide_1024'] ) ) checked( $shortcode_fields['dots_show_hide_1024'][0], 'true' ); ?> >
					</div>					
					<div class="col-md-2">
						<input id="dots_show_hide_767" name="dots_show_hide_767" data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-onstyle="success" class="dots_show_hide_767" data-offstyle="danger" type="checkbox" value="false" <?php if ( isset ( $shortcode_fields['dots_show_hide_767'] ) ) checked( $shortcode_fields['dots_show_hide_767'][0], 'true' ); ?> >
					</div>
					<div class="col-md-2">
						<input id="dots_show_hide_480" name="dots_show_hide_480" data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-onstyle="success" class="dots_show_hide_480" data-offstyle="danger" type="checkbox" value="false" <?php if ( isset ( $shortcode_fields['dots_show_hide_480'] ) ) checked( $shortcode_fields['dots_show_hide_480'][0], 'true' ); ?> >
					</div>
				</div>
			</div>

			<div class="row">
				<div class="form-group">
					<div class="col-md-4">
						<label for="autoplay" class="control-label">Autoplay</label>
						<span class="help-block"><i>(A block of help text that breaks onto a new line and may extend beyond one line.)</i></span>
					</div>	
					<div class="col-md-2">
						<input id="autoplay" name="autoplay" data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-onstyle="success" class="autoplay" data-offstyle="danger" type="checkbox" value="false" <?php if ( isset ( $shortcode_fields['autoplay'] ) ) checked( $shortcode_fields['autoplay'][0], 'true' ); ?> >
					</div>
					<div class="col-md-2">
						<input id="autoplay_1024" name="autoplay_1024" data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-onstyle="success" class="autoplay_1024" data-offstyle="danger" type="checkbox" value="false" <?php if ( isset ( $shortcode_fields['autoplay_1024'] ) ) checked( $shortcode_fields['autoplay_1024'][0], 'true' ); ?> >
					</div>					
					<div class="col-md-2">
						<input id="autoplay_767" name="autoplay_767" data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-onstyle="success" class="autoplay_767" data-offstyle="danger" type="checkbox" value="false" <?php if ( isset ( $shortcode_fields['autoplay_767'] ) ) checked( $shortcode_fields['autoplay_767'][0], 'true' ); ?> >
					</div>
					<div class="col-md-2">
						<input id="autoplay_480" name="autoplay_480" data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-onstyle="success" class="autoplay_480" data-offstyle="danger" type="checkbox" value="false" <?php if ( isset ( $shortcode_fields['autoplay_480'] ) ) checked( $shortcode_fields['autoplay_480'][0], 'true' ); ?> >
					</div>
				</div>
			</div>

			<div class="row">
				<div class="form-group">
					<div class="col-md-4">
						<label for="centermode" class="control-label">CenterMode</label>
						<span class="help-block"><i>(A block of help text that breaks onto a new line and may extend beyond one line.)</i></span>
					</div>	
					<div class="col-md-2">
						<input id="centermode" name="centermode" data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-onstyle="success" class="centermode" data-offstyle="danger" type="checkbox" value="false" <?php if ( isset ( $shortcode_fields['centermode'] ) ) checked( $shortcode_fields['centermode'][0], 'true' ); ?> >
					</div>
					<div class="col-md-2">
						<input id="centermode_1024" name="centermode_1024" data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-onstyle="success" class="centermode_1024" data-offstyle="danger" type="checkbox" value="false" <?php if ( isset ( $shortcode_fields['centermode_1024'] ) ) checked( $shortcode_fields['centermode_1024'][0], 'true' ); ?> >
					</div>					
					<div class="col-md-2">
						<input id="centermode_767" name="centermode_767" data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-onstyle="success" class="centermode_767" data-offstyle="danger" type="checkbox" value="false" <?php if ( isset ( $shortcode_fields['centermode_767'] ) ) checked( $shortcode_fields['centermode_767'][0], 'true' ); ?> >
					</div>
					<div class="col-md-2">
						<input id="centermode_480" name="centermode_480" data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-onstyle="success" class="centermode_480" data-offstyle="danger" type="checkbox" value="false" <?php if ( isset ( $shortcode_fields['centermode_480'] ) ) checked( $shortcode_fields['centermode_480'][0], 'true' ); ?> >
					</div>
				</div>
			</div>

			<div class="row">
				<div class="form-group">
					<div class="col-md-4">
						<label for="infinite" class="control-label">Infinite</label>
						<span class="help-block"><i>(A block of help text that breaks onto a new line and may extend beyond one line.)</i></span>
					</div>	
					<div class="col-md-2">
						<input id="infinite" name="infinite" data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-onstyle="success" class="infinite" data-offstyle="danger" type="checkbox" value="false" <?php if ( isset ( $shortcode_fields['infinite'] ) ) checked( $shortcode_fields['infinite'][0], 'true' ); ?> >
					</div>
					<div class="col-md-2">
						<input id="infinite_1024" name="infinite_1024" data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-onstyle="success" class="infinite_1024" data-offstyle="danger" type="checkbox" value="false" <?php if ( isset ( $shortcode_fields['infinite_1024'] ) ) checked( $shortcode_fields['infinite_1024'][0], 'true' ); ?> >
					</div>					
					<div class="col-md-2">
						<input id="infinite_767" name="infinite_767" data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-onstyle="success" class="infinite_767" data-offstyle="danger" type="checkbox" value="false" <?php if ( isset ( $shortcode_fields['infinite_767'] ) ) checked( $shortcode_fields['infinite_767'][0], 'true' ); ?> >
					</div>
					<div class="col-md-2">
						<input id="infinite_480" name="infinite_480" data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-onstyle="success" class="infinite_480" data-offstyle="danger" type="checkbox" value="false" <?php if ( isset ( $shortcode_fields['infinite_480'] ) ) checked( $shortcode_fields['infinite_480'][0], 'true' ); ?> >
					</div>
				</div>
			</div>

			<div class="row">
				<div class="form-group">
					<div class="col-md-4">
						<label for="vertical" class="control-label">Vertical</label>
						<span class="help-block"><i>(A block of help text that breaks onto a new line and may extend beyond one line.)</i></span>
					</div>	
					<div class="col-md-2">
						<input id="vertical" name="vertical" data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-onstyle="success" class="vertical" data-offstyle="danger" type="checkbox" value="false" <?php if ( isset ( $shortcode_fields['vertical'] ) ) checked( $shortcode_fields['vertical'][0], 'true' ); ?> >
					</div>
					<div class="col-md-2">
						<input id="vertical_1024" name="vertical_1024" data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-onstyle="success" class="vertical_1024" data-offstyle="danger" type="checkbox" value="false" <?php if ( isset ( $shortcode_fields['vertical_1024'] ) ) checked( $shortcode_fields['vertical_1024'][0], 'true' ); ?> >
					</div>					
					<div class="col-md-2">
						<input id="vertical_767" name="vertical_767" data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-onstyle="success" class="vertical_767" data-offstyle="danger" type="checkbox" value="false" <?php if ( isset ( $shortcode_fields['vertical_767'] ) ) checked( $shortcode_fields['vertical_767'][0], 'true' ); ?> >
					</div>
					<div class="col-md-2">
						<input id="vertical_480" name="vertical_480" data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-onstyle="success" class="vertical_480" data-offstyle="danger" type="checkbox" value="false" <?php if ( isset ( $shortcode_fields['vertical_480'] ) ) checked( $shortcode_fields['vertical_480'][0], 'true' ); ?> >
					</div>
				</div>
			</div>
		</fieldset>
	</div> 
	<!-- carousel_setting end -->
<?php }

/********* color meta box ***********/
function setting_testimonial_color_metabox($post) {
	global $post;
	$shortcode_fields = get_post_meta( $post->ID );
	/* Defualt color */
	$item_bg = (isset($shortcode_fields["item_bg"][0])) ? $shortcode_fields["item_bg"][0] : '#e1e1e1';
	$title_color = (isset($shortcode_fields["title_color"][0])) ? $shortcode_fields["title_color"][0] : '#444444';
	$title_bg = (isset($shortcode_fields["title_bg"][0])) ? $shortcode_fields["title_bg"][0] : '';
	$content_color = (isset($shortcode_fields["content_color"][0])) ? $shortcode_fields["content_color"][0] : '#444444';
	$content_bg = (isset($shortcode_fields["content_bg"][0])) ? $shortcode_fields["content_bg"][0] : '';
	$readmore_text_color = (isset($shortcode_fields["readmore_text_color"][0])) ? $shortcode_fields["readmore_text_color"][0] : '#ffffff';
	$readmore_bg = (isset($shortcode_fields["readmore_bg"][0])) ? $shortcode_fields["readmore_bg"][0] : '#444444';

	/* font size defualt */
	$title_font_size = (isset($shortcode_fields["title_font_size"][0])) ? $shortcode_fields["title_font_size"][0] : '15';
	$content_font_size = (isset($shortcode_fields["content_font_size"][0])) ? $shortcode_fields["content_font_size"][0] : '14';
	$readmore_font_size = (isset($shortcode_fields["readmore_font_size"][0])) ? $shortcode_fields["readmore_font_size"][0] : '14';

	/* padding defualt */
	$title_padding_top = (isset($shortcode_fields["title_padding_top"][0])) ? $shortcode_fields["title_padding_top"][0] : '5';
	$title_padding_right = (isset($shortcode_fields["title_padding_right"][0])) ? $shortcode_fields["title_padding_right"][0] : '5';
	$title_padding_bottom = (isset($shortcode_fields["title_padding_bottom"][0])) ? $shortcode_fields["title_padding_bottom"][0] : '5';
	$title_padding_left = (isset($shortcode_fields["title_padding_left"][0])) ? $shortcode_fields["title_padding_left"][0] : '5';

	/* content padding */
	$content_padding_top = (isset($shortcode_fields["content_padding_top"][0])) ? $shortcode_fields["content_padding_top"][0] : '5';
	$content_padding_right = (isset($shortcode_fields["content_padding_right"][0])) ? $shortcode_fields["content_padding_right"][0] : '5';
	$content_padding_bottom = (isset($shortcode_fields["content_padding_bottom"][0])) ? $shortcode_fields["content_padding_bottom"][0] : '5';
	$content_padding_left = (isset($shortcode_fields["content_padding_left"][0])) ? $shortcode_fields["content_padding_left"][0] : '5';

	/* readmore button */
	$readmore_padding_top = (isset($shortcode_fields["readmore_padding_top"][0])) ? $shortcode_fields["readmore_padding_top"][0] : '5';
	$readmore_padding_right = (isset($shortcode_fields["readmore_padding_right"][0])) ? $shortcode_fields["readmore_padding_right"][0] : '5';
	$readmore_padding_bottom = (isset($shortcode_fields["readmore_padding_bottom"][0])) ? $shortcode_fields["readmore_padding_bottom"][0] : '5';
	$readmore_padding_left = (isset($shortcode_fields["readmore_padding_left"][0])) ? $shortcode_fields["readmore_padding_left"][0] : '5'; ?>

	<!-- Background -->
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<div class="col-md-6">
					<label for="item_bg" class="control-label">Item Background</label>
					<span class="help-block"><i>(A block of help text that breaks onto a new line and may extend beyond one line.)</i></span>
				</div>
				<div class="col-md-6 setting_element">
					<div class="col-md-6">
						<input type="text" value="<?php echo $item_bg; ?>" data-alpha="true" data-default-color="#354d7a" class="color_picker" name="item_bg" id="item_bg" />
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Title -->
	<fieldset class="form-group">
		<legend>
			<span>Title</span>
		</legend>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<div class="col-md-6">
						<label for="title_color" class="control-label">Title</label>
						<span class="help-block"><i>(A block of help text that breaks onto a new line and may extend beyond one line.)</i></span>
					</div>
					<div class="col-md-6 setting_element">
						<div class="col-md-6">
							<input type="text" value="<?php echo $title_color; ?>" data-alpha="true" data-default-color="#354d7a" class="color_picker" name="title_color" id="title_color" />
						</div>
						<div class="col-md-6">
							<div class="input-group">
								<input type="number" min="1" class="form-control" value="<?php echo $title_font_size; ?>" name="title_font_size" id="title_font_size" placeholder="Default 15px" aria-describedby="sizing-addon2">
								<span class="input-group-addon" id="sizing-addon2">px</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!--padding -->
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<div class="col-md-6">
						<label for="title_color" class="control-label">Padding</label>
						<span class="help-block"><i>(A block of help text that breaks onto a new line and may extend beyond one line.)</i></span>
					</div>
					<div class="col-md-6 setting_element">
						<div class="col-md-6">
							<div class="input-group">
								<span class="input-group-addon" id="sizing-addon2"><div class="fa fa-arrow-up"></div></span>
								<input type="number" min="1" class="form-control" value="<?php echo $title_padding_top; ?>" name="title_padding_top" id="title_padding_top" placeholder="Default 15px" aria-describedby="sizing-addon2">
								<span class="input-group-addon" id="sizing-addon2">px</span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="input-group">
								<span class="input-group-addon" id="sizing-addon2"><div class="fa fa-arrow-right"></div></span>
								<input type="number" min="1" class="form-control" value="<?php echo $title_padding_right; ?>" name="title_padding_right" id="title_padding_right" placeholder="Default 15px" aria-describedby="sizing-addon2">
								<span class="input-group-addon" id="sizing-addon2">px</span>
							</div>
						</div>
						<br/><br/>
						<div class="col-md-6">
							<div class="input-group">
								<span class="input-group-addon" id="sizing-addon2"><div class="fa fa-arrow-down"></div></span>
								<input type="number" min="1" class="form-control" value="<?php echo $title_padding_right; ?>" name="title_padding_bottom" id="title_padding_bottom" placeholder="Default 15px" aria-describedby="sizing-addon2">
								<span class="input-group-addon" id="sizing-addon2">px</span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="input-group">
								<span class="input-group-addon" id="sizing-addon2"><div class="fa fa-arrow-left"></div></span>
								<input type="number" min="1" class="form-control" value="<?php echo $title_padding_left; ?>" name="title_padding_left" id="title_padding_left" placeholder="Default 15px" aria-describedby="sizing-addon2">
								<span class="input-group-addon" id="sizing-addon2">px</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Title Background -->
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<div class="col-md-6">
						<label for="title_bg" class="control-label">Title Background</label>
						<span class="help-block"><i>(A block of help text that breaks onto a new line and may extend beyond one line.)</i></span>
					</div>
					<div class="col-md-6 setting_element">
						<div class="col-md-6">
							<input type="text" value="<?php echo $title_bg; ?>" data-alpha="true" data-default-color="#354d7a" class="color_picker" name="title_bg" id="title_bg" />
						</div> 
					</div>
				</div>
			</div>
		</div>
	</fieldset>

	<!-- content feildset-->
	<fieldset class="form-group">
		<legend>
			<span>Content</span>
		</legend>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<div class="col-md-6">
						<label for="content_color" class="control-label">Content</label>
						<span class="help-block"><i>(A block of help text that breaks onto a new line and may extend beyond one line.)</i></span>
					</div>
					<div class="col-md-6 setting_element">
						<div class="col-md-6">
							<input type="text" value="<?php echo $content_color; ?>" data-alpha="true" data-default-color="#354d7a" class="color_picker" name="content_color" id="content_color" />
						</div>
						<div class="col-md-6">
							<div class="input-group">
								<input type="number" min="1" class="form-control" value="<?php echo $content_font_size; ?>" name="content_font_size" id="content_font_size" placeholder=	"Default 15px" aria-describedby="sizing-addon2">
								<span class="input-group-addon" id="sizing-addon2">px</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!--padding -->
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<div class="col-md-6">
						<label for="content_padding" class="control-label">Padding</label>
						<span class="help-block"><i>(A block of help text that breaks onto a new line and may extend beyond one line.)</i></span>
					</div>
					<div class="col-md-6 setting_element">
						<div class="col-md-6">
							<div class="input-group">
								<span class="input-group-addon" id="sizing-addon2"><div class="fa fa-arrow-up"></div></span>
								<input type="number" min="1" class="form-control" value="<?php echo $content_padding_top; ?>" name="content_padding_top" id="content_padding_top" placeholder="Default 15px" aria-describedby="sizing-addon2">
								<span class="input-group-addon" id="sizing-addon2">px</span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="input-group">
								<span class="input-group-addon" id="sizing-addon2"><div class="fa fa-arrow-right"></div></span>
								<input type="number" min="1" class="form-control" value="<?php echo $content_padding_right; ?>" name="content_padding_right" id="content_padding_right" placeholder="Default 15px" aria-describedby="sizing-addon2">
								<span class="input-group-addon" id="sizing-addon2">px</span>
							</div>
						</div>
						<br/><br/>
						<div class="col-md-6">
							<div class="input-group">
								<span class="input-group-addon" id="sizing-addon2"><div class="fa fa-arrow-down"></div></span>
								<input type="number" min="1" class="form-control" value="<?php echo $content_padding_bottom; ?>" name="content_padding_bottom" id="content_padding_bottom" placeholder="Default 15px" aria-describedby="sizing-addon2">
								<span class="input-group-addon" id="sizing-addon2">px</span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="input-group">
								<span class="input-group-addon" id="sizing-addon2"><div class="fa fa-arrow-left"></div></span>
								<input type="number" min="1" class="form-control" value="<?php echo $content_padding_left; ?>" name="content_padding_left" id="content_padding_left" placeholder="Default 15px" aria-describedby="sizing-addon2">
								<span class="input-group-addon" id="sizing-addon2">px</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Content Background -->
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<div class="col-md-6">
						<label for="content_bg" class="control-label">Content Background</label>
						<span class="help-block"><i>(A block of help text that breaks onto a new line and may extend beyond one line.)</i></span>
					</div>
					<div class="col-md-6 setting_element">
						<div class="col-md-6">
							<input type="text" value="<?php echo $content_bg; ?>" data-alpha="true" data-default-color="#354d7a" class="color_picker" name="content_bg" id="content_bg" />
						</div> 
					</div>
				</div>
			</div>
		</div>
	</fieldset>

	<!-- Read More feildset-->
	<fieldset class="form-group">
		<legend>
			<span>Read More</span>
		</legend>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<div class="col-md-6">
						<label for="readmore_color" class="control-label">Read More</label>
						<span class="help-block"><i>(A block of help text that breaks onto a new line and may extend beyond one line.)</i></span>
					</div>
					<div class="col-md-6 setting_element">
						<div class="col-md-6">
							<input type="text" value="<?php echo $readmore_text_color; ?>" data-alpha="true" data-default-color="#354d7a" class="color_picker" name="readmore_text_color" id="readmore_text_color" />
						</div>
						<div class="col-md-6">
							<div class="input-group">
								<input type="number" min="1" class="form-control" value="<?php echo $readmore_font_size; ?>" name="readmore_font_size" id="readmore_font_size" placeholder="Default 15px" aria-describedby="sizing-addon2">
								<span class="input-group-addon" id="sizing-addon2">px</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!--padding -->
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<div class="col-md-6">
						<label for="readmore_button_padding" class="control-label">Padding</label>
						<span class="help-block"><i>(A block of help text that breaks onto a new line and may extend beyond one line.)</i></span>
					</div>
					<div class="col-md-6 setting_element">
						<div class="col-md-6">
							<div class="input-group">
								<span class="input-group-addon" id="sizing-addon2"><div class="fa fa-arrow-up"></div></span>
								<input type="number" min="1" class="form-control" value="<?php echo $readmore_padding_top; ?>" name="readmore_padding_top" id="readmore_padding_top" placeholder="Default 15px" aria-describedby="sizing-addon2">
								<span class="input-group-addon" id="sizing-addon2">px</span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="input-group">
								<span class="input-group-addon" id="sizing-addon2"><div class="fa fa-arrow-right"></div></span>
								<input type="number" min="1" class="form-control" value="<?php echo $readmore_padding_right; ?>" name="readmore_padding_right" id="readmore_padding_right" placeholder="Default 15px" aria-describedby="sizing-addon2">
								<span class="input-group-addon" id="sizing-addon2">px</span>
							</div>
						</div>
						<br/><br/>
						<div class="col-md-6">
							<div class="input-group">
								<span class="input-group-addon" id="sizing-addon2"><div class="fa fa-arrow-down"></div></span>
								<input type="number" min="1" class="form-control" value="<?php echo $readmore_padding_bottom; ?>" name="readmore_padding_bottom" id="readmore_padding_bottom" placeholder="Default 15px" aria-describedby="sizing-addon2">
								<span class="input-group-addon" id="sizing-addon2">px</span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="input-group">
								<span class="input-group-addon" id="sizing-addon2"><div class="fa fa-arrow-left"></div></span>
								<input type="number" min="1" class="form-control" value="<?php echo $readmore_padding_left; ?>" name="readmore_padding_left" id="readmore_padding_left" placeholder="Default 15px" aria-describedby="sizing-addon2">
								<span class="input-group-addon" id="sizing-addon2">px</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Read more button Background -->
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<div class="col-md-6">
						<label for="readmore_bg" class="control-label">Read More Background</label>
						<span class="help-block"><i>(A block of help text that breaks onto a new line and may extend beyond one line.)</i></span>
					</div>
					<div class="col-md-6 setting_element">
						<div class="col-md-6">
							<input type="text" value="<?php echo $readmore_bg; ?>" data-alpha="true" data-default-color="#354d7a" class="color_picker" name="readmore_bg" id="readmore_bg" />
						</div> 
					</div>
				</div>
			</div>
		</div>
	</fieldset>
<?php }

function setting_testimonial_metabox($post) {
	global $post; ?>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<div class="col-md-12">
					<input type="text" name="shortcode" class="form-control" value="[km_testimonial id=<?php echo $post->ID; ?>]" />
					<span class="help-block"><i>(A block of help text that breaks onto a new line and may extend beyond one line.)</i></span>
				</div>
			</div>
		</div>
	</div>
<?php }

		// save all metabox info
add_action( 'save_post', 'save_testimonial_metaboxes' );
function save_testimonial_metaboxes( $post_id ) {
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post->ID;
	}		

	if(isset($_POST[ 'container_custom_class'])){
		update_post_meta($post_id,'container_custom_class',$_POST['container_custom_class']);
	}else {
		update_post_meta($post_id,'container_custom_class', '' );
	}

	if(isset( $_POST['view'])){
		update_post_meta($post_id,'view',$_POST['view']);
	} else {
		update_post_meta($post_id,'view','view_grid');
	}

	if(isset($_POST['category_sel'])) {
		update_post_meta($post_id,'select_category',$_POST['category_sel']);
	} else {
		update_post_meta($post_id,'select_category', '' );
	}

	if(isset($_POST[ 'title_show_hide'])){
		update_post_meta($post_id,'title_show_hide', 'true' );
	} else {
		update_post_meta($post_id,'title_show_hide', 'false' );
	}

	if(isset( $_POST['title_position'])){
		update_post_meta($post_id,'title_position',$_POST['title_position']);
	} else {
		update_post_meta($post_id,'title_position','before_description');
	}

	if(isset($_POST[ 'apply_link_on_title'])){
		update_post_meta($post_id,'apply_link_on_title', 'true' );
	} else {
		update_post_meta($post_id,'apply_link_on_title', 'false' );
	}

	if(isset($_POST[ 'description_show_hide'])){
		update_post_meta($post_id,'description_show_hide', 'true' );
	} else {
		update_post_meta($post_id,'description_show_hide', 'false' );
	}

	if(isset($_POST[ 'description_count'])){
		update_post_meta($post_id,'description_count',$_POST['description_count']);
	} else {
		update_post_meta($post_id,'description_count', '150' );
	}

	if(isset($_POST[ 'readmore_show_hide'])){
		update_post_meta($post_id,'readmore_show_hide', 'true' );
	} else {
		update_post_meta($post_id,'readmore_show_hide', 'false' );
	}

	if(isset( $_POST['readmore_btn_text'])){
		update_post_meta($post_id,'readmore_btn_text',$_POST['readmore_btn_text']);
	}else {
		update_post_meta($post_id,'readmore_btn_text', '' );
	}
	
	if(isset($_POST[ 'featuredimage_show_hide'])){
		update_post_meta($post_id,'featuredimage_show_hide', 'true' );
	} else {
		update_post_meta($post_id,'featuredimage_show_hide', 'false' );
	} 

	if(isset($_POST[ 'apply_link_on_featuered_image'])){
		update_post_meta($post_id,'apply_link_on_featuered_image', 'true' );
	} else {
		update_post_meta($post_id,'apply_link_on_featuered_image', 'false' );
	}

	// if(isset($_POST[ 'designation_show_hide'])){
	// 	update_post_meta($post_id,'designation_show_hide', 'true' );
	// } else {
	// 	update_post_meta($post_id,'designation_show_hide', 'false' );
	// } 

	if(isset($_POST[ 'km_country_show_hide'])){
		update_post_meta($post_id,'km_country_show_hide', 'true' );
	} else {
		update_post_meta($post_id,'km_country_show_hide', 'false' );
	} 


	// if(isset($_POST[ 'companyname_show_hide'])){
	// 	update_post_meta($post_id,'companyname_show_hide', 'true' );
	// } else {
	// 	update_post_meta($post_id,'companyname_show_hide', 'false' );
	// } 

	if(isset($_POST[ 'km_city_show_hide'])){
		update_post_meta($post_id,'km_city_show_hide', 'true' );
	} else {
		update_post_meta($post_id,'km_city_show_hide', 'false' );
	} 

	if(isset($_POST[ 'rating_show_hide'])){
		update_post_meta($post_id,'rating_show_hide', 'true' );
	} else {
		update_post_meta($post_id,'rating_show_hide', 'false' );
	}

	if(isset($_POST[ 'per_row_item'])){
		update_post_meta($post_id,'per_row_item',$_POST['per_row_item']);
	} else {
		update_post_meta($post_id,'per_row_item', '3' );
	}

	if(isset($_POST[ 'per_page_item'])){
		update_post_meta($post_id,'per_page_item',$_POST['per_page_item']);
	} else {
		update_post_meta($post_id,'per_page_item', '10' );
	} 

	if(isset($_POST[ 'pagination_show_hide'])){
		update_post_meta($post_id,'pagination_show_hide', 'true' );
	} else {
		update_post_meta($post_id,'pagination_show_hide', 'false' );
	}

	if(isset($_POST[ 'carousel_speed'])){
		update_post_meta($post_id,'carousel_speed',$_POST['carousel_speed']);
	}
	if(isset($_POST[ 'carousel_speed_1024'])){
		update_post_meta($post_id,'carousel_speed_1024',$_POST['carousel_speed_1024']);
	}
	if(isset($_POST[ 'carousel_speed_767'])){
		update_post_meta($post_id,'carousel_speed_767',$_POST['carousel_speed_767']);
	}
	if(isset($_POST[ 'carousel_speed_480'])){
		update_post_meta($post_id,'carousel_speed_480',$_POST['carousel_speed_480']);
	}

	if(isset($_POST[ 'slide_item'])){
		update_post_meta($post_id,'slide_item',$_POST['slide_item']);
	}
	if(isset($_POST[ 'slide_item_1024'])){
		update_post_meta($post_id,'slide_item_1024',$_POST['slide_item_1024']);
	}
	if(isset($_POST[ 'slide_item_767'])){
		update_post_meta($post_id,'slide_item_767',$_POST['slide_item_767']);
	}
	if(isset($_POST[ 'slide_item_480'])){
		update_post_meta($post_id,'slide_item_480',$_POST['slide_item_480']);
	}

	if(isset($_POST[ 'scroll_item'])){
		update_post_meta($post_id,'scroll_item',$_POST['scroll_item']);
	}
	if(isset($_POST[ 'scroll_item_1024'])){
		update_post_meta($post_id,'scroll_item_1024',$_POST['scroll_item_1024']);
	}
	if(isset($_POST[ 'scroll_item_767'])){
		update_post_meta($post_id,'scroll_item_767',$_POST['scroll_item_767']);
	}
	if(isset($_POST[ 'scroll_item_480'])){
		update_post_meta($post_id,'scroll_item_480',$_POST['scroll_item_480']);
	}

	if(isset($_POST[ 'arrows_show_hide'])){
		update_post_meta($post_id,'arrows_show_hide', 'true' );
	} else {
		update_post_meta($post_id,'arrows_show_hide', 'false' );
	}
	if(isset($_POST[ 'arrows_show_hide_1024'])){
		update_post_meta($post_id,'arrows_show_hide_1024', 'true' );
	} else {
		update_post_meta($post_id,'arrows_show_hide_1024', 'false' );
	}
	if(isset($_POST[ 'arrows_show_hide_767'])){
		update_post_meta($post_id,'arrows_show_hide_767', 'true' );
	} else {
		update_post_meta($post_id,'arrows_show_hide_767', 'false' );
	}
	if(isset($_POST[ 'arrows_show_hide_480'])){
		update_post_meta($post_id,'arrows_show_hide_480', 'true' );
	} else {
		update_post_meta($post_id,'arrows_show_hide_480', 'false' );
	}

	if(isset($_POST[ 'dots_show_hide'])){
		update_post_meta($post_id,'dots_show_hide', 'true' );
	} else {
		update_post_meta($post_id,'dots_show_hide', 'false' );
	}
	if(isset($_POST[ 'dots_show_hide_1024'])){
		update_post_meta($post_id,'dots_show_hide_1024', 'true' );
	} else {
		update_post_meta($post_id,'dots_show_hide_1024', 'false' );
	}
	if(isset($_POST[ 'dots_show_hide_767'])){
		update_post_meta($post_id,'dots_show_hide_767', 'true' );
	} else {
		update_post_meta($post_id,'dots_show_hide_767', 'false' );
	}
	if(isset($_POST[ 'dots_show_hide_480'])){
		update_post_meta($post_id,'dots_show_hide_480', 'true' );
	} else {
		update_post_meta($post_id,'dots_show_hide_480', 'false' );
	}

	if(isset($_POST[ 'autoplay'])){
		update_post_meta($post_id,'autoplay', 'true' );
	} else {
		update_post_meta($post_id,'autoplay', 'false' );
	} 
	if(isset($_POST[ 'autoplay_1024'])){
		update_post_meta($post_id,'autoplay_1024', 'true' );
	} else {
		update_post_meta($post_id,'autoplay_1024', 'false' );
	}
	if(isset($_POST[ 'autoplay_767'])){
		update_post_meta($post_id,'autoplay_767', 'true' );
	} else {
		update_post_meta($post_id,'autoplay_767', 'false' );
	}
	if(isset($_POST[ 'autoplay_480'])){
		update_post_meta($post_id,'autoplay_480', 'true' );
	} else {
		update_post_meta($post_id,'autoplay_480', 'false' );
	}

	if(isset($_POST[ 'centermode'])){
		update_post_meta($post_id,'centermode', 'true' );
	} else {
		update_post_meta($post_id,'centermode', 'false' );
	} 
	if(isset($_POST[ 'centermode_1024'])){
		update_post_meta($post_id,'centermode_1024', 'true' );
	} else {
		update_post_meta($post_id,'centermode_1024', 'false' );
	}
	if(isset($_POST[ 'centermode_767'])){
		update_post_meta($post_id,'centermode_767', 'true' );
	} else {
		update_post_meta($post_id,'centermode_767', 'false' );
	}
	if(isset($_POST[ 'centermode_480'])){
		update_post_meta($post_id,'centermode_480', 'true' );
	} else {
		update_post_meta($post_id,'centermode_480', 'false' );
	}

	if(isset($_POST[ 'infinite'])){
		update_post_meta($post_id,'infinite', 'true' );
	} else {
		update_post_meta($post_id,'infinite', 'false' );
	} 
	if(isset($_POST[ 'infinite_1024'])){
		update_post_meta($post_id,'infinite_1024', 'true' );
	} else {
		update_post_meta($post_id,'infinite_1024', 'false' );
	}
	if(isset($_POST[ 'infinite_767'])){
		update_post_meta($post_id,'infinite_767', 'true' );
	} else {
		update_post_meta($post_id,'infinite_767', 'false' );
	}
	if(isset($_POST[ 'infinite_480'])){
		update_post_meta($post_id,'infinite_480', 'true' );
	} else {
		update_post_meta($post_id,'infinite_480', 'false' );
	}

	if(isset($_POST[ 'vertical'])){
		update_post_meta($post_id,'vertical', 'true' );
	} else {
		update_post_meta($post_id,'vertical', 'false' );
	} 
	if(isset($_POST[ 'vertical_1024'])){
		update_post_meta($post_id,'vertical_1024', 'true' );
	} else {
		update_post_meta($post_id,'vertical_1024', 'false' );
	}
	if(isset($_POST[ 'vertical_767'])){
		update_post_meta($post_id,'vertical_767', 'true' );
	} else {
		update_post_meta($post_id,'vertical_767', 'false' );
	}
	if(isset($_POST[ 'vertical_480'])){
		update_post_meta($post_id,'vertical_480', 'true' );
	} else {
		update_post_meta($post_id,'vertical_480', 'false' );
	}

	if(isset($_POST[ 'item_bg'])){
		update_post_meta($post_id,'item_bg',$_POST['item_bg']);
	}

	if(isset($_POST[ 'title_color'])){
		update_post_meta($post_id,'title_color',$_POST['title_color']);
	}	

	if(isset($_POST[ 'title_bg'])){
		update_post_meta($post_id,'title_bg',$_POST['title_bg']);
	}	

	if(isset($_POST[ 'content_color'])){
		update_post_meta($post_id,'content_color',$_POST['content_color']);
	}		    

	if(isset($_POST[ 'content_bg'])){
		update_post_meta($post_id,'content_bg',$_POST['content_bg']);
	}

	if(isset($_POST[ 'readmore_text_color'])){
		update_post_meta($post_id,'readmore_text_color',$_POST['readmore_text_color']);
	}

	if(isset($_POST[ 'readmore_bg'])){
		update_post_meta($post_id,'readmore_bg',$_POST['readmore_bg']);
	}

	if(isset($_POST[ 'title_font_size'])){
		update_post_meta($post_id,'title_font_size',$_POST['title_font_size']);
	}

	if(isset($_POST[ 'content_font_size'])){
		update_post_meta($post_id,'content_font_size',$_POST['content_font_size']);
	}	    

	if(isset($_POST[ 'readmore_font_size'])){
		update_post_meta($post_id,'readmore_font_size',$_POST['readmore_font_size']);
	}	

	if(isset($_POST[ 'title_padding_top'])){
		update_post_meta($post_id,'title_padding_top',$_POST['title_padding_top']);
	}		       

	if(isset($_POST[ 'title_padding_right'])){
		update_post_meta($post_id,'title_padding_right', $_POST['title_padding_right']);
	}	

	if(isset($_POST['title_padding_bottom'])){
		update_post_meta($post_id,'title_padding_bottom', $_POST['title_padding_bottom']);
	}	

	if(isset($_POST[ 'title_padding_left'])){
		update_post_meta($post_id,'title_padding_left',$_POST['title_padding_left']);
	}

	if(isset($_POST[ 'content_padding_top'])){
		update_post_meta($post_id,'content_padding_top',$_POST['content_padding_top']);
	}

	if(isset($_POST[ 'content_padding_right'])){
		update_post_meta($post_id,'content_padding_right',$_POST['content_padding_right']);
	}

	if(isset($_POST[ 'content_padding_bottom'])){
		update_post_meta($post_id,'content_padding_bottom',$_POST['content_padding_bottom']);
	}

	if(isset($_POST[ 'content_padding_left'])){
		update_post_meta($post_id,'content_padding_left',$_POST['content_padding_left']);
	}

	if(isset($_POST[ 'readmore_padding_top'])){
		update_post_meta($post_id,'readmore_padding_top',$_POST['readmore_padding_top']);
	}

	if(isset($_POST[ 'readmore_padding_right'])){
		update_post_meta($post_id,'readmore_padding_right',$_POST['readmore_padding_right']);
	}

	if(isset($_POST[ 'readmore_padding_bottom'])){
		update_post_meta($post_id,'readmore_padding_bottom',$_POST['readmore_padding_bottom']);
	}

	if(isset($_POST[ 'readmore_padding_left'])){
		update_post_meta($post_id,'readmore_padding_left',$_POST['readmore_padding_left']);
	}
} ?>