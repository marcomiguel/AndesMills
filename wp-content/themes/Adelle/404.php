<?php get_header(); ?>

  <section class="section" role="main">

    <article class="article" <?php post_class(); ?> id="post-<?php the_ID(); ?>" itemscope itemtype="http://schema.org/Article">

      <header class="post-header">
        <h2 class="post-title"><?php _e('Error 404 - Not Found','adelle-theme'); ?></h2>
      </header>

      <p><?php echo _e('404 Not Found','adelle-theme'); ?></p>

      <?php get_search_form();?>

      <section class="left">
        <h3><?php _e('Archives by month','adelle-theme'); ?></h3>
        <ul>
          <?php wp_get_archives('type=monthly'); ?>
        </ul>
      </section>
      <section class="right">
        <h3><?php _e('Archives by category','adelle-theme'); ?></h3>
        <ul>
          <?php wp_list_categories('sort_column=name'); ?>
        </ul>
      </section>
      <div class="clearfix">&nbsp;</div>

    </article><!-- .article -->

  </section><!-- .section -->

  <?php get_sidebar(); ?>

<?php get_footer(); ?>