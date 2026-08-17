<?php
/**
 * جستجوی سراسری سایت — معادل کامل search.html استاتیک. برخلاف نسخه استاتیک،
 * ایندکس جستجو (window.PARS_SEARCH_INDEX) دیگر یک آرایه ثابت نیست؛ در همین‌جا
 * از محتوای واقعی وردپرس (مقالات، مدل‌های دستگاه، دسته‌ها، خدمات، سوالات متداول)
 * ساخته می‌شود و دقیقاً همان منطق جستجوی زنده و فیلتر سمت کاربر موجود در
 * main.js's [data-search-page] بدون هیچ تغییری روی آن اجرا می‌شود.
 *
 * @package ParsBM
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$GLOBALS['parsbm_main_attr'] = 'data-search-page';

/* ---------------------------------------------------------------
 * ساخت ایندکس جستجو از محتوای زنده وردپرس
 * ------------------------------------------------------------- */
$index = array();

foreach ( parsbm_get_terms_ordered( 'machine_category' ) as $term ) {
	$index[] = array(
		'type'      => 'category',
		'typeLabel' => 'دسته محصول',
		'icon'      => 'i-grid',
		'title'     => $term->name,
		'url'       => parsbm_term_url( $term ),
		'urlLabel'  => 'محصولات › ' . $term->name,
		'excerpt'   => $term->description,
		'keywords'  => $term->name,
	);
}

$machines_q = new WP_Query( array( 'post_type' => 'machine', 'posts_per_page' => 100, 'orderby' => 'menu_order', 'order' => 'ASC' ) );
while ( $machines_q->have_posts() ) : $machines_q->the_post();
	$index[] = array(
		'type'      => 'model',
		'typeLabel' => 'مدل دستگاه',
		'icon'      => 'i-press',
		'title'     => get_the_title(),
		'url'       => get_permalink(),
		'urlLabel'  => 'محصولات › ' . get_the_title(),
		'excerpt'   => get_the_excerpt(),
		'keywords'  => get_post_meta( get_the_ID(), '_machine_specs', true ),
	);
endwhile; wp_reset_postdata();

$posts_q = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 50 ) );
while ( $posts_q->have_posts() ) : $posts_q->the_post();
	$index[] = array(
		'type'      => 'article',
		'typeLabel' => 'مقاله',
		'icon'      => 'i-newspaper',
		'title'     => get_the_title(),
		'url'       => get_permalink(),
		'urlLabel'  => 'مقالات › ' . get_the_title(),
		'excerpt'   => get_the_excerpt(),
		'keywords'  => get_the_title(),
	);
endwhile; wp_reset_postdata();

$services_q = new WP_Query( array( 'post_type' => 'service', 'posts_per_page' => -1, 'orderby' => 'menu_order', 'order' => 'ASC' ) );
while ( $services_q->have_posts() ) : $services_q->the_post();
	$index[] = array(
		'type'      => 'service',
		'typeLabel' => 'خدمت',
		'icon'      => 'i-wrench',
		'title'     => get_the_title(),
		'url'       => home_url( '/#services' ),
		'urlLabel'  => 'خدمات › ' . get_the_title(),
		'excerpt'   => get_the_excerpt(),
		'keywords'  => get_the_title(),
	);
endwhile; wp_reset_postdata();

$faq_q = new WP_Query( array( 'post_type' => 'faq', 'posts_per_page' => 100 ) );
while ( $faq_q->have_posts() ) : $faq_q->the_post();
	$index[] = array(
		'type'      => 'faq',
		'typeLabel' => 'سوال متداول',
		'icon'      => 'i-list',
		'title'     => get_the_title(),
		'url'       => home_url( '/faq/#' ),
		'urlLabel'  => 'سوالات متداول › ' . get_the_title(),
		'excerpt'   => wp_strip_all_tags( get_the_content() ),
		'keywords'  => get_the_title(),
	);
endwhile; wp_reset_postdata();

$static_pages = array(
	array( 'title' => 'خانه', 'url' => home_url( '/#home' ), 'excerpt' => 'فناوری بلومولدینگ پارس، خط تولید شما را متحول می‌کند.' ),
	array( 'title' => 'درباره پارس بلومولدینگ', 'url' => home_url( '/#about' ), 'excerpt' => 'مهندسی و ساخت داخلی، در کنار کیفیت جهانی.' ),
	array( 'title' => 'نمونه محصولات', 'url' => home_url( '/#samples' ), 'excerpt' => 'گزیده‌ای از محصولات نهایی مشتریان پارس بلومولدینگ.' ),
	array( 'title' => 'تماس با پارس بلومولدینگ', 'url' => home_url( '/#contact' ), 'excerpt' => 'فرم تماس، آدرس کارخانه، تلفن و ایمیل پارس بلومولدینگ.' ),
);
foreach ( $static_pages as $p ) {
	$index[] = array(
		'type' => 'page', 'typeLabel' => 'صفحه', 'icon' => 'i-home',
		'title' => $p['title'], 'url' => $p['url'], 'urlLabel' => $p['title'], 'excerpt' => $p['excerpt'], 'keywords' => $p['title'],
	);
}

get_header();
?>

<script>
  window.PARS_SEARCH_INDEX = <?php echo wp_json_encode( $index ); ?>;
</script>

<!-- ============================= SEARCH HERO ============================= -->
<section class="search-hero">
  <div class="hero__grid" aria-hidden="true"></div>
  <div class="hero__glow" aria-hidden="true"></div>
  <div class="container search-hero__inner">
    <h1>در محصولات، مدل‌ها و مقالات پارس جستجو کنید</h1>
    <form class="search-form" data-search-form role="search">
      <input type="search" name="q" data-search-input placeholder="مثلاً: مخزن، تزریق پلاستیک، گارانتی..." value="<?php echo esc_attr( get_search_query() ); ?>" autofocus>
      <button type="submit" aria-label="جستجو"><svg><use href="#i-search"/></svg></button>
    </form>
    <div class="popular-chips">
      <span>پرجستجوترین‌ها:</span>
      <button type="button" data-search-chip="مخزن">مخزن</button>
      <button type="button" data-search-chip="تزریق پلاستیک">تزریق پلاستیک</button>
      <button type="button" data-search-chip="PET">PET</button>
      <button type="button" data-search-chip="گارانتی">گارانتی</button>
      <button type="button" data-search-chip="اکستروژن">اکستروژن</button>
    </div>
  </div>
</section>

<!-- ============================= RESULTS ============================= -->
<section class="section">
  <div class="container">
    <div class="filter-tabs" role="tablist" aria-label="فیلتر نوع نتیجه" style="margin-bottom:var(--space-md)">
      <button type="button" class="is-active" data-search-filter="all">همه</button>
      <button type="button" data-search-filter="category">دسته محصول</button>
      <button type="button" data-search-filter="model">مدل دستگاه</button>
      <button type="button" data-search-filter="article">مقاله</button>
      <button type="button" data-search-filter="faq">سوال متداول</button>
      <button type="button" data-search-filter="service">خدمات</button>
      <button type="button" data-search-filter="page">صفحات</button>
    </div>

    <div class="search-meta">
      <p class="search-meta__count" data-search-count></p>
    </div>

    <div class="search-results" data-search-results></div>

    <div class="search-empty" data-search-empty hidden>
      <span class="search-empty__icon"><svg><use href="#i-search"/></svg></span>
      <h2>نتیجه‌ای پیدا نشد</h2>
      <p>کلمه دیگری امتحان کنید یا از دسته‌بندی‌های زیر شروع کنید.</p>
      <?php parsbm_other_cats_nav( 0, 'justify-content:center;' ); ?>
    </div>
  </div>
</section>

<?php get_footer(); ?>
