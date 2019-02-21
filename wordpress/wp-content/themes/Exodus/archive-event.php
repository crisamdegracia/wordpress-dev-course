<?php get_header();
pageBanner(array(
  'title' => 'All Events',
  'subtitle' => "See what's going on in our world"
))
?>

<div class="container container--narrow page-section">
  <?php   
  while( have_posts() ) : the_post();
get_template_part('template-parts/content','event');
endwhile; 
echo paginate_links(); ?>
</div>

<?php get_footer(); ?>