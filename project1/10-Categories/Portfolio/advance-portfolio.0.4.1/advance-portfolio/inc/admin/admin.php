<?php
//about theme info
add_action( 'admin_menu', 'advance_portfolio_abouttheme' );
function advance_portfolio_abouttheme() {    	
	add_theme_page( esc_html__('About Portfolio Theme', 'advance-portfolio'), esc_html__('About Portfolio Theme', 'advance-portfolio'), 'edit_theme_options', 'advance_portfolio_guide', 'advance_portfolio_mostrar_guide');   
}

// Add a Custom CSS file to WP Admin Area
function advance_portfolio_admin_theme_style() {
   wp_enqueue_style('advance-portfolio-custom-admin-style', get_template_directory_uri() .'/inc/admin/admin.css');
}
add_action('admin_enqueue_scripts', 'advance_portfolio_admin_theme_style');

//guidline for about theme
function advance_portfolio_mostrar_guide() {
	//custom function about theme customizer
	$return = add_query_arg( array()) ;
?>
<div class="wrapper-info">
	 <div class="header">
	 	<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/admin/images/logo.png" alt="" />
 		<p><?php esc_html_e('Most of our outstanding theme is elegant, responsive, multifunctional, SEO friendly has amazing features and functionalities that make them highly demanding for designers and bloggers, who ought to excel in web development domain. Our Themeshopy has got everything that an individual and group need to be successful in their venture.', 'advance-portfolio'); ?></p>
		<div class="main-button">
			<a href="<?php echo esc_url( ADVANCE_PORTFOLIO_BUY_NOW ); ?>" target="_blank"><?php esc_html_e('Buy Now', 'advance-portfolio'); ?></a>
			<a href="<?php echo esc_url( ADVANCE_PORTFOLIO_LIVE_DEMO ); ?>"><?php esc_html_e('Live Demo', 'advance-portfolio'); ?></a>
			<a href="<?php echo esc_url( ADVANCE_PORTFOLIO_PRO_DOC ); ?>" target="_blank"><?php esc_html_e('Pro Documentation', 'advance-portfolio'); ?></a>
		</div>
	</div>
	<div class="button-bg">
	<button role="tab" class="tablink" onclick="openPage('Home', this, '')"><?php esc_html_e('Lite Theme Setup', 'advance-portfolio'); ?></button>
	<button role="tab" class="tablink" onclick="openPage('Contact', this, '')"><?php esc_html_e('Premium Theme info', 'advance-portfolio'); ?></button>
	</div>
	<div id="Home" class="tabcontent tab1">
	  	<h3><?php esc_html_e('How to set up homepage', 'advance-portfolio'); ?></h3>
	  	<div class="sec-button">
			<a href="<?php echo esc_url( ADVANCE_PORTFOLIO_FREE_DOC ); ?>" target="_blank"><?php esc_html_e('Documentation', 'advance-portfolio'); ?></a>
			<a href="<?php echo esc_url( ADVANCE_PORTFOLIO_CONTACT ); ?>"><?php esc_html_e('Support', 'advance-portfolio'); ?></a>
			<a target="_blank" href="<?php echo esc_url( admin_url('customize.php') ); ?>"><?php esc_html_e('Start Customizing', 'advance-portfolio'); ?></a>
		</div>
	  	<div class="documentation">
		  	<div class="image-docs">
				<ul>
					<li> <b><?php esc_html_e('Step 1.', 'advance-portfolio'); ?></b> <?php esc_html_e('Follow these instructions to setup Home page.', 'advance-portfolio'); ?></li>
					<li> <b><?php esc_html_e('Step 2.', 'advance-portfolio'); ?></b> <?php esc_html_e(' Create Page to set template: Go to Dashboard >> Pages >> Add New Page.Label it "home" or anything as you wish. Then select template "home-page" from template dropdown.', 'advance-portfolio'); ?></li>
				</ul>
		  	</div>
		  	<div class="doc-image">
		  		<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/admin/images/home-page-template.png" alt="" />	
		  	</div>
		  	<div class="clearfixed">
				<div class="doc-image1">
					<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/admin/images/set-front-page.png" alt="" />	
			    </div>
			    <div class="image-docs1">
				    <ul>
						<li> <b><?php esc_html_e('Step 3.', 'advance-portfolio'); ?></b> <?php esc_html_e('Set the front page: Go to Setting >> Reading >> Set the front page display static page to home page', 'advance-portfolio'); ?></li>
					</ul>
			  	</div>
			</div>
		</div>
	</div>

	<div id="Contact" class="tabcontent">
	 	<h3><?php esc_html_e('Premium Theme Info', 'advance-portfolio'); ?></h3>
	  	<div class="sec-button">
			<a href="<?php echo esc_url( ADVANCE_PORTFOLIO_BUY_NOW ); ?>" target="_blank"><?php esc_html_e('Buy Now', 'advance-portfolio'); ?></a>
			<a href="<?php echo esc_url( ADVANCE_PORTFOLIO_LIVE_DEMO ); ?>"><?php esc_html_e('Live Demo', 'advance-portfolio'); ?></a>
			<a href="<?php echo esc_url( ADVANCE_PORTFOLIO_PRO_DOC ); ?>" target="_blank"><?php esc_html_e('Pro Documentation', 'advance-portfolio'); ?></a>
		</div>
	  	<div class="features-section">
	  		<div class="col-4">
	  			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/admin/images/Responsive.jpg" alt="" />
	  			<p><?php esc_html_e( 'The WordPress portfolio theme is a clean, visually promising, flexible and well-structured theme for creating portfolios, photography sites, design studios, graphic designers, artists, painters, blogs and used for many other artistic purposes. It is a pleasure to work on this beautiful theme which is designed with great care to help WordPress newbies and webmasters to use it without requiring any coding knowledge. Its design is decorated with all the necessary elements giving it a look suitable for portfolio site. This WordPress portfolio theme has all the modern amenities present to build a niche-specific website in just few minutes. Its cascading sections will never allow visitors to lose interest in you content. It is a responsive theme with great fluidity for all screen sizes. It is made cross-browser compatible as we know everyone uses different browsers. The theme is bundled with .po and .mo files to get it translated in other languages easily.', 'advance-portfolio' ); ?></p>
	  		</div>
	  		<div class="col-4">
	  			<h4><?php esc_html_e( 'Theme Features', 'advance-portfolio' ); ?></h4>
				<ul>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Theme options using customizer API', 'advance-portfolio' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Responsive Design', 'advance-portfolio' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Favicon, Logo, Title and Tagline Customization', 'advance-portfolio' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Advanced Color Options and Color Pallets', 'advance-portfolio' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( '100+ Font Family Options', 'advance-portfolio' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Support to Add Custom CSS/JS', 'advance-portfolio' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'SEO Friendly', 'advance-portfolio' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Pagination Option', 'advance-portfolio' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Compatible With Different WordPress Famous Plugins Like Contact Form 7 and Woocommerce', 'advance-portfolio' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Enable-Disable Options on All Sections', 'advance-portfolio' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Footer Customization Options', 'advance-portfolio' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Fully Integrated with Font Awesome Icon', 'advance-portfolio' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Short Codes', 'advance-portfolio' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Background Image Option', 'advance-portfolio' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Custom Page Templates', 'advance-portfolio' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Featured Product Images, HD Images and Video display', 'advance-portfolio' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Allow To Set Site Title, Tagline, Logo', 'advance-portfolio' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Make Post About Firms News, Events, Achievements and So On.', 'advance-portfolio' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Left and Right Sidebar', 'advance-portfolio' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Sticky Post & Comment Threads', 'advance-portfolio' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Parallax Image-Background Section', 'advance-portfolio' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Custom Backgrounds, Colors, Headers, Logo & Menu', 'advance-portfolio' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Customizable Home Page', 'advance-portfolio' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Full-Width Template', 'advance-portfolio' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Gallery, Banner & Post Type Plugin Functionality', 'advance-portfolio' ); ?></li>
					<li><span class="dashicons dashicons-arrow-right"></span><?php esc_html_e( 'Advance Social Media Feature', 'advance-portfolio' ); ?></li>
				</ul>
			</div>
		</div>
	</div>

<script type="text/javascript">
	function openPage(pageName,elmnt,color) {
	    var i, tabcontent, tablinks;
		    tabcontent = document.getElementsByClassName("tabcontent");
		    for (i = 0; i < tabcontent.length; i++) {
		        tabcontent[i].style.display = "none";
	    }
	    tablinks = document.getElementsByClassName("tablink");
		    for (i = 0; i < tablinks.length; i++) {
		        tablinks[i].style.backgroundColor = "";
	    }
	    document.getElementById(pageName).style.display = "block";
	    elmnt.style.backgroundColor = color;

	}
	// Get the element with id="defaultOpen" and click on it
	document.getElementById("defaultOpen").click();
</script>
<?php } ?>