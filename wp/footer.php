<?php
/**
 * فوتر مشترک سایت — بستن main/page-shell، فوتر ۴ ستونه، نوار پایین موبایل.
 *
 * @package ParsBM
 */

if ( ! defined( 'ABSPATH' ) ) exit;
?>
</main>
</div>

<!-- ============================= FOOTER ============================= -->
<footer class="site-footer">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <span class="brand">
          <span class="brand__mark"><img src="<?php echo esc_url( PARSBM_URI . '/assets/img/pars-icon.png' ); ?>" alt="" width="34" height="30"></span>
          <span class="brand__type" style="color:#fff"><strong style="color:#fff"><?php bloginfo( 'name' ); ?></strong><span style="color:rgba(255,255,255,.6)">Pars Blow Molding Technology</span></span>
        </span>
        <p><?php echo esc_html( parsbm_opt( 'footer_about' ) ); ?></p>
        <div class="footer-social">
          <?php if ( parsbm_opt( 'social_whatsapp' ) ) : ?><a href="<?php echo esc_url( parsbm_opt( 'social_whatsapp' ) ); ?>" aria-label="واتس‌اپ"><svg width="17" height="17"><use href="#i-whatsapp"/></svg></a><?php endif; ?>
          <?php if ( parsbm_opt( 'social_telegram' ) ) : ?><a href="<?php echo esc_url( parsbm_opt( 'social_telegram' ) ); ?>" aria-label="تلگرام"><svg width="17" height="17"><use href="#i-telegram"/></svg></a><?php endif; ?>
          <?php if ( parsbm_opt( 'social_instagram' ) ) : ?><a href="<?php echo esc_url( parsbm_opt( 'social_instagram' ) ); ?>" aria-label="اینستاگرام"><svg width="17" height="17"><use href="#i-instagram"/></svg></a><?php endif; ?>
          <?php if ( parsbm_opt( 'social_linkedin' ) ) : ?><a href="<?php echo esc_url( parsbm_opt( 'social_linkedin' ) ); ?>" aria-label="لینکدین"><svg width="17" height="17"><use href="#i-linkedin"/></svg></a><?php endif; ?>
        </div>
      </div>

      <div class="footer-col">
        <h4>دسترسی سریع</h4>
        <?php
        wp_nav_menu( array(
          'theme_location' => 'footer_quick',
          'container'      => false,
          'items_wrap'     => '<ul>%3$s</ul>',
          'fallback_cb'    => false,
        ) );
        ?>
      </div>

      <div class="footer-col">
        <h4>محصولات</h4>
        <ul>
          <?php foreach ( parsbm_get_terms_ordered( 'machine_category' ) as $term ) : ?>
            <li><a href="<?php echo esc_url( parsbm_term_url( $term ) ); ?>"><?php echo esc_html( $term->name ); ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="footer-col">
        <h4>تماس با ما</h4>
        <ul class="footer-contact">
          <li><svg width="18" height="18"><use href="#i-pin"/></svg> <?php echo esc_html( parsbm_opt( 'contact_address' ) ); ?></li>
          <li><svg width="18" height="18"><use href="#i-phone"/></svg> <span dir="ltr"><?php echo esc_html( parsbm_opt( 'contact_phone_display' ) ); ?></span></li>
          <li><svg width="18" height="18"><use href="#i-mail"/></svg> <span dir="ltr"><?php echo esc_html( parsbm_opt( 'contact_email' ) ); ?></span></li>
          <li><svg width="18" height="18"><use href="#i-clock"/></svg> <?php echo esc_html( parsbm_opt( 'contact_hours' ) ); ?></li>
        </ul>
      </div>
    </div>

    <div class="footer-bottom">
      <span>© <span data-year><?php echo esc_html( parsbm_fa_number( date_i18n( 'Y' ) ) ); ?></span> <?php bloginfo( 'name' ); ?>. تمامی حقوق محفوظ است.</span>
      <span><?php echo esc_html( parsbm_opt( 'footer_credit' ) ); ?></span>
    </div>
  </div>
</footer>

<!-- ============================= MOBILE BOTTOM NAV ============================= -->
<nav class="bottom-nav" aria-label="ناوبری پایین صفحه">
  <?php
  wp_nav_menu( array(
    'theme_location' => 'bottom_nav',
    'container'      => false,
    'items_wrap'     => '%3$s',
    'walker'         => new Walker_Parsbm_Bottom(),
    'fallback_cb'    => false,
  ) );
  ?>
</nav>

<button class="back-to-top" data-back-to-top aria-label="بازگشت به بالای صفحه">
  <svg width="20" height="20"><use href="#i-arrow-up"/></svg>
</button>

<?php wp_footer(); ?>
</body>
</html>
