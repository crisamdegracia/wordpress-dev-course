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

    }  


    //PROFESSORS ROUTE
    if( get_post_type() == 'professor') {

      //1st arg the array we want to add on to
      //2nd arg what we want to add to the array
      //push
      array_push(  $results['professors'],  array ( 

        'title'     => get_the_title(),
        'permalink' => get_the_permalink(),
        //get_the_post_thumbnail_url(arg1) = 0 means current post
        // arg2 [size] = professorLandscape
        'image'         => get_the_post_thumbnail_url(0, 'professorLandscape')

      ));

    }    if(get_post_type() == 'program') {

      //1st arg the array we want to add on to
      //2nd arg what we want to add to the array
      //push
      array_push(  $results['programs'],  array ( 

        'title'     => get_the_title(),
        'permalink' => get_the_permalink(),
        'id'        => get_the_id() 
      ));

    }   

    //EVENTS ROUTE

    if(get_post_type() == 'event') {
      $eventDate = new DateTime( get_field('event_date'));
      $desc      = null;

      if ( has_excerpt() ) {

        $desc = get_the_excerpt();
      } else { 
        $desc = wp_trim_words(get_the_content(), 18 );
      }

      //1st arg the array we want to add on to
      //2nd arg what we want to add to the array
      //push
      array_push(  $results['events'],  array ( 

        'title'     => get_the_title(),
        'permalink' => get_the_permalink(),
        'month'     => $eventDate->format('M'),
        'day'       => $eventDate->format('d'),
        'desc'      => $desc
      ));

    }  

    // CAMPUSES ROUTE

    if(get_post_type() == 'campus') {

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

  
  // this if condition purpose is when we put relative words to programs like Math then on also english
  // kapag naglagay tayo ng words like english on math programs, hind sila mag hahalo halo-
  // if condition is to check that we only output them a programs, not contents, alias,  blah blah
  if($results['programs']){


    $programsMetaQuery = array( 'relation' => 'OR' );

    foreach ( $results['programs'] as $item ) {

      // a function that adds item to an existing array
      //1st arg the array that we wanna add on to
      //2nd the item or value that we wanna add
      // on the 2nd arg.
      array_push( $programsMetaQuery,  array(

        'key' => 'related_programs',
        'compare' => 'LIKE',
        // we create id for programs -- now we are calling it
        'value' =>   '"'.$item['id'].'"'

      ) );
    }

    // We will check if the programs are duplicated
    //
    $programRelationshipQuery = new WP_Query(array(

      'post_type'     => array['professor','event', 'campus']

      //this is how we search based on the value of the custom field
      // Multiple meta_query is like looking for different programs like (green programs, hospital program and so on)
      'meta_query'    =>  $programsMetaQuery
    )//meta_query
                                            ); 


    //Program Relationship Query
    while(  $programRelationshipQuery->have_posts() ) {

      $programRelationshipQuery->the_post();

      if( get_post_type() == 'professor') {

        //1st arg the array we want to add on to
        //2nd arg what we want to add to the array
        //push
        array_push(  $results['professors'],  array ( 

          'title'     => get_the_title(),
          'permalink' => get_the_permalink(),
          
          //get_the_post_thumbnail_url(arg1) = 0 means current post
          // arg2 [size] = professorLandscape
          'image'       => get_the_post_thumbnail_url(0, 'professorLandscape')
        ));

      } 
    }

    //Remove duplicates
    // array_unique arg[1] - the array we want to work with
    // array_unique arg[2] - assiociative array, so we can see if its duplicate or not
    // by using array_unique alone -- the array will give us numerical item
    // array_values removes the numerical item
    $results['professors'] = array_values( array_unique($results['professors'], SORT_REGULAR ) );



  }
  //then we will return the results here
  return $results;

}
