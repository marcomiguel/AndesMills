<section class="comment-box">

<?php
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
  die ('Please do not load this page directly. Thanks!');
if ( post_password_required() ) { ?>
  <p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments','adelle-theme'); ?>.</p>
<?php return; } ?>

<!-- You can start editing here. -->
  <?php if ( have_comments() ) : ?>
  <section class="navigation">
    <section class="alignleft"><?php previous_comments_link() ?></section>
    <section class="alignright"><?php next_comments_link() ?></section>
  </section>

  <?php if (!empty($comments_by_type['comment'])) { ?>
    <h4 id="comments"><?php comments_number(__('0 comment','adelle-theme'), __('1 Comment','adelle-theme'), __('% Comments','adelle-theme')); ?> <?php _e('on','adelle-theme'); ?> <?php the_title(); ?></h4>
    <ol class="commentlist">
      <?php wp_list_comments('type=comment&callback=adelle_theme_comment_style'); ?>
    </ol>
  <?php } if (!empty($comments_by_type['pings'])) { ?>
    <h4 id="comments"><?php echo count($wp_query->comments_by_type['pings']); ?><?php _e('Pingbacks &amp; Trackbacks on','adelle-theme'); ?> <?php the_title(); ?></h4>
    <ol class="commentlist">
      <?php wp_list_comments('type=pingback&callback=comment_style'); ?>
    </ol>
  <?php } ?>

  <?php else : // this is displayed if there are no comments so far ?>

    <?php if ('open' == $post->comment_status) : ?>

    <?php else : // comments are closed ?>

      <?php if ( is_page() ) : else : ?>
        <p class="nocomments"><?php _e('Comments are closed','adelle-theme'); ?>.</p>
      <?php endif; ?>

    <?php endif; ?>

  <?php endif; ?>

  <?php if ('open' == $post->comment_status) : ?>

  <section id="respond">

    <?php
    $comments_args = array(
      'label_submit'          => __('Comment','adelle-theme'),
      'title_reply'           => __('Leave a Reply','adelle-theme'),
      'title_reply_to'        => __('Leave a reply to %s','adelle-theme'),
      'cancel_reply_link'     => __('Cancel reply','adelle-theme'),
      'comment_notes_before'  => '',
      'comment_notes_after'   => '',
      'comment_field'         => '<p><textarea name="comment" class="comment-textarea" title="' . __('Comment','adelle-theme') . '" cols="50" rows="5" tabindex="1"></textarea></p>',
      'fields'                => apply_filters( 'comment_form_default_fields', array(
        'author'  => '<p><input type="text" name="author" class="comment-text" title="'.__('Name','adelle-theme').'*" value="'.$comment_author.'" size="22" tabindex="2" />',
        'email'   => '<input type="text" name="email" class="comment-text" title="'.__('Email','adelle-theme').'*" value="'.$comment_author_email.'" size="22" tabindex="3" />',
        'url'     => '<input type="text" name="url" class="comment-text" title="'.__('Website','adelle-theme').'" value="'.$comment_author_url.'" size="22" tabindex="4" /></p>',
      ) ),
    );
    comment_form($comments_args);
    ?>

  </section>
  <?php endif; // if you delete this the sky will fall on your head ?>
</section>