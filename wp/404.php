<?php
/**
 * صفحه ۴۰۴ — معادل کامل 404.html استاتیک.
 *
 * @package ParsBM
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
$latest_post = get_posts( array( 'post_type' => 'post', 'posts_per_page' => 1 ) );
?>

<!-- ============================= 404 HERO ============================= -->
<section class="notfound-hero">
  <div class="hero__grid" aria-hidden="true"></div>
  <div class="hero__glow" aria-hidden="true"></div>
  <div class="container notfound-inner">

    <div class="notfound-figure">
      <span class="notfound-chip hero__chip hero__chip--a"><svg width="18" height="18"><use href="#i-bottle"/></svg> این محصول پیدا نشد</span>
      <span class="notfound-digit">4</span>
      <span class="notfound-gear" aria-hidden="true"><svg><use href="#i-cog"/></svg></span>
      <span class="notfound-digit">4</span>
      <span class="notfound-chip hero__chip hero__chip--b"><svg width="18" height="18"><use href="#i-wrench"/></svg> در حال تعمیر مسیر</span>
    </div>

    <span class="eyebrow" style="background:rgba(255,255,255,.12); color:#ffd98a;">خطای ۴۰۴</span>
    <h1>این صفحه از خط تولید ما گم شده!</h1>
    <p>به نظر می‌رسد صفحه‌ای که دنبالش بودید جابه‌جا شده یا دیگر وجود ندارد. نگران نباشید — مسیر درست را برایتان پیدا می‌کنیم.</p>

    <form class="notfound-search" role="search" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
      <input type="search" name="s" placeholder="جستجو در محصولات، مدل‌ها و مقالات...">
      <button type="submit" aria-label="جستجو"><svg><use href="#i-search"/></svg></button>
    </form>

    <div class="hero__actions" style="justify-content:center;">
      <a class="btn btn--primary" href="<?php echo esc_url( home_url( '/#home' ) ); ?>">بازگشت به خانه <svg width="16" height="16"><use href="#i-arrow-fwd"/></svg></a>
      <?php $first_cat = parsbm_get_terms_ordered( 'machine_category' ); ?>
      <a class="btn btn--ghost btn--on-dark" href="<?php echo esc_url( ! empty( $first_cat ) ? parsbm_term_url( $first_cat[0] ) : home_url( '/#products' ) ); ?>">مشاهده محصولات</a>
    </div>
  </div>
</section>

<!-- ============================= QUICK LINKS ============================= -->
<section class="section">
  <div class="container">
    <div class="section-head" data-reveal>
      <span class="eyebrow">مسیرهای پیشنهادی</span>
      <h2 class="section-title">شاید دنبال یکی از این‌ها بودید</h2>
    </div>
    <div class="quicklink-grid" data-reveal-group>
      <a class="quicklink-card" href="<?php echo esc_url( home_url( '/#home' ) ); ?>" data-reveal>
        <span class="quicklink-card__icon"><svg><use href="#i-home"/></svg></span>
        <strong>صفحه اصلی</strong>
      </a>
      <a class="quicklink-card" href="<?php echo esc_url( ! empty( $first_cat ) ? parsbm_term_url( $first_cat[0] ) : home_url( '/' ) ); ?>" data-reveal>
        <span class="quicklink-card__icon"><svg><use href="#i-grid"/></svg></span>
        <strong>محصولات</strong>
      </a>
      <a class="quicklink-card" href="<?php echo esc_url( home_url( '/#samples' ) ); ?>" data-reveal>
        <span class="quicklink-card__icon"><svg><use href="#i-gallery"/></svg></span>
        <strong>نمونه محصولات</strong>
      </a>
      <a class="quicklink-card" href="<?php echo esc_url( $latest_post ? get_permalink( $latest_post[0] ) : home_url( '/' ) ); ?>" data-reveal>
        <span class="quicklink-card__icon"><svg><use href="#i-newspaper"/></svg></span>
        <strong>مقالات و راهنما</strong>
      </a>
      <a class="quicklink-card" href="<?php echo esc_url( home_url( '/#services' ) ); ?>" data-reveal>
        <span class="quicklink-card__icon"><svg><use href="#i-wrench"/></svg></span>
        <strong>خدمات ویژه</strong>
      </a>
      <a class="quicklink-card" href="<?php echo esc_url( home_url( '/#contact' ) ); ?>" data-reveal>
        <span class="quicklink-card__icon"><svg><use href="#i-phone"/></svg></span>
        <strong>تماس با ما</strong>
      </a>
    </div>
  </div>
</section>

<!-- ============================= CATEGORIES ============================= -->
<section class="section section-bg-alt">
  <div class="container">
    <div class="section-head" data-reveal>
      <span class="eyebrow">دسته‌بندی محصولات</span>
      <h2 class="section-title">یا مستقیم به یکی از دسته‌ها بروید</h2>
    </div>
    <?php parsbm_other_cats_nav( 0, 'justify-content:center;' ); ?>
  </div>
</section>

<?php get_footer(); ?>
