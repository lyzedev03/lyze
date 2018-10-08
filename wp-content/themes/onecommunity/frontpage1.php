<?php
/*
Template Name: Frontpage 1
*/
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

<?php if (have_posts()) : while (have_posts()) : the_post();
the_content();
endwhile;
endif; ?>

</div><!-- #content -->

<div id="sidebar">
<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('sidebar-frontpage')) : ?><?php endif; ?>
</div><!-- #sidebar -->

<?php get_footer(); ?>