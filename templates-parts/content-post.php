<div class="post-item">
    <h2 class="headline headline--medium headline--post-title"><a href="<?php the_permalink(); ?>"><?php th); ?></a></h2>

    <div class="metabox">
              <p>Posted by <?php the_author_posts_link(); ?> on <?php the_time( 'n.j.y' ); ?> in <?php echo get_the_category_list( ', ' ); ?></p>
    </div>

    <div class="generic-content">
              <?php the_excerpt(); ?>
              <p><a href="<?php the_permalink(); ?>">Continue reading &raquo</a></p>
    </div>
</div>