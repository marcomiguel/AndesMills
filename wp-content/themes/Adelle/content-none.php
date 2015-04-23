  <article class="article" <?php post_class(); ?> id="post-<?php the_ID(); ?>" itemscope itemtype="http://schema.org/Article">

    <div class="post-text"><h2 class="post-title"><?php _e('Not Found','adelle-theme'); ?></h2></div>

    <p><?php _e('You have come to a page that is either not existing or already been removed','adelle-theme'); ?>.</p>

    <?php get_search_form();?>

    <div class="left">
      <h3><?php _e('Archives by month','adelle-theme'); ?></h3>
      <ul>
        <?php wp_get_archives('type=monthly'); ?>
      </ul>
    </div>
    <div class="right">
      <h3><?php _e('Archives by category','adelle-theme'); ?></h3>
      <ul>
        <?php wp_list_categories('sort_column=name'); ?>
      </ul>
    </div>
    <div class="clearfix">&nbsp;</div>

  </article><!-- .article -->