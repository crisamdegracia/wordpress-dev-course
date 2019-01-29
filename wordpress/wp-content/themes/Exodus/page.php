
<?php get_header() ?>

<div class="page-banner">
  <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg') ?>);"></div>
  <div class="page-banner__content container container--narrow">
    <h1 class="page-banner__title"><?php the_title(); ?></h1>
    <div class="page-banner__intro">
      <p>Learn how the school of your dreams got started.</p>
    </div>
  </div>  
</div>

<div class="container container--narrow page-section">
  <?php 
  $theParent = wp_get_post_parent_id(get_the_ID());
  if($theParent){ ?>

  <div class="metabox metabox--position-up metabox--with-home-link">
    <p><a class="metabox__blog-home-link" href="<?php echo get_permalink( $theParent ) ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($theParent) ?></a> <span class="metabox__main"><?php the_title(); ?></span></p>
  </div>

  <?php  }  ?>

<?php 
  //this function wil return a collection of children of the parent
  //otherwise will return false or zero
  $testArray = get_pages( array(
    'child_of' => get_the_ID()
  )); 
  
  
  if($theParent or $testArray ) { ?>
  

  <div class="page-links">
    <h2 class="page-links__title"><a href="<?php echo get_the_permalink($theParent) ?>"><?php echo get_the_title($theParent) ?></a></h2>
    <ul class="min-list">
      <!--
<li class="current_page_item"><a href="#">Our History</a></li>
<li><a href="#">Our Goals</a></li>
-->

     <!-- if theParent page is true then $findTheChildrenOf isthe ID for list of pages. then the children pages will be displayed  -->
      <?php 
      if ($theParent) {
       $findTheChildrenOf = $theParent; 
      } else {
        $findTheChildrenOf = get_the_ID();
      }
      
      wp_list_pages(array(
        'title_li' => NULL, // remove the title
        'child_of' => $findTheChildrenOf,      //numerical ID of a certain post or page
        'sort_column' => 'menu_order' // we can now change the number order on the dashboard on pages section
 
        ));
      ?>
    </ul>
  </div>
<?php } ?>


  <div class="generic-content">

    <?php while( have_posts() ) : the_post(); ?>

    <?php  the_content(); ?> 

    <?php  endwhile; ?>

  </div>

</div>



<?php get_footer() ?>