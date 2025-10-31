<?php
/**
 * Navigation - hiển thị bài trước / bài sau
 */

$prev_post = get_previous_post();
$next_post = get_next_post();
?>

<nav class="post-navigation-custom">
    <?php if ($prev_post): ?>
        <a class="nav-item prev-post" href="<?php echo get_permalink($prev_post->ID); ?>">
            <div class="nav-date-vertical">
                <div class="day"><?php echo get_the_date('d', $prev_post->ID); ?></div>
                <div class="divider"></div>
                <div class="month-year">
                    <div class="month"><?php echo get_the_date('m', $prev_post->ID); ?></div>
                    <div class="year"><?php echo get_the_date('y', $prev_post->ID); ?></div>
                </div>
            </div>
            <div class="nav-title"><?php echo get_the_title($prev_post->ID); ?></div>
        </a>
    <?php endif; ?>

    <?php if ($next_post): ?>
        <a class="nav-item next-post" href="<?php echo get_permalink($next_post->ID); ?>">
            <div class="nav-date-vertical">
                <div class="day"><?php echo get_the_date('d', $next_post->ID); ?></div>
                <div class="divider"></div>
                <div class="month-year">
                    <div class="month"><?php echo get_the_date('m', $next_post->ID); ?></div>
                    <div class="year"><?php echo get_the_date('y', $next_post->ID); ?></div>
                </div>
            </div>
            <div class="nav-title"><?php echo get_the_title($next_post->ID); ?></div>
        </a>
    <?php endif; ?>
</nav>