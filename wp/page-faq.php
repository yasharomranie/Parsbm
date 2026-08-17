<?php
/**
 * Template Name: صفحه سوالات متداول
 * قالب صفحه سوالات متداول — معادل کامل faq.html استاتیک، با دسته‌بندی و
 * جستجوی زنده (main.js's [data-faq-page] handler, بدون تغییر).
 *
 * @package ParsBM
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$GLOBALS['parsbm_main_attr'] = 'data-faq-page';
get_header();

$cat_terms  = parsbm_get_terms_ordered( 'faq_category' );
$faq_count  = (int) wp_count_posts( 'faq' )->publish;
$cat_count  = count( $cat_terms );
?>

<div class="container">
  <nav class="breadcrumb" aria-label="مسیر صفحه">
    <a href="<?php echo esc_url( home_url( '/#home' ) ); ?>">خانه</a>
    <span class="breadcrumb__sep">/</span>
    <span class="breadcrumb__current">سوالات متداول</span>
  </nav>
</div>

<!-- ============================= FAQ HERO ============================= -->
<section class="faq-hero">
  <div class="hero__grid" aria-hidden="true"></div>
  <span class="faq-hero__mark" aria-hidden="true">؟</span>
  <div class="container faq-hero__inner">
    <span class="eyebrow" style="background:rgba(255,255,255,.12); color:#ffd98a;">مرکز راهنمایی</span>
    <h1><?php the_title(); ?></h1>
    <p class="faq-hero__desc">از انتخاب مدل دستگاه تا گارانتی و صادرات؛ پاسخ <?php echo esc_html( parsbm_fa_number( $faq_count ) ); ?> سوال پرتکرار مشتریان را در <?php echo esc_html( parsbm_fa_number( $cat_count ) ); ?> دسته جمع کرده‌ایم.</p>

    <form class="faq-search" data-faq-search-form role="search">
      <input type="search" data-faq-search-input placeholder="سوال خود را جستجو کنید...">
      <button type="submit" aria-label="جستجو"><svg><use href="#i-search"/></svg></button>
    </form>

    <div class="faq-hero__stats">
      <div><strong data-counter="<?php echo esc_attr( $faq_count ); ?>" data-counter-suffix="">۰</strong><span>سوال پاسخ‌داده‌شده</span></div>
      <div><strong data-counter="<?php echo esc_attr( $cat_count ); ?>" data-counter-suffix="">۰</strong><span>دسته‌بندی</span></div>
      <div><strong data-counter="24" data-counter-suffix="/۷">۰</strong><span>پشتیبانی فنی</span></div>
    </div>
  </div>
</section>

<!-- ============================= CONTROL PANEL CATEGORY SELECTOR ============================= -->
<section class="section">
  <div class="container">
    <div class="faq-categories" data-reveal-group>
      <?php foreach ( $cat_terms as $term ) :
        $icon = get_term_meta( $term->term_id, 'icon', true ) ?: 'i-press';
      ?>
      <a class="faq-cat-btn" href="#cat-<?php echo esc_attr( $term->slug ); ?>" data-faq-cat data-reveal>
        <span class="faq-cat-btn__led" aria-hidden="true"></span>
        <span class="faq-cat-btn__icon"><svg><use href="#<?php echo esc_attr( $icon ); ?>"/></svg></span>
        <strong><?php echo esc_html( $term->name ); ?></strong>
        <span><?php echo esc_html( parsbm_fa_number( $term->count ) ); ?> سوال</span>
      </a>
      <?php endforeach; ?>
    </div>

    <p class="search-meta__count" data-faq-count style="text-align:center; margin-bottom:var(--space-md);"></p>

    <!-- ============================= FAQ GROUPS ============================= -->
    <div style="max-width:820px; margin-inline:auto;">
      <?php foreach ( $cat_terms as $term ) :
        $icon = get_term_meta( $term->term_id, 'icon', true ) ?: 'i-press';
        $items = new WP_Query( array(
          'post_type'      => 'faq',
          'posts_per_page' => -1,
          'orderby'        => 'meta_value_num',
          'meta_key'       => '_faq_order',
          'order'          => 'ASC',
          'tax_query'      => array( array( 'taxonomy' => 'faq_category', 'field' => 'term_id', 'terms' => $term->term_id ) ),
        ) );
      ?>
      <div class="faq-group" id="cat-<?php echo esc_attr( $term->slug ); ?>" data-faq-group>
        <div class="faq-group__head">
          <span class="faq-group__icon"><svg><use href="#<?php echo esc_attr( $icon ); ?>"/></svg></span>
          <div><h2><?php echo esc_html( $term->name ); ?></h2><span><?php echo esc_html( $term->description ); ?></span></div>
        </div>
        <div class="faq-list">
          <?php while ( $items->have_posts() ) : $items->the_post(); ?>
            <div class="faq-item" data-faq-searchable>
              <button class="faq-item__q" aria-expanded="false"><?php the_title(); ?><svg width="18" height="18"><use href="#i-chevron-down"/></svg></button>
              <div class="faq-item__a"><div><?php the_content(); ?></div></div>
            </div>
          <?php endwhile; wp_reset_postdata(); ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <div class="search-empty" data-faq-empty hidden>
      <span class="search-empty__icon"><svg><use href="#i-search"/></svg></span>
      <h2>سوالی با این عبارت پیدا نشد</h2>
      <p>می‌توانید مستقیماً از کارشناسان ما بپرسید.</p>
      <a class="btn btn--primary" href="<?php echo esc_url( home_url( '/#contact' ) ); ?>">تماس با ما</a>
    </div>
  </div>
</section>

<!-- ============================= CTA ============================= -->
<section class="section section--tight section-bg-alt">
  <div class="container">
    <div class="cta-banner faq-cta" data-reveal>
      <div class="cta-banner__text">
        <h3><?php echo esc_html( parsbm_opt( 'cta_faq_title' ) ); ?></h3>
        <p><?php echo esc_html( parsbm_opt( 'cta_faq_desc' ) ); ?></p>
      </div>
      <div class="cta-banner__actions">
        <a class="btn btn--primary" href="<?php echo esc_url( home_url( '/#contact' ) ); ?>">تماس با کارشناسان</a>
        <a class="btn btn--ghost btn--on-dark" href="tel:<?php echo esc_attr( parsbm_opt( 'contact_phone' ) ); ?>"><svg width="16" height="16"><use href="#i-phone"/></svg> <?php echo esc_html( parsbm_opt( 'contact_phone_display' ) ); ?></a>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>
