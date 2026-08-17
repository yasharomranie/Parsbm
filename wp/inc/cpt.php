<?php
/**
 * پوست‌تایپ‌ها و طبقه‌بندی‌های اختصاصی قالب پارس بلومولدینگ.
 *
 * @package ParsBM
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * دستگاه‌ها / محصولات (مدل‌های دستگاه اکستروژن بادی، تزریق و ...).
 * آرشیو این پوست‌تایپ بر اساس طبقه‌بندی machine_category رندر می‌شود
 * (taxonomy-machine_category.php) که دقیقاً معادل category.html استاتیک است.
 */
function parsbm_register_machine_cpt() {
	register_post_type( 'machine', array(
		'labels' => array(
			'name'                  => 'دستگاه‌ها',
			'singular_name'         => 'دستگاه',
			'add_new'               => 'افزودن دستگاه',
			'add_new_item'          => 'افزودن دستگاه جدید',
			'edit_item'             => 'ویرایش دستگاه',
			'new_item'              => 'دستگاه جدید',
			'view_item'             => 'مشاهده دستگاه',
			'view_items'            => 'مشاهده دستگاه‌ها',
			'search_items'          => 'جستجوی دستگاه',
			'not_found'             => 'دستگاهی یافت نشد',
			'not_found_in_trash'    => 'دستگاهی در زباله‌دان یافت نشد',
			'all_items'             => 'همه دستگاه‌ها',
			'archives'              => 'آرشیو دستگاه‌ها',
			'menu_name'             => 'دستگاه‌ها',
			'featured_image'        => 'تصویر دستگاه',
			'set_featured_image'    => 'انتخاب تصویر دستگاه',
			'remove_featured_image' => 'حذف تصویر دستگاه',
		),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_rest'       => true,
		'menu_icon'          => 'dashicons-hammer',
		'menu_position'      => 20,
		'hierarchical'       => false,
		'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ),
		'has_archive'        => 'machines',
		'rewrite'            => array( 'slug' => 'machine', 'with_front' => false ),
		'taxonomies'         => array( 'machine_category' ),
	) );

	register_taxonomy( 'machine_category', 'machine', array(
		'labels' => array(
			'name'          => 'دسته‌های محصول',
			'singular_name' => 'دسته محصول',
			'search_items'  => 'جستجوی دسته',
			'all_items'     => 'همه دسته‌ها',
			'edit_item'     => 'ویرایش دسته',
			'add_new_item'  => 'افزودن دسته جدید',
			'menu_name'     => 'دسته‌های محصول',
		),
		'public'            => true,
		'hierarchical'      => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
		'rewrite'           => array( 'slug' => 'products', 'with_front' => false ),
	) );
}
add_action( 'init', 'parsbm_register_machine_cpt' );

/**
 * اسلایدهای هیرو — هم برای اسلایدر صفحه اصلی و هم اسلایدر صفحات دسته‌بندی
 * (از طریق فیلد «محل نمایش» از هم تفکیک می‌شوند، نگاه کنید به meta-boxes.php).
 */
function parsbm_register_hero_slide_cpt() {
	register_post_type( 'hero_slide', array(
		'labels' => array(
			'name'          => 'اسلایدهای هیرو',
			'singular_name' => 'اسلاید هیرو',
			'add_new_item'  => 'افزودن اسلاید جدید',
			'edit_item'     => 'ویرایش اسلاید',
			'menu_name'     => 'اسلایدر هیرو',
			'all_items'     => 'همه اسلایدها',
		),
		'public'        => false,
		'show_ui'       => true,
		'show_in_menu'  => true,
		'menu_icon'     => 'dashicons-images-alt2',
		'menu_position' => 21,
		'supports'      => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
	) );
}
add_action( 'init', 'parsbm_register_hero_slide_cpt' );

/**
 * سوالات متداول — عنوان = سوال، محتوا = پاسخ. طبقه‌بندی faq_category دقیقاً
 * معادل ۶ دسته faq.html استاتیک است.
 */
function parsbm_register_faq_cpt() {
	register_post_type( 'faq', array(
		'labels' => array(
			'name'          => 'سوالات متداول',
			'singular_name' => 'سوال متداول',
			'add_new_item'  => 'افزودن سوال جدید',
			'edit_item'     => 'ویرایش سوال',
			'menu_name'     => 'سوالات متداول',
			'all_items'     => 'همه سوالات',
		),
		'public'       => false,
		'show_ui'      => true,
		'show_in_menu' => true,
		'menu_icon'    => 'dashicons-editor-help',
		'menu_position' => 22,
		'supports'     => array( 'title', 'editor' ),
		'taxonomies'   => array( 'faq_category' ),
	) );

	register_taxonomy( 'faq_category', 'faq', array(
		'labels' => array(
			'name'          => 'دسته‌های سوالات متداول',
			'singular_name' => 'دسته سوال',
			'add_new_item'  => 'افزودن دسته جدید',
			'edit_item'     => 'ویرایش دسته',
			'menu_name'     => 'دسته‌های سوال',
		),
		'public'            => false,
		'show_ui'           => true,
		'hierarchical'      => true,
		'show_admin_column' => true,
	) );
}
add_action( 'init', 'parsbm_register_faq_cpt' );

/**
 * خدمات ویژه (بخش «خدمات ویژه پارس بلومولدینگ»).
 */
function parsbm_register_service_cpt() {
	register_post_type( 'service', array(
		'labels' => array(
			'name'          => 'خدمات',
			'singular_name' => 'خدمت',
			'add_new_item'  => 'افزودن خدمت جدید',
			'edit_item'     => 'ویرایش خدمت',
			'menu_name'     => 'خدمات',
			'all_items'     => 'همه خدمات',
		),
		'public'       => false,
		'show_ui'      => true,
		'show_in_menu' => true,
		'menu_icon'    => 'dashicons-admin-tools',
		'menu_position' => 23,
		'supports'     => array( 'title', 'excerpt', 'page-attributes' ),
	) );
}
add_action( 'init', 'parsbm_register_service_cpt' );

/**
 * نمونه محصولات (بخش «نمونه محصولات» با تب‌های فیلتر).
 */
function parsbm_register_sample_cpt() {
	register_post_type( 'sample', array(
		'labels' => array(
			'name'          => 'نمونه محصولات',
			'singular_name' => 'نمونه محصول',
			'add_new_item'  => 'افزودن نمونه جدید',
			'edit_item'     => 'ویرایش نمونه',
			'menu_name'     => 'نمونه محصولات',
			'all_items'     => 'همه نمونه‌ها',
		),
		'public'       => false,
		'show_ui'      => true,
		'show_in_menu' => true,
		'menu_icon'    => 'dashicons-screenoptions',
		'menu_position' => 24,
		'supports'     => array( 'title', 'page-attributes' ),
		'taxonomies'   => array( 'sample_type' ),
	) );

	register_taxonomy( 'sample_type', 'sample', array(
		'labels' => array(
			'name'          => 'نوع نمونه',
			'singular_name' => 'نوع نمونه',
			'add_new_item'  => 'افزودن نوع جدید',
			'edit_item'     => 'ویرایش نوع',
			'menu_name'     => 'نوع نمونه',
		),
		'public'            => false,
		'show_ui'           => true,
		'hierarchical'      => true,
		'show_admin_column' => true,
	) );
}
add_action( 'init', 'parsbm_register_sample_cpt' );
