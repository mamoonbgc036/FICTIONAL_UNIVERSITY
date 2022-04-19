<?php
get_header();

page_banner(
  array(
    'title' => 'All Past Events',
    'subtitle' => 'See What is happing in our world',
  )
);
?>

  <div class="container container--narrow page-section">
    <?php

 			$today = date('Ymd');
            $past_events = new WP_Query( array(
              'paged' => get_query_var( 'paged', 1 ),	
              'posts_per_page' => -1,	
              'post_type' => 'event',
              'meta_key' => 'event_date',
              'orderby' => 'meta_value_num',
              'order' => 'ASC',
              'meta_query' => array(
                array(
                  'key' => 'event_date',
                  'compare' => '<',
                  'value' => $today,
                  'type' => 'numeric'
                ),
              ),
            ) );     
      while( $past_events->have_posts() ) {
        $past_events->the_post();
       get_template_part( 'templates-parts/content-event' );
      }

      echo paginate_links( array(
      	'total' => $past_events->max_num_pages,
      ) );
    ?>
  </div>
<?php
get_footer();
?>