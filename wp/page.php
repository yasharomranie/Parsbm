<?php
/**
 * قالب عمومی صفحه (Page) — برای هر صفحه‌ای که قالب اختصاصی ندارد
 * (مثل «سوالات متداول» که page-faq.php را دارد). صفحاتی که بعداً از
 * پیشخوان ساخته می‌شوند (درباره ما، حریم خصوصی، و ...) با همین قالب
 * نمایش داده می‌شوند مگر این‌که قالب اختصاصی خودشان را داشته باشند.
 *
 * @package ParsBM
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

while ( have_posts() ) : the_post();
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
					<?php if ( has_excerpt() ) : ?><p class="post-lede"><?php echo esc_html( get_the_excerpt() ); ?></p><?php endif; ?>
				</header>

				<?php if ( has_post_thumbnail() ) : ?>
					<div class="post-hero-img" data-reveal>
						<?php the_post_thumbnail( 'large' ); ?>
					</div>
				<?php endif; ?>

				<div class="post-body" data-reveal>
					<?php the_content(); ?>
				</div>

				<?php if ( comments_open() || get_comments_number() ) : ?>
					<div style="margin-top:var(--space-xl);">
						<?php comments_template(); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php endwhile; ?>

<?php get_footer(); ?>
