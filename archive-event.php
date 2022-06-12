<?php
get_header();

page_banner( array(
	'title'    => 'All Events',
	'subtitle' => 'See What is happing in our world',
) );
?>

  <div class="container container--narrow page-section">
    <?php
      while( have_posts() ) {
        the_post();
        get_template_part( 'templates-parts/content-event' );
      }

      echo paginate_links();
    ?>

    <hr class="section-break">

    <a href="<?php echo site_url( '/past-events' )?>">Please have a look at our past events</a>
  </div>
<?php
get_footer();
?>