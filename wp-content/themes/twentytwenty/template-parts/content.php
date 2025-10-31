<?php
/**
 * Template hiển thị bài viết
 * Format giống hình mẫu (Ngày bên trái, nội dung bên phải)
 */

if ( is_single() ) { ?>
    <article <?php post_class('single-post'); ?> id="post-<?php the_ID(); ?>">

        <!-- Ảnh đại diện -->
        <?php if ( has_post_thumbnail() ) : ?>
            <div class="single-thumbnail">
                <?php the_post_thumbnail('large'); ?>
            </div>
        <?php endif; ?>

        <!-- Nội dung -->
        <div class="post-content">

            <!-- Gộp tiêu đề và vòng tròn ngày vào chung -->
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

            <!-- Nội dung bài viết -->
            <div class="entry-content">
                <?php the_content(__('Continue reading', 'twentytwenty')); ?>

                <?php
                // Nếu bài viết chia nhiều trang bằng <!--nextpage-->
                wp_link_pages(array(
                    'before' => '<div class="page-links">Trang:',
                    'after'  => '</div>',
                ));
                ?>
            </div>

        </div>

        <!-- Navigation Comment -->
        <div class="post-footer section-inner">
            <?php
            get_template_part('template-parts/navigation');

            // Hiển thị comment nếu bật
            if ((comments_open() || get_comments_number()) && !post_password_required()) {
                echo '<div class="comments-wrapper section-inner">';
                comments_template();
                echo '</div>';
            }
            ?>
        </div>

    </article>

<?php } else { ?>

    <!-- Danh sách bài viết -->
    <article <?php post_class('news-item'); ?> id="post-<?php the_ID(); ?>">

        <div class="news-card">

            <!-- Ảnh đại diện -->
            <?php if ( has_post_thumbnail() ) : ?>
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