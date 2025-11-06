<?php
/**
 * Custom Blog List Layout (FIT-TDC Style with Sidebar Right + Search Support)
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

get_header();
?>

<main id="site-content" class="news-wrapper">
	
	<?php
	// --- Phần xử lý tiêu đề & mô tả cho trang Search / Archive ---
	$archive_title = '';
	$archive_subtitle = '';

	if (is_search()) {
		global $wp_query;

		// SỬA LẠI: Hiển thị đúng định dạng "Search: “abc”" như ảnh
		$archive_title = sprintf(
			'%1$s %2$s',
			'<span class="search-label">' . __('Search:', 'twentytwenty') . '</span>',
			'&ldquo;' . get_search_query() . '&rdquo;'
		);

		if ($wp_query->found_posts) {
			$archive_subtitle = sprintf(
				_n(
					'We found %s result for your search.',
					'We found %s results for your search.',
					$wp_query->found_posts,
					'twentytwenty'
				),
				number_format_i18n($wp_query->found_posts)
			);
		} else {
			// Giữ nguyên thông báo không có kết quả
			$archive_subtitle = __('We could not find any results for your search. You can give it another try through the search form below.', 'twentytwenty');
		}
	} elseif (is_archive() && !have_posts()) {
		$archive_title = __('Nothing Found', 'twentytwenty');
	} elseif (!is_home()) {
		$archive_title = get_the_archive_title();
		$archive_subtitle = get_the_archive_description();
	}

	if ($archive_title || $archive_subtitle): ?>
		<header class="archive-header has-text-align-center header-footer-group">
			<div class="archive-header-inner section-inner medium">
				<?php if ($archive_title): ?>
					<h1 class="archive-title"><?php echo wp_kses_post($archive_title); ?></h1>
				<?php endif; ?>

				<?php if ($archive_subtitle): ?>
					<div class="archive-subtitle section-inner thin max-percentage intro-text">
						<?php echo wp_kses_post(wpautop($archive_subtitle)); ?>
					</div>
				<?php endif; ?>

				<!-- THÊM FORM TÌM KIẾM VÀO ĐÂY -->
					<div class="header-search-form">
						<form role="search" method="get" class="custom-search-form" action="<?php echo esc_url(home_url('/')); ?>">
							<div class="search-form-inner">
								<input type="search" 
									   class="search-field" 
									   placeholder="Q Search topics or keywords" 
									   value="<?php echo get_search_query(); ?>" 
									   name="s" 
									   aria-label="Search topics or keywords" />
								<button type="submit" class="search-submit">Search</button>
							</div>
						</form>
					</div>
			</div>
		</header>

	<?php endif; ?>
	
	<!-- new-content-wrapper -->
	<div class="new-content-wrapper">
		<!-- Cột bên TRÁI: Xem nhiều - GIỐNG ẢNH 2 -->
		<aside class="news-sidebar">
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

		<!-- Cột GIỮA: Danh sách bài viết -->
		<div class="news-main">
			<?php if (have_posts()): ?>
				<?php while (have_posts()):
					the_post(); ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class('news-item'); ?>>

						<!-- Ảnh đại diện -->
						<div class="news-thumb">
							<a href="<?php the_permalink(); ?>">
								<?php
								if (has_post_thumbnail()) {
									the_post_thumbnail('medium_large', array('class' => 'thumb-img'));
								} else {
									echo '<img class="thumb-img" src="' . esc_url(get_template_directory_uri() . '/assets/images/no-image.jpg') . '" alt="' . esc_attr(get_the_title()) . '">';
								}
								?>
							</a>
						</div>

						<!-- Nội dung -->
						<div class="news-content">
							<div class="news-date">
								<span class="day"><?php echo esc_html(get_the_date('d')); ?></span>
								<span class="month">
									<?php
									$month_number = get_the_date('n');
									echo 'THÁNG ' . $month_number;
									?>
								</span>
							</div>

							<h2 class="news-title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h2>

							<div class="news-excerpt">
								<?php echo wp_trim_words(get_the_excerpt(), 30, '...'); ?>
							</div>

							<a class="news-readmore" href="<?php the_permalink(); ?>">Xem thêm »</a>
						</div>
					</article>
				<?php endwhile; ?>

				<!-- Phân trang -->
				<div class="pagination-wrap">
					<?php
					the_posts_pagination(array(
						'mid_size' => 3,
						'prev_text' => __('« Trước', 'twentytwenty'),
						'next_text' => __('Sau »', 'twentytwenty'),
						'screen_reader_text' => '',
					));
					?>
				</div>

			<?php elseif (is_search()): ?>
				<!-- Không có kết quả tìm kiếm - THIẾT KẾ CHUẨN ẢNH -->
				<div class="no-search-results-wrapper">
					<div class="search-suggestions-box">
						<div class="search-suggestions-label">Q Search topics or keywords</div>
						<!-- CUSTOM SEARCH FORM GIỐNG ẢNH -->
						<form role="search" method="get" class="custom-search-form" action="<?php echo esc_url(home_url('/')); ?>">
							<div class="search-form-inner">
								<input type="search" 
									   class="search-field" 
									   placeholder="" 
									   value="<?php echo get_search_query(); ?>" 
									   name="s" 
									   aria-label="Search topics or keywords" />
								<button type="submit" class="search-submit">Search</button>
							</div>
						</form>
					</div>
					
					<!-- THÊM PHẦN NÀY: Thanh tìm kiếm ở dưới cùng -->
					<div class="bottom-search-form">
						<div class="search-suggestions-label">Q Search topics or keywords</div>
						<!-- CUSTOM SEARCH FORM GIỐNG ẢNH -->
						<form role="search" method="get" class="custom-search-form" action="<?php echo esc_url(home_url('/')); ?>">
							<div class="search-form-inner">
								<input type="search" 
									   class="search-field" 
									   placeholder="" 
									   value="<?php echo get_search_query(); ?>" 
									   name="s" 
									   aria-label="Search topics or keywords" />
								<button type="submit" class="search-submit">Search</button>
							</div>
						</form>
					</div>
				</div>
			<?php else: ?>
				<p>Không có bài viết nào.</p>
			<?php endif; ?>
		</div>

		<!-- Cột bên PHẢI: Comments - HIỂN THỊ COMMENTS THỰC TẾ -->
		<aside class="comments-sidebar">
			<div class="sidebar-header">
				<h3 class="sidebar-title">Comments</h3>
			</div>
			<div class="sidebar-content">
				<ul class="comments-list">
					<?php
					// Lấy 6 comments mới nhất
					$recent_comments = get_comments(array(
						'number' => 6,
						'status' => 'approve'
					));

					if ($recent_comments):
						foreach ($recent_comments as $comment): ?>
							<li class="comment-item">
								<div class="comment-text">
									<?php echo wp_trim_words($comment->comment_content, 10, '...'); ?>
								</div>
							</li>
						<?php endforeach;
					else: ?>
						<li class="comment-item">
							<div class="comment-text">Chưa có comment nào.</div>
						</li>
					<?php endif; ?>
				</ul>
			</div>
		</aside>
	</div>

</main><!-- #site-content -->

<?php get_template_part('template-parts/footer-menus-widgets'); ?>
<?php get_footer(); ?>