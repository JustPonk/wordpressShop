<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content-vw">
 *
 * @package Florist Flower Shop
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php if ( function_exists( 'wp_body_open' ) ) {
    wp_body_open();
} else {
    do_action('wp_body_open');
} ?>

<header role="banner">
    <a class="screen-reader-text skip-link" href="#maincontent" ><?php esc_html_e( 'Skip to content', 'florist-flower-shop' ); ?><span class="screen-reader-text"> <?php esc_html_e( 'Skip to content', 'florist-flower-shop' ); ?></span></a>
    <div class="home-page-header">
        <?php get_template_part('template-parts/header/top-header'); ?>
        <?php get_template_part('template-parts/header/middle-header'); ?>            
    </div>
</header>

<!-- Hero Section -->
<section class="hero-section" style="background-image: url('<?php echo esc_url(get_theme_mod('florist_flower_shop_hero_bg', get_template_directory_uri().'/assets/images/default-hero.jpg')); ?>');">
    <div class="hero-content">
        <h1><?php echo esc_html(get_theme_mod('florist_flower_shop_hero_title', 'Bienvenido a nuestra tienda de flores')); ?></h1>
        <p><?php echo esc_html(get_theme_mod('florist_flower_shop_hero_subtitle', 'Las mejores flores para cada ocasión.')); ?></p>
        <a href="<?php echo esc_url(get_theme_mod('florist_flower_shop_hero_button_link', '#')); ?>" class="hero-button">
            <?php echo esc_html(get_theme_mod('florist_flower_shop_hero_button_text', 'Ver productos')); ?>
        </a>
    </div>
</section>

<style>
.hero-section {
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    height: 60vh;
    background-size: cover;
    background-position: center;
    color: white;
    padding: 50px;
    position: relative;
}
.hero-section::before {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0, 0, 0, 0.5);
}
.hero-content {
    position: relative;
    z-index: 2;
}
.hero-button {
    display: inline-block;
    padding: 10px 20px;
    background-color: #ff4081;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    margin-top: 15px;
}
.hero-button:hover {
    background-color: #e91e63;
}
</style>

<?php if(get_theme_mod('florist_flower_shop_loader_enable', false) == 1 || get_theme_mod('florist_flower_shop_responsive_preloader_hide', false) == 1) { ?>
    <div id="preloader">
        <div class="loader-inner">
            <div class="loader-line-wrap"><div class="loader-line"></div></div>
            <div class="loader-line-wrap"><div class="loader-line"></div></div>
            <div class="loader-line-wrap"><div class="loader-line"></div></div>
            <div class="loader-line-wrap"><div class="loader-line"></div></div>
            <div class="loader-line-wrap"><div class="loader-line"></div></div>
        </div>
    </div>
<?php } ?>
