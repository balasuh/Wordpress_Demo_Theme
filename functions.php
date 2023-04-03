<?php

//Importing dotenv functionality from phpdotenv - START

require_once __DIR__ . '/vendor/autoload.php';

//Importing dotenv functionality from phpdotenv - END

//Loading the Google Maps API Key from ENV Variable - START

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
$googleMapsJS = '//maps.googleapis.com/maps/api/js?key=' . $_ENV['GOOGLE_MAPS_API_KEY'];

//Loading the Google Maps API Key from ENV Variable - END

function pageBanner($args = NULL)
{
    if (!isset($args['title'])) {
        $args['title'] = get_the_title();
    }
    if (!isset($args['subtitle'])) {
        $args['subtitle'] = get_field('page_banner_subtitle');
    }
    if (!isset($args['photo'])) {
        if (get_field('page_banner_background_image') and !is_home() and !is_archive()) {
            $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
        } else {
            $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
            // $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
        }
    }
    ?>
<div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php
        echo $args['photo'];
        ?>)">
    </div>
    <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title">
            <?php echo $args['title']; ?>
        </h1>
        <div class="page-banner__intro">
            <p><?php echo $args['subtitle']; ?></p>
        </div>
    </div>
</div>

<?php }
function university_files()
{
    global $googleMapsJS;
    wp_enqueue_script('googleMap', $googleMapsJS, NULL, '1.0', true);
    wp_enqueue_script('main_university_js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('external-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css'));
    wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css'));
}

function university_features()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_image_size('professorLandscape', 400, 260, true);
    add_image_size('professorPortrait', 480, 650, true);
    add_image_size('pageBanner', 1500, 350, true);
    // add_image_size('professorLandscape', 400, 260, array('left', 'top'));
    // register_nav_menu('headerMenuLocation', 'Header Menu Location');
    // register_nav_menu('footerLocation1', 'Footer Location 1');
    // register_nav_menu('footerLocation2', 'Footer Location 2');
}

function disable_url_guessing($url_guessing)
{
    if (is_404()) {
        return false;
    }
    return $url_guessing;
}

function university_adjust_queries($query)
{
    if (!is_admin() and is_post_type_archive('campus') and $query->is_main_query()) {
        $query->set('posts_per_page', -l);
    };


    if (!is_admin() and is_post_type_archive('program') and $query->is_main_query()) {
        $query->set('orderby', 'title');
        $query->set('order', 'ASC');
        $query->set('posts_per_page', -1);
    };


    if (!is_admin() and is_post_type_archive('event') and $query->is_main_query()) {
        $today = date('Ymd');
        $query->set('meta_key', 'event_date');
        $query->set('orderby', 'meta_value_num');
        $query->set('order', 'ASC');
        $query->set(
            'meta_query',
            array(
                array(
                    'key' => 'event_date',
                    'compare' => '>=',
                    'value' => $today,
                    'type' => 'numeric'
                )
            )
        );
    }
    ;
}

add_action('wp_enqueue_scripts', 'university_files');
add_action('after_setup_theme', 'university_features');
add_filter('redirect_canonical', 'disable_url_guessing');
add_action('pre_get_posts', 'university_adjust_queries');

function console_log($data)
{
    echo "<script>console.log(" . json_encode($data) . ");</script>";
}

function universityMapKey($api)
{
    $api['key'] = $_ENV['GOOGLE_MAPS_API_KEY'];
    // console_log($api['key']);
    return $api;
}


add_filter('acf/fields/google_map/api', 'universityMapKey');

?>