<?php
/**
 * Template hiển thị bài viết
 * Format giống hình mẫu (Ngày bên trái, nội dung bên phải)
 */

if (is_single()) { ?>
    <div class="container single-layout">
        <div class="row">

            <!-- Cột categories-->
            <div class="col-2 post-sidebar">
                <?php
                $categories = get_categories(array(
                    'orderby' => 'name',
                    'order' => 'ASC',
                ));

                if (!empty($categories)) {
                    echo '<div class="post-categories"><h3>Categories</h3><ul>';
                    foreach ($categories as $category) {
                        echo '<li><a class="post-category" href="' . esc_url(get_category_link($category->term_id)) . '">';
                        echo esc_html($category->name);
                        echo '</a></li>';
                    }
                    echo '</ul></div>';
                }
                ?>
            </div>

            <!-- Cột nội dung chính -->
            <div class="col-8 post-main">
                <article <?php post_class('single-post'); ?> id="post-<?php the_ID(); ?>">

                    <?php if (has_post_thumbnail()): ?>
                        <div class="single-thumbnail">
                            <?php the_post_thumbnail('large'); ?>
                        </div>
                    <?php endif; ?>

                    <div class="post-content">
                        <div class="post-header">
                            <h1 class="post-title"><?php the_title(); ?></h1>
                            <div class="date-circle">
                                <div class="date-left">
                                    <div class="day"><?php echo get_the_date('d'); ?></div>
                                    <div class="divider"></div>
                                    <div class="month"><?php echo get_the_date('m'); ?></div>
                                </div>
                                <div class="year"><?php echo get_the_date('y'); ?></div>
                            </div>
                        </div>

                        <div class="line-divider"></div>

                        <div class="entry-content">
                            <?php the_content(); ?>
                        </div>
                    </div>

                    <div class="post-footer section-inner">
                        <?php get_template_part('template-parts/navigation'); ?>

                        <?php
                        if ((comments_open() || get_comments_number()) && !post_password_required()) {
                            echo '<div class="comments-wrapper section-inner">';
                            comments_template();
                            echo '</div>';
                        }
                        ?>
                    </div>
                </article>
            </div>
            <div class="col-2"></div>
        </div>
    </div>
<?php } else { ?>

    <!-- Danh sách bài viết -->
    <article <?php post_class('news-item'); ?> id="post-<?php the_ID(); ?>">

        <div class="news-card">

            <!-- Ảnh đại diện -->
            <?php if (has_post_thumbnail()): ?>
                <div class="news-thumb">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('medium_large'); ?>
                    </a>
                </div>
            <?php endif; ?>

            <!-- Cột ngày tháng -->
            <div class="news-date">
                <div class="day"><?php echo get_the_date('d'); ?></div>
                <div class="month">THÁNG <?php echo get_the_date('m'); ?></div>
            </div>

            <!-- Nội dung bài viết -->
            <div class="news-content">
                <div class="news-text">
                    <h2 class="news-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>
                    <div class="news-excerpt">
                        <?php echo wp_trim_words(get_the_excerpt(), 50, ' [...]'); ?>
                    </div>
                </div>
            </div>

        </div>
    </article>

<?php } ?>