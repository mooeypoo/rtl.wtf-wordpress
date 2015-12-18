<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package rtlwtf
 */

// Get the current variables and push them to the chosen
// direcitonality domain
$params = http_build_query( $_GET );
$params = !empty( $params ) ? '?' . $params : '';

$domain = strtolower( $_SERVER['SERVER_NAME'] );

// TODO: If this is used outside of the rtl.wtf and ltr.wtf domains,
// this 'currDir' check should change to fit the local conditions
$currDir = strpos( 'rtl', $domain ) === 0 ? 'ltr' : 'rtl';
$dirOptions = array( 'rtl', 'ltr' );

$currSiteName = get_option("rtlwtf_option_sitename_" . $currDir);
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'rtlwtf' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<div class="header-wrapper">
			<div class="site-branding">
				<?php
				if ( is_front_page() && is_home() ) : ?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php echo $currSiteName; ?></a></h1>
				<?php else : ?>
					<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php echo $currSiteName; ?></a></p>
				<?php
				endif;

				$description = get_bloginfo( 'description', 'display' );
				if ( $description || is_customize_preview() ) : ?>
					<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
				<?php
				endif; ?>
			</div><!-- .site-branding -->

			<nav id="site-navigation" class="main-navigation" role="navigation">
				<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'rtlwtf' ); ?></button>
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
			</nav><!-- #site-navigation -->

			<div id="dirswitch" class="site-dir-switch">
				<ul>
<?php
	foreach ( $dirOptions as $d ) {
		echo '<li>';
		if ( $d === $currDir ) {
			echo '<a class="dir-active">' . strtoupper( $d ) . '</a>';
		} else {
			echo '<a href="http://' . $d . '.wtf/'. $params . '">' . strtoupper( $d ) . '</a>';
		}
		echo '</li>';
	}
?>
				</ul>
			</div>
		</div>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
