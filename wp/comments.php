<?php
/**
 * دیدگاه‌های واقعی وردپرس — مارک‌آپ نگاشت‌شده روی کلاس‌های .comment-list/.comment
 * موجود در style.css تا دقیقاً هم‌شکل نسخه استاتیک post.html باشد.
 *
 * @package ParsBM
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( post_password_required() ) return;

/** رندر هر دیدگاه — بستن </li> به‌صورت خودکار توسط Walker_Comment انجام می‌شود. */
function parsbm_comment_cb( $comment, $args, $depth ) {
	?>
	<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
		<span class="comment__avatar"><?php echo get_avatar( $comment, 40 ); ?></span>
		<div>
			<div class="comment__head"><strong><?php comment_author(); ?></strong><span><?php echo esc_html( get_comment_date( 'j F Y' ) ); ?></span></div>
			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p><em>دیدگاه شما در انتظار تأیید مدیر سایت است.</em></p>
			<?php endif; ?>
			<?php comment_text(); ?>
			<?php
			comment_reply_link( array_merge( $args, array(
				'depth'      => $depth,
				'max_depth'  => $args['max_depth'],
				'reply_text' => 'پاسخ',
			) ) );
			?>
		</div>
	<?php
}
?>

<div class="comments-head">
  <h2 class="section-title" style="margin:0; font-size:1.3rem;">دیدگاه‌ها (<?php echo esc_html( parsbm_fa_number( get_comments_number() ) ); ?>)</h2>
</div>

<?php if ( have_comments() ) : ?>
  <ol class="comment-list">
    <?php wp_list_comments( array( 'style' => 'ol', 'avatar_size' => 40, 'callback' => 'parsbm_comment_cb' ) ); ?>
  </ol>
  <?php the_comments_pagination( array( 'prev_text' => 'قبلی', 'next_text' => 'بعدی' ) ); ?>
<?php endif; ?>

<?php if ( comments_open() ) : ?>
  <?php comment_form(); ?>
<?php else : ?>
  <p>امکان ثبت دیدگاه برای این مطلب بسته است.</p>
<?php endif; ?>
