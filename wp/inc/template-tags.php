<?php
/**
 * توابع کمکی مشترک قالب پارس.
 *
 * @package ParsBM
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/** چاپ یک آیکون از اسپرایت SVG مشترک قالب (template-parts/icon-sprite.php). */
function parsbm_icon( $id, $w = null, $h = null ) {
	$attrs = '';
	if ( $w ) $attrs .= ' width="' . esc_attr( $w ) . '"';
	if ( $h ) $attrs .= ' height="' . esc_attr( $h ) . '"';
	echo '<svg' . $attrs . '><use href="#' . esc_attr( $id ) . '"/></svg>';
}

/** تبدیل یک فیلد چندخطی «آیکون|برچسب» یا «مقدار|پسوند|برچسب» به آرایه. */
function parsbm_parse_pairs( $text ) {
	$out = array();
	foreach ( preg_split( '/\r\n|\r|\n/', (string) $text ) as $line ) {
		$line = trim( $line );
		if ( '' === $line ) continue;
		$out[] = array_map( 'trim', explode( '|', $line ) );
	}
	return $out;
}

/** تبدیل یک فیلد چندخطی ساده (هر خط یک مورد) به آرایه. */
function parsbm_parse_lines( $text ) {
	$lines = preg_split( '/\r\n|\r|\n/', (string) $text );
	return array_values( array_filter( array_map( 'trim', $lines ) ) );
}

/** چاپ ردیف آمار شمارشگردار از آرایه [مقدار، پسوند، برچسب]. */
function parsbm_render_stats( $pairs ) {
	foreach ( $pairs as $p ) {
		if ( count( $p ) < 3 ) continue;
		list( $val, $suffix, $label ) = $p;
		echo '<div><strong data-counter="' . esc_attr( $val ) . '" data-counter-suffix="' . esc_attr( $suffix ) . '">۰</strong><span>' . esc_html( $label ) . '</span></div>';
	}
}

/** خواندن یک تنظیم قالب (سفارشی‌ساز) با پیشوند parsbm_. */
function parsbm_opt( $key ) {
	return get_theme_mod( 'parsbm_' . $key, '' );
}

/**
 * لینک به یک بخش/لنگر صفحه اصلی. اگر همین الان در صفحه اصلی هستیم یک لنگر
 * ساده («#contact») تولید می‌شود، در غیر این صورت لینک کامل به خانه بعلاوه
 * لنگر — دقیقاً معادل href="#contact" در برابر href="index.html#contact" در نسخه استاتیک.
 */
function parsbm_home_anchor( $anchor ) {
	$anchor = ltrim( $anchor, '#' );
	return is_front_page() ? '#' . $anchor : home_url( '/#' . $anchor );
}

/**
 * یک مقدار لینک ذخیره‌شده در فیلدهای سفارشی را به URL نهایی تبدیل می‌کند:
 * اگر با # شروع شود، لنگر صفحه اصلی در نظر گرفته می‌شود؛ در غیر این صورت
 * همان مقدار (آدرس کامل یا نسبی) بدون تغییر استفاده می‌شود.
 */
function parsbm_resolve_url( $value ) {
	$value = trim( (string) $value );
	if ( '' === $value ) return '#';
	if ( '#' === substr( $value, 0, 1 ) ) return parsbm_home_anchor( $value );
	return $value;
}

/** ترم‌های یک طبقه‌بندی، مرتب‌شده بر اساس متای display_order. */
function parsbm_get_terms_ordered( $taxonomy, $args = array() ) {
	$terms = get_terms( array_merge( array( 'taxonomy' => $taxonomy, 'hide_empty' => false ), $args ) );
	if ( is_wp_error( $terms ) || empty( $terms ) ) return array();
	usort( $terms, function ( $a, $b ) {
		$oa = (int) get_term_meta( $a->term_id, 'display_order', true );
		$ob = (int) get_term_meta( $b->term_id, 'display_order', true );
		if ( $oa === $ob ) return strcmp( $a->name, $b->name );
		return $oa <=> $ob;
	} );
	return $terms;
}

/** لینک واقعی یک دسته محصول: آرشیو آن دسته یا لینک جایگزین (external_url) اگر ثبت شده باشد. */
function parsbm_term_url( $term ) {
	$external = get_term_meta( $term->term_id, 'external_url', true );
	if ( $external ) {
		return ( '#' === substr( $external, 0, 1 ) ) ? home_url( '/' . $external ) : $external;
	}
	$link = get_term_link( $term );
	return is_wp_error( $link ) ? home_url( '/' ) : $link;
}

/** چاپ نوار پیل «سایر دسته‌ها» بر اساس طبقه‌بندی machine_category. */
function parsbm_other_cats_nav( $active_term_id = 0, $extra_style = '' ) {
	$terms = parsbm_get_terms_ordered( 'machine_category' );
	if ( empty( $terms ) ) return;
	echo '<div class="other-cats"' . ( $extra_style ? ' style="' . esc_attr( $extra_style ) . '"' : '' ) . '>';
	foreach ( $terms as $term ) {
		$icon   = get_term_meta( $term->term_id, 'icon', true );
		$icon   = $icon ?: 'i-box';
		$class  = ( $active_term_id && (int) $term->term_id === (int) $active_term_id ) ? ' class="is-active"' : '';
		echo '<a' . $class . ' href="' . esc_url( parsbm_term_url( $term ) ) . '">';
		parsbm_icon( $icon );
		echo ' ' . esc_html( $term->name ) . '</a>';
	}
	echo '</div>';
}

/** چاپ مسیر ناوبری (breadcrumb). $items: [['label'=>'', 'url'=>'' یا null]] */
function parsbm_breadcrumb( $items ) {
	echo '<div class="container"><nav class="breadcrumb" aria-label="مسیر صفحه">';
	$last = count( $items ) - 1;
	foreach ( $items as $i => $item ) {
		if ( $i > 0 ) echo '<span class="breadcrumb__sep">/</span>';
		if ( $i === $last || empty( $item['url'] ) ) {
			echo '<span class="breadcrumb__current">' . esc_html( $item['label'] ) . '</span>';
		} else {
			echo '<a href="' . esc_url( $item['url'] ) . '">' . esc_html( $item['label'] ) . '</a>';
		}
	}
	echo '</nav></div>';
}

/**
 * تزریق id خودکار به تگ‌های h2/h3 محتوای مقاله (در صورت نبود) و استخراج
 * فهرست عنوان‌های h2 برای ساخت سایدبار «فهرست مطالب» به‌صورت خودکار.
 * خروجی: [محتوای اصلاح‌شده, آرایه [ [id, text], ... ] ]
 */
function parsbm_extract_toc( $content ) {
	$toc = array();
	$used_ids = array();
	$content = preg_replace_callback( '/<h([23])([^>]*)>(.*?)<\/h\1>/si', function ( $m ) use ( &$toc, &$used_ids ) {
		$level = $m[1];
		$attrs = $m[2];
		$text  = $m[3];
		if ( preg_match( '/id=("|\')(.*?)\1/', $attrs, $idm ) ) {
			$id = $idm[2];
		} else {
			$id = sanitize_title( wp_strip_all_tags( $text ) );
			if ( '' === $id ) $id = 'sec';
			$base = $id;
			$n = 2;
			while ( in_array( $id, $used_ids, true ) ) {
				$id = $base . '-' . $n;
				$n++;
			}
			$attrs .= ' id="' . esc_attr( $id ) . '"';
		}
		$used_ids[] = $id;
		if ( '2' === $level ) {
			$toc[] = array( 'id' => $id, 'text' => wp_strip_all_tags( $text ) );
		}
		return '<h' . $level . $attrs . '>' . $text . '</h' . $level . '>';
	}, $content );
	return array( $content, $toc );
}

/** زمان تخمینی مطالعه (به دقیقه) بر اساس شمارش کلمات فارسی/انگلیسی. */
function parsbm_reading_minutes( $content ) {
	$plain = trim( wp_strip_all_tags( $content ) );
	if ( '' === $plain ) return 1;
	$words = count( preg_split( '/\s+/u', $plain ) );
	return max( 1, (int) ceil( $words / 200 ) );
}

/** عدد فارسی‌سازی‌شده برای متن‌های ثابت (شمارشگرهای JS خودشان تبدیل عدد را انجام می‌دهند). */
function parsbm_fa_number( $n ) {
	$fa = array( '0', '1', '2', '3', '4', '5', '6', '7', '8', '9' );
	$en = array( '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹' );
	return str_replace( $fa, $en, (string) $n );
}

/**
 * صفحه‌بندی واقعی وردپرس با مارک‌آپ یکسان با نسخه استاتیک (.pagination a...).
 * $query: نتیجه WP_Query که پیمایش شده. $paged: شماره صفحه فعلی.
 */
function parsbm_render_pagination( $query, $paged ) {
	$total = (int) $query->max_num_pages;
	if ( $total <= 1 ) return;
	$prev_disabled = $paged <= 1;
	$next_disabled = $paged >= $total;
	echo '<nav class="pagination" aria-label="صفحه‌بندی">';
	echo '<a' . ( $prev_disabled ? ' aria-disabled="true"' : '' ) . ' style="transform:scaleX(-1)" href="' . esc_url( $prev_disabled ? '#' : get_pagenum_link( $paged - 1 ) ) . '" aria-label="صفحه قبل"><svg><use href="#i-arrow-fwd"/></svg></a>';
	for ( $p = 1; $p <= $total; $p++ ) {
		echo '<a class="' . ( $p === $paged ? 'is-active' : '' ) . '" href="' . esc_url( get_pagenum_link( $p ) ) . '">' . esc_html( parsbm_fa_number( $p ) ) . '</a>';
	}
	echo '<a' . ( $next_disabled ? ' aria-disabled="true"' : '' ) . ' href="' . esc_url( $next_disabled ? '#' : get_pagenum_link( $paged + 1 ) ) . '" aria-label="صفحه بعد"><svg><use href="#i-arrow-fwd"/></svg></a>';
	echo '</nav>';
}

/** کوئری مقالات مرتبط (سایر نوشته‌های استاندارد وردپرس، به‌جز نوشته جاری). */
function parsbm_related_articles( $post_id, $count = 4 ) {
	return new WP_Query( array(
		'post_type'           => 'post',
		'posts_per_page'      => $count,
		'post__not_in'        => array( $post_id ),
		'orderby'             => 'date',
		'order'               => 'DESC',
		'ignore_sticky_posts'  => true,
	) );
}
