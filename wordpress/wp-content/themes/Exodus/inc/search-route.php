<?php 

//1st args the event to hook
//2nd args the function name to call to run
add_action('rest_api_init', 'universityRegisterSearch');

function universityRegisterSearch(){

  // take 3 args
  // 1st args a name space we want like :
  // wp-json/wp/v2/professors so the 1st args /wp/v2
  // 2nd is the route so -> wp-json/wp/v2/professors
  // proffesors is the route
  // 3rd args an array that will decide what wud happen
  // when someon visits the URL
  register_rest_route('university/v1', 'search', array(


    //when we see 'methods' we think 'CRUD' 
    //when they visit here they want to get data by GET request
    //GET will work but due to the diferent web we use
    // WP_REST_SERVER::READABLE
    'methods'   =>  WP_REST_SERVER::READABLE, 

    //a function name that we call for the ouput 
    'callback'  =>  'universitySearchResults' 

  ));
}

function universitySearchResults($data){

  //we create new array to call
  //the professors post type
  //this is like when we create a custom query
  //we can choose what only we need to output from post type
  // 's' means search 
  //we created $data for us to use within the body of the function

  $mainQuery = new WP_Query(array(
    'post_type'   =>  array('post','page','professor', 'program','campus','event'),
    's'           =>  sanitize_text_field( $data['term'] )
  ));

  $results = array(
    'generalInfo' => array(),
    'professors'  => array(),
    'programs'    => array(),
    'events'      => array(),
    'campuses'    => array()
  );


  while($mainQuery->have_posts()){

    $mainQuery->the_post();

    if( get_post_type() == 'post' OR get_post_type() == 'page') {

      //1st arg the array we want to add on to
      //2nd arg what we want to add to the array
      //push
      array_push(  $results['generalInfo'],  array ( 

        'title'     => get_the_title(),
        'permalink' => get_the_permalink(),
        'postType'       => get_post_type(),
        'authorName'    => get_the_author()

      ));

    }    if( get_post_type() == 'professor') {

      //1st arg the array we want to add on to
      //2nd arg what we want to add to the array
      //push
      array_push(  $results['professors'],  array ( 

        'title'     => get_the_title(),
        'permalink' => get_the_permalink(),
        'postType'      => get_post_type(),
        'authorName'    => get_the_author()

      ));

    }    if(get_post_type() == 'program') {

      //1st arg the array we want to add on to
      //2nd arg what we want to add to the array
      //push
      array_push(  $results['programs'],  array ( 

        'title'     => get_the_title(),
        'permalink' => get_the_permalink(),
        'postType'      => get_post_type(),
        'authorName'    => get_the_author()

      ));

    }    if(get_post_type() == 'event') {

      //1st arg the array we want to add on to
      //2nd arg what we want to add to the array
      //push
      array_push(  $results['events'],  array ( 

        'title'     => get_the_title(),
        'permalink' => get_the_permalink(),
        'postType'       => get_post_type(),
        'authorName'    => get_the_author()

      ));

    }    if(get_post_type() == 'campus') {

      //1st arg the array we want to add on to
      //2nd arg what we want to add to the array
      //push
      array_push(  $results['campuses'],  array ( 

        'title'     => get_the_title(),
        'permalink' => get_the_permalink(),
        'postType'      => get_post_type(),
        'authorName'    => get_the_author()

      ));

    }


  }


  //then we will return the results here
  return $results;
}











