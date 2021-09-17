<?php
/**
	* Plugin Name: KM Testimonial
	* Plugin URI: https://www.kinexmedia.ca/
	* Description: This plugin used for add Logo and client review the testimonials.
	* Version: 1.0.0
	* Author: Kinex media
	* Author URI: https://www.kinexmedia.ca/
	* License: Kinex Media
	**/

	add_action( 'init', 'create_testimonial_post' );
	function create_testimonial_post() {
		register_post_type('km_testimonial',
			array(
				'labels' => array(
					'name' => 'Testimonials',
					'singular_name' => 'Testimonials',
					'add_new' => 'Add New',
					'add_new_item' => 'Add New',
					'edit_item' => 'Edit',
					'new_item' => 'New',
					'all_items' => 'All Testimonials',
					'view_item' => 'View Testimonial',
					'search_items' => 'Search Testimonial',
					'not_found' => 'No Testimonial found',
					'not_found_in_trash' => 'No Testimonial found in the Trash',
					'menu_name' => 'KM Testimonial'				
				),
				'public' => true,
				'menu_position' => 15,
				'rewrite' => array('slug' => 'testimonial'),
				'supports' => array('title','editor','thumbnail','taxonomy'),
				'has_archive' => true
			)
		);
		register_taxonomy('testimonial_category', 'km_testimonial',
			array(
				'fields' => 'count',
				'public' => true,
				'hierarchical' => true,
			'label' => 'Testimonial Category',  //Display name
			'query_var' => true,
			'rewrite' => array( 'slug' => 'testimonial-cate' ),
		)
		);
	}

	/****** post typr for shortcode ***/


	function create_testimonial_shorcode_post() {
// Set UI labels for Custom Post Type
		$labels = array(
			'name'                => _x( 'Generate Shortcode', 'Generate Shortcode', 'easyshortcode' ),
			'singular_name'       => _x( 'Generate Shortcode', 'Generate Shortcode', 'easyshortcode' ),
			'menu_name'           => __( 'Generate Shortcode', 'easyshortcode' ),
			'parent_item_colon'   => __( 'Parent Shortcode', 'easyshortcode' ),
			'all_items'           => __( 'All Shortcode', 'easyshortcode' ),
			'view_item'           => __( 'View Shortcode', 'easyshortcode' ),
			'add_new_item'        => __( 'Add New Shortcode', 'easyshortcode' ),
			'add_new'             => __( 'Add New Shortcode', 'easyshortcode' ),
			'edit_item'           => __( 'Edit Shortcode', 'easyshortcode' ),
			'update_item'         => __( 'Update Shortcode', 'easyshortcode' ),
			'search_items'        => __( 'Search Shortcode', 'easyshortcode' ),
			'not_found'           => __( 'Not Found', 'easyshortcode' ),
			'not_found_in_trash'  => __( 'Not found in Trash', 'easyshortcode' ),
		);

// Set other options for Custom Post Type

		$args = array(
			'label'               => __( 'Generate Shortcode', 'easyshortcode' ),
			'description'         => __( 'Generate Shortcode', 'easyshortcode' ),
			'labels'              => $labels,
        // Features this CPT supports in Post Editor
			'supports'            => array( 'title'),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => 'edit.php?post_type=km_testimonial',
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => false,
			'capability_type'     => 'post',
		);

    // Registering your Custom Post Type
		register_post_type( 'kmeasy_shortcode', $args );

	}

	add_action( 'init', 'create_testimonial_shorcode_post', 0 );


	/* META BOX CODE START */
	add_action( 'admin_init', 'testimonial_admin' );
	function testimonial_admin() {
		add_meta_box( 'detail_meta_box',
			'Detail',
			'display_testimonial_detail_metabox',
			'km_testimonial', 'normal', 'high'
		);
	}

	function display_testimonial_detail_metabox() {
		$post_id = get_the_id();
		$km_city = esc_html(get_post_meta( $post_id, 'km_city', true));
		$km_country = esc_html(get_post_meta( $post_id, 'km_country', true));
		//$rating = intval( get_post_meta( $post_id, 'km_rating', true ) );?>
		<table>
			<tr>
				<td style="width: 35%">City</td>
				<td><input type="text" name="km_city" value="<?php echo $km_city; ?>" /></td>
			</tr>
			<tr>
				<td style="width: 35%">Country</td>
				<td><input type="text" name="km_country" value="<?php echo $km_country; ?>" /></td>
			</tr>

			<?php /* <tr>
				<td style="width: 35%">Rating</td>
				<td>
					<select style="width: 100px" name="rating">
						<?php for($rating_value = 5;$rating_value >= 1;$rating_value--){?>
							<option value="<?php echo $rating_value; ?>" <?php echo selected( $rating_value, $rating ); ?>>
								<?php echo $rating_value." stars"; 
							} ?>
						</select>
					</td>
					</tr> */ ?>
				</table>
				<?php
			}

			add_action( 'save_post', 'save_testimonial_detail', 10, 2 );
			function save_testimonial_detail( $post_id ,$km_company_name) {
				if ( $km_company_name->post_type == 'km_testimonial' ) {
					$post_data = array(
						"km_city"=>@$_POST['km_city'],
						"km_country"=>@$_POST['km_country'],
						// "km_rating"=>@$_POST['rating'],
					);
					foreach( $post_data as $key => $key_value){
						update_post_meta( $post_id, $key, $key_value );
					}
				}		
			}
			/* META BOX CODE END */

			include_once 'function.php';
			include_once 'setting.php';
			include_once 'shortcode.php';
			?>