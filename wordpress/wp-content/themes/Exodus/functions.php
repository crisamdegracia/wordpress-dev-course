<?php 

require get_theme_file_path('/inc/search-route.php');


//we add custom field named authorName to our
// advance custom field and we can use it anywhere
function university_custom_rest(){
  
  //1st arg the post-type we want to customize
  //2nd arg what we wanna name
  //3rd an array that describes how we want to manage this field
  register_rest_field('post', 'authorName', array(
    
    //what ever the value will store on the name authorName
    'get_callback'  => function(){ return get_the_author(); }
   ));
  
  //we can create as many property as we want
  // register_rest_field(arg1, arg2, arg3)
  // and return it as PHP script
}

add_action('rest_api_init', 'university_custom_rest');


//Dynamic function for pages 
function pageBanner($args = NULL) {
  if( !$args['title'] ) {
    $args['title'] = get_the_title();
  }
  if( !$args['subtitle'] ){
    $args['subtitle'] = get_field('page_banner_subtitle');
  }
  if( !$args['photo'] ) {
    if( get_field('page_banner_background_image') ) {
      $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'] ; 
    } else {
      $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
    }    
  }
?>

<div class="page-banner">
  <div class="page-banner__bg-image" style="background-image: url('<?php echo $args['photo'] ?> ')"></div>
  <div class="page-banner__content container container--narrow">
    <h1 class="page-banner__title"><?php echo $args['title'] ?></h1>
    <div class="page-banner__intro">
      <p><?php echo $args['subtitle'] ?></p>
    </div>
  </div>  
</div>

<?php }

function wp_theme_styles(){
  wp_enqueue_script( 'googleMap', '//maps.googleapis.com/maps/api/js?key=AIzaSyD-rsOXjG5-vXQEjd-YFC4zBBEEAb8tl6w', NULL, microtime() , true); 

  wp_enqueue_script( 'main-university-js', get_theme_file_uri('/js/scripts-bundled.js'), NULL, microtime() , true);


  wp_enqueue_style( 'custom-google-fonts', 'https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
  
  wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
  
  wp_enqueue_style( 'main-style', get_stylesheet_uri(), NULL, microtime() );

  wp_enqueue_script('main-university-js', get_template_directory_uri() . '/test.js');
  
  wp_localize_script('main-university-js', 'universityData',
                     array( 'root_url' => get_site_url() ) );

}

add_action('wp_enqueue_scripts', 'wp_theme_styles');


function university_features(){
  register_nav_menu('MainHeaderMenu', 'Main Header Menu');
  register_nav_menu('FooterOne', 'Footer One');
  register_nav_menu('FooterTwo', 'Footer Two');
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_image_size('professorsLandscape', 400, 260, true); // [nickname][width][hieght][true->will forced to crop image to center][false-> no-crop]
  add_image_size('professorPortrait', 400,650,true);
  add_image_size('pageBanner', 1500, 350, true);
}

add_action('after_setup_theme' , 'university_features');


function university_adjust_queries($query){

  if( !is_admin() AND is_post_type_archive('campus') AND $query->is_main_query()) {
    $query->set('posts_per_page', -1);

  }

  if( !is_admin() AND is_post_type_archive('program') AND $query->is_main_query()) {
    $query->set('orderby', 'title');
    $query->set('order', 'ASC');
    $query->set('posts_per_page', -1);

  }

  if( !is_admin() AND is_post_type_archive('event') AND $query-> is_main_query() ){

    $today = date("Ymd");
    $query ->set('meta_key', 'event_date');
    $query ->set('orderby', 'meta_value_num');
    $query ->set('order','ASC');
    $query ->set('meta_query', array(
      array(
        'key' => 'event_date',
        'compare' => '>=',
        'value'   => $today,
        'type'    => 'numeric'
      )
    ) );
  }
}

add_action('pre_get_posts', 'university_adjust_queries');

function universityMapKey($api){
  $api['key'] = 'AIzaSyD-rsOXjG5-vXQEjd-YFC4zBBEEAb8tl6w';
  return $api;
}

add_filter('acf/fields/google_map/api', 'universityMapKey');

?>
