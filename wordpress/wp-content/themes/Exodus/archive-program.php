<?php get_header(); 
pageBanner(array(
  'title' => 'All programs',
  'subtitle' => "There's something for everyone. Have a look around."
)); ?>

<div class="container container--narrow page-section">
  <ul class="link-list min-list">
    <?php   
    while( have_posts() ) : the_post(); ?>

    <li><a href="<?php the_permalink() ?>"><?php the_title() ?></a>
      <?php the_field('main_body_content') ?>

    </li>
    <?php endwhile; ?>
  </ul>
  <?php echo paginate_links() ?>
</div>





<?php get_footer(); ?>