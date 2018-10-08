<?php do_action( 'bp_before_blog_search_form' ); ?>

<div id="top-search-container">
<form method="get" id="searchform" action="<?php echo home_url(); ?>/">
<div id="searchform-child">
	<input type="text" title="<?php _e('Search', 'onecommunity' ); ?>" value="<?php the_search_query(); ?>" name="s" id="s" class="hoverText hoverTextActive" />
	<input type="submit" id="searchsubmit" value=" " />
	<?php do_action( 'bp_blog_search_form' ); ?>
</div>
</form>
</div>

<?php do_action( 'bp_after_blog_search_form' ); ?>