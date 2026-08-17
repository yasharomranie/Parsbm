<?php
/**
 * تک‌نوشته استاندارد وردپرس — معادل کامل post.html استاتیک، با فهرست مطالب
 * خودکار (از h2/h3 محتوا)، جعبه نویسنده، مطالب مرتبط و دیدگاه‌های واقعی وردپرس.
 *
 * @package ParsBM
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$GLOBALS['parsbm_active_bottom_key'] = 'products';
get_header();

while ( have_posts() ) : the_post();
	$post_id   = get_the_ID();
	$cats      = get_the_category();
	$eyebrow   = ! empty( $cats ) ? $cats[0]->name : 'راهنمای خرید';
	$subtitle  = get_post_meta( $post_id, '_parsbm_subtitle', true );
	$minutes   = parsbm_reading_minutes( get_the_content() );

	$rendered  = apply_filters( 'the_content', get_the_content() );
	list( $content_with_ids, $toc ) = parsbm_extract_toc( $rendered );

	$hero_image = has_post_thumbnail() ? get_the_post_thumbnail_url( $post_id, 'large' ) : get_post_meta( $post_id, '_parsbm_hero_image_url', true );
	if ( ! $hero_image ) $hero_image = PARSBM_URI . '/assets/img/products/machine-3.jpg';

	parsbm_breadcrumb( array(
		array( 'label' => 'خانه', 'url' => home_url( '/#home' ) ),
		array( 'label' => 'مقالات ' . $eyebrow, 'url' => get_category_link( ! empty( $cats ) ? $cats[0]->term_id : 0 ) ),
		array( 'label' => get_the_title() ),
	) );
	?>

  <!-- ============================= POST HEADER ============================= -->
  <article <?php post_class(); ?>>
    <div class="container">
      <header class="post-header" data-reveal>
        <span class="eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
        <h1 class="post-title"><?php the_title(); ?><?php if ( $subtitle ) : ?> <small style="display:block; font-size:0.6em; color:var(--color-text-muted); font-weight:700; margin-top:0.4rem;">(<?php echo esc_html( $subtitle ); ?>)</small><?php endif; ?></h1>
        <?php if ( has_excerpt() ) : ?><p class="post-lede"><?php echo esc_html( get_the_excerpt() ); ?></p><?php endif; ?>
        <div class="post-meta">
          <span class="post-meta__item post-meta__author"><span class="post-meta__avatar"><?php echo get_avatar( get_the_author_meta( 'ID' ), 32 ); ?></span> <?php the_author(); ?></span>
          <span class="post-meta__item"><svg><use href="#i-calendar"/></svg> <?php echo esc_html( get_the_date( 'j F Y' ) ); ?></span>
          <span class="post-meta__item"><svg><use href="#i-clock"/></svg> <?php echo esc_html( parsbm_fa_number( $minutes ) ); ?> دقیقه مطالعه</span>
        </div>
      </header>

      <div class="post-hero-img" data-reveal>
        <img src="<?php echo esc_url( $hero_image ); ?>" alt="<?php the_title_attribute(); ?>">
      </div>

      <div style="max-width:1080px; margin:var(--space-md) auto 0; display:flex; justify-content:center;">
        <div class="share-bar">
          <span>اشتراک‌گذاری:</span>
          <a href="https://wa.me/?text=<?php echo rawurlencode( get_the_title() . ' ' . get_permalink() ); ?>" target="_blank" rel="noopener" aria-label="اشتراک در واتس‌اپ"><svg><use href="#i-whatsapp"/></svg></a>
          <a href="https://t.me/share/url?url=<?php echo rawurlencode( get_permalink() ); ?>&text=<?php echo rawurlencode( get_the_title() ); ?>" target="_blank" rel="noopener" aria-label="اشتراک در تلگرام"><svg><use href="#i-telegram"/></svg></a>
          <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo rawurlencode( get_permalink() ); ?>" target="_blank" rel="noopener" aria-label="اشتراک در لینکدین"><svg><use href="#i-linkedin"/></svg></a>
          <a href="<?php echo esc_url( get_permalink() ); ?>" aria-label="کپی لینک"><svg><use href="#i-link"/></svg></a>
        </div>
      </div>
    </div>

    <div class="container section">
      <div class="post-layout">

        <div class="post-body" data-reveal>
          <?php echo $content_with_ids; ?>

          <div class="author-box" data-reveal>
            <span class="author-box__avatar"><?php echo get_avatar( get_the_author_meta( 'ID' ), 48 ); ?></span>
            <div>
              <h4><?php the_author(); ?></h4>
              <p><?php echo esc_html( get_the_author_meta( 'description' ) ?: 'این مطلب توسط تیم مهندسی پارس بلومولدینگ با بیش از ۲۷ سال تجربه در طراحی و ساخت ماشین‌آلات اکستروژن بادی تهیه شده است.' ); ?></p>
            </div>
          </div>

          <div style="display:flex; justify-content:center; padding-top:var(--space-sm)">
            <div class="share-bar">
              <span>این مطلب مفید بود؟ اشتراک بگذارید:</span>
              <a href="https://wa.me/?text=<?php echo rawurlencode( get_the_title() . ' ' . get_permalink() ); ?>" target="_blank" rel="noopener" aria-label="اشتراک در واتس‌اپ"><svg><use href="#i-whatsapp"/></svg></a>
              <a href="https://t.me/share/url?url=<?php echo rawurlencode( get_permalink() ); ?>&text=<?php echo rawurlencode( get_the_title() ); ?>" target="_blank" rel="noopener" aria-label="اشتراک در تلگرام"><svg><use href="#i-telegram"/></svg></a>
              <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo rawurlencode( get_permalink() ); ?>" target="_blank" rel="noopener" aria-label="اشتراک در لینکدین"><svg><use href="#i-linkedin"/></svg></a>
            </div>
          </div>
        </div>

        <!-- ============================= TOC SIDEBAR ============================= -->
        <?php if ( ! empty( $toc ) ) : ?>
        <aside class="toc" data-reveal aria-label="فهرست مطالب">
          <h2><svg><use href="#i-list"/></svg> فهرست مطالب</h2>
          <ol data-toc>
            <?php foreach ( $toc as $item ) : ?>
              <li><a href="#<?php echo esc_attr( $item['id'] ); ?>"><?php echo esc_html( $item['text'] ); ?></a></li>
            <?php endforeach; ?>
          </ol>
          <p class="toc__progress-note"><?php echo esc_html( parsbm_fa_number( $minutes ) ); ?> دقیقه مطالعه · <?php echo esc_html( parsbm_fa_number( count( $toc ) ) ); ?> بخش</p>

          <?php $tags = get_the_tags(); ?>
          <?php if ( $tags || ! empty( $cats ) ) : ?>
          <div class="toc__tags">
            <?php if ( $tags ) : foreach ( $tags as $tag ) : ?>
              <a href="<?php echo esc_url( get_tag_link( $tag ) ); ?>"><?php echo esc_html( $tag->name ); ?></a>
            <?php endforeach; else : foreach ( $cats as $cat ) : ?>
              <a href="<?php echo esc_url( get_category_link( $cat ) ); ?>"><?php echo esc_html( $cat->name ); ?></a>
            <?php endforeach; endif; ?>
          </div>
          <?php endif; ?>

          <div class="toc__cta">
            <span class="toc__cta-icon"><svg width="20" height="20"><use href="#i-phone"/></svg></span>
            <strong>مشاوره رایگان می‌خواهید؟</strong>
            <p>کارشناسان ما مدل مناسب شما را رایگان مشخص می‌کنند.</p>
            <a class="btn btn--primary btn--sm btn--block" href="<?php echo esc_url( home_url( '/#contact' ) ); ?>">تماس با ما</a>
          </div>
        </aside>
        <?php endif; ?>

      </div>
    </div>

    <!-- ============================= RELATED ARTICLES ============================= -->
    <?php $related = parsbm_related_articles( $post_id, 4 ); ?>
    <?php if ( $related->have_posts() ) : ?>
    <div class="container section section-bg-alt">
      <div class="section-head" data-reveal>
        <span class="eyebrow">مطالب مرتبط</span>
        <h2 class="section-title">ادامه بدهید</h2>
      </div>
      <div class="related-grid" data-reveal-group>
        <?php while ( $related->have_posts() ) : $related->the_post(); ?>
          <a class="related-card" href="<?php the_permalink(); ?>" data-reveal>
            <div class="related-card__art"><?php if ( has_post_thumbnail() ) the_post_thumbnail( 'medium' ); else echo '<img src="' . esc_url( PARSBM_URI . '/assets/img/products/machine-1.jpg' ) . '" alt="">'; ?></div>
            <div class="related-card__body"><span><?php echo esc_html( $eyebrow ); ?></span><h4><?php the_title(); ?></h4></div>
          </a>
        <?php endwhile; wp_reset_postdata(); ?>
      </div>
    </div>
    <?php endif; ?>

    <!-- ============================= COMMENTS ============================= -->
    <div class="container section section--tight">
      <div style="max-width:800px; margin-inline:auto;">
        <?php comments_template(); ?>
      </div>
    </div>

  </article>

<?php endwhile; ?>

<?php get_footer(); ?>
