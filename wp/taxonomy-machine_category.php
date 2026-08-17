<?php
/**
 * آرشیو یک دسته محصول (دستگاه‌ها) — معادل کامل category.html استاتیک،
 * با هیرو، مقدمه، گرید مدل‌ها و صفحه‌بندی واقعی وردپرس (نه جاوااسکریپتی).
 *
 * @package ParsBM
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$term = get_queried_object();

$GLOBALS['parsbm_active_bottom_key'] = 'products';
get_header();

parsbm_breadcrumb( array(
	array( 'label' => 'خانه', 'url' => home_url( '/#home' ) ),
	array( 'label' => 'محصولات', 'url' => home_url( '/#products' ) ),
	array( 'label' => $term->name ),
) );

$slides = new WP_Query( array(
	'post_type'      => 'hero_slide',
	'posts_per_page' => -1,
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
	'meta_key'       => '_slide_placement',
	'meta_value'     => $term->slug,
) );
?>

<?php if ( $slides->have_posts() ) : ?>
<!-- ============================= CATEGORY HERO SLIDER =============================
     عمداً یک سیستم بصری متفاوت از هیروی صفحه اصلی: موزاییک محصولات پراکنده
     به‌جای یک قاب عکس، شماره بزرگ خط‌دار به‌جای ردیف آمار، و نوار متحرک آیکون
     به‌جای رینگ ثابت. ========================================================== -->
<section class="hero hero--compact hero--catalog" data-hero-slider aria-roledescription="اسلایدر" aria-label="محصولات قابل تولید با دستگاه‌های <?php echo esc_attr( $term->name ); ?>">
  <div class="hero__grid" aria-hidden="true"></div>
  <div class="hero__ribbon" aria-hidden="true"></div>

  <div class="container">
    <div class="hero__slides">
      <?php
      $i = 0;
      while ( $slides->have_posts() ) : $slides->the_post();
        $pid    = get_the_ID();
        $active = ( 0 === $i ) ? ' is-active' : '';
        $mosaic = parsbm_parse_pairs( get_post_meta( $pid, '_slide_mosaic', true ) );
      ?>
      <div class="hero__slide<?php echo esc_attr( $active ); ?>">
        <div class="hero__inner hero__inner--catalog">
          <div>
            <span class="hero__index" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
            <span class="hero__tag"><svg width="14" height="14"><use href="#<?php echo esc_attr( get_post_meta( $pid, '_slide_tag_icon', true ) ?: 'i-box' ); ?>"/></svg> <?php echo esc_html( get_post_meta( $pid, '_slide_tag_text', true ) ); ?></span>
            <h1 class="hero__title"><?php echo esc_html( get_post_meta( $pid, '_slide_title_pre', true ) ); ?><em><?php echo esc_html( get_post_meta( $pid, '_slide_title_em', true ) ); ?></em><?php echo esc_html( get_post_meta( $pid, '_slide_title_post', true ) ); ?></h1>
            <p class="hero__desc"><?php echo esc_html( get_the_content() ); ?></p>
            <div class="hero__actions">
              <a class="btn btn--primary" href="<?php echo esc_url( parsbm_resolve_url( get_post_meta( $pid, '_slide_cta1_url', true ) ) ); ?>"><?php echo esc_html( get_post_meta( $pid, '_slide_cta1_label', true ) ); ?> <svg width="16" height="16"><use href="#i-arrow-fwd"/></svg></a>
              <a class="btn btn--ghost btn--on-dark" href="<?php echo esc_url( parsbm_resolve_url( get_post_meta( $pid, '_slide_cta2_url', true ) ) ); ?>"><?php echo esc_html( get_post_meta( $pid, '_slide_cta2_label', true ) ); ?></a>
            </div>
          </div>
          <div class="hero__visual">
            <div class="mosaic">
              <?php foreach ( array_slice( $mosaic, 0, 5 ) as $idx => $tile ) : if ( count( $tile ) < 2 ) continue; ?>
                <div class="mosaic__tile mosaic__tile--<?php echo esc_attr( $idx + 1 ); ?>"><div class="mosaic__tile__inner"><svg><use href="#<?php echo esc_attr( $tile[0] ); ?>"/></svg><?php echo esc_html( $tile[1] ); ?></div></div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
      <?php $i++; endwhile; wp_reset_postdata(); ?>
    </div>
  </div>

  <?php $ticker = parsbm_parse_pairs( get_term_meta( $term->term_id, 'ticker_items', true ) ); ?>
  <?php if ( ! empty( $ticker ) ) : ?>
  <div class="hero__ticker" aria-hidden="true">
    <div class="hero__ticker__track">
      <?php
      // آیتم‌ها دو بار چاپ می‌شوند تا حلقه ۵۰٪ بدون پرش دیده شود.
      for ( $rep = 0; $rep < 2; $rep++ ) :
        foreach ( $ticker as $tick ) : if ( count( $tick ) < 2 ) continue; ?>
        <span class="hero__ticker__item"><svg><use href="#<?php echo esc_attr( $tick[0] ); ?>"/></svg><?php echo esc_html( $tick[1] ); ?></span>
      <?php endforeach; endfor; ?>
    </div>
  </div>
  <?php endif; ?>

  <div class="container hero__controls">
    <div class="hero__tabs" data-hero-dots role="tablist" aria-label="انتخاب اسلاید"></div>
    <div class="hero__arrows">
      <button type="button" data-hero-prev aria-label="اسلاید قبلی" style="transform:scaleX(-1)"><svg width="18" height="18"><use href="#i-arrow-fwd"/></svg></button>
      <button type="button" data-hero-next aria-label="اسلاید بعدی"><svg width="18" height="18"><use href="#i-arrow-fwd"/></svg></button>
    </div>
  </div>
</section>
<?php else : wp_reset_postdata(); endif; ?>

<!-- ============================= CATEGORY INTRO ============================= -->
<section class="section section--tight">
  <div class="container cat-intro">
    <div data-reveal>
      <span class="eyebrow"><?php echo esc_html( $term->name ); ?></span>
      <h2 class="section-title">فناوری <?php echo esc_html( $term->name ); ?> پارس بلومولدینگ</h2>
      <p><?php echo esc_html( $term->description ); ?></p>
      <div style="margin-top:var(--space-md)">
        <?php parsbm_other_cats_nav( $term->term_id ); ?>
      </div>
    </div>
    <?php
    $capacity = get_term_meta( $term->term_id, 'capacity_max', true );
    $cap_val  = $capacity; $cap_suffix = '';
    if ( preg_match( '/^([\d.]+)(.*)$/', (string) $capacity, $m ) ) { $cap_val = $m[1]; $cap_suffix = $m[2]; }
    ?>
    <div class="cat-stats" data-reveal>
      <?php
      parsbm_render_stats( array(
        array( (int) $term->count, '+', 'مدل دستگاه' ),
        array( $cap_val ?: 0, $cap_suffix, 'حداکثر ظرفیت' ),
        array( (int) get_term_meta( $term->term_id, 'max_stations', true ), '', 'حداکثر ایستگاه' ),
      ) );
      ?>
    </div>
  </div>
</section>

<!-- ============================= MACHINE GRID ============================= -->
<section id="machines" class="section section-bg-alt">
  <div class="container">
    <div class="section-head" data-reveal>
      <span class="eyebrow">مدل‌های دستگاه</span>
      <h2 class="section-title">مدل‌های دستگاه <?php echo esc_html( $term->name ); ?> پارس</h2>
      <p class="section-desc">مدل مناسب ظرفیت و محصول خود را انتخاب کنید؛ برای مشاوره فنی و استعلام قیمت با کارشناسان ما در تماس باشید.</p>
    </div>

    <?php
    $paged = max( 1, (int) get_query_var( 'paged' ) );
    $machines_q = new WP_Query( array(
      'post_type'      => 'machine',
      'posts_per_page' => 12,
      'paged'          => $paged,
      'orderby'        => 'menu_order',
      'order'          => 'ASC',
      'tax_query'      => array( array( 'taxonomy' => 'machine_category', 'field' => 'term_id', 'terms' => $term->term_id ) ),
    ) );
    ?>

    <div class="machine-grid" id="machine-grid">
      <?php if ( $machines_q->have_posts() ) : while ( $machines_q->have_posts() ) : $machines_q->the_post();
        $mid   = get_the_ID();
        $specs = array_filter( array_map( 'trim', explode( ',', get_post_meta( $mid, '_machine_specs', true ) ) ) );
        $cta_l = get_post_meta( $mid, '_machine_cta_label', true ) ?: 'استعلام قیمت';
        $cta_u = get_post_meta( $mid, '_machine_cta_url', true ) ?: '#contact';
        $image = parsbm_post_image_url( $mid, '_machine_image_url' );
      ?>
      <article class="machine-card" data-reveal>
        <div class="machine-card__art"><img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy"></div>
        <h3><?php the_title(); ?></h3>
        <div class="machine-card__specs">
          <?php foreach ( $specs as $spec ) : ?><span class="spec-chip"><?php echo esc_html( $spec ); ?></span><?php endforeach; ?>
        </div>
        <p><?php echo esc_html( get_the_excerpt() ); ?></p>
        <a class="machine-card__link" href="<?php echo esc_url( parsbm_resolve_url( $cta_u ) ); ?>"><?php echo esc_html( $cta_l ); ?> <svg><use href="#i-arrow-fwd"/></svg></a>
      </article>
      <?php endwhile; else : ?>
        <p>در حال حاضر مدلی برای این دسته ثبت نشده است.</p>
      <?php endif; ?>
    </div>

    <?php if ( $machines_q->max_num_pages > 1 ) : ?>
    <nav class="pagination" aria-label="صفحه‌بندی محصولات">
      <?php
      $total = (int) $machines_q->max_num_pages;
      $prev_disabled = $paged <= 1;
      $next_disabled = $paged >= $total;
      ?>
      <a<?php echo $prev_disabled ? ' aria-disabled="true"' : ''; ?> style="transform:scaleX(-1)" href="<?php echo esc_url( $prev_disabled ? '#' : get_pagenum_link( $paged - 1 ) ); ?>" aria-label="صفحه قبل"><svg><use href="#i-arrow-fwd"/></svg></a>
      <?php for ( $p = 1; $p <= $total; $p++ ) : ?>
        <a class="<?php echo ( $p === $paged ) ? 'is-active' : ''; ?>" href="<?php echo esc_url( get_pagenum_link( $p ) ); ?>"><?php echo esc_html( parsbm_fa_number( $p ) ); ?></a>
      <?php endfor; ?>
      <a<?php echo $next_disabled ? ' aria-disabled="true"' : ''; ?> href="<?php echo esc_url( $next_disabled ? '#' : get_pagenum_link( $paged + 1 ) ); ?>" aria-label="صفحه بعد"><svg><use href="#i-arrow-fwd"/></svg></a>
    </nav>
    <?php endif; wp_reset_postdata(); ?>
  </div>
</section>

<!-- ============================= CTA BANNER ============================= -->
<section class="section section--tight">
  <div class="container">
    <div class="cta-banner" data-reveal>
      <div class="cta-banner__text">
        <h3><?php echo esc_html( parsbm_opt( 'cta_category_title' ) ); ?></h3>
        <p><?php echo esc_html( parsbm_opt( 'cta_category_desc' ) ); ?></p>
      </div>
      <div class="cta-banner__actions">
        <a class="btn btn--primary" href="<?php echo esc_url( home_url( '/#contact' ) ); ?>">درخواست مشاوره رایگان</a>
        <a class="btn btn--ghost btn--on-dark" href="tel:<?php echo esc_attr( parsbm_opt( 'contact_phone' ) ); ?>"><svg width="16" height="16"><use href="#i-phone"/></svg> تماس تلفنی</a>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>
