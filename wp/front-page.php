<?php
/**
 * صفحه اصلی — معادل کامل index.html استاتیک.
 *
 * @package ParsBM
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$GLOBALS['parsbm_active_bottom_key'] = 'home';
get_header();

$home_slides = new WP_Query( array(
	'post_type'      => 'hero_slide',
	'posts_per_page' => -1,
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
	'meta_key'       => '_slide_placement',
	'meta_value'     => 'home',
) );
?>

<!-- ============================= HERO SLIDER ============================= -->
<section id="home" class="hero" data-hero-slider aria-roledescription="اسلایدر" aria-label="معرفی پارس بلومولدینگ">
  <div class="hero__grid" aria-hidden="true"></div>
  <div class="hero__glow" aria-hidden="true"></div>

  <div class="container">
    <div class="hero__slides">
      <?php
      $i = 0;
      while ( $home_slides->have_posts() ) : $home_slides->the_post();
        $pid    = get_the_ID();
        $active = ( 0 === $i ) ? ' is-active' : '';
        $stats  = parsbm_parse_pairs( get_post_meta( $pid, '_slide_stats', true ) );
        $image  = parsbm_post_image_url( $pid, '_slide_image_url', 'parsbm-hero-photo' );
      ?>
      <div class="hero__slide<?php echo esc_attr( $active ); ?>">
        <div class="hero__inner">
          <div>
            <span class="hero__tag"><svg width="14" height="14"><use href="#<?php echo esc_attr( get_post_meta( $pid, '_slide_tag_icon', true ) ?: 'i-factory' ); ?>"/></svg> <?php echo esc_html( get_post_meta( $pid, '_slide_tag_text', true ) ); ?></span>
            <h1 class="hero__title"><?php echo esc_html( get_post_meta( $pid, '_slide_title_pre', true ) ); ?><em><?php echo esc_html( get_post_meta( $pid, '_slide_title_em', true ) ); ?></em><?php echo esc_html( get_post_meta( $pid, '_slide_title_post', true ) ); ?></h1>
            <p class="hero__desc"><?php echo esc_html( get_the_content() ); ?></p>
            <div class="hero__actions">
              <a class="btn btn--primary" href="<?php echo esc_url( parsbm_resolve_url( get_post_meta( $pid, '_slide_cta1_url', true ) ) ); ?>"><?php echo esc_html( get_post_meta( $pid, '_slide_cta1_label', true ) ); ?> <svg width="16" height="16"><use href="#i-arrow-fwd"/></svg></a>
              <a class="btn btn--ghost btn--on-dark" href="<?php echo esc_url( parsbm_resolve_url( get_post_meta( $pid, '_slide_cta2_url', true ) ) ); ?>"><?php echo esc_html( get_post_meta( $pid, '_slide_cta2_label', true ) ); ?></a>
            </div>
            <div class="hero__stats">
              <?php parsbm_render_stats( $stats ); ?>
            </div>
          </div>
          <div class="hero__visual">
            <div class="hero__frame-wrap">
              <div class="hero__ring" aria-hidden="true"></div>
              <div class="hero__frame">
                <span class="hero__corner hero__corner--tl" aria-hidden="true"></span>
                <span class="hero__corner hero__corner--br" aria-hidden="true"></span>
                <img class="hero__photo" src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
              </div>
              <span class="hero__chip hero__chip--a"><svg width="18" height="18"><use href="#i-check"/></svg> <?php echo esc_html( get_post_meta( $pid, '_slide_chip1', true ) ); ?></span>
              <span class="hero__chip hero__chip--b"><svg width="18" height="18"><use href="#i-check"/></svg> <?php echo esc_html( get_post_meta( $pid, '_slide_chip2', true ) ); ?></span>
            </div>
          </div>
        </div>
      </div>
      <?php $i++; endwhile; wp_reset_postdata(); ?>
    </div>
  </div>

  <div class="container hero__controls">
    <div class="hero__dots" data-hero-dots role="tablist" aria-label="انتخاب اسلاید"></div>
    <div class="hero__arrows">
      <button type="button" data-hero-prev aria-label="اسلاید قبلی" style="transform:scaleX(-1)"><svg width="18" height="18"><use href="#i-arrow-fwd"/></svg></button>
      <button type="button" data-hero-next aria-label="اسلاید بعدی"><svg width="18" height="18"><use href="#i-arrow-fwd"/></svg></button>
    </div>
  </div>
</section>

<!-- ============================= ABOUT ============================= -->
<section id="about" class="section">
  <div class="container about">
    <div class="about__visual" data-reveal>
      <svg viewBox="0 0 24 24" style="color:#fff"><use href="#i-factory"/></svg>
      <div class="about__badge">
        <svg width="30" height="30" style="color:var(--color-accent)"><use href="#i-award"/></svg>
        <span><strong><?php echo esc_html( parsbm_opt( 'about_badge_number' ) ); ?></strong><span><?php echo esc_html( parsbm_opt( 'about_badge_label' ) ); ?></span></span>
      </div>
    </div>
    <div data-reveal>
      <span class="eyebrow"><?php echo esc_html( parsbm_opt( 'about_eyebrow' ) ); ?></span>
      <h2 class="section-title"><?php echo esc_html( parsbm_opt( 'about_title' ) ); ?></h2>
      <p class="section-desc"><?php echo esc_html( parsbm_opt( 'about_desc' ) ); ?></p>
      <ul class="about__list">
        <?php foreach ( parsbm_parse_lines( parsbm_opt( 'about_checklist' ) ) as $item ) : ?>
          <li><svg width="22" height="22"><use href="#i-check"/></svg> <?php echo esc_html( $item ); ?></li>
        <?php endforeach; ?>
      </ul>
      <div class="about__stats">
        <?php
        parsbm_render_stats( array(
          array( parsbm_opt( 'about_stat1_value' ), parsbm_opt( 'about_stat1_suffix' ), parsbm_opt( 'about_stat1_label' ) ),
          array( parsbm_opt( 'about_stat2_value' ), parsbm_opt( 'about_stat2_suffix' ), parsbm_opt( 'about_stat2_label' ) ),
          array( parsbm_opt( 'about_stat3_value' ), parsbm_opt( 'about_stat3_suffix' ), parsbm_opt( 'about_stat3_label' ) ),
        ) );
        ?>
      </div>
      <div style="margin-top:var(--space-lg)">
        <a class="btn btn--primary" href="<?php echo esc_url( parsbm_home_anchor( 'contact' ) ); ?>">آشنایی بیشتر با تیم ما <svg width="16" height="16"><use href="#i-arrow-fwd"/></svg></a>
      </div>
    </div>
  </div>
</section>

<!-- ============================= PRODUCTS ============================= -->
<section id="products" class="section section-bg-alt">
  <div class="container">
    <div class="section-head" data-reveal>
      <span class="eyebrow">محصولات</span>
      <h2 class="section-title">انواع دستگاه‌های پارس بلومولدینگ</h2>
      <p class="section-desc">از تولید بطری تا قطعات فنی؛ خطوط کامل ماشین‌آلات بادی و تزریق پلاستیک، طراحی‌شده برای بازدهی بالا و نگهداری آسان.</p>
    </div>

    <div class="product-grid" data-reveal-group>
      <?php
      $n = 0;
      foreach ( parsbm_get_terms_ordered( 'machine_category' ) as $term ) :
        $n++;
        $icon = get_term_meta( $term->term_id, 'icon', true ) ?: 'i-box';
      ?>
      <article class="product-card" id="p-<?php echo esc_attr( $term->slug ); ?>" data-reveal>
        <div class="product-card__art"><span class="product-card__num"><?php echo esc_html( parsbm_fa_number( $n ) ); ?></span><svg viewBox="0 0 24 24"><use href="#<?php echo esc_attr( $icon ); ?>"/></svg></div>
        <h3><?php echo esc_html( $term->name ); ?></h3>
        <p><?php echo esc_html( $term->description ); ?></p>
        <a class="product-card__link" href="<?php echo esc_url( parsbm_term_url( $term ) ); ?>">مشاهده مدل‌های دستگاه <svg width="16" height="16"><use href="#i-arrow-fwd"/></svg></a>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============================= PRODUCT SAMPLES ============================= -->
<section id="samples" class="section">
  <div class="container">
    <div class="section-head" data-reveal>
      <span class="eyebrow">نمونه محصولات</span>
      <h2 class="section-title">نمونه‌کارهای تولیدشده روی دستگاه‌های پارس</h2>
      <p class="section-desc">گزیده‌ای از محصولات نهایی مشتریان پارس بلومولدینگ روی خطوط اکستروژن، تزریق و بادکن PET.</p>
    </div>

    <?php $sample_terms = parsbm_get_terms_ordered( 'sample_type' ); ?>
    <div class="filter-tabs" role="tablist" aria-label="فیلتر نمونه محصولات">
      <button type="button" class="is-active" data-filter="all">همه</button>
      <?php foreach ( $sample_terms as $st ) : ?>
        <button type="button" data-filter="<?php echo esc_attr( $st->slug ); ?>"><?php echo esc_html( $st->name ); ?></button>
      <?php endforeach; ?>
    </div>

    <div class="sample-grid">
      <?php
      $samples = new WP_Query( array( 'post_type' => 'sample', 'posts_per_page' => -1, 'orderby' => 'menu_order', 'order' => 'ASC' ) );
      while ( $samples->have_posts() ) : $samples->the_post();
        $terms = get_the_terms( get_the_ID(), 'sample_type' );
        $t     = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0] : null;
        $icon  = $t ? ( get_term_meta( $t->term_id, 'icon', true ) ?: 'i-box' ) : 'i-box';
      ?>
      <div class="sample-card" data-sample-cat="<?php echo esc_attr( $t ? $t->slug : '' ); ?>" data-reveal>
        <div class="sample-card__art"><svg viewBox="0 0 24 24"><use href="#<?php echo esc_attr( $icon ); ?>"/></svg></div>
        <div class="sample-card__body"><span><?php echo esc_html( $t ? $t->name : '' ); ?></span><h4><?php the_title(); ?></h4></div>
      </div>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
  </div>
</section>

<!-- ============================= SERVICES ============================= -->
<section id="services" class="section section-bg-alt">
  <div class="container services">
    <div class="services__intro" data-reveal>
      <span class="eyebrow"><?php echo esc_html( parsbm_opt( 'services_eyebrow' ) ); ?></span>
      <h2 class="section-title"><?php echo esc_html( parsbm_opt( 'services_title' ) ); ?></h2>
      <p><?php echo esc_html( parsbm_opt( 'services_desc' ) ); ?></p>
      <div class="services__stats">
        <?php
        parsbm_render_stats( array(
          array( parsbm_opt( 'services_stat1_value' ), parsbm_opt( 'services_stat1_suffix' ), parsbm_opt( 'services_stat1_label' ) ),
          array( parsbm_opt( 'services_stat2_value' ), parsbm_opt( 'services_stat2_suffix' ), parsbm_opt( 'services_stat2_label' ) ),
        ) );
        ?>
      </div>
    </div>

    <div class="service-grid" data-reveal-group>
      <?php
      $services = new WP_Query( array( 'post_type' => 'service', 'posts_per_page' => -1, 'orderby' => 'menu_order', 'order' => 'ASC' ) );
      while ( $services->have_posts() ) : $services->the_post();
        $icon = get_post_meta( get_the_ID(), '_service_icon', true ) ?: 'i-cog';
      ?>
      <div class="service-card" data-reveal>
        <div class="service-card__icon"><svg width="26" height="26"><use href="#<?php echo esc_attr( $icon ); ?>"/></svg></div>
        <h3><?php the_title(); ?></h3>
        <p><?php echo esc_html( get_the_excerpt() ); ?></p>
      </div>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
  </div>
</section>

<!-- ============================= CTA BANNER ============================= -->
<section class="section section--tight">
  <div class="container">
    <div class="cta-banner" data-reveal>
      <div class="cta-banner__text">
        <h3><?php echo esc_html( parsbm_opt( 'cta_home_title' ) ); ?></h3>
        <p><?php echo esc_html( parsbm_opt( 'cta_home_desc' ) ); ?></p>
      </div>
      <div class="cta-banner__actions">
        <a class="btn btn--primary" href="<?php echo esc_url( parsbm_home_anchor( 'contact' ) ); ?>">درخواست مشاوره رایگان</a>
        <a class="btn btn--ghost btn--on-dark" href="tel:<?php echo esc_attr( parsbm_opt( 'contact_phone' ) ); ?>"><svg width="16" height="16"><use href="#i-phone"/></svg> تماس تلفنی</a>
      </div>
    </div>
  </div>
</section>

<!-- ============================= TRUST STRIP ============================= -->
<section class="section--tight">
  <div class="container trust-strip" data-reveal>
    <div class="trust-item"><svg><use href="#i-award"/></svg> <?php echo esc_html( parsbm_opt( 'trust_item1' ) ); ?></div>
    <div class="trust-item"><svg><use href="#i-globe"/></svg> <?php echo esc_html( parsbm_opt( 'trust_item2' ) ); ?></div>
    <div class="trust-item"><svg><use href="#i-shield"/></svg> <?php echo esc_html( parsbm_opt( 'trust_item3' ) ); ?></div>
    <div class="trust-item"><svg><use href="#i-star"/></svg> <?php echo esc_html( parsbm_opt( 'trust_item4' ) ); ?></div>
  </div>
</section>

<!-- ============================= CONTACT ============================= -->
<section id="contact" class="section section-bg-alt">
  <div class="container">
    <div class="section-head" data-reveal>
      <span class="eyebrow">تماس با ما</span>
      <h2 class="section-title">مشاوره رایگان و استعلام قیمت</h2>
      <p class="section-desc">فرم زیر را تکمیل کنید تا کارشناسان پارس بلومولدینگ در کوتاه‌ترین زمان با شما تماس بگیرند.</p>
    </div>

    <div class="contact-layout">
      <div class="contact-info-grid" data-reveal-group>
        <div class="service-card contact-info-card" data-reveal>
          <div class="service-card__icon"><svg width="26" height="26"><use href="#i-pin"/></svg></div>
          <h3>آدرس کارخانه</h3>
          <p style="direction:rtl"><?php echo esc_html( parsbm_opt( 'contact_address' ) ); ?></p>
        </div>
        <div class="service-card contact-info-card" data-reveal>
          <div class="service-card__icon"><svg width="26" height="26"><use href="#i-phone"/></svg></div>
          <h3>تلفن تماس</h3>
          <p><?php echo esc_html( parsbm_opt( 'contact_phone_display' ) ); ?></p>
        </div>
        <div class="service-card contact-info-card" data-reveal>
          <div class="service-card__icon"><svg width="26" height="26"><use href="#i-mail"/></svg></div>
          <h3>ایمیل</h3>
          <p><?php echo esc_html( parsbm_opt( 'contact_email' ) ); ?></p>
        </div>
      </div>

      <form class="contact-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" data-reveal>
        <?php if ( isset( $_GET['contact'] ) && 'sent' === $_GET['contact'] ) : ?>
          <div class="contact-form__notice contact-form__notice--ok">درخواست شما با موفقیت ارسال شد؛ به‌زودی با شما تماس می‌گیریم.</div>
        <?php elseif ( isset( $_GET['contact'] ) && 'error' === $_GET['contact'] ) : ?>
          <div class="contact-form__notice contact-form__notice--err">لطفاً نام و شماره تماس را کامل وارد کنید.</div>
        <?php endif; ?>
        <input type="hidden" name="action" value="parsbm_contact">
        <input type="text" name="website" value="" autocomplete="off" tabindex="-1" style="position:absolute;left:-9999px;" aria-hidden="true">
        <?php wp_nonce_field( 'parsbm_contact', 'parsbm_contact_nonce' ); ?>
        <div class="contact-form__row">
          <label>نام و نام‌خانوادگی
            <input type="text" name="name" required placeholder="مثلاً: علی رضایی">
          </label>
          <label>شماره تماس
            <input type="tel" name="phone" required placeholder="۰۹۱۲XXXXXXX">
          </label>
        </div>
        <label>محصول مورد نظر
          <select name="product">
            <?php foreach ( parsbm_get_terms_ordered( 'machine_category' ) as $term ) : ?>
              <option><?php echo esc_html( $term->name ); ?></option>
            <?php endforeach; ?>
          </select>
        </label>
        <label>پیام شما
          <textarea name="message" rows="4" placeholder="نیاز خود را شرح دهید..."></textarea>
        </label>
        <button type="submit" class="btn btn--primary btn--block">ارسال درخواست</button>
      </form>
    </div>
  </div>
</section>

<?php get_footer(); ?>
