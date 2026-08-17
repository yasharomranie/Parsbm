<?php
/**
 * نمای تکی یک دستگاه (در صورت بازدید مستقیم از پرمالینک آن). ورودی معمول
 * کاربران گرید مدل‌های taxonomy-machine_category.php است؛ این قالب یک نمای
 * ساده و سازگار با باقی طراحی سایت برای دسترسی مستقیم فراهم می‌کند.
 *
 * @package ParsBM
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$GLOBALS['parsbm_active_bottom_key'] = 'products';
get_header();

while ( have_posts() ) : the_post();
	$post_id = get_the_ID();
	$terms   = get_the_terms( $post_id, 'machine_category' );
	$term    = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0] : null;
	$specs   = array_filter( array_map( 'trim', explode( ',', get_post_meta( $post_id, '_machine_specs', true ) ) ) );
	$cta_l   = get_post_meta( $post_id, '_machine_cta_label', true ) ?: 'استعلام قیمت';
	$cta_u   = get_post_meta( $post_id, '_machine_cta_url', true ) ?: '#contact';
	$image   = parsbm_post_image_url( $post_id, '_machine_image_url' );

	parsbm_breadcrumb( array(
		array( 'label' => 'خانه', 'url' => home_url( '/#home' ) ),
		array( 'label' => 'محصولات', 'url' => home_url( '/#products' ) ),
		array( 'label' => $term ? $term->name : 'محصولات', 'url' => $term ? parsbm_term_url( $term ) : '' ),
		array( 'label' => get_the_title() ),
	) );
	?>

  <section class="section">
    <div class="container">
      <div class="post-hero-img" data-reveal>
        <img src="<?php echo esc_url( $image ); ?>" alt="<?php the_title_attribute(); ?>">
      </div>
      <div style="max-width:820px; margin:var(--space-lg) auto 0;">
        <span class="eyebrow"><?php echo esc_html( $term ? $term->name : '' ); ?></span>
        <h1 class="post-title"><?php the_title(); ?></h1>
        <div class="machine-card__specs" style="margin:var(--space-sm) 0;">
          <?php foreach ( $specs as $spec ) : ?><span class="spec-chip"><?php echo esc_html( $spec ); ?></span><?php endforeach; ?>
        </div>
        <div class="post-body"><?php the_content(); ?></div>
        <a class="btn btn--primary" href="<?php echo esc_url( parsbm_resolve_url( $cta_u ) ); ?>"><?php echo esc_html( $cta_l ); ?> <svg width="16" height="16"><use href="#i-arrow-fwd"/></svg></a>
      </div>
    </div>
  </section>

<?php endwhile; ?>

<?php get_footer(); ?>
