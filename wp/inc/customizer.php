<?php
/**
 * تنظیمات قالب پارس در سفارشی‌ساز وردپرس (Appearance > Customize).
 * محتوای سراسری سایت (اطلاعات تماس، آمار، متن بخش‌های ثابت) از اینجا مدیریت می‌شود.
 *
 * @package ParsBM
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function parsbm_customize_register( $wp_customize ) {

	$wp_customize->add_panel( 'parsbm_options', array(
		'title'    => 'تنظیمات قالب پارس',
		'priority' => 8,
	) );

	$sections = array(
		'parsbm_contact' => 'اطلاعات تماس',
		'parsbm_social'  => 'شبکه‌های اجتماعی',
		'parsbm_about'   => 'بخش درباره ما',
		'parsbm_trust'   => 'نوار اعتماد',
		'parsbm_services_intro' => 'مقدمه بخش خدمات',
		'parsbm_cta'     => 'بنرهای دعوت‌به‌اقدام',
		'parsbm_footer'  => 'فوتر',
	);
	foreach ( $sections as $id => $label ) {
		$wp_customize->add_section( $id, array( 'title' => $label, 'panel' => 'parsbm_options' ) );
	}

	/**
	 * هر آیتم: [id, section, label, default, type(text|textarea|url|email)]
	 */
	$fields = array(
		array( 'contact_phone', 'parsbm_contact', 'شماره تلفن (برای لینک تماس)', '+982188000000', 'text' ),
		array( 'contact_phone_display', 'parsbm_contact', 'شماره تلفن (نمایشی)', '021-88000000', 'text' ),
		array( 'contact_email', 'parsbm_contact', 'ایمیل', 'info@pars-bm.com', 'email' ),
		array( 'contact_address', 'parsbm_contact', 'آدرس کارخانه', 'تهران، شهرک صنعتی، خیابان صنعت، پلاک ۱۲', 'textarea' ),
		array( 'contact_hours', 'parsbm_contact', 'ساعات کاری', 'شنبه تا چهارشنبه، ۸ تا ۱۷', 'text' ),

		array( 'social_whatsapp', 'parsbm_social', 'واتس‌اپ', '', 'url' ),
		array( 'social_telegram', 'parsbm_social', 'تلگرام', '', 'url' ),
		array( 'social_instagram', 'parsbm_social', 'اینستاگرام', '', 'url' ),
		array( 'social_linkedin', 'parsbm_social', 'لینکدین', '', 'url' ),

		array( 'about_eyebrow', 'parsbm_about', 'عنوان کوچک بالای بخش', 'درباره پارس بلومولدینگ', 'text' ),
		array( 'about_title', 'parsbm_about', 'عنوان بخش', 'مهندسی و ساخت داخلی، در کنار کیفیت جهانی', 'text' ),
		array( 'about_desc', 'parsbm_about', 'پاراگراف توضیح', 'پارس بلومولدینگ (Pars Blow Molding Technology) با تکیه بر دانش فنی مهندسان داخلی، طراح و سازنده دستگاه‌های اکستروژن بادی، تزریق پلاستیک، تزریق بادی و بادکن PET است. محصولات ما برای صنایع بسته‌بندی، دارویی، غذایی، خودرو و لوازم خانگی طراحی می‌شوند و با تمرکز بر پایداری، دقت تولید و بازگشت سرمایه سریع، همراه صنعتگران ایرانی و شرکای صادراتی در منطقه هستیم.', 'textarea' ),
		array( 'about_checklist', 'parsbm_about', 'موارد چک‌لیست (هر خط یک مورد)', "طراحی، مهندسی و تولید داخلی قطعات کلیدی دستگاه\nتیم فنی مجرب برای نصب، راه‌اندازی و آموزش اپراتور\nتأمین قطعات یدکی اصلی و پشتیبانی فنی مستمر\nسابقه صادرات به بازارهای منطقه با استانداردهای بین‌المللی", 'textarea' ),
		array( 'about_badge_number', 'parsbm_about', 'عدد نشان (بج)', '۲۷+', 'text' ),
		array( 'about_badge_label', 'parsbm_about', 'برچسب نشان', 'سال سابقه ساخت ماشین‌آلات', 'text' ),
		array( 'about_stat1_value', 'parsbm_about', 'آمار ۱ — مقدار', '27', 'text' ),
		array( 'about_stat1_suffix', 'parsbm_about', 'آمار ۱ — پسوند', '+', 'text' ),
		array( 'about_stat1_label', 'parsbm_about', 'آمار ۱ — برچسب', 'سال تجربه', 'text' ),
		array( 'about_stat2_value', 'parsbm_about', 'آمار ۲ — مقدار', '1200', 'text' ),
		array( 'about_stat2_suffix', 'parsbm_about', 'آمار ۲ — پسوند', '+', 'text' ),
		array( 'about_stat2_label', 'parsbm_about', 'آمار ۲ — برچسب', 'دستگاه نصب‌شده', 'text' ),
		array( 'about_stat3_value', 'parsbm_about', 'آمار ۳ — مقدار', '18', 'text' ),
		array( 'about_stat3_suffix', 'parsbm_about', 'آمار ۳ — پسوند', '+', 'text' ),
		array( 'about_stat3_label', 'parsbm_about', 'آمار ۳ — برچسب', 'کشور صادراتی', 'text' ),

		array( 'trust_item1', 'parsbm_trust', 'مورد ۱ (آیکون: جایزه)', 'بیش از ۲۷ سال سابقه ساخت', 'text' ),
		array( 'trust_item2', 'parsbm_trust', 'مورد ۲ (آیکون: کره زمین)', 'صادرات به بازارهای منطقه', 'text' ),
		array( 'trust_item3', 'parsbm_trust', 'مورد ۳ (آیکون: سپر)', 'گارانتی و خدمات پس از فروش', 'text' ),
		array( 'trust_item4', 'parsbm_trust', 'مورد ۴ (آیکون: ستاره)', 'طراحی و مهندسی داخلی', 'text' ),

		array( 'services_eyebrow', 'parsbm_services_intro', 'عنوان کوچک', 'خدمات ویژه', 'text' ),
		array( 'services_title', 'parsbm_services_intro', 'عنوان بخش', 'خدمات ویژه پارس بلومولدینگ', 'text' ),
		array( 'services_desc', 'parsbm_services_intro', 'پاراگراف توضیح', 'از لحظه سفارش تا سال‌ها پس از راه‌اندازی، تیم فنی پارس بلومولدینگ کنار خط تولید شماست؛ از طراحی سفارشی تا تأمین قطعات یدکی و آموزش اپراتور.', 'textarea' ),
		array( 'services_stat1_value', 'parsbm_services_intro', 'آمار ۱ — مقدار', '98', 'text' ),
		array( 'services_stat1_suffix', 'parsbm_services_intro', 'آمار ۱ — پسوند', '٪', 'text' ),
		array( 'services_stat1_label', 'parsbm_services_intro', 'آمار ۱ — برچسب', 'رضایت مشتریان', 'text' ),
		array( 'services_stat2_value', 'parsbm_services_intro', 'آمار ۲ — مقدار', '24', 'text' ),
		array( 'services_stat2_suffix', 'parsbm_services_intro', 'آمار ۲ — پسوند', '/۷', 'text' ),
		array( 'services_stat2_label', 'parsbm_services_intro', 'آمار ۲ — برچسب', 'پشتیبانی فنی', 'text' ),

		array( 'cta_home_title', 'parsbm_cta', 'صفحه اصلی — عنوان', 'آماده‌اید خط تولید خود را ارتقا دهید؟', 'text' ),
		array( 'cta_home_desc', 'parsbm_cta', 'صفحه اصلی — توضیح', 'کارشناسان پارس بلومولدینگ رایگان شما را در انتخاب دستگاه مناسب راهنمایی می‌کنند.', 'textarea' ),
		array( 'cta_category_title', 'parsbm_cta', 'صفحه دسته‌بندی — عنوان', 'مطمئن نیستید کدام مدل مناسب شماست؟', 'text' ),
		array( 'cta_category_desc', 'parsbm_cta', 'صفحه دسته‌بندی — توضیح', 'کارشناسان پارس بلومولدینگ بر اساس محصول و ظرفیت تولید، بهترین مدل را به شما پیشنهاد می‌دهند.', 'textarea' ),
		array( 'cta_faq_title', 'parsbm_cta', 'صفحه سوالات متداول — عنوان', 'جواب سوالتان را پیدا نکردید؟', 'text' ),
		array( 'cta_faq_desc', 'parsbm_cta', 'صفحه سوالات متداول — توضیح', 'کارشناسان پارس بلومولدینگ مستقیم و رایگان پاسخگوی شما هستند.', 'textarea' ),

		array( 'footer_about', 'parsbm_footer', 'توضیح کوتاه فوتر', 'سازنده دستگاه‌های اکستروژن بادی، تزریق پلاستیک، تزریق بادی و بادکن PET با مهندسی و ساخت داخلی و پشتیبانی کامل پس از فروش.', 'textarea' ),
		array( 'footer_credit', 'parsbm_footer', 'متن کوچک کنار کپی‌رایت', 'طراحی با اسکیل UI/UX Pro Max', 'text' ),
	);

	foreach ( $fields as $f ) {
		list( $id, $section, $label, $default, $type ) = $f;
		$sanitize = 'text' === $type || 'textarea' === $type ? 'sanitize_textarea_field' : ( 'email' === $type ? 'sanitize_email' : 'esc_url_raw' );
		$wp_customize->add_setting( 'parsbm_' . $id, array(
			'default'           => $default,
			'sanitize_callback' => $sanitize,
		) );
		$wp_customize->add_control( 'parsbm_' . $id, array(
			'label'   => $label,
			'section' => $section,
			'type'    => 'textarea' === $type ? 'textarea' : ( 'url' === $type ? 'url' : ( 'email' === $type ? 'email' : 'text' ) ),
		) );
	}
}
add_action( 'customize_register', 'parsbm_customize_register' );

// میان‌بر parsbm_opt() برای خواندن این تنظیمات در قالب‌ها، در inc/template-tags.php تعریف شده است.
