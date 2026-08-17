<?php
/**
 * هدر مشترک سایت — هدر دسکتاپ، مگامنوی محصولات، کشوی منوی موبایل.
 *
 * قالب‌های صفحه می‌توانند قبل از فراخوانی get_header() متغیر سراسری
 * $GLOBALS['parsbm_main_attr'] را برای افزودن یک ویژگی HTML به تگ <main>
 * تنظیم کنند (مثل data-search-page یا data-faq-page).
 *
 * @package ParsBM
 */

if ( ! defined( 'ABSPATH' ) ) exit;
?><!doctype html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="theme-color" content="#f7f8fc">
<?php if ( is_404() || is_search() ) : ?><meta name="robots" content="noindex"><?php endif; ?>
<?php if ( ! has_custom_logo() ) : ?>
<link rel="icon" type="image/png" href="<?php echo esc_url( PARSBM_URI . '/assets/img/pars-icon.png' ); ?>">
<link rel="apple-touch-icon" href="<?php echo esc_url( PARSBM_URI . '/assets/img/pars-icon.png' ); ?>">
<?php endif; ?>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main">رفتن به محتوای اصلی</a>

<?php get_template_part( 'template-parts/icon-sprite' ); ?>

<!-- ============================= HEADER ============================= -->
<header class="site-header">
  <div class="container">
    <a class="brand" href="<?php echo esc_url( home_url( '/#home' ) ); ?>" aria-label="پارس بلومولدینگ - بازگشت به خانه">
      <?php if ( has_custom_logo() ) : ?>
        <span class="brand__mark"><?php the_custom_logo(); ?></span>
        <span class="brand__type">
          <strong><?php bloginfo( 'name' ); ?></strong>
          <span><?php bloginfo( 'description' ); ?></span>
        </span>
      <?php else : ?>
        <span class="brand__mark"><img src="<?php echo esc_url( PARSBM_URI . '/assets/img/pars-icon.png' ); ?>" alt="نماد پارس بلومولدینگ" width="38" height="34"></span>
        <span class="brand__type">
          <strong>پارس بلومولدینگ</strong>
          <span>Pars Blow Molding Technology</span>
        </span>
      <?php endif; ?>
    </a>

    <nav aria-label="ناوبری اصلی">
      <?php
      wp_nav_menu( array(
        'theme_location' => 'primary',
        'container'      => false,
        'items_wrap'     => '<ul class="nav-desktop">%3$s</ul>',
        'walker'         => new Walker_Parsbm_Primary(),
        'fallback_cb'    => false,
      ) );
      ?>
    </nav>

    <div class="header-actions">
      <a class="icon-btn" href="<?php echo esc_url( get_search_link() ); ?>" aria-label="جستجو"><svg width="19" height="19"><use href="#i-search"/></svg></a>
      <button class="icon-btn theme-toggle" data-theme-toggle aria-label="تغییر حالت روشن و تاریک">
        <svg class="icon-sun" width="19" height="19"><use href="#i-sun"/></svg>
        <svg class="icon-moon" width="19" height="19"><use href="#i-moon"/></svg>
      </button>
      <a class="btn btn--primary btn--sm header-cta" href="<?php echo esc_url( parsbm_home_anchor( 'contact' ) ); ?>">درخواست مشاوره</a>
      <button class="icon-btn nav-toggle" data-drawer-open aria-label="باز کردن منو" aria-expanded="false">
        <svg width="20" height="20"><use href="#i-menu"/></svg>
      </button>
    </div>
  </div>
</header>

<?php if ( is_singular( 'post' ) ) : ?>
<div class="reading-progress" aria-hidden="true"><div class="reading-progress__bar" data-reading-progress></div></div>
<?php endif; ?>

<!-- ============================= MOBILE DRAWER ============================= -->
<div class="mobile-drawer" data-drawer>
  <div class="mobile-drawer__scrim" data-drawer-close></div>
  <div class="mobile-drawer__panel" role="dialog" aria-modal="true" aria-label="منوی موبایل">
    <div class="mobile-drawer__head">
      <span class="brand">
        <span class="brand__mark"><img src="<?php echo esc_url( PARSBM_URI . '/assets/img/pars-icon.png' ); ?>" alt="" width="32" height="28"></span>
        <span class="brand__type"><strong>پارس بلومولدینگ</strong></span>
      </span>
      <button class="icon-btn" data-drawer-close aria-label="بستن منو"><svg width="18" height="18"><use href="#i-close"/></svg></button>
    </div>

    <?php
    wp_nav_menu( array(
      'theme_location' => 'primary',
      'container'      => false,
      'items_wrap'     => '<ul class="mobile-nav-list">%3$s</ul>',
      'walker'         => new Walker_Parsbm_Mobile(),
      'fallback_cb'    => false,
    ) );
    ?>

    <div class="mobile-drawer__foot">
      <a class="btn btn--primary btn--block" href="<?php echo esc_url( parsbm_home_anchor( 'contact' ) ); ?>">درخواست مشاوره</a>
      <div class="mobile-contact-row"><svg width="16" height="16"><use href="#i-phone"/></svg> <?php echo esc_html( parsbm_opt( 'contact_phone_display' ) ); ?></div>
      <div class="mobile-contact-row"><svg width="16" height="16"><use href="#i-mail"/></svg> <?php echo esc_html( parsbm_opt( 'contact_email' ) ); ?></div>
    </div>
  </div>
</div>

<div class="page-shell">
<main id="main"<?php echo isset( $GLOBALS['parsbm_main_attr'] ) ? ' ' . $GLOBALS['parsbm_main_attr'] : ''; ?>>
