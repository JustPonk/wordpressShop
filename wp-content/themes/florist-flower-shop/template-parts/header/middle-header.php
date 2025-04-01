<?php
/**
 * The template part for top header
 *
 * @package Florist Flower Shop
 * @subpackage florist-flower-shop
 * @since florist-flower-shop 1.0
 */
?>


<style>

.navbar {
    display: flex;
    justify-content: center;
    align-items: center;
}

.nav-links {
    list-style: none;
    display: flex;
    gap: 20px;
    padding: 0;
    margin: 0;
}

.nav-links li {
    display: inline;
}

.nav-links a {
    text-decoration: none;
    font-size: 18px;
    color: #333;
    transition: color 0.3s ease-in-out;
}

.nav-links a:hover {
    color: #ff4081;
}



</style>










<div class="middle-bar text-center text-lg-start text-md-start">
  <div class="container">
    <div class="inner-head-box">
      <div class="row">
        <!-- Logo a la izquierda -->
        <div class="col-lg-3 col-md-5 col-9 align-self-lg-center">
          <div class="logo text-md-start text-lg-start py-md-2 py-lg-0">
            <?php if ( has_custom_logo() ) : ?>
              <div class="site-logo"><?php the_custom_logo(); ?></div>
            <?php endif; ?>
            <p class="site-title py-1">
              <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
            </p>
          </div>
        </div>

        <!-- Menú + Search + Carrito a la derecha -->
        <div class="col-lg-9 col-md-7 col-12 p-0 py-2 align-self-lg-center d-flex justify-content-end align-items-center">
          <nav class="navbar">
            <ul class="nav-links d-flex align-items-center">
              <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>
              <li><a href="<?php echo esc_url( home_url('/shop') ); ?>">Shop</a></li>
              <li><a href="<?php echo esc_url( get_permalink(get_option('woocommerce_myaccount_page_id')) ); ?>">My Account</a></li>
            </ul>
          </nav>

          <!-- Search Box -->
          <div class="search-box ms-3">
            <?php if(class_exists('woocommerce')){ ?>
              <?php get_product_search_form(); ?>
            <?php } ?>
          </div>

          <!-- Carrito de compras -->
          <?php if(class_exists('woocommerce')){ ?>
            <span class="cart_no ms-3">
              <a href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e( 'Shopping Cart','florist-flower-shop' ); ?>">
                <i class="fas fa-shopping-basket"></i>
                <span class="screen-reader-text"><?php esc_html_e( 'Shopping Cart','florist-flower-shop' );?></span>
              </a>
              <span class="cart-value"><?php echo esc_html( WC()->cart->get_cart_contents_count());?></span>
            </span>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>
