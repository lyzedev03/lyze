<?php get_header( 'buddypress' ); ?>

<div id="content">

<?php do_action( 'bp_before_directory_groups_page' ); ?>

		<?php do_action( 'bp_before_directory_groups' ); ?>

		<form action="" method="post" id="groups-directory-form" class="dir-form">
			<?php do_action( 'bp_before_directory_groups_content' ); ?>

			<?php do_action( 'template_notices' ); ?>


			<div id="groups-dir-list" class="groups dir-list">

				<?php bp_get_template_part( 'groups/groups-loop' ); ?>

			</div><!-- #groups-dir-list -->

			<?php do_action( 'bp_directory_groups_content' ); ?>

			<?php wp_nonce_field( 'directory_groups', '_wpnonce-groups-filter' ); ?>

			<?php do_action( 'bp_after_directory_groups_content' ); ?>

		</form><!-- #groups-directory-form -->

		<?php do_action( 'bp_after_directory_groups' ); ?>
<?php do_action( 'bp_after_directory_groups_page' ); ?>
	</div><!-- #content -->

<?php get_footer( 'buddypress' ); ?>