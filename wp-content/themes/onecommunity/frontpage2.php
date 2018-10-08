<?php
/*
Template Name: Frontpage No Page Bulder
*/

/*--------------------------------------------------------------
style.css -> 2.5 - Frontpage
--------------------------------------------------------------*/
?>

<?php get_header() ?>


<?php 
if ( is_user_logged_in() ) :

	if (function_exists('dynamic_sidebar') && dynamic_sidebar('frontpage-slider-logged-in')) :
	endif; 

else :

	if (function_exists('dynamic_sidebar') && dynamic_sidebar('frontpage-slider-logged-out')) :
	endif; 

endif;
?>

<div id="content">



<div class="frontpage-row-1">
	<?php echo do_shortcode( "[onecommunity-bp-groups-listing number_of_groups='8' col='4']" ); ?>
</div><!-- frontpage-row-1 -->



<div class="frontpage-row-2">
	<?php echo do_shortcode( "[onecommunity-blog-posts-tabs number_of_posts='3' col='3']" ); ?>
</div><!-- frontpage-row-2 -->



<div class="frontpage-row-3 spacer-50">
	
<div class="frontpage-row-3-left">
<?php echo do_shortcode( "[onecommunity-title]Active Members[/onecommunity-title]" ); ?>
<?php echo do_shortcode( "[onecommunity-members number_of_members='8' type='active']" ); ?>
<?php echo do_shortcode( "[onecommunity-title]Popular Members[/onecommunity-title]" ); ?>
<?php echo do_shortcode( "[onecommunity-members number_of_members='8' type='popular']" ); ?>
</div>

<div class="frontpage-row-3-right">
<?php echo do_shortcode( "[onecommunity-title]On the Forums[/onecommunity-title]" ); ?>
<?php echo do_shortcode( "[onecommunity-recent-forum-topics number_of_topics='5']" ); ?>
</div>

</div><!-- frontpage-row-3 -->



</div><!-- #content -->

<div id="sidebar">
<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('sidebar-frontpage')) : ?><?php endif; ?>
</div><!-- #sidebar -->

<?php get_footer(); ?>