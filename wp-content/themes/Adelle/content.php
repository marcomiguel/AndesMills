    <article class="article" <?php post_class(); ?> id="post-<?php the_ID(); ?>" itemscope itemtype="http://schema.org/Article">

      <?php if(get_post_meta($post->ID, 'ace_title', true)) {} else { ?>
      <header class="post-header">
        <div class="post-date radius-100"><span><?php echo get_the_date('d') ?></span><br /><?php echo get_the_date('M') ?><br /><?php echo get_the_date('Y') ?></div>
        <h2 class="post-title"><a href="<?php the_permalink() ?>" rel="<?php _e('bookmark','adelle-theme'); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
        <div class="post-category"><?php _e('categories', 'ace'); ?>: <?php the_category(', ') ?></div>
      </header>
      <?php } ?>

      <?php the_Content(); ?>

      <?php echo adelle_theme_get_link_pages() ?>

      <footer class="post-footer">

        <ul class="post-info-meta">
          <!--<li><?php the_tags('', ', ', ''); ?></li>-->
          <li class="post-info-comment"><div class="post-comment"><?php comments_popup_link( __('0 comment','adelle-theme'), __('1 Comment','adelle-theme'), __('% Comments','adelle-theme') ); ?></div></li>
        </ul>

        <ul class="footer-navi">
           <span class="nav-previous"><?php previous_post_link('%link', __('Previous', 'twentyeleven')); ?></span>
           <span class="nav-next"><?php next_post_link('%link', __('Next', 'twentyeleven')); ?></span>
          <!--<?php previous_post_link(__('<li class="previous">&laquo; %link</li>')); ?>
          <?php next_post_link(__('<li class="next">%link &raquo;</li>')); ?>-->
        </ul>
        
        


      </footer><!-- .post-footer -->

      <?php comments_template('/comments.php',true); ?>

    </article><!-- .article -->