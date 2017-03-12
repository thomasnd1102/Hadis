<?php
/**
 * The Main Header.
 */
global $ct_options;
?>
<!DOCTYPE html>
<!--[if IE 7 ]>    <html class="ie7 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE   ]>    <html class="ie" <?php language_attributes(); ?>> <![endif]-->
<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<html <?php language_attributes(); ?>>
<head>
	<!-- Meta Tags -->
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta property="fb:app_id" content="287004874991108" />
	<?php if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) { ?>
	<link rel="shortcut icon" href="<?php echo esc_url( ct_favicon_url() ); ?>" type="image/x-icon" />
	<?php } ?>
<?php include('json-ld.php'); ?>
<script type="application/ld+json">// <![CDATA[
<?php echo json_encode($payload); ?>
// ]]></script>
	<?php wp_head();?>
</head>
<body <?php body_class(); ?>>
<!--[if lte IE 8]>
	<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a>.</p>
<![endif]-->
	<div class="layer"></div>
	<!-- Mobile menu overlay mask -->

	<!-- Header Plain:  add the class plain to header and change logo.png to logo_sticky.png ======================= -->
	<?php $header_class = '';
	if ( ! empty ( $ct_options['header_style'] ) && ( $ct_options['header_style'] == 'plain' ) ) { $header_class = 'plain'; } ?>

	<header class="<?php echo esc_attr( $header_class ); ?>">
		<div id="top_line">
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-6"><i class="icon_set_1_icon-91"></i>+844 3838 4858 | <i class="icon-mail"></i> info@hanoidiscovery.com</div>
					<div class="col-md-6 col-sm-6 col-xs-6">
						<ul id="top_links">
							<li><a href="#"><i class="icon-facebook"></i></a></li>
							<li><a href="#"><i class="icon-googleplus"></i></a></li>
							<li><a href="#"><i class="icon-pinterest"></i></a></li>
							<li><a href="#"><i class="icon-twitter"></i></a></li>
						</ul>
					</div>
				</div><!-- End row -->
			</div><!-- End container-->
		</div><!-- End top line-->

		<div class="container">
			<div class="row">
				<div class="col-md-3 col-sm-3 col-xs-3">
					<div id="logo">
						<a href="<?php echo esc_url( home_url('/') ); ?>"><img src="<?php echo esc_url( ct_logo_url() ) ?>" width="160" height="32" alt="Hanoi Discovery" data-retina="true" class="logo_normal"></a>
						<a href="<?php echo esc_url( home_url('/') ); ?>"><img src="<?php echo esc_url( ct_logo_sticky_url() ) ?>" width="160" height="32" alt="Hanoi Discovery" data-retina="true" class="logo_sticky"></a>
					</div>
				</div>
				<nav class="col-md-9 col-sm-9 col-xs-9">
					<a class="cmn-toggle-switch cmn-toggle-switch__htx open_close" href="javascript:void(0);"><span>Menu mobile</span></a>
					<div class="main-menu">
						<div id="header_menu">
							<img src="<?php echo esc_url( ct_logo_sticky_url() ) ?>" width="160" height="34" alt="City tours" data-retina="true">
						</div>
						<a href="#" class="open_close" id="close_in"><i class="icon_set_1_icon-77"></i></a>
						<?php if ( has_nav_menu( 'header-menu' ) ) {
								wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); 
							} else { ?>
								<div>
									<ul>
										<li class="menu-item"><a href="<?php echo esc_url( home_url('/') ); ?>"><?php esc_html_e( 'Home', "ct"); ?></a></li>
										<li class="menu-item"><a href="<?php echo esc_url( admin_url('nav-menus.php') ); ?>"><?php esc_html_e( 'Configure', "ct"); ?></a></li>
									</ul>
								</div>
						<?php } ?>
					</div><!-- End main-menu -->
					<ul id="top_tools">
						<li>
							<div class="dropdown dropdown-search">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon_set_1_icon-78"></i></a>
								<div class="dropdown-menu">
									<?php get_search_form(); ?>
								</div>
							</div>
						</li>
					</ul>
				</nav>
			</div>
		</div><!-- container -->
	</header><!-- End Header -->