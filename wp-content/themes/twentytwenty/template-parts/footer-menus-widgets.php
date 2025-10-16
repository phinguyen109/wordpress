<?php
/**
 * Custom unified footer inside footer-menu-widget.php
 * Gộp tất cả footer vào một phần duy nhất, sử dụng widget WordPress.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 */

$has_sidebar_1 = is_active_sidebar( 'sidebar-1' );
$has_sidebar_2 = is_active_sidebar( 'sidebar-2' );
$has_sidebar_3 = is_active_sidebar( 'sidebar-3' );
$has_social_menu = has_nav_menu( 'social' );
?>

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

<section id="footer">
  <div class="container">
    <div class="row text-center text-md-left">

      <?php if ( $has_sidebar_1 ) : ?>
        <div class="col-sm-4 mb-4 footer-widget">
          <?php dynamic_sidebar( 'sidebar-1' ); ?>
        </div>
      <?php endif; ?>

      <?php if ( $has_sidebar_2 ) : ?>
        <div class="col-sm-4 mb-4 footer-widget">
          <?php dynamic_sidebar( 'sidebar-2' ); ?>
        </div>
      <?php endif; ?>

      <?php if ( $has_sidebar_3 ) : ?>
        <div class="col-sm-4 mb-4 footer-widget">
          <?php dynamic_sidebar( 'sidebar-3' ); ?>
        </div>
      <?php endif; ?>

    </div>

    <!-- Social icons -->
    <div class="row">
      <div class="col-12 mt-3">
        <ul class="list-inline social text-center">
          <?php
          if ( $has_social_menu ) :
            wp_nav_menu( array(
              'theme_location' => 'social',
              'container'      => '',
              'items_wrap'     => '%3$s',
              'depth'          => 1,
            ) );
          else :
          ?>
            <li class="list-inline-item"><a href="#"><i class="fa fa-facebook"></i></a></li>
            <li class="list-inline-item"><a href="#"><i class="fa fa-twitter"></i></a></li>
            <li class="list-inline-item"><a href="#"><i class="fa fa-instagram"></i></a></li>
            <li class="list-inline-item"><a href="#"><i class="fa fa-google-plus"></i></a></li>
            <li class="list-inline-item"><a href="#"><i class="fa fa-envelope"></i></a></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>

    <!-- Copyright -->
    <div class="row">
      <div class="col-12 text-center mt-3">
        <p class="small mb-1">
          <a href="https://www.nationaltransaction.com/" class="text-white">
            National Transaction Corporation
          </a> is a Registered MSP/ISO of Elavon, Inc. Georgia [a wholly owned subsidiary of U.S. Bancorp, Minneapolis, MN]
        </p>
        <p class="mb-0 small">© All rights reserved.
          <a class="text-white ml-2" href="https://www.sunlimetech.com" target="_blank">Sunlimetech</a>
        </p>
      </div>
    </div>
  </div>
</section>
