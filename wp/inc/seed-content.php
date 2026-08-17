<?php
/**
 * محتوای پیش‌فرض قالب — یک‌بار در زمان فعال‌سازی اجرا می‌شود تا نصب تازه
 * وردپرس دقیقاً همان محتوای سایت استاتیک اصلی پارس بلومولدینگ را داشته باشد
 * (بدون این مرحله، پوست‌تایپ‌های تازه‌ساز خالی‌اند و صفحات خالی نمایش داده می‌شوند).
 * بعد از اجرای اول، از طریق پیشخوان وردپرس کاملاً قابل ویرایش/جایگزینی است.
 *
 * @package ParsBM
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function parsbm_seed_content() {
	if ( get_option( 'parsbm_seeded' ) ) return;

	$img = function ( $file ) {
		return get_template_directory_uri() . '/assets/img/products/' . $file;
	};

	/* ---------------------------------------------------------------
	 * ۱) دسته‌های محصول
	 * ------------------------------------------------------------- */
	$categories = array(
		array(
			'slug' => 'extrusion-blow-molding',
			'name' => 'دستگاه‌های پلاستیک بادی (اکستروژن)',
			'desc' => 'دستگاه‌های اکستروژن بادی (Extrusion Blow Molding) پارس، از مدل‌های تک‌ایستگاهه اقتصادی برای کارگاه‌های کوچک تا خطوط چندایستگاهه صنعتی با رباتیک کامل را پوشش می‌دهند. تمام مدل‌ها با کنترل ضخامت دیواره (Parison Control)، سیستم خنک‌کاری بهینه و امکان ساخت قالب اختصاصی عرضه می‌شوند.',
			'meta' => array(
				'icon' => 'i-bottle', 'display_order' => 1, 'capacity_max' => '1000L', 'max_stations' => 8,
				'ticker_items' => "i-jerrycan|گالن صنعتی\ni-drum|بشکه شیمیایی\ni-tank|مخزن بزرگ\ni-spray|بطری اسپری\ni-jar|ظرف آرایشی\ni-bottle|بطری شوینده\ni-duct|داکت هوا\ni-box|لوازم جانبی",
			),
		),
		array( 'slug' => 'injection', 'name' => 'دستگاه تزریق پلاستیک پارس بلومولدینگ', 'desc' => 'تزریق دقیق برای قطعات فنی، صنعتی و لوازم خانگی با کنترل هوشمند دما، فشار و سیکل تولید.', 'meta' => array( 'icon' => 'i-press', 'display_order' => 2, 'external_url' => '#p-injection' ) ),
		array( 'slug' => 'injection-blow', 'name' => 'دستگاه‌های تزریق بادی - پارس بلومولدینگ', 'desc' => 'ترکیب فرآیند تزریق و بادکنی برای تولید ظروف با دقت ابعادی بالا و ضخامت دیواره یکنواخت.', 'meta' => array( 'icon' => 'i-layers', 'display_order' => 3, 'external_url' => '#p-injection-blow' ) ),
		array( 'slug' => 'pet', 'name' => 'دستگاه بادکن پت (PET)', 'desc' => 'تولید بطری‌های PET با شفافیت و استحکام استاندارد صادراتی برای صنایع نوشیدنی، دارویی و غذایی.', 'meta' => array( 'icon' => 'i-cap-bottle', 'display_order' => 4, 'external_url' => '#p-pet' ) ),
		array( 'slug' => 'accessories', 'name' => 'لوازم جانبی پارس بلومولدینگ', 'desc' => 'قالب‌های اختصاصی، مولد هوا، سیستم خنک‌کننده و سایر تجهیزات جانبی برای تکمیل خط تولید شما.', 'meta' => array( 'icon' => 'i-box', 'display_order' => 5, 'external_url' => '#p-accessories' ) ),
	);
	$cat_term_ids = array();
	foreach ( $categories as $c ) {
		$term = term_exists( $c['slug'], 'machine_category' );
		if ( ! $term ) {
			$term = wp_insert_term( $c['name'], 'machine_category', array( 'slug' => $c['slug'], 'description' => $c['desc'] ) );
		}
		if ( is_wp_error( $term ) ) continue;
		$term_id = is_array( $term ) ? $term['term_id'] : $term;
		$cat_term_ids[ $c['slug'] ] = $term_id;
		foreach ( $c['meta'] as $k => $v ) {
			update_term_meta( $term_id, $k, $v );
		}
	}

	/* ---------------------------------------------------------------
	 * ۲) مدل‌های دستگاه اکستروژن بادی (۱۸ مدل)
	 * ------------------------------------------------------------- */
	$machines = array(
		array( 'پارس EBM‑201S', 'تا ۲ لیتر, تک‌ایستگاهه', 'مدل اقتصادی ورودی، مناسب کارگاه‌های کوچک و تولید گالن‌های کوچک.', 'machine-1.jpg' ),
		array( 'پارس EBM‑205S', 'تا ۵ لیتر, تک‌ایستگاهه', 'مناسب تولید بطری و گالن‌های خانگی و شوینده در تیراژ متوسط.', 'machine-2.jpg' ),
		array( 'پارس EBM‑210D', 'تا ۱۰ لیتر, دو ایستگاهه', 'افزایش بازدهی با دو ایستگاه قالب‌گیری هم‌زمان و سیکل کوتاه‌تر.', 'machine-3.jpg' ),
		array( 'پارس EBM‑220D', 'تا ۲۰ لیتر, دو ایستگاهه', 'مناسب تولید گالن روغن و مواد شیمیایی با دیواره ضخیم‌تر.', 'machine-4.jpg' ),
		array( 'پارس EBM‑430Q', 'تا ۳۰ لیتر, چهار ایستگاهه', 'خط نیمه‌صنعتی با چهار ایستگاه برای تیراژ بالا و توقف کمتر.', 'machine-5.jpg' ),
		array( 'پارس EBM‑460Q', 'تا ۶۰ لیتر, چهار ایستگاهه', 'تولید بشکه و گالن‌های صنعتی بزرگ با اتوماسیون بالا.', 'machine-1.jpg' ),
		array( 'پارس EBM‑6100H', 'تا ۱۰۰ لیتر, شش ایستگاهه', 'خط سنگین صنعتی با شش ایستگاه برای تیراژ بسیار بالا.', 'machine-2.jpg' ),
		array( 'پارس EBM‑D2L', 'دولایه, ضدسایش', 'ساختار دولایه برای گالن روغن موتور با مقاومت شیمیایی بالاتر.', 'machine-3.jpg' ),
		array( 'پارس EBM‑D3L', 'سه‌لایه, بشکه شیمیایی', 'مناسب بشکه‌های حاوی مواد شیمیایی حساس با لایه بازدارنده.', 'machine-4.jpg' ),
		array( 'پارس EBM‑TANK1000', 'تا ۱۰۰۰ لیتر, تک‌قالب', 'تولید مخازن بزرگ کشاورزی و صنعتی در یک مرحله بادکنی.', 'machine-5.jpg' ),
		array( 'پارس EBM‑AUTO', 'رباتیک کامل, اتوماسیون بالا', 'برداشت و چیدمان کاملاً رباتیک، مناسب تولید انبوه بدون وقفه.', 'machine-1.jpg' ),
		array( 'پارس EBM‑COMPACT', 'فوت‌پرینت کم, نیمه‌صنعتی', 'طراحی فشرده برای کارگاه‌هایی با فضای محدود.', 'machine-2.jpg' ),
		array( 'پارس EBM‑ECO150', 'تا ۱٫۵ لیتر, کم‌مصرف', 'مصرف انرژی بهینه برای تولید بطری‌های کوچک با حجم بالا.', 'machine-3.jpg' ),
		array( 'پارس EBM‑DUCT500', 'قطعات هالو, خودرویی', 'اختصاصی تولید داکت هوا و قطعات هالو صنعت خودرو.', 'machine-4.jpg' ),
		array( 'پارس EBM‑MULTI8', 'هشت‌ایستگاهه, تیراژ بسیار بالا', 'بیشترین بازدهی خط برای تولیدکنندگان بزرگ‌مقیاس.', 'machine-5.jpg' ),
		array( 'پارس EBM‑CHEM20', 'مقاوم شیمیایی, تا ۲۰ لیتر', 'مخصوص بسته‌بندی مواد شیمیایی خورنده و حلال‌ها.', 'machine-1.jpg' ),
		array( 'پارس EBM‑AGRI200', 'گالن کشاورزی, سم‌پاش', 'طراحی‌شده برای بسته‌بندی سموم و کودهای کشاورزی.', 'machine-2.jpg' ),
		array( 'پارس EBM‑PRO2000', 'تا ۲۰۰۰ لیتر, صنعتی سنگین', 'بزرگ‌ترین مدل خانواده، برای مخازن ذخیره صنعتی سنگین.', 'machine-3.jpg' ),
	);
	if ( isset( $cat_term_ids['extrusion-blow-molding'] ) && ! get_option( 'parsbm_seeded_machines' ) ) {
		$order = 0;
		foreach ( $machines as $m ) {
			list( $title, $specs, $excerpt, $file ) = $m;
			$post_id = wp_insert_post( array(
				'post_type'    => 'machine',
				'post_status'  => 'publish',
				'post_title'   => $title,
				'post_excerpt' => $excerpt,
				'menu_order'   => $order++,
			) );
			if ( ! is_wp_error( $post_id ) && $post_id ) {
				wp_set_object_terms( $post_id, array( (int) $cat_term_ids['extrusion-blow-molding'] ), 'machine_category' );
				update_post_meta( $post_id, '_machine_specs', $specs );
				update_post_meta( $post_id, '_machine_cta_label', 'استعلام قیمت' );
				update_post_meta( $post_id, '_machine_cta_url', '#contact' );
				update_post_meta( $post_id, '_machine_image_url', $img( $file ) );
			}
		}
		update_option( 'parsbm_seeded_machines', 1 );
	}

	/* ---------------------------------------------------------------
	 * ۳) اسلایدهای هیرو — صفحه اصلی (۳) و آرشیو اکستروژن بادی (۳)
	 * ------------------------------------------------------------- */
	$home_slides = array(
		array(
			'label' => 'اسلاید ۱ - خانه', 'tag_icon' => 'i-factory', 'tag_text' => 'سازنده ماشین‌آلات بلومولدینگ در ایران',
			'pre' => 'فناوری ', 'em' => 'بلومولدینگ', 'post' => ' پارس، خط تولید شما را متحول می‌کند',
			'desc' => 'طراحی، ساخت و راه‌اندازی دستگاه‌های اکستروژن بادی، تزریق پلاستیک، تزریق بادی و بادکن PET با مهندسی داخلی و پشتیبانی کامل پس از فروش.',
			'cta1l' => 'مشاهده محصولات', 'cta1u' => '#products', 'cta2l' => 'مشاوره رایگان', 'cta2u' => '#contact',
			'stats' => "27|+|سال تجربه ساخت\n1200|+|دستگاه نصب‌شده\n18|+|کشور صادراتی",
			'chip1' => 'استاندارد CE', 'chip2' => 'گارانتی ۲۴ ماهه', 'image' => 'extrusion-blow-molding.jpg',
		),
		array(
			'label' => 'اسلاید ۲ - خانه', 'tag_icon' => 'i-press', 'tag_text' => 'دقت بالا در تزریق پلاستیک',
			'pre' => 'دستگاه‌های ', 'em' => 'تزریق پلاستیک', 'post' => ' با دقت و بازدهی صنعتی',
			'desc' => 'تولید انواع قطعات فنی و صنعتی با دستگاه‌های تزریق پارس بلومولدینگ؛ کنترل هوشمند، مصرف انرژی بهینه و کیفیت تکرارپذیر در هر سیکل.',
			'cta1l' => 'جزئیات دستگاه تزریق', 'cta1u' => '#p-injection', 'cta2l' => 'تماس با کارشناسان', 'cta2u' => '#contact',
			'stats' => "35|+|نوع قالب پشتیبانی‌شده\n99|٪|دقت تکرار تولید\n24|/۷|پشتیبانی فنی",
			'chip1' => 'کنترل PLC', 'chip2' => 'مهندسی داخلی', 'image' => 'injection-molding.jpg',
		),
		array(
			'label' => 'اسلاید ۳ - خانه', 'tag_icon' => 'i-layers', 'tag_text' => 'خطوط یکپارچه و اتوماتیک',
			'pre' => 'خطوط کامل ', 'em' => 'تولید بلومولدینگ', 'post' => ' با اتوماسیون تمام‌عیار',
			'desc' => 'از تغذیه مواد اولیه تا برداشت رباتیک محصول نهایی؛ پارس بلومولدینگ خطوط یکپارچه تولید را متناسب با ظرفیت و محصول شما طراحی، مونتاژ و راه‌اندازی می‌کند.',
			'cta1l' => 'مشاوره خط تولید', 'cta1u' => '#contact', 'cta2l' => 'مشاهده محصولات', 'cta2u' => '#products',
			'stats' => "90|٪|اتوماسیون خط تولید\n40|٪+|کاهش نیروی انسانی\n24|/۷|تولید پیوسته",
			'chip1' => 'رباتیک صنعتی', 'chip2' => 'اتوماسیون کامل', 'image' => 'production-line.jpg',
		),
	);
	$catalog_slides = array(
		array(
			'label' => 'اسلاید ۱ - دسته اکستروژن بادی', 'tag_icon' => 'i-jerrycan', 'tag_text' => 'خانواده محصولات اکستروژن بادی',
			'pre' => 'از ', 'em' => 'گالن صنعتی', 'post' => ' تا مخازن بزرگ',
			'desc' => 'دستگاه‌های اکستروژن بادی پارس، طیف کاملی از گالن، بشکه و مخازن پلاستیکی را با دیواره یکنواخت و استحکام بالا تولید می‌کنند.',
			'cta1l' => 'مشاهده مدل‌های دستگاه', 'cta1u' => '#machines', 'cta2l' => 'درخواست مشاوره', 'cta2u' => home_url( '/#contact' ),
			'mosaic' => "i-jerrycan|گالن صنعتی\ni-drum|بشکه\ni-tank|مخزن\ni-bottle|بطری صنعتی\ni-press|ساخته‌شده با پارس",
		),
		array(
			'label' => 'اسلاید ۲ - دسته اکستروژن بادی', 'tag_icon' => 'i-spray', 'tag_text' => 'بطری‌های خانگی و شوینده',
			'pre' => 'بطری‌های ', 'em' => 'خانگی و شوینده', 'post' => ' با کیفیت صادراتی',
			'desc' => 'از بطری اسپری و شوینده تا ظروف آرایشی و بهداشتی؛ با دقت ابعادی بالا و سطحی صاف و براق برای چاپ و برچسب‌زنی.',
			'cta1l' => 'مشاهده مدل‌های دستگاه', 'cta1u' => '#machines', 'cta2l' => 'نمونه محصولات', 'cta2u' => home_url( '/#samples' ),
			'mosaic' => "i-spray|اسپری\ni-bottle|بطری شوینده\ni-jar|ظرف آرایشی\ni-cap-bottle|ظرف بهداشتی\ni-press|ساخته‌شده با پارس",
		),
		array(
			'label' => 'اسلاید ۳ - دسته اکستروژن بادی', 'tag_icon' => 'i-duct', 'tag_text' => 'قطعات صنعتی و خودرویی',
			'pre' => 'قطعات ', 'em' => 'هالو صنعتی', 'post' => ' و خودرو با دقت بالا',
			'desc' => 'تولید داکت هوا، مجاری خودرویی و قطعات هالو صنعتی با ضخامت دیواره کنترل‌شده و مقاومت مکانیکی بالا.',
			'cta1l' => 'مشاهده مدل‌های دستگاه', 'cta1u' => '#machines', 'cta2l' => 'تماس با کارشناسان', 'cta2u' => home_url( '/#contact' ),
			'mosaic' => "i-duct|داکت هوا\ni-cog|قطعه فنی\ni-box|مخزن خودرو\ni-tank|مخزن سوخت\ni-press|ساخته‌شده با پارس",
		),
	);

	if ( ! get_option( 'parsbm_seeded_slides' ) ) {
		$order = 0;
		foreach ( $home_slides as $s ) {
			$post_id = wp_insert_post( array( 'post_type' => 'hero_slide', 'post_status' => 'publish', 'post_title' => $s['label'], 'post_content' => $s['desc'], 'menu_order' => $order++ ) );
			if ( is_wp_error( $post_id ) || ! $post_id ) continue;
			update_post_meta( $post_id, '_slide_placement', 'home' );
			update_post_meta( $post_id, '_slide_tag_icon', $s['tag_icon'] );
			update_post_meta( $post_id, '_slide_tag_text', $s['tag_text'] );
			update_post_meta( $post_id, '_slide_title_pre', $s['pre'] );
			update_post_meta( $post_id, '_slide_title_em', $s['em'] );
			update_post_meta( $post_id, '_slide_title_post', $s['post'] );
			update_post_meta( $post_id, '_slide_cta1_label', $s['cta1l'] );
			update_post_meta( $post_id, '_slide_cta1_url', $s['cta1u'] );
			update_post_meta( $post_id, '_slide_cta2_label', $s['cta2l'] );
			update_post_meta( $post_id, '_slide_cta2_url', $s['cta2u'] );
			update_post_meta( $post_id, '_slide_stats', $s['stats'] );
			update_post_meta( $post_id, '_slide_chip1', $s['chip1'] );
			update_post_meta( $post_id, '_slide_chip2', $s['chip2'] );
			update_post_meta( $post_id, '_slide_image_url', $img( $s['image'] ) );
		}
		$order = 0;
		foreach ( $catalog_slides as $s ) {
			$post_id = wp_insert_post( array( 'post_type' => 'hero_slide', 'post_status' => 'publish', 'post_title' => $s['label'], 'post_content' => $s['desc'], 'menu_order' => $order++ ) );
			if ( is_wp_error( $post_id ) || ! $post_id ) continue;
			update_post_meta( $post_id, '_slide_placement', 'extrusion-blow-molding' );
			update_post_meta( $post_id, '_slide_tag_icon', $s['tag_icon'] );
			update_post_meta( $post_id, '_slide_tag_text', $s['tag_text'] );
			update_post_meta( $post_id, '_slide_title_pre', $s['pre'] );
			update_post_meta( $post_id, '_slide_title_em', $s['em'] );
			update_post_meta( $post_id, '_slide_title_post', $s['post'] );
			update_post_meta( $post_id, '_slide_cta1_label', $s['cta1l'] );
			update_post_meta( $post_id, '_slide_cta1_url', $s['cta1u'] );
			update_post_meta( $post_id, '_slide_cta2_label', $s['cta2l'] );
			update_post_meta( $post_id, '_slide_cta2_url', $s['cta2u'] );
			update_post_meta( $post_id, '_slide_mosaic', $s['mosaic'] );
		}
		update_option( 'parsbm_seeded_slides', 1 );
	}

	/* ---------------------------------------------------------------
	 * ۴) خدمات ویژه (۵ مورد)
	 * ------------------------------------------------------------- */
	$services = array(
		array( 'طراحی و مهندسی سفارشی', 'طراحی اختصاصی دستگاه و قالب متناسب با محصول و ظرفیت تولید شما.', 'i-cog' ),
		array( 'نصب و راه‌اندازی در محل', 'نصب، تنظیم و راه‌اندازی کامل دستگاه توسط تیم فنی پارس در کارخانه شما.', 'i-wrench' ),
		array( 'پشتیبانی فنی و خدمات پس از فروش', 'پاسخگویی و پشتیبانی فنی مستمر برای اطمینان از تداوم تولید بدون توقف.', 'i-headset' ),
		array( 'تأمین قطعات یدکی اصلی', 'موجودی همیشگی قطعات یدکی اصلی برای کاهش زمان توقف خط تولید.', 'i-box' ),
		array( 'آموزش تخصصی اپراتورها', 'دوره‌های آموزشی عملی برای اپراتورها جهت بهره‌برداری بهینه از دستگاه.', 'i-cap' ),
	);
	if ( ! get_option( 'parsbm_seeded_services' ) ) {
		$order = 0;
		foreach ( $services as $s ) {
			list( $title, $excerpt, $icon ) = $s;
			$post_id = wp_insert_post( array( 'post_type' => 'service', 'post_status' => 'publish', 'post_title' => $title, 'post_excerpt' => $excerpt, 'menu_order' => $order++ ) );
			if ( ! is_wp_error( $post_id ) && $post_id ) update_post_meta( $post_id, '_service_icon', $icon );
		}
		update_option( 'parsbm_seeded_services', 1 );
	}

	/* ---------------------------------------------------------------
	 * ۵) نمونه محصولات (۸ مورد، ۴ نوع)
	 * ------------------------------------------------------------- */
	$sample_types = array(
		'bottle' => array( 'بطری و گالن', 'i-bottle' ),
		'jar'    => array( 'ظروف و قوطی', 'i-jar' ),
		'part'   => array( 'قطعات فنی', 'i-cog' ),
		'pet'    => array( 'بطری PET', 'i-cap-bottle' ),
	);
	$sample_term_ids = array();
	foreach ( $sample_types as $slug => $t ) {
		$term = term_exists( $slug, 'sample_type' );
		if ( ! $term ) $term = wp_insert_term( $t[0], 'sample_type', array( 'slug' => $slug ) );
		if ( is_wp_error( $term ) ) continue;
		$term_id = is_array( $term ) ? $term['term_id'] : $term;
		$sample_term_ids[ $slug ] = $term_id;
		update_term_meta( $term_id, 'icon', $t[1] );
	}
	$samples = array(
		array( 'bottle', 'گالن روغن موتور ۴ لیتری' ),
		array( 'jar', 'قوطی مواد غذایی درب‌دار' ),
		array( 'part', 'قطعه فنی صنعت خودرو' ),
		array( 'pet', 'بطری آب‌معدنی ۰٫۵ لیتری' ),
		array( 'bottle', 'بطری مواد شوینده ۱ لیتری' ),
		array( 'jar', 'ظرف دارویی استوانه‌ای' ),
		array( 'pet', 'بطری نوشابه ۱٫۵ لیتری' ),
		array( 'part', 'پایه و اتصالات پلاستیکی' ),
	);
	if ( ! get_option( 'parsbm_seeded_samples' ) ) {
		$order = 0;
		foreach ( $samples as $s ) {
			list( $type, $title ) = $s;
			$post_id = wp_insert_post( array( 'post_type' => 'sample', 'post_status' => 'publish', 'post_title' => $title, 'menu_order' => $order++ ) );
			if ( ! is_wp_error( $post_id ) && $post_id && isset( $sample_term_ids[ $type ] ) ) {
				wp_set_object_terms( $post_id, array( (int) $sample_term_ids[ $type ] ), 'sample_type' );
			}
		}
		update_option( 'parsbm_seeded_samples', 1 );
	}

	/* ---------------------------------------------------------------
	 * ۶) سوالات متداول — ۶ دسته، ۲۱ سوال
	 * ------------------------------------------------------------- */
	$faq_categories = array(
		'products' => array( 'محصولات و دستگاه‌ها', 'آشنایی با انواع دستگاه‌های پارس', 'i-press', 1 ),
		'pricing'  => array( 'خرید و قیمت‌گذاری', 'فرآیند سفارش و پرداخت', 'i-tag', 2 ),
		'install'  => array( 'نصب و راه‌اندازی', 'از تحویل تا شروع تولید', 'i-wrench', 3 ),
		'warranty' => array( 'گارانتی و خدمات پس از فروش', 'پشتیبانی بعد از خرید', 'i-shield', 4 ),
		'parts'    => array( 'قطعات یدکی و نگهداری', 'تداوم تولید بدون توقف', 'i-cog', 5 ),
		'export'   => array( 'صادرات و همکاری بین‌المللی', 'حضور در بازارهای منطقه', 'i-globe', 6 ),
	);
	$faq_term_ids = array();
	foreach ( $faq_categories as $slug => $c ) {
		$term = term_exists( $slug, 'faq_category' );
		if ( ! $term ) $term = wp_insert_term( $c[0], 'faq_category', array( 'slug' => $slug, 'description' => $c[1] ) );
		if ( is_wp_error( $term ) ) continue;
		$term_id = is_array( $term ) ? $term['term_id'] : $term;
		$faq_term_ids[ $slug ] = $term_id;
		update_term_meta( $term_id, 'icon', $c[2] );
		update_term_meta( $term_id, 'display_order', $c[3] );
	}
	$faqs = array(
		'products' => array(
			array( 'چه انواع دستگاه‌هایی تولید می‌کنید؟', 'پارس بلومولدینگ پنج خانواده اصلی محصول دارد: دستگاه‌های پلاستیک بادی (اکستروژن)، دستگاه تزریق پلاستیک، دستگاه‌های تزریق بادی، دستگاه بادکن PET و لوازم جانبی. جزئیات هر دسته را می‌توانید در صفحه محصولات ببینید.' ),
			array( 'تفاوت دستگاه اکستروژن بادی با تزریق بادی چیست؟', 'در اکستروژن بادی، پاریسون از هد اکسترودر خارج و در قالب دمیده می‌شود؛ مناسب تیراژ بالا. در تزریق بادی، پریفرم ابتدا با تزریق دقیق ساخته و سپس باد می‌شود؛ مناسب ظروف با دقت ابعادی بالاتر.' ),
			array( 'آیا امکان ساخت دستگاه سفارشی وجود دارد؟', 'بله، تیم مهندسی پارس بر اساس محصول نهایی، ظرفیت تولید و فضای کارگاه شما، دستگاه و قالب اختصاصی طراحی می‌کند.' ),
			array( 'حداکثر ظرفیت تولید دستگاه‌های شما چقدر است؟', 'از دستگاه‌های تک‌ایستگاهه برای گالن‌های کوچک تا مدل‌های صنعتی سنگین برای مخازن تا ۲۰۰۰ لیتر و خطوط چندایستگاهه با اتوماسیون کامل را پوشش می‌دهیم.' ),
		),
		'pricing' => array(
			array( 'چطور می‌توانم قیمت دستگاه مورد نظرم را استعلام بگیرم؟', 'از فرم تماس سایت، تماس تلفنی یا واتس‌اپ می‌توانید مدل و نیاز خود را اعلام کنید تا کارشناسان ما در کوتاه‌ترین زمان استعلام قیمت ارسال کنند.' ),
			array( 'آیا امکان پرداخت اقساطی وجود دارد؟', 'بسته به مدل دستگاه و شرایط مشتری، امکان تسویه پلکانی وجود دارد؛ جزئیات را کارشناسان فروش در زمان مشاوره اعلام می‌کنند.' ),
			array( 'زمان تحویل دستگاه بعد از سفارش چقدر است؟', 'برای مدل‌های استاندارد ۴ تا ۶ هفته و برای دستگاه‌های سفارشی با قالب اختصاصی معمولاً ۶ تا ۸ هفته زمان می‌برد.' ),
			array( 'آیا قبل از خرید امکان بازدید از خط تولید هست؟', 'بله، مشتریان می‌توانند با هماهنگی قبلی از کارخانه و دستگاه‌های در حال کار بازدید کنند.' ),
		),
		'install' => array(
			array( 'نصب دستگاه توسط چه کسی انجام می‌شود؟', 'تیم فنی پارس بلومولدینگ در محل کارخانه شما نصب، تنظیم و راه‌اندازی کامل دستگاه را انجام می‌دهد.' ),
			array( 'چه فضا و زیرساختی برای نصب دستگاه نیاز است؟', 'بسته به مدل، نیاز به برق سه‌فاز، هوای فشرده و فضای مناسب ارتفاع سقف دارید؛ چک‌لیست کامل پیش از ارسال دستگاه در اختیارتان قرار می‌گیرد.' ),
			array( 'آموزش اپراتور شامل چه مواردی می‌شود؟', 'آموزش عملی کار با دستگاه، تعویض قالب، تنظیمات پارامترها و نکات ایمنی، همزمان با نصب توسط تیم فنی ما ارائه می‌شود.' ),
		),
		'warranty' => array(
			array( 'مدت گارانتی دستگاه‌ها چقدر است؟', 'تمام دستگاه‌های پارس بلومولدینگ حداقل ۲۴ ماه گارانتی استاندارد دارند.' ),
			array( 'در صورت خرابی، زمان پاسخگویی تیم فنی چقدر است؟', 'پشتیبانی فنی ۲۴/۷ فعال است و تیم اعزامی معمولاً ظرف ۴۸ ساعت در محل حاضر می‌شود.' ),
			array( 'آیا خدمات پس از فروش شامل قطعات هم می‌شود؟', 'بله، قطعات یدکی اصلی به‌صورت جداگانه و با قیمت مصوب برای مشتریان تأمین می‌شود.' ),
			array( 'آیا سرویس دوره‌ای رایگان است؟', 'یک نوبت سرویس دوره‌ای در سال اول خرید رایگان است؛ نوبت‌های بعدی طبق تعرفه خدمات پس از فروش محاسبه می‌شود.' ),
		),
		'parts' => array(
			array( 'قطعات یدکی اصلی همیشه موجود است؟', 'موجودی انبار قطعات پرمصرف همیشه حفظ می‌شود تا زمان توقف خط تولید مشتریان به حداقل برسد.' ),
			array( 'دوره سرویس دوره‌ای دستگاه چقدر است؟', 'بسته به میزان کارکرد، سرویس دوره‌ای معمولاً هر ۶ ماه یک‌بار توصیه می‌شود.' ),
			array( 'آیا راهنمای نگهداری در اختیار مشتری قرار می‌گیرد؟', 'بله، دفترچه راهنمای فنی و نگهداری همراه هر دستگاه و آموزش اپراتور ارائه می‌شود.' ),
		),
		'export' => array(
			array( 'آیا امکان صادرات دستگاه به سایر کشورها وجود دارد؟', 'بله، پارس بلومولدینگ سابقه صادرات به بازارهای منطقه را دارد و مطابق استانداردهای بین‌المللی بسته‌بندی و ارسال می‌کند.' ),
			array( 'آیا نمایندگی فروش در سایر کشورها اعطا می‌کنید؟', 'برای همکاری در قالب نمایندگی، از طریق فرم تماس با تیم توسعه بازار پارس در ارتباط باشید.' ),
			array( 'زبان مستندات فنی دستگاه‌ها چیست؟', 'مستندات فنی به فارسی و انگلیسی ارائه می‌شود؛ برای سفارش‌های صادراتی مستندات انگلیسی به‌صورت پیش‌فرض همراه دستگاه ارسال می‌شود.' ),
		),
	);
	if ( ! get_option( 'parsbm_seeded_faqs' ) ) {
		foreach ( $faqs as $slug => $items ) {
			if ( ! isset( $faq_term_ids[ $slug ] ) ) continue;
			$order = 0;
			foreach ( $items as $qa ) {
				list( $q, $a ) = $qa;
				$post_id = wp_insert_post( array( 'post_type' => 'faq', 'post_status' => 'publish', 'post_title' => $q, 'post_content' => '<p>' . $a . '</p>' ) );
				if ( ! is_wp_error( $post_id ) && $post_id ) {
					wp_set_object_terms( $post_id, array( (int) $faq_term_ids[ $slug ] ), 'faq_category' );
					update_post_meta( $post_id, '_faq_order', $order++ );
				}
			}
		}
		update_option( 'parsbm_seeded_faqs', 1 );
	}

	/* ---------------------------------------------------------------
	 * ۷) صفحه سوالات متداول با قالب اختصاصی page-faq.php
	 * ------------------------------------------------------------- */
	if ( ! get_option( 'parsbm_seeded_faq_page' ) ) {
		$existing = get_page_by_path( 'faq' );
		if ( ! $existing ) {
			$page_id = wp_insert_post( array(
				'post_type'   => 'page',
				'post_status' => 'publish',
				'post_title'  => 'سوالات متداول',
				'post_name'   => 'faq',
			) );
			if ( ! is_wp_error( $page_id ) && $page_id ) {
				update_post_meta( $page_id, '_wp_page_template', 'page-faq.php' );
			}
		}
		update_option( 'parsbm_seeded_faq_page', 1 );
	}

	/* ---------------------------------------------------------------
	 * ۸) مقاله نمونه (post.html) — یک نوشته استاندارد وردپرس
	 * ------------------------------------------------------------- */
	if ( ! get_option( 'parsbm_seeded_post' ) ) {
		$existing = get_page_by_path( 'راهنمای-خرید-دستگاه-تولید-مخزن', OBJECT, 'post' );
		if ( ! $existing ) {
			$content  = '<h2>چرا تولید مخزن با دستگاه پلاستیک بادی؟</h2>';
			$content .= '<p>مخازن پلاستیکی به‌دلیل مقاومت بالا در برابر خوردگی، وزن سبک نسبت به فلز، و هزینه تولید پایین‌تر، جایگزین اصلی مخازن فلزی در صنایع کشاورزی، شیمیایی، آب و فاضلاب و ذخیره‌سازی مواد غذایی شده‌اند. فرآیند اکستروژن بادی (Extrusion Blow Molding) امکان تولید مخازن یک‌تکه بدون درز جوش را فراهم می‌کند که در مقایسه با مخازن چندتکه، نشتی و نقطه ضعف ساختاری ندارند.</p>';
			$content .= '<ul><li><strong>بدون درز جوش:</strong> ساختار یک‌پارچه، ریسک نشتی را به صفر می‌رساند.</li><li><strong>سبک و قابل‌حمل:</strong> جابه‌جایی و نصب آسان‌تر نسبت به مخازن فلزی مشابه.</li><li><strong>مقاوم در برابر خوردگی:</strong> مناسب برای اسیدها، کودهای شیمیایی و آب.</li><li><strong>هزینه تولید پایین‌تر:</strong> بازگشت سرمایه سریع‌تر برای تولیدکننده.</li></ul>';
			$content .= '<h2>دستگاه پلاستیک بادی تولید مخزن چطور کار می‌کند؟</h2>';
			$content .= '<p>در این فرآیند، مواد اولیه (معمولاً پلی‌اتیلن) در اکسترودر ذوب شده و به‌صورت یک لوله استوانه‌ای (پریفرم یا پاریسون) از هد خارج می‌شود. قالب دو‌تکه دور پاریسون بسته شده و هوای فشرده به داخل آن دمیده می‌شود تا پلاستیک به دیواره داخلی قالب بچسبد و شکل نهایی مخزن را بگیرد.</p>';
			$content .= '<blockquote>کنترل دقیق ضخامت دیواره پاریسون (Parison Control) مهم‌ترین عامل تفاوت کیفیت بین یک دستگاه معمولی و یک دستگاه صنعتی حرفه‌ای است — همان چیزی که مصرف مواد را تا ۱۵٪ کاهش می‌دهد. — تیم مهندسی پارس بلومولدینگ</blockquote>';
			$content .= '<h2>معرفی سری XBLOW</h2><p>سری <strong>XBLOW</strong> پارس، برای تولید مخازن استوانه‌ای عمودی از ۵۰۰ تا ۲۰۰۰ لیتر طراحی شده و بیشتر در صنایع کشاورزی و ذخیره آب به‌کار می‌رود. این سری با هد اکستروژن تک‌لایه، برای تولید مخازن سبک با تیراژ بالا بهینه شده است.</p><ul><li>مناسب تولید مخازن ذخیره آب و کود مایع کشاورزی</li><li>سیکل تولید کوتاه‌تر برای تیراژ بالا</li><li>قابلیت ارتقا به قالب‌های چندحفره</li></ul>';
			$content .= '<h2>معرفی سری BA</h2><p>سری <strong>BA</strong> برای مخازن و تانکرهای صنعتی سنگین با دیواره ضخیم‌تر و ساختار دو یا سه‌لایه طراحی شده است. این سری برای نگهداری مواد شیمیایی خورنده و مخازن حمل سوخت مناسب‌تر است و امکان افزودن لایه بازدارنده (Barrier Layer) را دارد.</p><ul><li>ساختار چندلایه برای مقاومت شیمیایی بالاتر</li><li>مناسب تانکر حمل سوخت و مواد خورنده</li><li>کنترل دقیق‌تر ضخامت دیواره برای مخازن فشار</li></ul>';
			$content .= '<h2>جدول مقایسه مشخصات فنی</h2><p>جدول زیر مهم‌ترین تفاوت‌های دو سری را برای انتخاب سریع‌تر خلاصه می‌کند:</p>';
			$content .= '<figure class="wp-block-table"><table><thead><tr><th>مشخصه</th><th>XBLOW</th><th>BA</th></tr></thead><tbody><tr><td>محدوده ظرفیت</td><td><strong>۵۰۰ تا ۲۰۰۰ لیتر</strong></td><td><strong>۱۰۰۰ تا ۲۰۰۰ لیتر</strong></td></tr><tr><td>ساختار دیواره</td><td>تک‌لایه</td><td>دو یا سه‌لایه</td></tr><tr><td>کاربرد اصلی</td><td>آب و کود کشاورزی</td><td>مواد شیمیایی و سوخت</td></tr><tr><td>سیکل تولید</td><td>کوتاه‌تر</td><td>متوسط</td></tr><tr><td>لایه بازدارنده</td><td>ندارد</td><td>اختیاری</td></tr><tr><td>سطح اتوماسیون</td><td>نیمه تا کامل</td><td>کامل</td></tr></tbody></table></figure>';
			$content .= '<div class="inline-cta"><div><h3>هنوز مطمئن نیستید کدام سری مناسب شماست؟</h3><p>کارشناسان ما رایگان بر اساس محصول و ظرفیت تولید شما، بهترین مدل را پیشنهاد می‌دهند.</p></div><a class="btn btn--primary" href="' . esc_url( home_url( '/#contact' ) ) . '">مشاوره رایگان</a></div>';
			$content .= '<h2>نکات کلیدی قبل از خرید</h2><ul><li><strong>ظرفیت واقعی مورد نیاز را مشخص کنید:</strong> خرید دستگاه بزرگ‌تر از نیاز، هزینه راه‌اندازی را بی‌دلیل بالا می‌برد.</li><li><strong>نوع ماده اولیه مصرفی را بررسی کنید:</strong> برای مواد خورنده حتماً به سراغ سری BA با لایه بازدارنده بروید.</li><li><strong>پشتیبانی فنی و قطعات یدکی را استعلام بگیرید:</strong> در دسترس بودن قطعات یدکی مستقیماً روی زمان توقف خط تأثیر دارد.</li><li><strong>گارانتی و خدمات پس از فروش را مقایسه کنید:</strong> حداقل ۲۴ ماه گارانتی استاندارد صنعت است.</li></ul>';
			$content .= '<h2>سوالات متداول</h2><div class="faq-list" data-faq>';
			$content .= '<div class="faq-item"><button class="faq-item__q" aria-expanded="false">تفاوت اصلی سری XBLOW و BA در چیست؟<svg width="18" height="18"><use href="#i-chevron-down"/></svg></button><div class="faq-item__a"><div><p>XBLOW برای مخازن سبک‌تر آب و کشاورزی با تک‌لایه بهینه شده، درحالی‌که BA با ساختار چندلایه برای مواد شیمیایی و سوخت طراحی شده است.</p></div></div></div>';
			$content .= '<div class="faq-item"><button class="faq-item__q" aria-expanded="false">حداقل سرمایه لازم برای شروع تولید مخزن چقدر است؟<svg width="18" height="18"><use href="#i-chevron-down"/></svg></button><div class="faq-item__a"><div><p>بسته به مدل و ظرفیت انتخابی متغیر است؛ برای مشاوره دقیق و استعلام قیمت با کارشناسان ما تماس بگیرید.</p></div></div></div>';
			$content .= '<div class="faq-item"><button class="faq-item__q" aria-expanded="false">آیا امکان بازدید حضوری از خط تولید وجود دارد؟<svg width="18" height="18"><use href="#i-chevron-down"/></svg></button><div class="faq-item__a"><div><p>بله، مشتریان می‌توانند پیش از خرید از کارخانه و دستگاه‌های در حال کار بازدید کنند.</p></div></div></div>';
			$content .= '<div class="faq-item"><button class="faq-item__q" aria-expanded="false">زمان تحویل دستگاه چقدر طول می‌کشد؟<svg width="18" height="18"><use href="#i-chevron-down"/></svg></button><div class="faq-item__a"><div><p>بسته به مدل و شخصی‌سازی قالب، زمان تحویل معمولاً بین ۴ تا ۸ هفته است.</p></div></div></div>';
			$content .= '</div>';
			$content .= '<h2>جمع‌بندی و پیشنهاد پارس</h2><p>انتخاب بین سری XBLOW و BA به نوع محصول نهایی، حجم تولید و ماده اولیه مصرفی بستگی دارد. برای اکثر کاربردهای آب و کشاورزی، XBLOW گزینه مقرون‌به‌صرفه‌تری است؛ اما برای مواد شیمیایی و سوخت، سرمایه‌گذاری روی ساختار چندلایه BA در بلندمدت به‌صرفه‌تر خواهد بود. تیم فنی پارس بلومولدینگ آماده است بر اساس نیاز دقیق شما، مناسب‌ترین مدل را پیشنهاد دهد.</p>';

			$post_id = wp_insert_post( array(
				'post_type'    => 'post',
				'post_status'  => 'publish',
				'post_title'   => 'راهنمای جامع خرید دستگاه پلاستیک بادی تولید مخزن و تانکر',
				'post_name'    => 'راهنمای-خرید-دستگاه-تولید-مخزن',
				'post_excerpt' => 'ورود به دنیای تولید مخازن پلاستیکی حجیم نیازمند شناخت دقیق فناوری، مدل مناسب و نکاتی است که در این راهنما به‌صورت کامل بررسی می‌کنیم.',
				'post_content' => $content,
			) );
			if ( ! is_wp_error( $post_id ) && $post_id ) {
				update_post_meta( $post_id, '_parsbm_hero_image_url', $img( 'machine-3.jpg' ) );
			}
		}
		update_option( 'parsbm_seeded_post', 1 );
	}

	/* ---------------------------------------------------------------
	 * ۹) منوهای ناوبری
	 * ------------------------------------------------------------- */
	parsbm_seed_menus( $cat_term_ids );

	update_option( 'parsbm_seeded', 1 );
}
add_action( 'after_switch_theme', 'parsbm_seed_content' );


/** ساخت منوهای اصلی، نوار پایین موبایل و فوتر «دسترسی سریع». */
function parsbm_seed_menus( $cat_term_ids ) {
	$home = home_url( '/' );

	// منوی اصلی (دسکتاپ + کشوی موبایل).
	if ( ! wp_get_nav_menu_object( 'منوی اصلی' ) ) {
		$menu_id = wp_create_nav_menu( 'منوی اصلی' );
		$add = function ( $title, $url, $parent = 0, $icon_class = '', $desc = '' ) use ( $menu_id ) {
			return wp_update_nav_menu_item( $menu_id, 0, array(
				'menu-item-title'      => $title,
				'menu-item-url'        => $url,
				'menu-item-parent-id'  => $parent,
				'menu-item-status'     => 'publish',
				'menu-item-classes'    => $icon_class,
				'menu-item-description'=> $desc,
			) );
		};
		$add( 'خانه', $home . '#home' );
		$add( 'درباره ما', $home . '#about' );
		$products_id = $add( 'محصولات', $home . '#products' );
		if ( isset( $cat_term_ids['extrusion-blow-molding'] ) ) {
			$link = get_term_link( (int) $cat_term_ids['extrusion-blow-molding'] );
			$add( 'دستگاه‌های پلاستیک بادی (اکستروژن)', is_wp_error( $link ) ? $home : $link, $products_id, 'mega-icon-i-bottle', 'تولید بطری و ظروف با فرآیند اکستروژن بلو مولدینگ' );
		}
		$add( 'دستگاه تزریق پلاستیک', $home . '#p-injection', $products_id, 'mega-icon-i-press', 'تزریق دقیق برای قطعات فنی و صنعتی' );
		$add( 'دستگاه‌های تزریق بادی', $home . '#p-injection-blow', $products_id, 'mega-icon-i-layers', 'ترکیب تزریق و بادکنی برای ظروف دقیق' );
		$add( 'دستگاه بادکن PET', $home . '#p-pet', $products_id, 'mega-icon-i-cap-bottle', 'تولید بطری‌های PET با کیفیت صادراتی' );
		$add( 'لوازم جانبی پارس بلومولدینگ', $home . '#p-accessories', $products_id, 'mega-icon-i-box mega-full-width', 'قالب، مولد و تجهیزات جانبی خط تولید' );
		$add( 'نمونه محصولات', $home . '#samples' );
		$add( 'خدمات', $home . '#services' );
		$add( 'تماس با ما', $home . '#contact' );

		$locations = get_theme_mod( 'nav_menu_locations', array() );
		$locations['primary'] = $menu_id;
		set_theme_mod( 'nav_menu_locations', $locations );
	}

	// نوار پایین موبایل.
	if ( ! wp_get_nav_menu_object( 'نوار پایین موبایل' ) ) {
		$menu_id = wp_create_nav_menu( 'نوار پایین موبایل' );
		$items = array(
			array( 'خانه', $home . '#home', 'bn-icon-i-home bn-key-home' ),
			array( 'محصولات', $home . '#products', 'bn-icon-i-grid bn-key-products' ),
			array( 'نمونه‌کار', $home . '#samples', 'bn-icon-i-gallery bn-key-samples' ),
			array( 'خدمات', $home . '#services', 'bn-icon-i-wrench bn-key-services' ),
			array( 'تماس', $home . '#contact', 'bn-icon-i-phone bn-key-contact' ),
		);
		foreach ( $items as $it ) {
			wp_update_nav_menu_item( $menu_id, 0, array(
				'menu-item-title'   => $it[0],
				'menu-item-url'     => $it[1],
				'menu-item-status'  => 'publish',
				'menu-item-classes' => $it[2],
			) );
		}
		$locations = get_theme_mod( 'nav_menu_locations', array() );
		$locations['bottom_nav'] = $menu_id;
		set_theme_mod( 'nav_menu_locations', $locations );
	}

	// فوتر — دسترسی سریع.
	if ( ! wp_get_nav_menu_object( 'فوتر - دسترسی سریع' ) ) {
		$menu_id = wp_create_nav_menu( 'فوتر - دسترسی سریع' );
		$items = array(
			array( 'خانه', $home . '#home' ),
			array( 'درباره ما', $home . '#about' ),
			array( 'نمونه محصولات', $home . '#samples' ),
			array( 'خدمات', $home . '#services' ),
			array( 'سوالات متداول', $home . 'faq/' ),
			array( 'تماس با ما', $home . '#contact' ),
		);
		foreach ( $items as $it ) {
			wp_update_nav_menu_item( $menu_id, 0, array(
				'menu-item-title'  => $it[0],
				'menu-item-url'    => $it[1],
				'menu-item-status' => 'publish',
			) );
		}
		$locations = get_theme_mod( 'nav_menu_locations', array() );
		$locations['footer_quick'] = $menu_id;
		set_theme_mod( 'nav_menu_locations', $locations );
	}
}
