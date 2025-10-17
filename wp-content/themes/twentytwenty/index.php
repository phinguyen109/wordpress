<?php
/**
 * Custom Blog List Layout (FIT-TDC Style with Sidebar Right)
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

get_header();
?>

<main id="site-content" class="news-wrapper">

	<!-- Cột bên trái: Danh sách bài viết -->
	<div class="news-main">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'news-item' ); ?>>

					<!-- Ảnh đại diện -->
					<div class="news-thumb">
						<a href="<?php the_permalink(); ?>">
							<?php 
							if ( has_post_thumbnail() ) {
								the_post_thumbnail( 'medium_large', array( 'class' => 'thumb-img' ) );
							} else {
								echo '<img class="thumb-img" src="' . esc_url( get_template_directory_uri() . '/assets/images/no-image.jpg' ) . '" alt="' . esc_attr( get_the_title() ) . '">';
							}
							?>
						</a>
					</div>

					<!-- Nội dung -->
					<div class="news-content">
						<div class="news-date">
							<span class="day"><?php echo esc_html( get_the_date( 'd' ) ); ?></span>
							<span class="month"><?php echo mb_strtoupper( get_the_date( 'M' ) ); ?></span>
						</div>

						<h2 class="news-title">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h2>

						<div class="news-excerpt">
							<?php echo wp_trim_words( get_the_excerpt(), 30, '...' ); ?>
						</div>

						<a class="news-readmore" href="<?php the_permalink(); ?>">Xem thêm »</a>
					</div>
				</article>
			<?php endwhile; ?>

			<!-- Phân trang -->
			<div class="pagination-wrap">
				<?php
				the_posts_pagination( array(
					'mid_size'  => 1,
					'prev_text' => __('« Trước', 'twentytwenty'),
					'next_text' => __('Sau »', 'twentytwenty'),
					'screen_reader_text' => '',
				) );
				?>
			</div>

		<?php else : ?>
			<p>Không có bài viết nào.</p>
		<?php endif; ?>
	</div>

	<!-- Cột bên phải: Bài viết nổi bật -->
	<aside class="news-sidebar">
		<h3 class="sidebar-title">Bài viết nổi bật</h3>
		<ul class="sidebar-list">
			<?php
			$featured = new WP_Query(array(
				'posts_per_page' => 5,
				'orderby'        => 'comment_count',
			));
			if ( $featured->have_posts() ) :
				while ( $featured->have_posts() ) : $featured->the_post(); ?>
					<li class="sidebar-item">
						<a href="<?php the_permalink(); ?>" class="sidebar-link">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'thumbnail', array( 'class' => 'sidebar-thumb' ) ); ?>
							<?php endif; ?>
							<span class="sidebar-text"><?php the_title(); ?></span>
						</a>
					</li>
				<?php endwhile;
				wp_reset_postdata();
			endif;
			?>
		</ul>
	</aside>

</main><!-- #site-content -->

<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>
<?php get_footer(); ?>
