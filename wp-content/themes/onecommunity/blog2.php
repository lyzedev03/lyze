<?php
/*
Template Name: Blog - Masonry
*/
?>

<?php get_header(); ?>


<div id="content">

<div class="page-title"><?php the_title(); ?></div>

<ul class="masonry-posts list-unstyled">

<?php
$temp = $wp_query;
$wp_query= null;
$wp_query = new WP_Query();
$wp_query->query('posts_per_page=9'.'&paged='.$paged);
while ($wp_query->have_posts()) : $wp_query->the_post();
?>

<li class="blog-thumbs-view-entry">
    <div class="blog-thumb">
		<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('my-thumbnail'); ?></a>
	</div>
	<div class="group-box-bottom">
    	<div class="blog-thumb-title"><a href="<?php the_permalink(); ?>"><?php $thetitle = get_the_title(); $getlength = strlen($thetitle); $thelength = 90; echo mb_substr($thetitle, 0, $thelength, 'UTF-8'); if ($getlength > $thelength) echo "..."; ?></a></div>
		<div class="group-box-details"><?php the_category(', ') ?>
		<div class="group-box-details-date"><?php the_time('M j, Y / G:i'); ?></div>
		</div>
	</div>
</li>


<?php endwhile; // end of loop
 ?>

</ul>

<script type="text/javascript">
jQuery(function() {
jQuery('ul.masonry-posts').masonry({
  // options
  itemSelector: 'li.blog-thumbs-view-entry'
});
});
</script>

<div style="display:inline">
<div class="older-entries"><?php next_posts_link( __( '&larr; Previous Entries', 'onecommunity' ) ); ?></div>
<div class="newer-entries"><?php previous_posts_link( __( 'Next Entries &rarr;', 'onecommunity' ) ); ?></div>
</div>

<?php $wp_query = null; $wp_query = $temp;?>

</div>


<div id="sidebar">
	<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('sidebar-blog')) : ?><?php endif; ?>
	<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('sidebar-ad-blog')) : ?><?php endif; ?>
</div><!--sidebar ends-->

<?php get_footer(); ?>