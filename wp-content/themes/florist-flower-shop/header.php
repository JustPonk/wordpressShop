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
    
    <style>
        .hero-section {
            position: relative;
            width: 100%;
            height: 100vh; /* Ajusta la altura */
            background: url('https://png.pngtree.com/background/20230612/original/pngtree-red-barn-in-the-countryside-wallpaper-picture-image_3188341.jpg') no-repeat center center/cover;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            padding: 50px;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Oscurece la imagen para mejorar el contraste */
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
            transition: background 0.3s;
        }

        .hero-button:hover {
            background-color: #e91e63;
        }
    </style>
</head>

<body <?php body_class(); ?>>
<?php if ( function_exists( 'wp_body_open' ) ) {
    wp_body_open();
} else {
    do_action('wp_body_open');
} ?>

<header role="banner">
    <a class="screen-reader-text skip-link" href="#maincontent"><?php esc_html_e( 'Skip to content', 'florist-flower-shop' ); ?>
        <span class="screen-reader-text"><?php esc_html_e( 'Skip to content', 'florist-flower-shop' ); ?></span>
    </a>
    <div class="home-page-header">
        <?php get_template_part('template-parts/header/top-header'); ?>
        <?php get_template_part('template-parts/header/middle-header'); ?>            
    </div>
</header>

<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-content">
        <h1>Bienvenido a Florist Flower Shop</h1>
        <p>Las mejores flores para cada ocasión</p>
        <a href="#shop" class="hero-button">Ver Productos</a>
    </div>
</section>

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
