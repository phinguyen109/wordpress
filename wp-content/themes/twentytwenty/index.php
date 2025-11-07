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

				<div class="header-search-form">
					<form role="search" method="get" class="custom-search-form"
						action="<?php echo esc_url(home_url('/')); ?>">
						<div class="search-form-inner">
							<input type="search" class="search-field" placeholder="Q Search topics or keywords"
								value="<?php echo get_search_query(); ?>" name="s" aria-label="Search topics or keywords" />
							<button type="submit" class="search-submit">Search</button>
						</div>
					</form>
				</div>
			</div>
		</header>

	<?php endif; ?>

	<?php if (have_posts() && is_search()): ?>
		<div class="search-results-header">
			<h1 class="search-results-main-title">
				Results for "<?php echo esc_html(get_search_query()); ?>"
			</h1>
			<?php global $wp_query; ?>
			<p class="search-results-count">
				We found <?php echo number_format_i18n($wp_query->found_posts); ?>
				<?php echo $wp_query->found_posts == 1 ? 'result' : 'results'; ?> for your search.
			</p>
		</div>
	<?php endif; ?>

	<!-- new-content-wrapper -->
	<div class="new-content-wrapper">
		<!-- Cột bên TRÁI -->
		<?php if (!is_search()): ?>
			<aside class="news-sidebar">
				<div class="sidebar-header">
					<h3 class="sidebar-title">Xem nhiều</h3>
				</div>
				<div class="sidebar-content">
					<ul class="sidebar-list">
						<?php
						$popular_posts = new WP_Query([
							'posts_per_page' => 8,
							'orderby' => 'comment_count',
							'order' => 'DESC'
						]);

						if ($popular_posts->have_posts()):
							$count = 1;
							while ($popular_posts->have_posts()):
								$popular_posts->the_post(); ?>
								<li class="sidebar-item">
									<div class="item-number"><?php echo $count; ?></div>
									<div class="item-content">
										<a href="<?php the_permalink(); ?>" class="item-link"><?php the_title(); ?></a>
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
		<?php endif; ?>

		<!-- Cột GIỮA -->
		<div class="news-main">
			<?php if (have_posts()): ?>
				<?php while (have_posts()):
					the_post(); ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class('news-item'); ?>>
						<div class="news-thumb">
							<a href="<?php the_permalink(); ?>">
								<?php if (has_post_thumbnail()) {
									the_post_thumbnail('medium_large', ['class' => 'thumb-img']);
								} else {
									echo '<img class="thumb-img" src="' . esc_url(get_template_directory_uri() . '/assets/images/no-image.jpg') . '" alt="' . esc_attr(get_the_title()) . '">';
								} ?>
							</a>
						</div>
						<div class="news-content">
							<div class="news-date">
								<span class="day"><?php echo esc_html(get_the_date('d')); ?></span>
								<span class="month"><?php echo 'THÁNG ' . get_the_date('n'); ?></span>
							</div>
							<h2 class="news-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<div class="news-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 30, '...'); ?></div>
							<a class="news-readmore" href="<?php the_permalink(); ?>">Xem thêm »</a>
						</div>
					</article>
				<?php endwhile; ?>

				<div class="pagination-wrap">
					<?php the_posts_pagination([
						'mid_size' => 3,
						'prev_text' => __('« Trước', 'twentytwenty'),
						'next_text' => __('Sau »', 'twentytwenty'),
						'screen_reader_text' => '',
					]); ?>
				</div>

				<!-- 🧩 Latest News Timeline (chỉ hiển thị khi search) -->
				<?php if (is_search()): ?>
					<?php latest_news_timeline(4); ?>
				<?php endif; ?>


			<?php elseif (is_search()): ?>
				<div class="no-search-results-wrapper">
					<div class="search-suggestions-box">
						<div class="search-suggestions-label">Q Search topics or keywords</div>
						<form role="search" method="get" class="custom-search-form"
							action="<?php echo esc_url(home_url('/')); ?>">
							<div class="search-form-inner">
								<input type="search" class="search-field" placeholder=""
									value="<?php echo get_search_query(); ?>" name="s" />
								<button type="submit" class="search-submit">Search</button>
							</div>
						</form>
					</div>
				</div>
			<?php else: ?>
				<p>Không có bài viết nào.</p>
			<?php endif; ?>
		</div>

		<!-- ✅ Cột bên PHẢI: Comments -->
		<aside class="comments-sidebar">
			<div class="sidebar-header">
				<h3 class="sidebar-title">Comments</h3>
			</div>
			<div class="sidebar-content">
				<?php if (is_search()): ?>
					<?php
					if (is_active_widget(false, false, 'comment_style14_widget', true)) {
						the_widget('Comment_Style14_Widget', ['title' => '', 'number' => 5]);
					} else {
						$recent_comments = get_comments([
							'number' => 5,
							'status' => 'approve',
							'type' => 'comment',
						]);

						if ($recent_comments):
							foreach ($recent_comments as $comment):
								$avatar = get_avatar($comment->comment_author_email, 48);
								$content = wp_trim_words($comment->comment_content, 30, '...');
								?>
								<div class="search-comment-box">
									<div class="search-comment-avatar">
										<?php echo $avatar; ?>
									</div>
									<div class="search-comment-body">
										<h4 class="search-comment-author"><?php echo esc_html($comment->comment_author); ?></h4>
										<p class="search-comment-text"><?php echo esc_html($content); ?></p>
										<a href="<?php echo esc_url(get_comment_link($comment)); ?>" class="search-comment-link">View
											Post »</a>
									</div>
								</div>
								<?php
							endforeach;
						else:
							echo '<p class="no-comments">Chưa có comment nào.</p>';
						endif;
					}
					?>
				<?php else: ?>
					<ul class="comments-list">
						<?php
						$recent_comments = get_comments(['number' => 6, 'status' => 'approve']);
						if ($recent_comments):
							foreach ($recent_comments as $comment): ?>
								<li class="comment-item">
									<div class="comment-text"><?php echo wp_trim_words($comment->comment_content, 10, '...'); ?>
									</div>
								</li>
							<?php endforeach;
						else: ?>
							<li class="comment-item">
								<div class="comment-text">Chưa có comment nào.</div>
							</li>
						<?php endif; ?>
					</ul>
				<?php endif; ?>
			</div>
		</aside>

	</div>

</main>

<?php get_template_part('template-parts/footer-menus-widgets'); ?>
<?php get_footer(); ?>