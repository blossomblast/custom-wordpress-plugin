<?php
// Register Custom Taxonomy

class Test{
	public function __construct()
	{
		
	 add_action( 'init', 'cptui_register_my_cpts' );	
	 add_action( 'init', 'cptui_register_my_cpts_ultrapromo' );
	 add_filter( 'rwmb_meta_boxes', 'get_coupon_details' );
	 
	}
}
new Test();
function cptui_register_my_cpts() {

	/**
	 * Post Type: Ultra Promo.
	 */

	$labels = array(
		"name" => __( "Ultra Promo", "" ),
		"singular_name" => __( "ultra promo", "" ),
		"menu_name" => __( "Ultra Promocode", "" ),
		"all_items" => __( "AllCoupons", "" ),
		"add_new" => __( "Add New", "" ),
		"add_new_item" => __( "Add New coupon", "" ),
		"edit_item" => __( "Edit coupon", "" ),
	);

	$args = array(
		"label" => __( "Ultra Promo", "" ),
		"labels" => $labels,
		"description" => "ultra promocode description. nhgjyuh",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => false,
		"rest_base" => "",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => true,
		"rewrite" => array( "slug" => "ultrapromo", "with_front" => true ),
		"query_var" => true,
		"menu_position" => 70,
		"menu_icon" => "http://localhost/Ultra_Coupon/wp-content/uploads/2018/08/coupon-code-24.png",
		"supports" => array( "title", "editor", "thumbnail", "excerpt", "custom-fields", "page-attributes", "ultrapromo" ),
		"taxonomies" => array( "category" ),
	);

	register_post_type( "ultrapromo", $args );
}



function cptui_register_my_cpts_ultrapromo() {

	/**
	 * Post Type: Ultra Promo.
	 */

	$labels = array(
		"name" => __( "Ultra Promo", "" ),
		"singular_name" => __( "ultra promo", "" ),
		"menu_name" => __( "Ultra Promocode", "" ),
		"all_items" => __( "AllCoupons", "" ),
		"add_new" => __( "Add New", "" ),
		"add_new_item" => __( "Add New coupon", "" ),
		"edit_item" => __( "Edit coupon", "" ),
	);

	$args = array(
		"label" => __( "Ultra Promo", "" ),
		"labels" => $labels,
		"description" => "ultra promocode description. nhgjyuh",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => false,
		"rest_base" => "",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => true,
		"rewrite" => array( "slug" => "ultrapromo", "with_front" => true ),
		"query_var" => true,
		"menu_position" => 70,
		"menu_icon" => "http://localhost/Ultra_Coupon/wp-content/uploads/2018/08/coupon-code-24.png",
		"supports" => array( "title", "editor", "thumbnail", "excerpt", "custom-fields", "page-attributes", "ultrapromo" ),
		"taxonomies" => array( "category" ),
	);

	register_post_type( "ultrapromo", $args );
}



// meta box


