<?php
/**
 * قالب اختصاصی ماشین‌های بادی پارس
 * توابع راه‌انداز قالب.
 *
 * @package ParsBM
 * @author یاشار عمرانی
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'PARSBM_VERSION', '1.0' );
define( 'PARSBM_DIR', get_template_directory() );
define( 'PARSBM_URI', get_template_directory_uri() );

require PARSBM_DIR . '/inc/cpt.php';
require PARSBM_DIR . '/inc/meta-boxes.php';
require PARSBM_DIR . '/inc/customizer.php';
require PARSBM_DIR . '/inc/walkers.php';
require PARSBM_DIR . '/inc/template-tags.php';
require PARSBM_DIR . '/inc/seed-content.php';

/* --------------------------------------------------------------------
 * راه‌انداز پایه قالب
 * ------------------------------------------------------------------ */
function parsbm_setup() {
	load_theme_textdomain( 'parsbm', PARSBM_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'custom-logo', array(
		'height'      => 34,
		'width'       => 38,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'align-wide' );
	add_post_type_support( 'page', 'excerpt' );

	register_nav_menus( array(
		'primary'      => 'منوی اصلی (دسکتاپ و کشوی موبایل)',
		'bottom_nav'   => 'نوار پایین صفحه (موبایل)',
		'footer_quick' => 'فوتر — دسترسی سریع',
	) );
}
add_action( 'after_setup_theme', 'parsbm_setup' );

/* --------------------------------------------------------------------
 * بارگذاری استایل و اسکریپت
 * ------------------------------------------------------------------ */
function parsbm_assets() {
	wp_enqueue_style( 'parsbm-main', PARSBM_URI . '/assets/css/style.css', array(), PARSBM_VERSION );
	wp_enqueue_script( 'parsbm-main', PARSBM_URI . '/assets/js/main.js', array(), PARSBM_VERSION, true );

	if ( is_singular( 'post' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'parsbm_assets' );

/** پیش‌بارگذاری فونت‌های وزیرمتن (Regular/Bold) دقیقاً مثل نسخه استاتیک. */
function parsbm_font_preload() {
	echo '<link rel="preload" as="font" href="' . esc_url( PARSBM_URI . '/assets/fonts/Vazirmatn-Regular.woff2' ) . '" type="font/woff2" crossorigin>' . "\n";
	echo '<link rel="preload" as="font" href="' . esc_url( PARSBM_URI . '/assets/fonts/Vazirmatn-Bold.woff2' ) . '" type="font/woff2" crossorigin>' . "\n";
}
add_action( 'wp_head', 'parsbm_font_preload', 1 );

/** اعمال زودهنگام حالت تاریک/روشن ذخیره‌شده در localStorage، قبل از رندر صفحه (بدون فلش رنگ). */
function parsbm_theme_mode_script() {
	echo "<script>\n";
	echo "  try {\n";
	echo "    var t = localStorage.getItem(\"pars-bm-theme\");\n";
	echo "    if (t === \"dark\" || t === \"light\") document.documentElement.setAttribute(\"data-theme\", t);\n";
	echo "  } catch (e) {}\n";
	echo "</script>\n";
}
add_action( 'wp_head', 'parsbm_theme_mode_script', 0 );

/* --------------------------------------------------------------------
 * تنظیمات سایز تصویر شاخص برای کارت‌های دستگاه (نسبت ۲ به ۱)
 * ------------------------------------------------------------------ */
function parsbm_image_sizes() {
	add_image_size( 'parsbm-machine-card', 800, 400, true );
	add_image_size( 'parsbm-hero-photo', 900, 900, false );
}
add_action( 'after_setup_theme', 'parsbm_image_sizes' );

/* --------------------------------------------------------------------
 * تصویر شاخص دستگاه/اسلاید: از تصویر شاخص واقعی استفاده کن، در غیر این
 * صورت به تصویر پیش‌فرض seed (متای _machine_image_url / _slide_image_url)
 * برگرد تا نصب تازه هرگز جای خالی تصویر نداشته باشد.
 * ------------------------------------------------------------------ */
function parsbm_post_image_url( $post_id, $meta_key, $size = 'parsbm-machine-card' ) {
	if ( has_post_thumbnail( $post_id ) ) {
		$src = get_the_post_thumbnail_url( $post_id, $size );
		if ( $src ) return $src;
	}
	$fallback = get_post_meta( $post_id, $meta_key, true );
	return $fallback ? $fallback : PARSBM_URI . '/assets/img/products/machine-1.jpg';
}

/* --------------------------------------------------------------------
 * فرم تماس صفحه اصلی — پردازش واقعی سمت سرور با wp_mail (به‌جای mailto:).
 * ------------------------------------------------------------------ */
function parsbm_handle_contact_form() {
	if ( ! isset( $_POST['parsbm_contact_nonce'] ) || ! wp_verify_nonce( wp_unslash( $_POST['parsbm_contact_nonce'] ), 'parsbm_contact' ) ) {
		wp_safe_redirect( add_query_arg( 'contact', 'error', home_url( '/#contact' ) ) );
		exit;
	}
	// تله ضدهرزنامه: اگر فیلد مخفی پر شده باشد، درخواست ربات است.
	if ( ! empty( $_POST['website'] ) ) {
		wp_safe_redirect( add_query_arg( 'contact', 'sent', home_url( '/#contact' ) ) );
		exit;
	}

	$name    = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$phone   = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
	$product = isset( $_POST['product'] ) ? sanitize_text_field( wp_unslash( $_POST['product'] ) ) : '';
	$message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

	if ( '' === $name || '' === $phone ) {
		wp_safe_redirect( add_query_arg( 'contact', 'error', home_url( '/#contact' ) ) );
		exit;
	}

	$to      = parsbm_opt( 'contact_email' ) ?: get_option( 'admin_email' );
	$subject = 'درخواست مشاوره جدید از سایت — ' . $name;
	$body    = "نام: {$name}\nتلفن: {$phone}\nمحصول مورد نظر: {$product}\nپیام:\n{$message}\n";
	wp_mail( $to, $subject, $body );

	wp_safe_redirect( add_query_arg( 'contact', 'sent', home_url( '/#contact' ) ) );
	exit;
}
add_action( 'admin_post_nopriv_parsbm_contact', 'parsbm_handle_contact_form' );
add_action( 'admin_post_parsbm_contact', 'parsbm_handle_contact_form' );

/* --------------------------------------------------------------------
 * ثبت‌نام دیدگاه — نگاشت مارک‌آپ استاندارد وردپرس روی کلاس‌های .comment-form
 * موجود در style.css به‌جای فرم پیش‌فرض وردپرس (فقط ظاهر، بدون تغییر رفتار امنیتی وردپرس).
 * ------------------------------------------------------------------ */
function parsbm_comment_form_args( $args ) {
	$args['class_form']         = 'contact-form';
	$args['title_reply']        = 'دیدگاه خود را بنویسید';
	$args['label_submit']       = 'ارسال دیدگاه';
	$args['comment_field']      = '<label>دیدگاه شما<textarea id="comment" name="comment" rows="4" placeholder="نظر یا سوال خود را بنویسید..." required></textarea></label>';
	$args['fields']['author']   = '<label>نام شما<input id="author" name="author" type="text" placeholder="نام و نام‌خانوادگی" required></label>';
	$args['fields']['email']    = '<label>ایمیل شما (منتشر نمی‌شود)<input id="email" name="email" type="email" required></label>';
	$args['comment_notes_before'] = '';
	$args['comment_notes_after']  = '';
	return $args;
}
add_filter( 'comment_form_defaults', 'parsbm_comment_form_args' );
