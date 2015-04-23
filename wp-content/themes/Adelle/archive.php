<?php get_header(); ?>

  <section class="section" role="main">

    <?php if ( have_posts() ) : ?>
      <?php $post = $posts[0]; ?>
        <?php if (is_category()) { ?>
          <h3 class="pagetitle"><?php _e('Archive of','adelle-theme'); ?> &#8216;<?php single_cat_title(); ?>&#8217; <?php _e('category','adelle-theme'); ?></h3>
        <?php } elseif( is_tag() ) { ?>
          <h3 class="pagetitle"><?php _e('Posts Tagged','adelle-theme'); ?> &#8216;<?php single_tag_title(); ?>&#8217;</h3>
        <?php } elseif (is_day()) { ?>
          <h3 class="pagetitle"><?php echo get_the_date('F jS Y'); ?> <?php _e('archive','adelle-theme'); ?></h3>
        <?php } elseif (is_month()) { ?>
          <h3 class="pagetitle"><?php echo get_the_date('F Y'); ?> <?php _e('archive','adelle-theme'); ?></h3>
        <?php } elseif (is_year()) { ?>
          <h3 class="pagetitle"><?php echo get_the_date('Y'); ?> <?php _e('archive','adelle-theme'); ?></h3>
        <?php } elseif (is_author()) { ?>
          <h3 class="pagetitle"><?php _e('Author Archive','adelle-theme'); ?></h3>
        <?php } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
        <h3 class="pagetitle"><?php _e('Blog Archives','adelle-theme'); ?></h3>
      <?php } ?>

    <?php while (have_posts()) : the_post(); ?>

      <?php get_template_part( 'content', 'list' ); ?>

    <?php endwhile; ?>

      <section class="pagination">
        <p><?php echo adelle_theme_pagination_links(); ?></p>
      </section>

    <?php else : get_template_part( 'content', 'none' ); endif; ?>

  </section><!-- .section -->

  <?php get_sidebar(); ?>

<?php get_footer(); ?>