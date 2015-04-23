<?php get_header() ?>

  <section class="section" role="main">

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

      <?php get_template_part( 'content', 'list' ); ?>

    <?php endwhile; ?>

      <section class="pagination">
        <p><?php echo adelle_theme_pagination_links(); ?></p>
      </section>

    <?php else : get_template_part( 'content', 'none' ); endif; ?>

  </section><!-- .section -->

  <?php get_sidebar(); ?>

<?php get_footer(); ?>