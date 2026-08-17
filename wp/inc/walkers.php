<?php
/**
 * واکرهای منوی ناوبری — خروجی هرکدام دقیقاً معادل مارک‌آپ استاتیک اصلی است
 * تا با مدیریت منو از Appearance > Menus ظاهر سایت بدون تغییر بماند.
 *
 * برای منوی «محصولات» (اصلی) هر آیتم فرزند می‌تواند با افزودن کلاس CSS
 * mega-icon-i-NAME (در بخش Menus > CSS Classes) آیکون اختصاصی خودش را
 * داشته باشد و متن زیرش را از فیلد «توضیح» (Description) بگیرد. کلاس
 * mega-full-width هم یک آیتم را در کل عرض مگامنو پهن می‌کند.
 *
 * @package ParsBM
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/** منوی دسکتاپ اصلی + مگامنوی «محصولات». */
class Walker_Parsbm_Primary extends Walker_Nav_Menu {

	public function start_lvl( &$output, $depth = 0, $args = null ) {
		$output .= '<div class="mega">';
	}

	public function end_lvl( &$output, $depth = 0, $args = null ) {
		$output .= '</div>';
	}

	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$icon = 'i-box';
		foreach ( $classes as $c ) {
			if ( 0 === strpos( $c, 'mega-icon-' ) ) $icon = substr( $c, strlen( 'mega-icon-' ) );
		}
		$has_children = in_array( 'menu-item-has-children', $classes, true );

		if ( 0 === $depth ) {
			$li_class = $has_children ? ' class="nav-item--has-menu"' : '';
			$output  .= '<li' . $li_class . '>';
			$a_class  = 'nav-link' . ( in_array( 'current-menu-item', $classes, true ) ? ' is-active' : '' );
			$haspopup = $has_children ? ' aria-haspopup="true"' : '';
			$output  .= '<a class="' . esc_attr( $a_class ) . '" href="' . esc_url( $item->url ) . '"' . $haspopup . '>' . esc_html( $item->title );
			if ( $has_children ) {
				$output .= ' <svg class="i" width="15" height="15"><use href="#i-chevron-down"/></svg>';
			}
			$output .= '</a>';
		} else {
			$style = in_array( 'mega-full-width', $classes, true ) ? ' style="grid-column: 1 / -1;"' : '';
			$output .= '<a class="mega__item"' . $style . ' href="' . esc_url( $item->url ) . '">';
			$output .= '<span class="mega__icon"><svg width="20" height="20"><use href="#' . esc_attr( $icon ) . '"/></svg></span>';
			$output .= '<span><strong>' . esc_html( $item->title ) . '</strong>';
			if ( ! empty( $item->description ) ) {
				$output .= '<p>' . esc_html( $item->description ) . '</p>';
			}
			$output .= '</span></a>';
		}
	}

	public function end_el( &$output, $item, $depth = 0, $args = null ) {
		if ( 0 === $depth ) $output .= '</li>';
	}
}

/** آکاردئون داخل کشوی منوی موبایل. */
class Walker_Parsbm_Mobile extends Walker_Nav_Menu {

	public function start_lvl( &$output, $depth = 0, $args = null ) {
		$output .= '<div class="mobile-accordion__panel"><ul>';
	}

	public function end_lvl( &$output, $depth = 0, $args = null ) {
		$output .= '</ul></div>';
	}

	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$classes      = empty( $item->classes ) ? array() : (array) $item->classes;
		$has_children = in_array( 'menu-item-has-children', $classes, true );
		if ( 0 === $depth && $has_children ) {
			$output .= '<li class="mobile-accordion"><button class="mobile-accordion__trigger" aria-expanded="false">' . esc_html( $item->title ) . ' <svg width="16" height="16"><use href="#i-chevron-down"/></svg></button>';
		} else {
			$active = in_array( 'current-menu-item', $classes, true ) ? ' style="color:var(--color-primary)"' : '';
			$output .= '<li><a' . $active . ' href="' . esc_url( $item->url ) . '">' . esc_html( $item->title ) . '</a>';
		}
	}

	public function end_el( &$output, $item, $depth = 0, $args = null ) {
		$output .= '</li>';
	}
}

/**
 * نوار پایین موبایل. هر آیتم منو با کلاس CSS مشخص می‌شود:
 *  - bn-icon-i-NAME   آیکون آیتم
 *  - bn-key-KEY       شناسه‌ای که هر قالب برای تعیین آیتم فعال با آن مقایسه می‌شود
 *    (نگاه کنید به متغیر global $parsbm_active_bottom_key در هر قالب صفحه)
 */
class Walker_Parsbm_Bottom extends Walker_Nav_Menu {

	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$icon = 'i-home';
		$key  = '';
		foreach ( $classes as $c ) {
			if ( 0 === strpos( $c, 'bn-icon-' ) ) $icon = substr( $c, strlen( 'bn-icon-' ) );
			if ( 0 === strpos( $c, 'bn-key-' ) ) $key = substr( $c, strlen( 'bn-key-' ) );
		}
		$active_key = isset( $GLOBALS['parsbm_active_bottom_key'] ) ? $GLOBALS['parsbm_active_bottom_key'] : '';
		$active     = ( $key && $key === $active_key ) ? ' is-active' : '';
		$output .= '<a class="bottom-nav__item' . $active . '" href="' . esc_url( $item->url ) . '">';
		$output .= '<svg width="22" height="22"><use href="#' . esc_attr( $icon ) . '"/></svg>' . esc_html( $item->title ) . '</a>';
	}

	public function end_el( &$output, $item, $depth = 0, $args = null ) {}
}
