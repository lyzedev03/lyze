<div class="clear"></div>
</div> <!-- #container -->

		<?php do_action( 'bp_after_container' ); ?>

</div><!-- main -->

		<?php do_action( 'bp_before_footer'   ); ?>


<footer>

<div class="footer-left">
<?php if ( shortcode_exists( 'onecommunity-addthis' ) ) { ?>
	 	<?php echo do_shortcode( '[onecommunity-addthis]' ); ?>
<?php } ?>   
</div>

<div class="footer-right"><?php echo get_theme_mod( 'DD_copyright', 'All rights reserved by OneCommunity' ); ?></div>

</footer>

<?php if ( is_user_logged_in() ) {
   if ( function_exists( 'bp_is_active' ) ) {
	if ( $notifications = bp_notifications_get_notifications_for_user( bp_loggedin_user_id(), $format = 'string' ) ) { ?>
	<div class="notif-container">
	<?php
	}

	if ( $notifications ) {
		$counter = 0;
		for ( $i = 0, $count = count( $notifications ); $i < $count; ++$i ) {
			$alt = ( 0 == $counter % 2 ) ? ' alt' : ''; ?>
			<div class="my-notification<?php echo $alt ?>"><?php echo $notifications[$i] ?></div>

			<?php
			 $counter++;
			} ?>
	</div><!-- notif-container -->
	<?php
	} else {}
   }
}
?>

<?php wp_footer(); ?>

</body>

</html>