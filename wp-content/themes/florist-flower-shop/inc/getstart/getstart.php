<?php
//about theme info
add_action( 'admin_menu', 'florist_flower_shop_gettingstarted' );
function florist_flower_shop_gettingstarted() {
	add_theme_page( esc_html__('About Florist Flower Shop', 'florist-flower-shop'), esc_html__('About Florist Flower Shop', 'florist-flower-shop'), 'edit_theme_options', 'florist_flower_shop_guide', 'florist_flower_shop_mostrar_guide');
}

// Add a Custom CSS file to WP Admin Area
function florist_flower_shop_admin_theme_style() {
	wp_enqueue_style('florist-flower-shop-custom-admin-style', esc_url(get_template_directory_uri()) . '/inc/getstart/getstart.css');
	wp_enqueue_script('florist-flower-shop-tabs', esc_url(get_template_directory_uri()) . '/inc/getstart/js/tab.js');
}
add_action('admin_enqueue_scripts', 'florist_flower_shop_admin_theme_style');

//guidline for about theme
function florist_flower_shop_mostrar_guide() { 
	//custom function about theme customizer
	$florist_flower_shop_return = add_query_arg( array()) ;
	$florist_flower_shop_theme = wp_get_theme( 'florist-flower-shop' );
?>

<div class="wrapper-info">
    <div class="col-left  sshot-section">
    	<h2><?php esc_html_e( 'Welcome to Florist Flower Shop', 'florist-flower-shop' ); ?> <span class="version"><?php esc_html_e( 'Version', 'florist-flower-shop' ); ?>: <?php echo esc_html($florist_flower_shop_theme['Version']);?></span></h2>
    	<p><?php esc_html_e('All our WordPress themes are modern, minimalist, 100% responsive, seo-friendly,feature-rich, and multipurpose that best suit designers, bloggers and other professionals who are working in the creative fields.','florist-flower-shop'); ?></p>
    </div>
    <div class="col-right coupen-section">
    	<div class="logo-section">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/screenshot.png" alt="" />
		</div>
		<div class="logo-right">			
			<div class="update-now">
				<h4><?php esc_html_e('Try Premium ','florist-flower-shop'); ?></h4>
				<h4><?php esc_html_e('Florist Flower Shop Theme','florist-flower-shop'); ?></h4>
				<h4 class="disc-text"><?php esc_html_e('at 20% Discount','florist-flower-shop'); ?></h4>
				<h4><?php esc_html_e('Use Coupon','florist-flower-shop'); ?> ( <span><?php esc_html_e('vwpro20','florist-flower-shop'); ?></span> ) </h4> 
				<div class="info-link">
					<a href="<?php echo esc_url( FLORIST_FLOWER_SHOP_BUY_NOW ); ?>" target="_blank"> <?php esc_html_e( 'Upgrade to Pro', 'florist-flower-shop' ); ?></a>
				</div>
			</div>
		</div>   
		<div class="logo-img">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getstart/images/final-logo.png" alt="" />
		</div>
    </div>

    <div class="tab-sec">
    	<div class="tab">
    		<button class="tablinks" onclick="florist_flower_shop_open_tab(event, 'lite_theme')"><?php esc_html_e( 'Setup With Customizer', 'florist-flower-shop' ); ?></button>
    		
			<button class="tablinks" onclick="florist_flower_shop_open_tab(event, 'pro_theme')"><?php esc_html_e( 'Get Premium', 'florist-flower-shop' ); ?></button>
			<button class="tablinks" onclick="florist_flower_shop_open_tab(event, 'lite_pro')"><?php esc_html_e( 'Free VS Premium', 'florist-flower-shop' ); ?></button>
			<button class="tablinks" onclick="florist_flower_shop_open_tab(event, 'get_bundle')"><?php esc_html_e( 'Get 250+ Themes Bundle at $99', 'florist-flower-shop' ); ?></button>
		</div>

		<?php 
			$florist_flower_shop_plugin_custom_css = '';
			if(class_exists('Ibtana_Visual_Editor_Menu_Class')){
				$florist_flower_shop_plugin_custom_css ='display: block';
			}
		?>
		<div id="lite_theme" class="tabcontent open">
			<?php  if(!class_exists('Ibtana_Visual_Editor_Menu_Class')){ 
				$plugin_ins = Florist_Flower_Shop_Plugin_Activation_Settings::get_instance();
				$florist_flower_shop_actions = $plugin_ins->recommended_actions;
				?>
				<div class="florist-flower-shop-recommended-plugins">
				    <div class="florist-flower-shop-action-list">
				        <?php if ($florist_flower_shop_actions): foreach ($florist_flower_shop_actions as $key => $florist_flower_shop_actionValue): ?>
				                <div class="florist-flower-shop-action" id="<?php echo esc_attr($florist_flower_shop_actionValue['id']);?>">
			                        <div class="action-inner">
			                            <h3 class="action-title"><?php echo esc_html($florist_flower_shop_actionValue['title']); ?></h3>
			                            <div class="action-desc"><?php echo esc_html($florist_flower_shop_actionValue['desc']); ?></div>
			                            <?php echo wp_kses_post($florist_flower_shop_actionValue['link']); ?>
			                            <a class="ibtana-skip-btn" get-start-tab-id="lite-theme-tab" href="javascript:void(0);"><?php esc_html_e('Skip','florist-flower-shop'); ?></a>
			                        </div>
				                </div>
				            <?php endforeach;
				        endif; ?>
				    </div>
				</div>
			<?php } ?>
			<div class="lite-theme-tab" style="<?php echo esc_attr($florist_flower_shop_plugin_custom_css); ?>">
				<h3><?php esc_html_e( 'Lite Theme Information', 'florist-flower-shop' ); ?></h3>
				<hr class="h3hr">	
				<p><?php esc_html_e('Florist Flower Shop will make your life easier by giving you a functional website for flower shops, gardens, florists and floral decorator’s website. It can be used for multipurpose ecommerce storefronts like homemade decor items, boutiques, customized flower bouquets,florist, flower shop, floral design, boutique, greenery, dried flowers business, yard maintenance company, flower arrangements business, garden arbors business, gardening classes business, Retail florists, wedding planner, tree trimming service, greenhouses company, herb farm, artificial plants, corsages, wedding flowers, floral products, farmers market, decorators, artists, gift baskets, Home Decor, fashion stores and many more. You will see the expert quality work just by looking at the theme layout. Whenever the question of getting a sophisticated flower shop website arises, this theme will be your go-to option as it has a beautiful, and user-friendly design. It is designed with special care to details and functionality making your website professional. With a wide range of options for your flower business, it comes with an interactive design having Call To Action Button (CTA) at the right spots. This free theme is simple and straightforward with a handful of options such as social media options for promoting your business. The stunning CSS animations make the site look active and the clean codes add to the speed of your site giving faster page load time. It has a design that adjusts seamlessly to every screen size giving a responsive website that can be easily accessed using any device. Being a Bootstrap-based theme, you get a clean design with lots of customization options to get a personalized look. You get SEO-friendly codes and a translation-ready design.','florist-flower-shop'); ?></p>		  	
			  	<div class="col-left-inner">
			  		<h4><?php esc_html_e( 'Theme Documentation', 'florist-flower-shop' ); ?></h4>
					<p><?php esc_html_e( 'If you need any assistance regarding setting up and configuring the Theme, our documentation is there.', 'florist-flower-shop' ); ?></p>
					<div class="info-link">
						<a href="<?php echo esc_url( FLORIST_FLOWER_SHOP_FREE_THEME_DOC ); ?>" target="_blank"> <?php esc_html_e( 'Documentation', 'florist-flower-shop' ); ?></a>
					</div>
					<hr>
					<h4><?php esc_html_e('Theme Customizer', 'florist-flower-shop'); ?></h4>
					<p> <?php esc_html_e('To begin customizing your website, start by clicking "Customize".', 'florist-flower-shop'); ?></p>
					<div class="info-link">
						<a target="_blank" href="<?php echo esc_url( admin_url('customize.php') ); ?>"><?php esc_html_e('Customizing', 'florist-flower-shop'); ?></a>
					</div>
					<hr>				
					<h4><?php esc_html_e('Having Trouble, Need Support?', 'florist-flower-shop'); ?></h4>
					<p> <?php esc_html_e('Our dedicated team is well prepared to help you out in case of queries and doubts regarding our theme.', 'florist-flower-shop'); ?></p>
					<div class="info-link">
						<a href="<?php echo esc_url( FLORIST_FLOWER_SHOP_SUPPORT ); ?>" target="_blank"><?php esc_html_e('Support Forum', 'florist-flower-shop'); ?></a>
					</div>
					<hr>
					<h4><?php esc_html_e('Reviews & Testimonials', 'florist-flower-shop'); ?></h4>
					<p> <?php esc_html_e('All the features and aspects of this WordPress Theme are phenomenal. I\'d recommend this theme to all.', 'florist-flower-shop'); ?></p>
					<div class="info-link">
						<a href="<?php echo esc_url( FLORIST_FLOWER_SHOP_REVIEW ); ?>" target="_blank"><?php esc_html_e('Reviews', 'florist-flower-shop'); ?></a>
					</div>
					<div class="link-customizer">
						<h3><?php esc_html_e( 'Link to customizer', 'florist-flower-shop' ); ?></h3>
						<hr class="h3hr">
						<div class="first-row">
							<div class="row-box">
								<div class="row-box1">
									<span class="dashicons dashicons-buddicons-buddypress-logo"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[control]=custom_logo') ); ?>" target="_blank"><?php esc_html_e('Upload your logo','florist-flower-shop'); ?></a>
								</div>
								<div class="row-box2">
									<span class="dashicons dashicons-slides"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=florist_flower_shop_slidersettings') ); ?>" target="_blank"><?php esc_html_e('Slider Settings','florist-flower-shop'); ?></a>
								</div>
							</div>
							<div class="row-box">
								<div class="row-box1">
									<span class="dashicons dashicons-welcome-write-blog"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=florist_flower_shop_top_header') ); ?>" target="_blank"><?php esc_html_e('Top Header Section','florist-flower-shop'); ?></a>
								</div>
								<div class="row-box2">
									<span class="dashicons dashicons-category"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=florist_flower_shop_product_slide_section') ); ?>" target="_blank"><?php esc_html_e('Popular Product Section','florist-flower-shop'); ?></a>
								</div>
							</div>
							<div class="row-box">
								<div class="row-box1">
									<span class="dashicons dashicons-menu"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[panel]=nav_menus') ); ?>" target="_blank"><?php esc_html_e('Menus','florist-flower-shop'); ?></a>
								</div>
								<div class="row-box2">
									<span class="dashicons dashicons-screenoptions"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[panel]=widgets') ); ?>" target="_blank"><?php esc_html_e('Footer Widget','florist-flower-shop'); ?></a>
								</div>
							</div>

							<div class="row-box">
								<div class="row-box1">
									<span class="dashicons dashicons-format-gallery"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=florist_flower_shop_post_settings') ); ?>" target="_blank"><?php esc_html_e('Post settings','florist-flower-shop'); ?></a>
								</div>
								 <div class="row-box2">
									<span class="dashicons dashicons-editor-table"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=florist_flower_shop_product_section') ); ?>" target="_blank"><?php esc_html_e('BestSelling Product','florist-flower-shop'); ?></a>
								</div> 
							</div>
							
							<div class="row-box">
								<div class="row-box1">
									<span class="dashicons dashicons-admin-generic"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=florist_flower_shop_left_right') ); ?>" target="_blank"><?php esc_html_e('General Settings','florist-flower-shop'); ?></a>
								</div>
								<div class="row-box2">
									<span class="dashicons dashicons-text-page"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=florist_flower_shop_footer') ); ?>" target="_blank"><?php esc_html_e('Footer Text','florist-flower-shop'); ?></a>
								</div>
							</div>
						</div>
					</div>
			  	</div>
				<div class="col-right-inner">
					<h3 class="page-template"><?php esc_html_e('How to set up Home Page Template','florist-flower-shop'); ?></h3>
				  	<hr class="h3hr">
					<p><?php esc_html_e('Follow these instructions to setup Home page.','florist-flower-shop'); ?></p>
                  	<p><span class="strong"><?php esc_html_e('1. Create a new page :','florist-flower-shop'); ?></span><?php esc_html_e(' Go to ','florist-flower-shop'); ?>
					  	<b><?php esc_html_e(' Dashboard >> Pages >> Add New Page','florist-flower-shop'); ?></b></p>
                  	<p><?php esc_html_e('Name it as "Home" then select the template "Custom Home Page".','florist-flower-shop'); ?></p>
                  	<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getstart/images/home-page-template.png" alt="" />
                  	<p><span class="strong"><?php esc_html_e('2. Set the front page:','florist-flower-shop'); ?></span><?php esc_html_e(' Go to ','florist-flower-shop'); ?>
					  	<b><?php esc_html_e(' Settings >> Reading ','florist-flower-shop'); ?></b></p>
				  	<p><?php esc_html_e('Select the option of Static Page, now select the page you created to be the homepage, while another page to be your default page.','florist-flower-shop'); ?></p>
                  	<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getstart/images/set-front-page.png" alt="" />
                  	<p><?php esc_html_e(' Once you are done with setup, then follow the','florist-flower-shop'); ?> <a class="doc-links" href="<?php echo esc_url( FLORIST_FLOWER_SHOP_FREE_THEME_DOC ); ?>" target="_blank"><?php esc_html_e('Documentation','florist-flower-shop'); ?></a></p>
			  	</div>
			</div>
		</div>	


		<div id="pro_theme" class="tabcontent">
		  	<h3><?php esc_html_e( 'Premium Theme Information', 'florist-flower-shop' ); ?></h3>
			<hr class="h3hr">
		    <div class="col-left-pro">
		    	<p><?php esc_html_e('Flower shop WordPress theme has prime focus on floral business and you can accomplish this through a good floral website. It is clean, modern and alluring and you can also open a floral shop agency. It is a nice choice for the floristic studio and also has the blog post section as well as contact page template. You can make a website for horticulture or for the flowers that you grow in your apartment. WordPress theme for flower shop has testimonial section apart from enable disable options on all sections. It has the footer widgets and editor style and the prime focus of this WP theme is on the florist services. It has the social media feature apart from being retina ready, translation ready and with WooCommerce. With WooCommerce compatibility, you can open an online shop for sale of fresh or synthetic flowers. It is translation ready, SEO ready with more than 100 font family options.','florist-flower-shop'); ?></p>
		    </div>
		    <div class="col-right-pro">
		    	<div class="pro-links">
			    	<a href="<?php echo esc_url( FLORIST_FLOWER_SHOP_LIVE_DEMO ); ?>" target="_blank"><?php esc_html_e('Live Demo', 'florist-flower-shop'); ?></a>
					<a href="<?php echo esc_url( FLORIST_FLOWER_SHOP_BUY_NOW ); ?>" target="_blank"><?php esc_html_e('Buy Pro', 'florist-flower-shop'); ?></a>
					<a href="<?php echo esc_url( FLORIST_FLOWER_SHOP_PRO_DOC ); ?>" target="_blank"><?php esc_html_e('Pro Documentation', 'florist-flower-shop'); ?></a>
					<a href="<?php echo esc_url( FLORIST_FLOWER_SHOP_THEME_BUNDLE_BUY_NOW ); ?>" target="_blank"><?php esc_html_e('Get 250+ Themes Bundle at $99', 'florist-flower-shop'); ?></a>
				</div>
		    	<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getstart/images/responsive.png" alt="" />
		    </div>
		</div>

		<div id="lite_pro" class="tabcontent">
		  	<div class="featurebox">
			    <h3><?php esc_html_e( 'Theme Features', 'florist-flower-shop' ); ?></h3>
				<hr class="h3hr">
				<div class="table-image">
					<table class="tablebox">
						<thead>
							<tr>
								<th></th>
								<th><?php esc_html_e('Free Themes', 'florist-flower-shop'); ?></th>
								<th><?php esc_html_e('Premium Themes', 'florist-flower-shop'); ?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?php esc_html_e('Theme Customization', 'florist-flower-shop'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Responsive Design', 'florist-flower-shop'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Logo Upload', 'florist-flower-shop'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Social Media Links', 'florist-flower-shop'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Slider Settings', 'florist-flower-shop'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Number of Slides', 'florist-flower-shop'); ?></td>
								<td class="table-img"><?php esc_html_e('4', 'florist-flower-shop'); ?></td>
								<td class="table-img"><?php esc_html_e('Unlimited', 'florist-flower-shop'); ?></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Template Pages', 'florist-flower-shop'); ?></td>
								<td class="table-img"><?php esc_html_e('3', 'florist-flower-shop'); ?></td>
								<td class="table-img"><?php esc_html_e('6', 'florist-flower-shop'); ?></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Home Page Template', 'florist-flower-shop'); ?></td>
								<td class="table-img"><?php esc_html_e('1', 'florist-flower-shop'); ?></td>
								<td class="table-img"><?php esc_html_e('1', 'florist-flower-shop'); ?></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Theme sections', 'florist-flower-shop'); ?></td>
								<td class="table-img"><?php esc_html_e('3', 'florist-flower-shop'); ?></td>
								<td class="table-img"><?php esc_html_e('10', 'florist-flower-shop'); ?></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Contact us Page Template', 'florist-flower-shop'); ?></td>
								<td class="table-img">0</td>
								<td class="table-img"><?php esc_html_e('1', 'florist-flower-shop'); ?></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Blog Templates & Layout', 'florist-flower-shop'); ?></td>
								<td class="table-img">0</td>
								<td class="table-img"><?php esc_html_e('3(Full width/Left/Right Sidebar)', 'florist-flower-shop'); ?></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Page Templates & Layout', 'florist-flower-shop'); ?></td>
								<td class="table-img">0</td>
								<td class="table-img"><?php esc_html_e('2(Left/Right Sidebar)', 'florist-flower-shop'); ?></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Color Pallete For Particular Sections', 'florist-flower-shop'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Global Color Option', 'florist-flower-shop'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Section Reordering', 'florist-flower-shop'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Demo Importer', 'florist-flower-shop'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Allow To Set Site Title, Tagline, Logo', 'florist-flower-shop'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Enable Disable Options On All Sections, Logo', 'florist-flower-shop'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Full Documentation', 'florist-flower-shop'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Latest WordPress Compatibility', 'florist-flower-shop'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Woo-Commerce Compatibility', 'florist-flower-shop'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Support 3rd Party Plugins', 'florist-flower-shop'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Secure and Optimized Code', 'florist-flower-shop'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Exclusive Functionalities', 'florist-flower-shop'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Section Enable / Disable', 'florist-flower-shop'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Section Google Font Choices', 'florist-flower-shop'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Gallery', 'florist-flower-shop'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Simple & Mega Menu Option', 'florist-flower-shop'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Support to add custom CSS / JS ', 'florist-flower-shop'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Shortcodes', 'florist-flower-shop'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Custom Background, Colors, Header, Logo & Menu', 'florist-flower-shop'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Premium Membership', 'florist-flower-shop'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Budget Friendly Value', 'florist-flower-shop'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Priority Error Fixing', 'florist-flower-shop'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Custom Feature Addition', 'florist-flower-shop'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('All Access Theme Pass', 'florist-flower-shop'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Seamless Customer Support', 'florist-flower-shop'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td></td>
								<td class="table-img"></td>
								<td class="update-link"><a href="<?php echo esc_url( FLORIST_FLOWER_SHOP_BUY_NOW ); ?>" target="_blank"><?php esc_html_e('Upgrade to Pro', 'florist-flower-shop'); ?></a></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div id="get_bundle" class="tabcontent">		  	
		   <div class="col-left-pro">
		   	<h3><?php esc_html_e( 'WP Theme Bundle', 'florist-flower-shop' ); ?></h3>
		    	<p><?php esc_html_e('Enhance your website effortlessly with our WP Theme Bundle. Get access to 250+ premium WordPress themes and 5+ powerful plugins, all designed to meet diverse business needs. Enjoy seamless integration with any plugins, ultimate customization flexibility, and regular updates to keep your site current and secure. Plus, benefit from our dedicated customer support, ensuring a smooth and professional web experience.','florist-flower-shop'); ?></p>
		    	<div class="feature">
		    		<h4><?php esc_html_e( 'Features:', 'florist-flower-shop' ); ?></h4>
		    		<p><?php esc_html_e('250+ Premium Themes & 5+ Plugins.', 'florist-flower-shop'); ?></p>
		    		<p><?php esc_html_e('Seamless Integration.', 'florist-flower-shop'); ?></p>
		    		<p><?php esc_html_e('Customization Flexibility.', 'florist-flower-shop'); ?></p>
		    		<p><?php esc_html_e('Regular Updates.', 'florist-flower-shop'); ?></p>
		    		<p><?php esc_html_e('Dedicated Support.', 'florist-flower-shop'); ?></p>
		    	</div>
		    	<p><?php esc_html_e('Upgrade now and give your website the professional edge it deserves, all at an unbeatable price of $99!', 'florist-flower-shop'); ?></p>
		    	<div class="pro-links">
					<a href="<?php echo esc_url( FLORIST_FLOWER_SHOP_THEME_BUNDLE_BUY_NOW ); ?>" target="_blank"><?php esc_html_e('Buy Now', 'florist-flower-shop'); ?></a>
					<a href="<?php echo esc_url( FLORIST_FLOWER_SHOP_THEME_BUNDLE_DOC ); ?>" target="_blank"><?php esc_html_e('Documentation', 'florist-flower-shop'); ?></a>
				</div>
		   </div>
		   <div class="col-right-pro">
		    	<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getstart/images/bundle.png" alt="" />
		   </div>		    
		</div>
		
	</div>
</div>

<?php } ?>