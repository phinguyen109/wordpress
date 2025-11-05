<?php
/**
 * Template hiển thị bài viết
 * Format giống hình mẫu (Ngày bên trái, nội dung bên phải)
 */

if (is_single()) { ?>
    <!-- GIỮ NGUYÊN PHẦN SINGLE POST -->
    <div class="container single-layout">
        <div class="row">

            <!-- Cột Categories (chiếm 2 cột) -->
            <div class="col-2 post-sidebar">
                <?php
                // Lấy các category của bài viết hiện tại
                $categories = get_the_category();

                // Nếu bài viết có category
                if (!empty($categories)) {

                    // Lấy thêm 3 category khác (ngoài category hiện tại)
                    $exclude_ids = wp_list_pluck($categories, 'term_id');
                    $extra_cats = get_categories(array(
                        'number' => 3,
                        'exclude' => $exclude_ids,
                        'orderby' => 'count',
                        'order' => 'DESC'
                    ));

                    // Gộp hai mảng lại (category hiện tại + 3 category khác)
                    $all_cats = array_merge($categories, $extra_cats);

                    echo '<div class="post-categories"><h3>Categories</h3><ul>';

                    foreach ($all_cats as $category) {
                        echo '<li><a class="post-category" href="' . esc_url(get_category_link($category->term_id)) . '">';
                        echo esc_html($category->name);
                        echo '</a></li>';
                    }

                    echo '</ul></div>';
                }
                ?>
            </div>


            <!-- Cột nội dung chính (chiếm 8 cột, chừa lề phải 2 cột) -->
            <div class="col-7 post-main">
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
            <!-- Bài viết mới nhất (2 cột bên phải) -->
            <div class="col-3 post-latest">
                <div class="latest-posts">
                    <h3>Bài viết mới nhất</h3>
                    <ul id="latest-post-list">
                        <?php
                        $recent_posts = wp_get_recent_posts(array(
                            'numberposts' => 3,
                            'post_status' => 'publish'
                        ));

                        foreach ($recent_posts as $post):
                            ?>
                            <li class="latest-item">
                                <div class="latest-date">
                                    <div class="day-month">
                                        <span class="day"><?php echo get_the_date('d', $post['ID']); ?></span>
                                        <hr class="divider">
                                        <span class="month"><?php echo get_the_date('m', $post['ID']); ?></span>
                                    </div>
                                    <span class="year"><?php echo get_the_date('y', $post['ID']); ?></span>
                                </div>
                                <div class="latest-title">
                                    <a href="<?php echo get_permalink($post['ID']); ?>">
                                        <?php echo esc_html($post['post_title']); ?>
                                    </a>
                                </div>
                            </li>
                        <?php endforeach;
                        wp_reset_query(); ?>
                    </ul>

                    <!-- Nút bấm -->
                    <div class="view-all">
                        <a href="#" id="toggle-posts" data-nonce="<?php echo wp_create_nonce('load_more_posts'); ?>">Xem tất
                            cả tin tức</a>
                    </div>

                </div>
            </div>


        </div>
    </div>
<?php } else { ?>

    <!-- SIDEBAR XEM NHIỀU BÊN TRÁI + DANH SÁCH BÀI VIẾT -->
    <div class="archive-layout-wrapper">
        <!-- Sidebar Xem nhiều bên trái -->
        <aside class="archive-sidebar">
            <div class="sidebar-header">
                <h3 class="sidebar-title">Xem nhiều</h3>
            </div>
            <div class="sidebar-content">
                <ul class="sidebar-list">
                    <?php
                    // Lấy 8 bài viết có nhiều comment nhất
                    $popular_posts = new WP_Query(array(
                        'posts_per_page' => 8,
                        'orderby' => 'comment_count',
                        'order' => 'DESC'
                    ));

                    if ($popular_posts->have_posts()):
                        $count = 1;
                        while ($popular_posts->have_posts()):
                            $popular_posts->the_post(); ?>
                            <li class="sidebar-item">
                                <div class="item-number"><?php echo $count; ?></div>
                                <div class="item-content">
                                    <a href="<?php the_permalink(); ?>" class="item-link">
                                        <?php the_title(); ?>
                                    </a>
                                </div>
                            </li>
                            <?php $count++; ?>
                        <?php endwhile;
                        wp_reset_postdata();
                    else: ?>
                        <li class="sidebar-item">Không có bài viết nào.</li>
                    <?php endif; ?>
                </ul>
            </div>
        </aside>

        <!-- Danh sách bài viết bên phải -->
        <div class="archive-main-content">
            <article class="archive-post-item" id="post-<?php the_ID(); ?>">
                
                <div class="archive-post-content">
                    
                    <!-- Cột số thứ tự bên trái  -->
                    <div class="archive-number-section">
                        <div class="number-box">
                            <div class="post-number"><?php echo $wp_query->current_post + 1; ?></div>
                        </div>
                    </div>

                    <!-- Nội dung bài viết bên trái -->
                    <div class="archive-content-section">
                        <h2 class="archive-post-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        <div class="archive-post-excerpt">
                            <?php 
                            $excerpt = get_the_excerpt();
                            if (empty($excerpt)) {
                                $content = get_the_content();
                                $excerpt = wp_trim_words($content, 50, ' [...]');
                            } else {
                                $excerpt = wp_trim_words($excerpt, 50, ' [...]');
                            }
                            echo $excerpt;
                            ?>
                        </div>
                    </div>

                </div>
                
            </article>
        </div>
    </div>

<?php } ?>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const btn = document.getElementById("toggle-posts");
        const list = document.getElementById("latest-post-list");
        let expanded = false;
        const nonce = btn.dataset.nonce;

        btn.addEventListener("click", function (e) {
            e.preventDefault();
            btn.textContent = "Đang tải...";

            // Gọi AJAX
            const action = expanded ? "load_recent_posts" : "load_all_posts";

            fetch(ajaxurl, {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `action=${action}&security=${nonce}`
            })
                .then(res => res.text())
                .then(html => {
                    list.innerHTML = html;
                    expanded = !expanded;
                    btn.textContent = expanded ? "Thu gọn" : "Xem tất cả tin tức";
                })
                .catch(err => {
                    console.error(err);
                    btn.textContent = "Lỗi! Thử lại";
                });
        });
    });

</script>