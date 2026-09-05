<?php
/**
 * قالب اصلی/پیش‌فرض (index.php) — فایل الزامی هر قالب وردپرسی که وردپرس
 * بدون آن قالب را «خراب» تشخیص داده و اجازه فعال‌سازی نمی‌دهد.
 *
 * این فایل به‌عنوان آخرین ردهٔ سلسله‌مراتب قالب عمل می‌کند: آرشیو نوشته‌ها
 * (اگر «صفحه نوشته‌ها» تنظیم شده باشد)، آرشیو دسته/برچسب/تاریخ (چون قالب
 * اختصاصی archive.php/category.php/tag.php ندارد) و هر حالت پیش‌بینی‌نشده
 * دیگر را با یک چیدمان ساده و هم‌راستا با بقیه سایت نمایش می‌دهد. صفحه اصلی
 * واقعی سایت همیشه از front-page.php استفاده می‌کند، نه از این فایل.
 *
 * @package ParsBM
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
$paged = max( 1, (int) get_query_var( 'paged' ) );
?>

<?php if ( is_singular() ) : ?>

  <?php while ( have_posts() ) : the_post(); ?>
    <?php
    parsbm_breadcrumb( array(
      array( 'label' => 'خانه', 'url' => home_url( '/#home' ) ),
      array( 'label' => get_the_title() ),
    ) );
    ?>
    <section class="section">
      <div class="container">
        <div style="max-width:860px; margin-inline:auto;">
          <header class="post-header" data-reveal style="text-align:center;">
            <h1 class="post-title"><?php the_title(); ?></h1>
          </header>
          <?php if ( has_post_thumbnail() ) : ?>
            <div class="post-hero-img" data-reveal><?php the_post_thumbnail( 'large' ); ?></div>
          <?php endif; ?>
          <div class="post-body" data-reveal><?php the_content(); ?></div>
        </div>
      </div>
    </section>
  <?php endwhile; ?>

<?php else : ?>

  <?php
  $heading = 'مطالب سایت';
  $desc    = '';
  if ( is_category() || is_tag() || is_tax() ) {
    $term    = get_queried_object();
    $heading = $term->name;
    $desc    = $term->description;
  } elseif ( is_date() ) {
    $heading = 'آرشیو بر اساس تاریخ';
  } elseif ( is_author() ) {
    $heading = 'مطالب ' . get_the_author();
  }

  parsbm_breadcrumb( array(
    array( 'label' => 'خانه', 'url' => home_url( '/#home' ) ),
    array( 'label' => $heading ),
  ) );
  ?>

  <section class="section">
    <div class="container">
      <div class="section-head" data-reveal>
        <span class="eyebrow">مقالات</span>
        <h2 class="section-title"><?php echo esc_html( $heading ); ?></h2>
        <?php if ( $desc ) : ?><p class="section-desc"><?php echo esc_html( $desc ); ?></p><?php endif; ?>
      </div>

      <?php if ( have_posts() ) : ?>
        <div class="related-grid" data-reveal-group>
          <?php while ( have_posts() ) : the_post(); ?>
            <a class="related-card" href="<?php the_permalink(); ?>" data-reveal>
              <div class="related-card__art">
                <?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'medium' ); else : ?>
                  <img src="<?php echo esc_url( PARSBM_URI . '/assets/img/products/machine-1.jpg' ); ?>" alt="">
                <?php endif; ?>
              </div>
              <div class="related-card__body">
                <span><?php echo esc_html( get_the_date() ); ?></span>
                <h4><?php the_title(); ?></h4>
              </div>
            </a>
          <?php endwhile; ?>
        </div>

        <?php
        global $wp_query;
        parsbm_render_pagination( $wp_query, $paged );
        ?>
      <?php else : ?>
        <div class="search-empty">
          <span class="search-empty__icon"><svg><use href="#i-search"/></svg></span>
          <h2>مطلبی یافت نشد</h2>
          <p>به نظر می‌رسد فعلاً مطلبی برای نمایش وجود ندارد.</p>
          <a class="btn btn--primary" href="<?php echo esc_url( home_url( '/#home' ) ); ?>">بازگشت به خانه</a>
        </div>
      <?php endif; ?>
    </div>
  </section>

<?php endif; ?>

<?php get_footer(); ?>
