<?php
/**
 * rtlwtf functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package rtlwtf
 */

if ( ! function_exists( 'rtlwtf_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function rtlwtf_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on rtlwtf, use a find and replace
	 * to change 'rtlwtf' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'rtlwtf', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'rtlwtf' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'rtlwtf_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // rtlwtf_setup
add_action( 'after_setup_theme', 'rtlwtf_setup' );

/**
 * Add option page to the template
 */
function setup_theme_admin_menus() {
	add_submenu_page('themes.php',
		'RTL.WTF Theme Options', 'RTL.WTF Theme Options', 'manage_options',
		'rtlwtf-theme-options', 'rtlwtf_theme_settings');
}
add_action( "admin_menu", "setup_theme_admin_menus" );

function rtlwtf_theme_settings() {
	// Check that the user is allowed to update options
	if ( !current_user_can( 'manage_options' ) ) {
		wp_die( 'You do not have sufficient permissions to access this page.' );
	}

	// Save settings
	if (isset($_POST["update_settings"])) {
		$sitename_ltr = esc_attr( $_POST["sitename_ltr"] );
		$sitename_rtl = esc_attr( $_POST["sitename_rtl"] );

		update_option( "rtlwtf_option_sitename_ltr", $sitename_ltr );
		update_option( "rtlwtf_option_sitename_rtl", $sitename_rtl );
	}


	$sitename_ltr = get_option("rtlwtf_option_sitename_ltr");
	$sitename_rtl = get_option("rtlwtf_option_sitename_rtl");

	// The page
?>
	<div class="wrap">
		<?php screen_icon('themes'); ?> <h2>RTL.WTF Theme Options</h2>
		<form method="POST" action="">
			<h2>Site name variations</h2>
			<table class="form-table">
				<tr valign="top">
					<th scope="row">
						<label for="sitename_ltr">Name for LTR</label>
					</th>
					<td>
						<input type="text" name="sitename_ltr" value="<?php echo $sitename_ltr; ?>" size="25" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="sitename_rtl">Name for RTL</label>
					</th>
					<td>
						<input type="text" name="sitename_rtl" value="<?php echo $sitename_rtl; ?>" size="25" />
					</td>
				</tr>
				<tr valign="top">
					<th></th>
					<td>
						<input type="hidden" name="update_settings" value="Y" />
						<input type="submit" value="Save settings" class="button-primary"/>
					</td>
				</tr>
			</table>
		</form>
	</div>
<?php
}
/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function rtlwtf_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'rtlwtf_content_width', 640 );
}
add_action( 'after_setup_theme', 'rtlwtf_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function rtlwtf_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'rtlwtf' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'rtlwtf_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function rtlwtf_scripts() {
	$domain = strtolower( $_SERVER['SERVER_NAME'] );
	$currDir = strpos( $domain, 'rtl') !== false ? 'rtl' : 'ltr';

	wp_enqueue_style( 'rtlwtf', get_template_directory_uri() . '/css/' . $currDir . '.wtf.style.css', array(), '1.1', 'all');

	wp_enqueue_script( 'rtlwtf-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'rtlwtf-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'rtlwtf_scripts' );

/**
 * Add shortcodes for textareas and other html elements
 */
function textarea( $atts, $content = null ) {
	$domain = strtolower( $_SERVER['SERVER_NAME'] );
	$currDir = strpos( $domain, 'rtl' ) !== false ? 'rtl' : 'ltr';

	extract( shortcode_atts( array(
        "dir" => $currDir,
        "style" => '',
    ), $atts));
    return '<textarea class="wtf-demo-textarea" ' .
    	'dir="' . $atts['dir'] . '" ' .
    	'style="' . $atts['style'] . '">' .
    	$content .
    	'</textarea>';
}
add_shortcode("textarea", "textarea");

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
