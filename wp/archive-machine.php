<?php
/**
 * آرشیو کلی پوست‌تایپ «دستگاه» (بدون انتخاب دسته) — صفحه‌ای میانی که به آرشیو
 * هر دسته محصول (taxonomy-machine_category.php) لینک می‌دهد. ورودی اصلی
 * کاربران معمولاً از طریق مگامنو یا کارت‌های صفحه اصلی مستقیماً به آرشیو
 * یک دسته مشخص است؛ این قالب فقط یک نقشه راه ساده برای بازدید مستقیم است.
 *
 * @package ParsBM
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$GLOBALS['parsbm_active_bottom_key'] = 'products';
get_header();

parsbm_breadcrumb( array(
	array( 'label' => 'خانه', 'url' => home_url( '/#home' ) ),
	array( 'label' => 'محصولات' ),
) );
?>

<section class="section">
  <div class="container">
    <div class="section-head" data-reveal>
      <span class="eyebrow">محصولات</span>
      <h2 class="section-title">انواع دستگاه‌های پارس بلومولدینگ</h2>
      <p class="section-desc">یک دسته را برای مشاهده مدل‌های دستگاه انتخاب کنید.</p>
    </div>
    <?php parsbm_other_cats_nav(); ?>
  </div>
</section>

<?php get_footer(); ?>
