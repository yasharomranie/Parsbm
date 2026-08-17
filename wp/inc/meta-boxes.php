<?php
/**
 * فیلدهای سفارشی (متاباکس) برای پوست‌تایپ‌ها و فیلدهای ترم برای طبقه‌بندی‌ها —
 * بدون وابستگی به افزونه‌ای مثل ACF، فقط با APIهای استاندارد وردپرس.
 *
 * @package ParsBM
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* --------------------------------------------------------------------
 * کمکی عمومی برای رندر و ذخیره یک متاباکس روی پست‌تایپ
 * ------------------------------------------------------------------ */
function parsbm_register_meta_box( $post_type, $box_id, $title, $fields ) {
	add_action( 'add_meta_boxes', function () use ( $post_type, $box_id, $title, $fields ) {
		add_meta_box( $box_id, $title, function ( $post ) use ( $fields, $box_id ) {
			wp_nonce_field( $box_id . '_action', $box_id . '_nonce' );
			echo '<table class="form-table" role="presentation"><tbody>';
			foreach ( $fields as $key => $field ) {
				$value = get_post_meta( $post->ID, $key, true );
				parsbm_render_field( $key, $field, $value );
			}
			echo '</tbody></table>';
		}, $post_type, 'normal', 'high' );
	} );

	add_action( 'save_post_' . $post_type, function ( $post_id ) use ( $fields, $box_id ) {
		if ( ! isset( $_POST[ $box_id . '_nonce' ] ) || ! wp_verify_nonce( wp_unslash( $_POST[ $box_id . '_nonce' ] ), $box_id . '_action' ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
		foreach ( $fields as $key => $field ) {
			if ( isset( $_POST[ $key ] ) ) {
				$raw = wp_unslash( $_POST[ $key ] );
				update_post_meta( $post_id, $key, parsbm_sanitize_field( $raw, $field ) );
			} else {
				delete_post_meta( $post_id, $key );
			}
		}
	} );
}

function parsbm_render_field( $key, $field, $value ) {
	echo '<tr><th style="width:230px;text-align:right;"><label for="' . esc_attr( $key ) . '">' . esc_html( $field['label'] ) . '</label></th><td>';
	switch ( $field['type'] ) {
		case 'textarea':
			echo '<textarea style="width:100%;max-width:560px" rows="4" id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '">' . esc_textarea( $value ) . '</textarea>';
			break;
		case 'number':
			echo '<input type="number" step="any" id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" value="' . esc_attr( $value ) . '">';
			break;
		default:
			echo '<input type="text" style="width:100%;max-width:560px" id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" value="' . esc_attr( $value ) . '"' . ( ! empty( $field['placeholder'] ) ? ' placeholder="' . esc_attr( $field['placeholder'] ) . '"' : '' ) . '>';
	}
	if ( ! empty( $field['hint'] ) ) {
		echo '<p class="description">' . esc_html( $field['hint'] ) . '</p>';
	}
	echo '</td></tr>';
}

function parsbm_sanitize_field( $raw, $field ) {
	switch ( $field['type'] ) {
		case 'textarea':
			return sanitize_textarea_field( $raw );
		case 'number':
			return is_numeric( $raw ) ? $raw + 0 : '';
		default:
			return sanitize_text_field( $raw );
	}
}

/* --------------------------------------------------------------------
 * متاباکس دستگاه (machine)
 * ------------------------------------------------------------------ */
add_action( 'init', function () {
	parsbm_register_meta_box( 'machine', 'parsbm_machine_box', 'مشخصات دستگاه', array(
		'_machine_specs'    => array(
			'label' => 'برچسب‌های مشخصات',
			'type'  => 'text',
			'hint'  => 'با کاما جدا کنید، مثل: تا ۲ لیتر, تک‌ایستگاهه (روی کارت به‌صورت دو برچسب کوچک نمایش داده می‌شود)',
		),
		'_machine_cta_label' => array(
			'label'       => 'متن دکمه',
			'type'        => 'text',
			'placeholder' => 'استعلام قیمت',
		),
		'_machine_cta_url'   => array(
			'label'       => 'لینک دکمه',
			'type'        => 'text',
			'placeholder' => '#contact',
			'hint'        => 'می‌تواند یک لنگر مثل #contact یا یک آدرس کامل باشد.',
		),
	) );

	parsbm_register_meta_box( 'hero_slide', 'parsbm_slide_box', 'محتوای اسلاید', array(
		'_slide_placement' => array(
			'label' => 'محل نمایش',
			'type'  => 'text',
			'hint'  => 'برای اسلایدر صفحه اصلی مقدار home را وارد کنید؛ برای اسلایدر یک دسته محصول، اسلاگ آن دسته را وارد کنید (مثل extrusion-blow-molding).',
		),
		'_slide_tag_icon'   => array(
			'label' => 'آیکون برچسب بالای عنوان',
			'type'  => 'text',
			'hint'  => 'شناسه آیکون از اسپرایت SVG، مثل i-factory، i-press، i-layers، i-jerrycan',
		),
		'_slide_tag_text'   => array( 'label' => 'متن برچسب بالای عنوان', 'type' => 'text' ),
		'_slide_title_pre'  => array( 'label' => 'عنوان — بخش اول', 'type' => 'text' ),
		'_slide_title_em'   => array( 'label' => 'عنوان — بخش برجسته (تاکیدی)', 'type' => 'text' ),
		'_slide_title_post' => array( 'label' => 'عنوان — بخش پایانی', 'type' => 'text' ),
		'_slide_cta1_label' => array( 'label' => 'دکمه اول — متن', 'type' => 'text' ),
		'_slide_cta1_url'   => array( 'label' => 'دکمه اول — لینک', 'type' => 'text' ),
		'_slide_cta2_label' => array( 'label' => 'دکمه دوم — متن', 'type' => 'text' ),
		'_slide_cta2_url'   => array( 'label' => 'دکمه دوم — لینک', 'type' => 'text' ),
		'_slide_stats'      => array(
			'label' => 'آمار زیر عنوان (حداکثر ۳ مورد)',
			'type'  => 'textarea',
			'hint'  => 'هر خط یک مورد به‌صورت: مقدار|پسوند|برچسب — مثال: 27|+|سال تجربه ساخت',
		),
		'_slide_chip1'      => array( 'label' => 'برچسب شناور اول (فقط اسلاید خانه)', 'type' => 'text', 'placeholder' => 'استاندارد CE' ),
		'_slide_chip2'      => array( 'label' => 'برچسب شناور دوم (فقط اسلاید خانه)', 'type' => 'text', 'placeholder' => 'گارانتی ۲۴ ماهه' ),
		'_slide_mosaic'     => array(
			'label' => 'کاشی‌های موزاییک (فقط اسلاید دسته‌بندی)',
			'type'  => 'textarea',
			'hint'  => 'هر خط یک کاشی به‌صورت: آیکون|برچسب — حداکثر ۵ خط. مثال: i-jerrycan|گالن صنعتی',
		),
	) );

	parsbm_register_meta_box( 'faq', 'parsbm_faq_box', 'ترتیب نمایش', array(
		'_faq_order' => array( 'label' => 'شماره ترتیب', 'type' => 'number', 'hint' => 'عدد کوچک‌تر زودتر نمایش داده می‌شود.' ),
	) );

	parsbm_register_meta_box( 'service', 'parsbm_service_box', 'آیکون خدمت', array(
		'_service_icon' => array(
			'label' => 'شناسه آیکون',
			'type'  => 'text',
			'hint'  => 'مثل i-cog، i-wrench، i-headset، i-box، i-cap',
		),
	) );
} );

/* --------------------------------------------------------------------
 * فیلدهای ترم برای طبقه‌بندی machine_category و faq_category
 * ------------------------------------------------------------------ */
function parsbm_register_term_meta_fields( $taxonomy, $fields ) {
	add_action( $taxonomy . '_add_form_fields', function () use ( $fields ) {
		foreach ( $fields as $key => $field ) {
			echo '<div class="form-field"><label for="' . esc_attr( $key ) . '">' . esc_html( $field['label'] ) . '</label>';
			echo '<input type="text" name="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" value="">';
			if ( ! empty( $field['hint'] ) ) echo '<p>' . esc_html( $field['hint'] ) . '</p>';
			echo '</div>';
		}
	} );

	add_action( $taxonomy . '_edit_form_fields', function ( $term ) use ( $fields ) {
		foreach ( $fields as $key => $field ) {
			$value = get_term_meta( $term->term_id, $key, true );
			echo '<tr class="form-field"><th><label for="' . esc_attr( $key ) . '">' . esc_html( $field['label'] ) . '</label></th><td>';
			if ( 'textarea' === $field['type'] ) {
				echo '<textarea name="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" rows="4" style="width:100%;max-width:500px">' . esc_textarea( $value ) . '</textarea>';
			} else {
				echo '<input type="text" name="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" value="' . esc_attr( $value ) . '" style="width:100%;max-width:500px">';
			}
			if ( ! empty( $field['hint'] ) ) echo '<p class="description">' . esc_html( $field['hint'] ) . '</p>';
			echo '</td></tr>';
		}
	} );

	$save = function ( $term_id ) use ( $fields ) {
		foreach ( $fields as $key => $field ) {
			if ( isset( $_POST[ $key ] ) ) {
				update_term_meta( $term_id, $key, parsbm_sanitize_field( wp_unslash( $_POST[ $key ] ), $field ) );
			}
		}
	};
	add_action( 'created_' . $taxonomy, $save );
	add_action( 'edited_' . $taxonomy, $save );
}

add_action( 'init', function () {
	parsbm_register_term_meta_fields( 'machine_category', array(
		'icon'           => array( 'label' => 'شناسه آیکون', 'type' => 'text', 'hint' => 'مثل i-bottle، i-press، i-layers، i-cap-bottle، i-box' ),
		'external_url'   => array( 'label' => 'لینک جایگزین (اختیاری)', 'type' => 'text', 'hint' => 'اگر این دسته هنوز آرشیو مستقل ندارد، یک لنگر مثل #p-injection وارد کنید تا کارت به آن اشاره کند.' ),
		'display_order'  => array( 'label' => 'ترتیب نمایش', 'type' => 'number' ),
		'capacity_max'   => array( 'label' => 'حداکثر ظرفیت (برای آمار آرشیو)', 'type' => 'text', 'hint' => 'مثل 1000L' ),
		'max_stations'   => array( 'label' => 'حداکثر ایستگاه (برای آمار آرشیو)', 'type' => 'number' ),
		'ticker_items'   => array(
			'label' => 'موارد نوار متحرک هیرو',
			'type'  => 'textarea',
			'hint'  => 'هر خط: آیکون|برچسب — مثال: i-jerrycan|گالن صنعتی',
		),
	) );

	parsbm_register_term_meta_fields( 'faq_category', array(
		'icon'          => array( 'label' => 'شناسه آیکون', 'type' => 'text', 'hint' => 'مثل i-press، i-tag، i-wrench، i-shield، i-cog، i-globe' ),
		'display_order' => array( 'label' => 'ترتیب نمایش', 'type' => 'number' ),
	) );
} );
