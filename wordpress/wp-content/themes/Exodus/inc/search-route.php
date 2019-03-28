<?php 

//1st args the event to hook
//2nd args the function name to call
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
    
    
    //when we see methods we think 'CRUD' 
    //when they visit here they want to get data by GET request
    //GET will work but due to the diferent web we use
    // WP_REST_SERVER::READABLE
    'methods'   =>  WP_REST_SERVER::READABLE, 
    
    //a function name that we call for the ouput 
    'callback'  =>  'universitySearchResults' 
  
  ));
}

function universitySearchResults(){
  
  //we create new array to call
  //the professors post type
  //this is like when we create a custom query
  //we can choose what only we need to output from post type
  $professors = new WP_Query(array(
  
    'post_type'   =>  'professor'
  ));
  
  $professorResults = array();
    
  
  while($professors->have_posts()){
    
    $professors->the_post();
    
    //1st arg the array we want to add on to
    //2nd arg what we want to add to the array
    array_push($professorResults, array(
    
      'title'     => get_the_title(),
      'permalink' => get_the_permalink()
    
    ));
  }
  
  
    //then we will return the results here
    return $professorResults;
}











