<?php
	
	$advance_portfolio_theme_color_first = get_theme_mod('advance_portfolio_theme_color_first');

	$custom_css = '';

	if($advance_portfolio_theme_color_first != false){
		$custom_css .='.read-moresec a.button, .second-border a:hover, #footer input[type="submit"], .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button,.woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, #sidebar input[type="submit"], #sidebar .tagcloud a:hover, .pagination a:hover, .pagination .current, .woocommerce span.onsale,  #comments input[type="submit"].submit, #footer .tagcloud a:hover,.meta-nav:hover,#comments a.comment-reply-link,.tags p a:hover,#menu-sidebar input[type="submit"]{';
			$custom_css .='background-color: '.esc_html($advance_portfolio_theme_color_first).';';
		$custom_css .='}';
	}
	if($advance_portfolio_theme_color_first != false){
		$custom_css .=' nav.woocommerce-MyAccount-navigation ul li, #banner .social-media i:hover{';
			$custom_css .='background-color: '.esc_html($advance_portfolio_theme_color_first).'!important;';
		$custom_css .='}';
	}

	if($advance_portfolio_theme_color_first != false){
		$custom_css .='.social-media i:hover,#footer h3,.woocommerce-message::before, h1.entry-title,#footer h3.widget-title a, #footer li a:hover, .primary-navigation li a:hover,.metabox a:hover,#sidebar ul li a:hover,.sf-arrows ul li > .sf-with-ul:focus:after,.sf-arrows ul li:hover > .sf-with-ul:after,.sf-arrows .sfHover > .sf-with-ul:after,.sf-arrows ul .sf-with-ul:after,.tags i{';
			$custom_css .='color: '.esc_html($advance_portfolio_theme_color_first).';';
		$custom_css .='}';
	}
	
	if($advance_portfolio_theme_color_first != false){
		$custom_css .='#footer input[type="search"], #footer input[type="submit"], #footer .tagcloud a:hover,.second-border a:hover,.primary-navigation ul ul{';
			$custom_css .='border-color: '.esc_html($advance_portfolio_theme_color_first).';';
		$custom_css .='}';
	}
	if($advance_portfolio_theme_color_first != false){
		$custom_css .='.primary-navigation ul ul{';
			$custom_css .='border-top-color: '.esc_html($advance_portfolio_theme_color_first).' !important;';
		$custom_css .='}';
	}

/*---------------------------Theme color option-------------------*/

	$advance_portfolio_theme_color_second = get_theme_mod('advance_portfolio_theme_color_second');

	if($advance_portfolio_theme_color_second != false){
		$custom_css .='#header .horizontal, #header, #header .horizontal, #header, #banner .social-media i:hover, #header .horizontal, #header{';
			$custom_css .='background-color: '.esc_html($advance_portfolio_theme_color_second).';';
		$custom_css .='}';
	}
	if($advance_portfolio_theme_color_second != false){
		$custom_css .='#banner .social-media i:hover, #banner .social-media i:hover{';
			$custom_css .='color: '.esc_html($advance_portfolio_theme_color_second).';';
		$custom_css .='}';
	}
	if($advance_portfolio_theme_color_second != false){
		$custom_css .='.page-box, .page-box, .page-box{';
			$custom_css .='border-color: '.esc_html($advance_portfolio_theme_color_second).';';
		$custom_css .='}';
	}

// media

	$custom_css .='@media screen and (max-width:1000px) {';
	if($advance_portfolio_theme_color_second != false || $advance_portfolio_theme_color_first != false){
	$custom_css .='#menu-sidebar, .primary-navigation ul ul a, .primary-navigation li a:hover, .primary-navigation li:hover a, #contact-info{
	background-image: linear-gradient(-90deg, '.esc_html($advance_portfolio_theme_color_second).' 0%, '.esc_html($advance_portfolio_theme_color_first).' 120%);
		} ';
	}
	$custom_css .='}';

	/*---------------------------Width Layout -------------------*/

	$theme_lay = get_theme_mod( 'advance_portfolio_theme_options','Default');
    if($theme_lay == 'Default'){
		$custom_css .='body{';
			$custom_css .='max-width: 100%;';
		$custom_css .='}';
		$custom_css .='.page-template-custom-home-page .middle-header{';
			$custom_css .='width: 97.3%';
		$custom_css .='}';
	}else if($theme_lay == 'Container'){
		$custom_css .='body{';
			$custom_css .='width: 100%;padding-right: 15px;padding-left: 15px;margin-right: auto;margin-left: auto;';
		$custom_css .='}';
		$custom_css .='.page-template-custom-front-page #header{';
			$custom_css .='right:0;';
		$custom_css .='}';
		$custom_css .='.serach_outer{';
			$custom_css .='width: 97.7%;padding-right: 15px;padding-left: 15px;margin-right: auto;margin-left: auto';
		$custom_css .='}';
	}else if($theme_lay == 'Box Container'){
		$custom_css .='body{';
			$custom_css .='max-width: 1140px; width: 100%; padding-right: 15px; padding-left: 15px; margin-right: auto; margin-left: auto;';
		$custom_css .='}';
		$custom_css .='.page-template-custom-front-page #header{';
			$custom_css .='right:0;';
		$custom_css .='}';
		$custom_css .='.serach_outer{';
			$custom_css .='max-width: 1140px; width: 100%; padding-right: 15px; padding-left: 15px; margin-right: auto; margin-left: auto; right:0';
		$custom_css .='}';
	}

	// css
	$show_header = get_theme_mod( 'advance_portfolio_page_settings', true);
		if($show_header == false){
			$custom_css .='.page-template-custom-front-page #header{';
				$custom_css .='position:static; background-color: #ffdd65;';
			$custom_css .='}';
	}

/*---------------------------Slider Content Layout -------------------*/

	$theme_lay = get_theme_mod( 'advance_portfolio_banner_content_alignment','Left');
    if($theme_lay == 'Left'){
		$custom_css .='.box-content,.box-content h1{';
			$custom_css .='text-align:left; left:9%; right:50%;';
		$custom_css .='}';
	}else if($theme_lay == 'Center'){
		$custom_css .='.box-content,.box-content h1{';
			$custom_css .='text-align:center; left:20%; right:20%;';
		$custom_css .='}';
	}else if($theme_lay == 'Right'){
		$custom_css .='.box-content,.box-content h1{';
			$custom_css .='text-align:right; left:50%; right:9%;';
		$custom_css .='}';
	}

	/*--------------------------- Slider Opacity -------------------*/

	$theme_lay = get_theme_mod( 'advance_portfolio_banner_image_opacity','0.6');
	if($theme_lay == '0'){
		$custom_css .='#banner img{';
			$custom_css .='opacity:0';
		$custom_css .='}';
		}else if($theme_lay == '0.1'){
		$custom_css .='#banner img{';
			$custom_css .='opacity:0.1';
		$custom_css .='}';
		}else if($theme_lay == '0.2'){
		$custom_css .='#banner img{';
			$custom_css .='opacity:0.2';
		$custom_css .='}';
		}else if($theme_lay == '0.3'){
		$custom_css .='#banner img{';
			$custom_css .='opacity:0.3';
		$custom_css .='}';
		}else if($theme_lay == '0.4'){
		$custom_css .='#banner img{';
			$custom_css .='opacity:0.4';
		$custom_css .='}';
		}else if($theme_lay == '0.5'){
		$custom_css .='#banner img{';
			$custom_css .='opacity:0.5';
		$custom_css .='}';
		}else if($theme_lay == '0.6'){
		$custom_css .='#banner img{';
			$custom_css .='opacity:0.6';
		$custom_css .='}';
		}else if($theme_lay == '0.7'){
		$custom_css .='#banner img{';
			$custom_css .='opacity:0.7';
		$custom_css .='}';
		}else if($theme_lay == '0.8'){
		$custom_css .='#banner img{';
			$custom_css .='opacity:0.8';
		$custom_css .='}';
		}else if($theme_lay == '0.9'){
		$custom_css .='#banner img{';
			$custom_css .='opacity:0.9';
		$custom_css .='}';
		}

	/*-------------------------- Button Settings option------------------*/

	$advance_portfolio_button_padding_top_bottom = get_theme_mod('advance_portfolio_button_padding_top_bottom');
	$advance_portfolio_button_padding_left_right = get_theme_mod('advance_portfolio_button_padding_left_right');
	if($advance_portfolio_button_padding_top_bottom != false || $advance_portfolio_button_padding_left_right != false){
		$custom_css .=' #comments .form-submit input[type="submit"],.second-border a{';
			$custom_css .='padding-top: '.esc_html($advance_portfolio_button_padding_top_bottom).'px; padding-bottom: '.esc_html($advance_portfolio_button_padding_top_bottom).'px; padding-left: '.esc_html($advance_portfolio_button_padding_left_right).'px; padding-right: '.esc_html($advance_portfolio_button_padding_left_right).'px; display:inline-block;';
		$custom_css .='}';
	}

	$advance_portfolio_button_border_radius = get_theme_mod('advance_portfolio_button_border_radius');
	if($advance_portfolio_button_border_radius != false){
		$custom_css .='#comments .form-submit input[type="submit"], .second-border a{';
			$custom_css .='border-radius: '.esc_html($advance_portfolio_button_border_radius).'px;';
		$custom_css .='}';
	}

	/*-----------------------------Responsive Setting --------------------*/

	$stickyheader = get_theme_mod( 'advance_portfolio_responsive_sticky_header',true);
	if($stickyheader == true && get_theme_mod( 'advance_portfolio_sticky_header') == false){
    	$custom_css .='.fixed-header{';
			$custom_css .='position:static;';
		$custom_css .='} ';
	}
    if($stickyheader == true){
    	$custom_css .='@media screen and (max-width:575px) {';
		$custom_css .='.fixed-header{';
			$custom_css .='position:fixed;';
		$custom_css .='} }';
	}else if($stickyheader == false){
		$custom_css .='@media screen and (max-width:575px) {';
		$custom_css .='.fixed-header{';
			$custom_css .='position:static;';
		$custom_css .='} }';
	}

	$stickyheader = get_theme_mod( 'advance_portfolio_responsive_slider',true);
    if($stickyheader == true){
    	$custom_css .='@media screen and (max-width:575px) {';
		$custom_css .='#banner{';
			$custom_css .='display:block;';
		$custom_css .='} }';
	}else if($stickyheader == false){
		$custom_css .='@media screen and (max-width:575px) {';
		$custom_css .='#banner{';
			$custom_css .='display:none;';
		$custom_css .='} }';
	}

	$metabox = get_theme_mod( 'advance_portfolio_responsive_metabox',true);
    if($metabox == true){
    	$custom_css .='@media screen and (max-width:575px) {';
		$custom_css .='.metabox{';
			$custom_css .='display:block;';
		$custom_css .='} }';
	}else if($metabox == false){
		$custom_css .='@media screen and (max-width:575px) {';
		$custom_css .='.metabox{';
			$custom_css .='display:none;';
		$custom_css .='} }';
	}

	$sidebar = get_theme_mod( 'advance_portfolio_responsive_sidebar',true);
    if($sidebar == true){
    	$custom_css .='@media screen and (max-width:575px) {';
		$custom_css .='#sidebar{';
			$custom_css .='display:block;';
		$custom_css .='} }';
	}else if($sidebar == false){
		$custom_css .='@media screen and (max-width:575px) {';
		$custom_css .='#sidebar{';
			$custom_css .='display:none;';
		$custom_css .='} }';
	}

	/*------------------ Skin Option  -------------------*/

	$theme_lay = get_theme_mod( 'advance_portfolio_background_skin_mode','Transparent Background');
    if($theme_lay == 'With Background'){
		$custom_css .='.page-box, #sidebar .widget,.woocommerce ul.products li.product, .woocommerce-page ul.products li.product,.front-page-content,.background-img-skin,#Portfolio-Section .box-image{';
			$custom_css .='background-color: #fff;';
		$custom_css .='}';
	}else if($theme_lay == 'Transparent Background'){
		$custom_css .='.page-box-single{';
			$custom_css .='background-color: transparent;';
		$custom_css .='}';
	}

	/*------------ Woocommerce Settings  --------------*/

	$advance_portfolio_top_bottom_product_button_padding = get_theme_mod('advance_portfolio_top_bottom_product_button_padding', 10);
	if($advance_portfolio_top_bottom_product_button_padding != false){
		$custom_css .='.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce input.button.alt, .woocommerce button.button:disabled, .woocommerce button.button:disabled[disabled], .woocommerce .cart .button, .woocommerce .cart input.button{';
			$custom_css .='padding-top: '.esc_html($advance_portfolio_top_bottom_product_button_padding).'px; padding-bottom: '.esc_html($advance_portfolio_top_bottom_product_button_padding).'px;';
		$custom_css .='}';
	}

	$advance_portfolio_left_right_product_button_padding = get_theme_mod('advance_portfolio_left_right_product_button_padding', 16);
	if($advance_portfolio_left_right_product_button_padding != false){
		$custom_css .='.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce input.button.alt, .woocommerce button.button:disabled, .woocommerce button.button:disabled[disabled], .woocommerce .cart .button, .woocommerce .cart input.button{';
			$custom_css .='padding-left: '.esc_html($advance_portfolio_left_right_product_button_padding).'px; padding-right: '.esc_html($advance_portfolio_left_right_product_button_padding).'px;';
		$custom_css .='}';
	}

	$advance_portfolio_product_button_border_radius = get_theme_mod('advance_portfolio_product_button_border_radius', 0);
	if($advance_portfolio_product_button_border_radius != false){
		$custom_css .='.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce input.button.alt, .woocommerce button.button:disabled, .woocommerce button.button:disabled[disabled], .woocommerce .cart .button, .woocommerce .cart input.button{';
			$custom_css .='border-radius: '.esc_html($advance_portfolio_product_button_border_radius).'px;';
		$custom_css .='}';
	}

	$advance_portfolio_show_related_products = get_theme_mod('advance_portfolio_show_related_products',true);
	if($advance_portfolio_show_related_products == false){
		$custom_css .='.related.products{';
			$custom_css .='display: none;';
		$custom_css .='}';
	}

	$advance_portfolio_show_wooproducts_border = get_theme_mod('advance_portfolio_show_wooproducts_border', true);
	if($advance_portfolio_show_wooproducts_border == false){
		$custom_css .='.products li{';
			$custom_css .='border: none;';
		$custom_css .='}';
	}

	$advance_portfolio_top_bottom_wooproducts_padding = get_theme_mod('advance_portfolio_top_bottom_wooproducts_padding',10);
	if($advance_portfolio_top_bottom_wooproducts_padding != false){
		$custom_css .='.woocommerce ul.products li.product, .woocommerce-page ul.products li.product{';
			$custom_css .='padding-top: '.esc_html($advance_portfolio_top_bottom_wooproducts_padding).'px !important; padding-bottom: '.esc_html($advance_portfolio_top_bottom_wooproducts_padding).'px !important;';
		$custom_css .='}';
	}

	$advance_portfolio_left_right_wooproducts_padding = get_theme_mod('advance_portfolio_left_right_wooproducts_padding',10);
	if($advance_portfolio_left_right_wooproducts_padding != false){
		$custom_css .='.woocommerce ul.products li.product, .woocommerce-page ul.products li.product{';
			$custom_css .='padding-left: '.esc_html($advance_portfolio_left_right_wooproducts_padding).'px !important; padding-right: '.esc_html($advance_portfolio_left_right_wooproducts_padding).'px !important;';
		$custom_css .='}';
	}

	$advance_portfolio_wooproducts_border_radius = get_theme_mod('advance_portfolio_wooproducts_border_radius',0);
	if($advance_portfolio_wooproducts_border_radius != false){
		$custom_css .='.woocommerce ul.products li.product, .woocommerce-page ul.products li.product{';
			$custom_css .='border-radius: '.esc_html($advance_portfolio_wooproducts_border_radius).'px;';
		$custom_css .='}';
	}

	$advance_portfolio_wooproducts_box_shadow = get_theme_mod('advance_portfolio_wooproducts_box_shadow',0);
	if($advance_portfolio_wooproducts_box_shadow != false){
		$custom_css .='.woocommerce ul.products li.product, .woocommerce-page ul.products li.product{';
			$custom_css .='box-shadow: '.esc_html($advance_portfolio_wooproducts_box_shadow).'px '.esc_html($advance_portfolio_wooproducts_box_shadow).'px '.esc_html($advance_portfolio_wooproducts_box_shadow).'px #eee;';
		$custom_css .='}';
	}


		


	