<?php
/**
 * Sydney functions and definitions
 *
 * @package Sydney
 */
function register_cry_session()
{
    if (!session_id()) {
        session_start();
    }
}

add_action('init', 'register_cry_session');

function cos_scripts_method()
{
    wp_enqueue_script('custom-js-script', get_stylesheet_directory_uri() . '/js/custom-js.js', array('jquery'));
    wp_enqueue_script('leaflet-js', get_stylesheet_directory_uri() . '/js/leaflet.js', array('jquery'));
    wp_enqueue_style('leaflet-css', get_stylesheet_directory_uri() . '/css/leaflet.css', array(), '1.1', 'all');
}

add_action('wp_enqueue_scripts', 'cos_scripts_method');

add_action('wp_head', 'codecanal_ajaxurl');

function codecanal_ajaxurl()
{
    echo '<script type="text/javascript"> var ajaxurl = "' . admin_url('admin-ajax.php') . '"; </script>';
}

if (!function_exists('sydney_setup')) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function sydney_setup()
    {

        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on Sydney, use a find and replace
         * to change 'sydney' to the name of your theme in all the template files
         */
        load_theme_textdomain('sydney', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        // Content width
        global $content_width;
        if (!isset($content_width)) {
            $content_width = 1170; /* pixels */
        }

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
         */
        add_theme_support('post-thumbnails');
        add_image_size('sydney-large-thumb', 830);
        add_image_size('sydney-medium-thumb', 550, 400, true);
        add_image_size('sydney-small-thumb', 230);
        add_image_size('sydney-service-thumb', 350);
        add_image_size('sydney-mas-thumb', 480);

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            'primary' => __('Primary Menu', 'sydney'),
        ));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
        ));

        /*
         * Enable support for Post Formats.
         * See http://codex.wordpress.org/Post_Formats
         */
        add_theme_support('post-formats', array(
            'aside', 'image', 'video', 'quote', 'link',
        ));

        // Set up the WordPress core custom background feature.
        add_theme_support('custom-background', apply_filters('sydney_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        )));

        //Gutenberg align-wide support
        add_theme_support('align-wide');

        //Forked Owl Carousel flag
        $forked_owl = get_theme_mod('forked_owl_carousel', false);
        if (!$forked_owl) {
            set_theme_mod('forked_owl_carousel', true);
        }
    }
endif; // sydney_setup
add_action('after_setup_theme', 'sydney_setup');

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function sydney_widgets_init()
{
    register_sidebar(array(
        'name' => __('Sidebar', 'sydney'),
        'id' => 'sidebar-1',
        'description' => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    //Footer widget areas
    $widget_areas = get_theme_mod('footer_widget_areas', '3');
    for ($i = 1; $i <= $widget_areas; $i++) {
        register_sidebar(array(
            'name' => __('Footer ', 'sydney') . $i,
            'id' => 'footer-' . $i,
            'description' => '',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
    }

    //Register the front page widgets
    if (defined('SITEORIGIN_PANELS_VERSION')) {
        register_widget('Sydney_List');
        register_widget('Sydney_Services_Type_A');
        register_widget('Sydney_Services_Type_B');
        register_widget('Sydney_Facts');
        register_widget('Sydney_Clients');
        register_widget('Sydney_Testimonials');
        register_widget('Sydney_Skills');
        register_widget('Sydney_Action');
        register_widget('Sydney_Video_Widget');
        register_widget('Sydney_Social_Profile');
        register_widget('Sydney_Employees');
        register_widget('Sydney_Latest_News');
        register_widget('Sydney_Portfolio');
    }
    register_widget('Sydney_Contact_Info');

}

add_action('widgets_init', 'sydney_widgets_init');

/**
 * Load the front page widgets.
 */
if (defined('SITEORIGIN_PANELS_VERSION')) {
    require get_template_directory() . "/widgets/fp-list.php";
    require get_template_directory() . "/widgets/fp-services-type-a.php";
    require get_template_directory() . "/widgets/fp-services-type-b.php";
    require get_template_directory() . "/widgets/fp-facts.php";
    require get_template_directory() . "/widgets/fp-clients.php";
    require get_template_directory() . "/widgets/fp-testimonials.php";
    require get_template_directory() . "/widgets/fp-skills.php";
    require get_template_directory() . "/widgets/fp-call-to-action.php";
    require get_template_directory() . "/widgets/video-widget.php";
    require get_template_directory() . "/widgets/fp-social.php";
    require get_template_directory() . "/widgets/fp-employees.php";
    require get_template_directory() . "/widgets/fp-latest-news.php";
    require get_template_directory() . "/widgets/fp-portfolio.php";

    /**
     * Page builder support
     */
    require get_template_directory() . '/inc/so-page-builder.php';
}
require get_template_directory() . "/widgets/contact-info.php";

/**
 * Elementor ID
 */
if (!defined('ELEMENTOR_PARTNER_ID')) {
    define('ELEMENTOR_PARTNER_ID', 2128);
}

/**
 * Elementor editor scripts
 */
function sydney_elementor_editor_scripts()
{
    wp_enqueue_script('sydney-elementor-editor', get_template_directory_uri() . '/js/elementor.js', array('jquery'), '20200504', true);
}

add_action('elementor/frontend/after_register_scripts', 'sydney_elementor_editor_scripts');

/**
 * Enqueue scripts and styles.
 */
function sydney_scripts()
{

    wp_enqueue_style('sydney-google-fonts', esc_url(sydney_enqueue_google_fonts()), array(), null);

    if (is_customize_preview()) {
        wp_enqueue_style('sydney-preview-google-fonts-body', 'https://fonts.googleapis.com/', array(), null);
        wp_enqueue_style('sydney-preview-google-fonts-headings', 'https://fonts.googleapis.com/', array(), null);
    }

    wp_enqueue_style('sydney-style', get_stylesheet_uri(), '', '20200129');

    wp_enqueue_style('sydney-ie9', get_template_directory_uri() . '/css/ie9.css', array('sydney-style'));
    wp_style_add_data('sydney-ie9', 'conditional', 'lte IE 9');

    wp_enqueue_script('sydney-scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '', true);

    wp_enqueue_script('sydney-main', get_template_directory_uri() . '/js/main.min.js', array('jquery'), '20200504', true);

    if (defined('SITEORIGIN_PANELS_VERSION')) {
        wp_enqueue_script('sydney-so-legacy-scripts', get_template_directory_uri() . '/js/so-legacy.js', array('jquery'), '', true);
        wp_enqueue_script('sydney-so-legacy-main', get_template_directory_uri() . '/js/so-legacy-main.js', array('jquery'), '', true);
        wp_enqueue_style('sydney-font-awesome', get_template_directory_uri() . '/fonts/font-awesome.min.css');
    }

    if (get_theme_mod('blog_layout') == 'masonry-layout' && (is_home() || is_archive())) {

        wp_enqueue_script('sydney-masonry-init', get_template_directory_uri() . '/js/masonry-init.js', array('masonry'), '', true);
    }

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}

add_action('wp_enqueue_scripts', 'sydney_scripts');

/**
 * Disable Elementor globals on theme activation
 */
function sydney_disable_elementor_globals()
{
    update_option('elementor_disable_color_schemes', 'yes');
    update_option('elementor_disable_typography_schemes', 'yes');
}

add_action('after_switch_theme', 'sydney_disable_elementor_globals');

/**
 * Enqueue Bootstrap
 */
function sydney_enqueue_bootstrap()
{
    wp_enqueue_style('sydney-bootstrap', get_template_directory_uri() . '/css/bootstrap/bootstrap.min.css', array(), true);
}

add_action('wp_enqueue_scripts', 'sydney_enqueue_bootstrap', 9);

/**
 * Elementor editor scripts
 */

/**
 * Change the excerpt length
 */
function sydney_excerpt_length($length)
{

    $excerpt = get_theme_mod('exc_lenght', '55');
    return $excerpt;

}

add_filter('excerpt_length', 'sydney_excerpt_length', 999);

/**
 * Blog layout
 */
function sydney_blog_layout()
{
    $layout = get_theme_mod('blog_layout', 'classic-alt');
    return $layout;
}

/**
 * Menu fallback
 */
function sydney_menu_fallback()
{
    if (current_user_can('edit_theme_options')) {
        echo '<a class="menu-fallback" href="' . admin_url('nav-menus.php') . '">' . __('Create your menu here', 'sydney') . '</a>';
    }
}

/**
 * Header image overlay
 */
function sydney_header_overlay()
{
    $overlay = get_theme_mod('hide_overlay', 0);
    if (!$overlay) {
        echo '<div class="overlay"></div>';
    }
}

/**
 * Header video
 */
function sydney_header_video()
{

    if (!function_exists('the_custom_header_markup')) {
        return;
    }

    $front_header_type = get_theme_mod('front_header_type');
    $site_header_type = get_theme_mod('site_header_type');

    if ((get_theme_mod('front_header_type') == 'core-video' && is_front_page() || get_theme_mod('site_header_type') == 'core-video' && !is_front_page())) {
        the_custom_header_markup();
    }
}

/**
 * Polylang compatibility
 */
if (function_exists('pll_register_string')) :
    function sydney_polylang()
    {
        for ($i = 1; $i <= 5; $i++) {
            pll_register_string('Slide title ' . $i, get_theme_mod('slider_title_' . $i), 'Sydney');
            pll_register_string('Slide subtitle ' . $i, get_theme_mod('slider_subtitle_' . $i), 'Sydney');
        }
        pll_register_string('Slider button text', get_theme_mod('slider_button_text'), 'Sydney');
        pll_register_string('Slider button URL', get_theme_mod('slider_button_url'), 'Sydney');
    }

    add_action('admin_init', 'sydney_polylang');
endif;

/**
 * Preloader
 */
function sydney_preloader()
{
    ?>
    <div class="preloader">
        <div class="spinner">
            <div class="pre-bounce1"></div>
            <div class="pre-bounce2"></div>
        </div>
    </div>
    <?php
}

add_action('sydney_before_site', 'sydney_preloader');

/**
 * Header clone
 */
function sydney_header_clone()
{

    $front_header_type = get_theme_mod('front_header_type', 'nothing');
    $site_header_type = get_theme_mod('site_header_type');

    if (($front_header_type == 'nothing' && is_front_page()) || ($site_header_type == 'nothing' && !is_front_page())) { ?>

        <div class="header-clone"></div>

    <?php }
}

add_action('sydney_before_header', 'sydney_header_clone');

/**
 * Get image alt
 */
function sydney_get_image_alt($image)
{
    global $wpdb;

    if (empty($image)) {
        return false;
    }

    $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM {$wpdb->posts} WHERE guid=%s;", strtolower($image)));
    $id = (!empty($attachment)) ? $attachment[0] : 0;

    $alt = get_post_meta($id, '_wp_attachment_image_alt', true);

    return $alt;
}

/**
 * Fix skip link focus in IE11.
 *
 * This does not enqueue the script because it is tiny and because it is only for IE11,
 * thus it does not warrant having an entire dedicated blocking script being loaded.
 *
 * from TwentyTwenty
 *
 * @link https://git.io/vWdr2
 */
function sydney_skip_link_focus_fix()
{
    ?>
    <script>
        /(trident|msie)/i.test(navigator.userAgent) && document.getElementById && window.addEventListener && window.addEventListener("hashchange", function () {
            var t, e = location.hash.substring(1);
            /^[A-z0-9_-]+$/.test(e) && (t = document.getElementById(e)) && (/^(?:a|select|input|button|textarea)$/i.test(t.tagName) || (t.tabIndex = -1), t.focus())
        }, !1);
    </script>
    <?php
}

add_action('wp_print_footer_scripts', 'sydney_skip_link_focus_fix');

/**
 * Get SVG code for specific theme icon
 */
function sydney_get_svg_icon($icon, $echo = false)
{
    $svg_code = wp_kses( //From TwentTwenty. Keeps only allowed tags and attributes
        Sydney_SVG_Icons::get_svg_icon($icon),
        array(
            'svg' => array(
                'class' => true,
                'xmlns' => true,
                'width' => true,
                'height' => true,
                'viewbox' => true,
                'aria-hidden' => true,
                'role' => true,
                'focusable' => true,
            ),
            'path' => array(
                'fill' => true,
                'fill-rule' => true,
                'd' => true,
                'transform' => true,
            ),
            'polygon' => array(
                'fill' => true,
                'fill-rule' => true,
                'points' => true,
                'transform' => true,
                'focusable' => true,
            ),
        )
    );

    if ($echo != false) {
        echo $svg_code; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    } else {
        return $svg_code;
    }
}

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

/**
 * Slider
 */
require get_template_directory() . '/inc/slider.php';

/**
 * Styles
 */
require get_template_directory() . '/inc/styles.php';

/**
 * Theme info
 */
require get_template_directory() . '/inc/onboarding/theme-info.php';

/**
 * Woocommerce basic integration
 */
require get_template_directory() . '/inc/woocommerce.php';

/**
 * WPML
 */
if (class_exists('SitePress')) {
    require get_template_directory() . '/inc/wpml/class-sydney-wpml.php';
}

/**
 * Upsell
 */
require get_template_directory() . '/inc/upsell/class-customize.php';

/**
 * Gutenberg
 */
require get_template_directory() . '/inc/editor.php';

/**
 * Fonts
 */
require get_template_directory() . '/inc/fonts.php';

/**
 * SVG codes
 */
require get_template_directory() . '/inc/classes/class-sydney-svg-icons.php';

/**
 *TGM Plugin activation.
 */
require_once dirname(__FILE__) . '/plugins/class-tgm-plugin-activation.php';

add_action('tgmpa_register', 'sydney_recommend_plugin');
function sydney_recommend_plugin()
{

    $plugins = array();

    if (!defined('SITEORIGIN_PANELS_VERSION')) {
        $plugins[] = array(
            'name' => 'Elementor',
            'slug' => 'elementor',
            'required' => false,
        );
    }

    if (!function_exists('wpcf_init')) {
        $plugins[] = array(
            'name' => 'Sydney Toolbox - custom posts and fields for the Sydney theme',
            'slug' => 'sydney-toolbox',
            'required' => false,
        );
    }

    tgmpa($plugins);

}

/**
 * Admin notice
 */
require get_template_directory() . '/inc/notices/persist-admin-notices-dismissal.php';

function sydney_welcome_admin_notice()
{
    if (!PAnD::is_admin_notice_active('sydney-welcome-forever')) {
        return;
    }

    ?>
    <div data-dismissible="sydney-welcome-forever"
         class="sydney-admin-notice updated notice notice-success is-dismissible">

        <p><?php echo sprintf(__('Welcome to Sydney. To get started please make sure to visit our <a href="%s">welcome page</a>.', 'sydney'), admin_url('themes.php?page=sydney-info.php')); ?></p>
        <a class="button"
           href="<?php echo admin_url('themes.php?page=sydney-info.php'); ?>"><?php esc_html_e('Get started with Sydney', 'sydney'); ?></a>

    </div>
    <?php
}

add_action('admin_init', array('PAnD', 'init'));
add_action('admin_notices', 'sydney_welcome_admin_notice');

add_action('wp_ajax_address_ajax_request', 'tft_handle_ajax_request');
add_action('wp_ajax_nopriv_address_ajax_request', 'tft_handle_ajax_request');
function tft_handle_ajax_request()
{

    $responseData = array();
    $results = array();
    $totalResults = 0;
    $query = $_REQUEST['searchAddress'];
    $queryEncode = urlencode($query);
    $url = 'http://photon.komoot.de/api/?q=' . $queryEncode;

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
    ));
    $response = curl_exec($curl);
    curl_close($curl);

    $responseData = json_decode($response, true);
    $results = $responseData['features'];
    $totalResults = count($results);
    $_SESSION['totalResults'] = 0;
    $_SESSION['query_result'] = array();

    echo '<div class="cry-map-results" style="width: 100%; display: block;">';
    if ($totalResults > 0) {
        $_SESSION['totalResults'] = $totalResults;
        $_SESSION['query_result'] = $results;
        $mapAddress = $results[0]['properties']['name'] . ' ' . $results[0]['properties']['city'] . ' ' . $results[0]['properties']['state'] . ' ' . $results[0]['properties']['postcode'] . ' ' . $results[0]['properties']['country'];
        $latitude = $results[0]['geometry']['coordinates'][0];
        $longitude = $results[0]['geometry']['coordinates'][1];

        echo '<div class="cry-map-record-found" style="width: 100%; display: block; margin-top: 50px;">';
        echo '<div class="cry-content" style="width: 50%; display: inline-block;">';
        echo '<div>';
        echo '<form action="/crystal-os-map/" method="post" class="cry-map-frm1" name="map_frm1">';
        echo '<p style="text-align: center;"><h3 class="cry-heading">We have maps available for <strong>' . $query . '</strong></h3></p>';
        echo '<p>Please enter your email address.</p>';
        echo '<p><input type="email" name="user_email" id="user_email" class="user-email" placeholder="Email address">';
        echo '<input type="hidden" name="total_results" value="' . $totalResults . '" class="total-results" >';
        echo '<input type="hidden" name="results" value="' . base64_encode(serialize($results)) . '" class="results">';
        echo '</p>';
        echo '<p><button type="submit" name="email_btn" id="email_btn" value="Submitted" class="email-btn">Get Map</button></p>';
        echo '</form>';
        echo '</div>';
        echo '</div>';
        echo '<div class="cry-map-area" style="width: 50%;  display: inline-block;">';
        echo '<div id="map" class="show-map" style="height: 400px; width:100%;"></div>';
        echo '<script type="text/javascript">
                    var lat = "' . $latitude . '";
                    var lon = "' . $longitude . '";
                    var apikey = "3JAXP7ZnfP7JSsZfaqP199N3heFWzsXr";
                    var map = L.map("map").setView([lon, lat], 18);
                    L.tileLayer("https://api2.ordnancesurvey.co.uk/mapping_api/v1/service/zxy/EPSG%3A3857/Outdoor 3857/{z}/{x}/{y}.png?key="+apikey, {
                        maxZoom: 20,
                        minZoom: 18
                    }).addTo(map);
                </script>';
        echo '</div>';
        echo '</div>';
    } else {
        echo '<div class="cry-map-norecord" data-val="No record found"> No record found</div>';
    }
    echo '</div>';
    exit();
}

add_action('wp_ajax_selectAddress_ajax_request', 'cry_handle_ajax_request');
add_action('wp_ajax_nopriv_selectAddress_ajax_request', 'cry_handle_ajax_request');
function cry_handle_ajax_request()
{


    $address = $_REQUEST['address'];
    $email = $_REQUEST['email'];
    $totalResult = $_REQUEST['totalResults'];
    ?>
    <div class="cry-map-record-found" style="width: 100%; display: block; margin-top: 50px;">
        <form action="" method="post" class="cry-map-frm2" name="cry_map_frm2">
            <div class="cry-map-format">
                <select class="select-format" name="map_format">
                    <option value="" data-prod="raster">Select Format</option>
                    <option value="png" data-prod="raster">PNG</option>
                    <option value="jpeg" data-prod="raster">JPEG/JPG</option>
                    <option value="pdf" data-prod="raster">PDF</option>
                    <option value="doc" data-prod="raster">MS Word</option>
                    <option value="svg" data-prod="vector">SVG</option>
                    <option value="dxf" data-prod="vector">DXF</option>
                    <option value="dwg" data-prod="vector">DWG</option>
                </select>
            </div>

            <div class="cry-map-color">
                <select class="select-color" name="map_color">
                    <option value="">Select Type</option>
                    <option value="colour">Colour</option>
                    <option value="bw">Black &amp; White</option>
                </select>
            </div>

            <div class="cry-ma-selection" style="">
                <p>Select the map size.</p>

                <ul class="cry-map-raster" style="">
                    <li class="check-box">
                        <label>
                            <input type="checkbox" name="ptype[]" id="b36b" value="b36b" data-zoom="9">
                            Site Plan 36mx36m (1:200) £8.50
                        </label>
                    </li>
                    <li class="check-box">
                        <label>
                            <input type="checkbox" name="ptype[]" id="b90b" value="b90b" data-zoom="8">
                            Site Plan 90mx90m (1:500) £10.50
                        </label>
                    </li>
                    <li class="check-box">
                        <label>
                            <input type="checkbox" name="ptype[]" id="p2b" value="p2b" data-zoom="5">
                            Location Plan: 2 hectares (1:1,250) £13.00
                        </label>
                    </li>
                    <li class="check-box">
                        <label>
                            <input type="checkbox" name="ptype[]" id="p4b" value="p4b" data-zoom="4">
                            Location Plan: 4 hectares (1:1,250) £19.00
                        </label>
                    </li>
                    <li class="check-box">
                        <label>
                            <input type="checkbox" name="ptype[]" id="p16b" value="p16b" data-zoom="1">
                            Location Plan: 16 hectares (1:2,500) £49.00
                        </label>
                    </li>
                </ul>
                <ul class="cry-map-vector" style="display:none;">
                    <li class="radio-box">
                        <label>
                            <input type="radio" name="ptype[]" id="v1c" value="v1c" data-zoom="7">
                            1ha - 100m2 £16.00
                        </label>
                    </li>
                    <li class="radio-box">
                        <label>
                            <input type="radio" name="ptype[]" id="v2c" value="v2c" data-zoom="5">
                            2ha - 141.42m2 £21.00
                        </label>
                    </li>
                    <li class="radio-box">
                        <label>
                            <input type="radio" name="ptype[]" id="v4c" value="v4c" data-zoom="4">
                            4ha - 200m2 £39.00
                        </label>
                    </li>
                    <li class="radio-box">
                        <label>
                            <input type="radio" name="ptype[]" id="v10c" value="v10c" data-zoom="2">
                            10ha - 316m2 £99.00
                        </label>
                    </li>
                    <li class="radio-box">
                        <label>
                            <input type="radio" name="ptype[]" id="v20c" value="v20c" data-zoom="0">
                            20ha - 447m2 £146.00
                        </label>
                    </li>
                </ul>
            </div>
            <div class="cry-ma-selection" style="">
                <input type="hidden" name="totalResult" id="totalResult" value="<?php echo $totalResult; ?>">
                <input type="hidden" name="userEmail" id="userEmail" value="<?php echo $email; ?>">
                <input type="hidden" name="mapAddress" id="mapAddress" value="<?php echo $address; ?>">
                <button type="submit" name="submit_map" id="submit_map" value="Submitted" class="email-btn">Get Map
                </button>
                </p>

            </div>
        </form>
    </div>

    <?php
    exit();
}