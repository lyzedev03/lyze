<?php

/**
 * BuddyPress - Activity Stream (Single Item)
 *
 * This template is used by activity-loop.php and AJAX functions to show
 * each activity.
 *
 * @package BuddyPress
 * @subpackage bp-default
 */

?>

<?php do_action( 'bp_before_activity_entry' ); ?>

<li class="<?php bp_activity_css_class(); ?>" id="activity-<?php bp_activity_id(); ?>">
	<span class="activity-avatar">
		<a href="<?php bp_activity_user_link(); ?>">

			<?php bp_activity_avatar(); ?>

		</a>
	</span>

	<span class="activity-content">

		<span class="activity-header"><object><?php bp_activity_action(); ?></object></span>

		<?php if ( 'activity_comment' == bp_get_activity_type() ) : ?>

			<div class="activity-inreplyto">
				<strong><?php _e( 'In reply to: ', 'buddypress' ); ?></strong><?php bp_activity_parent_content(); ?> <a href="<?php bp_activity_thread_permalink(); ?>" class="view" title="<?php _e( 'View Thread / Permalink', 'buddypress' ); ?>"><?php _e( 'View', 'buddypress' ); ?></a>
			</div>

		<?php endif; ?>

		<?php if ( bp_activity_has_content() ) : ?>

			<span class="activity-inner"><object><?php bp_activity_content_body(); ?></object></span>

		<?php endif; ?>

		<?php do_action( 'bp_activity_entry_content' ); ?>

		<?php if ( is_user_logged_in() ) : ?>

			<div class="activity-meta">

				<?php if ( bp_activity_can_comment() ) : ?>

					<a href="<?php bp_activity_comment_link(); ?>" class="button acomment-reply bp-primary-action" id="acomment-comment-<?php bp_activity_id(); ?>"><?php printf( __( 'Comment %s', 'buddypress' ), '<span>' . bp_activity_get_comment_count() . '</span>' ); ?></a>

				<?php endif; ?>

				<?php if ( bp_activity_can_favorite() ) : ?>

					<?php if ( !bp_get_activity_is_favorite() ) : ?>

						<a href="<?php bp_activity_favorite_link(); ?>" class="button fav bp-secondary-action" title="<?php esc_attr_e( 'Mark as Favorite', 'buddypress' ); ?>"><?php _e( 'Favorite', 'buddypress' ); ?></a>

					<?php else : ?>

						<a href="<?php bp_activity_unfavorite_link(); ?>" class="button unfav bp-secondary-action" title="<?php esc_attr_e( 'Remove Favorite', 'buddypress' ); ?>"><?php _e( 'Remove Favorite', 'buddypress' ); ?></a>

					<?php endif; ?>

				<?php endif; ?>

				<?php if ( bp_activity_user_can_delete() ) bp_activity_delete_link(); ?>

				<?php do_action( 'bp_activity_entry_meta' ); ?>

			</div>

		<?php endif; ?>

	</span>

	<?php do_action( 'bp_before_activity_entry_comments' ); ?>

	<?php if ( ( bp_activity_get_comment_count() || bp_activity_can_comment() ) || bp_is_single_activity() ) : ?>

		<div class="activity-comments">

			<?php bp_activity_comments(); ?>

			<?php if ( is_user_logged_in() && bp_activity_can_comment() ) : ?>

				<form action="<?php bp_activity_comment_form_action(); ?>" method="post" id="ac-form-<?php bp_activity_id(); ?>" class="ac-form"<?php bp_activity_comment_form_nojs_display(); ?>>
					<div class="ac-reply-avatar"><?php bp_loggedin_user_avatar( 'width=' . BP_AVATAR_THUMB_WIDTH . '&height=' . BP_AVATAR_THUMB_HEIGHT ); ?></div>
					<div class="ac-reply-content">
						<div class="ac-textarea">
							<textarea id="ac-input-<?php bp_activity_id(); ?>" class="ac-input bp-suggestions" name="ac_input_<?php bp_activity_id(); ?>"></textarea>
						</div>
						<input type="submit" name="ac_form_submit" value="<?php esc_attr_e( 'Post', 'buddypress' ); ?>" /> &nbsp; <a href="#" class="ac-reply-cancel"><?php _e( 'Cancel', 'buddypress' ); ?></a>
						<input type="hidden" name="comment_form_id" value="<?php bp_activity_id(); ?>" />
					</div>

					<?php do_action( 'bp_activity_entry_comments' ); ?>

					<?php wp_nonce_field( 'new_activity_comment', '_wpnonce_new_activity_comment' ); ?>

				</form>

			<?php endif; ?>

		</div>

	<?php endif; ?>

	<?php do_action( 'bp_after_activity_entry_comments' ); ?>

</li>

<?php do_action( 'bp_after_activity_entry' ); ?>
