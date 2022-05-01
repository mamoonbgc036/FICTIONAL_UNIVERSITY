<?php

echo 'Search.php';
get_header();


page_banner(
  array(
    'title' => 'Search Results',
    'subtitle' => 'You Search for &ldquo;'. esc_html( get_search_query(false) ) .'&rdquo;',
  )
)
?>

  <div class="container container--narrow page-section">
    <?php
      while( have_posts() ) {
        the_post();
        get_template_part( 'templates-parts/content', get_post_type() );
        //echo get_post_type();
      }
      echo paginate_links();
    ?>
  </div>
<?php
get_footer();
?>