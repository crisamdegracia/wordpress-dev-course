<?php 



function wp_theme_styles(){
  wp_enqueue_script( 'main-university-js', get_theme_file_uri('/js/scripts-bundled.js'), NULL, microtime() , true);
  wp_enqueue_style( 'custom-google-fonts', 'https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
  wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
  wp_enqueue_style( 'main-style', get_stylesheet_uri(), NULL, microtime() );
}

add_action('wp_enqueue_scripts', 'wp_theme_styles');


function university_features(){
  register_nav_menu('MainHeaderMenu', 'Main Header Menu');
  register_nav_menu('FooterOne', 'Footer One');
  register_nav_menu('FooterTwo', 'Footer Two');
  add_theme_support('title-tag');
}

add_action('after_setup_theme' , 'university_features');



?>
