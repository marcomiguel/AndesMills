<?php get_header(); ?>

  <section class="section" role="main">

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <article class="article" <?php post_class(); ?> id="post-<?php the_ID(); ?>" itemscope itemtype="http://schema.org/Article">

      <header class="post-header">
        <h2 class="post-title"><?php the_title(); ?></h2>
      </header>
 
      <?php the_content(); ?>

      <?php echo adelle_theme_get_link_pages() ?>

      <?php comments_template('/comments.php',true); ?>

    </article><!-- .article -->

    <?php endwhile; endif; ?>

  </section><!-- .section -->

  <?php get_sidebar(); ?>

<?php get_footer(); ?>