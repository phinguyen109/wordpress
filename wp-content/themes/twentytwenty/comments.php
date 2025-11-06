<?php
/**
 * The template file for displaying the comments and comment form for the
 * Twenty Twenty theme.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
*/
if (post_password_required()) {
    return;
}

if ($comments) {
    ?>

    <div class="comments" id="comments">

        <?php
        $comments_number = get_comments_number();
        ?>

        <div class="comments-header section-inner small max-percentage">

            <h2 class="comment-reply-title post-comments-title">
            <?php
                if (!have_comments()) {
                    _e('Leave a comment', 'twentytwenty');
                } elseif ('1' === $comments_number) {
                    /* translators: %s: Post title. */
                    printf(_x('One reply on &ldquo;%s&rdquo;', 'comments title', 'twentytwenty'), get_the_title());
                } else {
                    printf(
                    /* translators: 1: Number of comments, 2: Post title. */
                        _nx(
                            '%1$s reply on &ldquo;%2$s&rdquo;',
                            '%1$s replies on &ldquo;%2$s&rdquo;',
                            $comments_number,
                            'comments title',
                            'twentytwenty'
                        ),
                        number_format_i18n($comments_number),
                        get_the_title()
                    );
                }

                ?>
            </h2><!-- .comments-title -->

        </div><!-- .comments-header -->

        <div class="comments-inner section-inner thin max-percentage">

            <?php
            $comments_list = get_comments(array(
                'post_id' => get_the_ID(),
                'status' => 'approve',
                'orderby' => 'comment_date_gmt',
                'order' => 'ASC'
            ));

            if ($comments_list) {
                echo '<div class="comments-area">';
                echo '<h3 class="comments-title">Comments</h3>';
                echo '<div class="comments-list">';
                foreach ($comments_list as $comment) {
                    echo '<div class="comment-item">';
                    echo '<a href="' . esc_url(get_comment_link($comment->comment_ID)) . '">';
                    echo esc_html($comment->comment_content);
                    echo '</a>';
                    echo '</div>';
                }
                echo '</div>';
                echo '</div>';
            }


            $comment_pagination = paginate_comments_links(
                array(
                    'echo' => false,
                    'end_size' => 0,
                    'mid_size' => 0,
                    'next_text' => __('Newer Comments', 'twentytwenty') . ' <span aria-hidden="true">&rarr;</span>',
                    'prev_text' => '<span aria-hidden="true">&larr;</span> ' . __('Older Comments', 'twentytwenty'),
                )
            );

            if ($comment_pagination) {
                $pagination_classes = '';

                // If we're only showing the "Next" link, add a class indicating so.
                if (false === strpos($comment_pagination, 'prev page-numbers')) {
                    $pagination_classes = ' only-next';
                }
                ?>

                <nav class="comments-pagination pagination<?php echo $pagination_classes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output ?>"
                     aria-label="<?php esc_attr_e('Comments', 'twentytwenty'); ?>">
                    <?php echo wp_kses_post($comment_pagination); ?>
                </nav>

                <?php
            }
            ?>

        </div><!-- .comments-inner -->

    </div><!-- comments -->

    <?php
}

if (comments_open() || pings_open()) {

    if ($comments) {
        echo '<hr class="styled-separator is-style-wide" aria-hidden="true" />';
    }

    comment_form(array(
        'class_form' => 'comment-form card my-5',
        'title_reply_before' => '
			<div class="card-header">
				<ul class="nav nav-tabs card-header-tabs">
					<li class="nav-item">
						<a class="nav-link active" id="posts-tab" href="#" role="tab">',
        'title_reply' => esc_html__('Make a Post', 'textdomain'),
        'title_reply_after' => '</a></li></ul></div>
			<div class="card-body">',

        'comment_notes_before' => '',
        'comment_notes_after' => '</div>', // đóng card-body

        'logged_in_as' => '', // ẩn “Logged in as...”

        'fields' => array(
            'author' => '',
            'email' => '',
            'url' => '',
        ),

        // Không dùng class nội bộ -> clean HTML
        'comment_field' => '
			<textarea id="comment" name="comment" placeholder="' . esc_attr__('What are you thinking...', 'textdomain') . '" required></textarea>',

        'submit_button' => '
			<div class="text-right">
				<button type="submit">share</button>
			</div>',
    ));


} elseif (is_single()) {

    if ($comments) {
        echo '<hr class="styled-separator is-style-wide" aria-hidden="true" />';
    }

    ?>

    <div class="comment-respond" id="respond">

        <p class="comments-closed"><?php _e('Comments are closed.', 'twentytwenty'); ?></p>

    </div><!-- #respond -->

    <?php
}