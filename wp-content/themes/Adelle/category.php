<?php get_header() ?>

  <section class="section" role="main">

    <?php if ( is_category('Recipes') ) : ?>
<h2 id="category-name-header">
<?php echo $cache_categories[$cat]->cat_name ?> Categoría</h2>
<?php add_filter('category_description', 'wpautop'); ?>
<?php add_filter('category_description', 'wptexturize'); ?>
<div id="category-description">
<?php echo category_description(); ?>
</div>
<?php endif; ?>

  </section><!-- .section -->

  <?php get_sidebar(); ?>

<?php get_footer(); ?>