<?php
/*
 * Template Name: WorkCast
 * Description: WorkCast default template.
 */

/* ================================================================================
  WordPress Post Fields | Content
================================================================================ */
$objThePost = get_post();

get_header(); ?>

<!-- TODO: WP Editor Contents -->
<?php echo apply_filters('the_content', $objThePost->post_content); ?>

<!-- Does NOT work. Reverting to CloudFront alternative. -->
<!-- <iframe src="<?php echo plugin_dir_url( __FILE__ ) . '../assets/html/workcast.html' ?>" class="workcast-iframe">Your browser is not supported.</iframe> -->

<!-- Modify the S3 files to change the look of this page. -->
<iframe src="https://d1qlu92qlflogk.cloudfront.net/workcast/workcast.html" class="workcast-iframe">Your browser is not supported.</iframe>
  
<?php get_footer();