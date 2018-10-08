<?php

/**
 * Single Topic Lead Content Part
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php do_action( 'bbp_template_before_lead_topic' ); ?>

<ul id="bbp-topic-<?php bbp_topic_id(); ?>-lead" class="bbp-lead-topic">

	<li class="bbp-body">


		<div id="post-<?php bbp_topic_id(); ?>" <?php bbp_topic_class(); ?>>

			<div class="bbp-topic-author">

				<?php do_action( 'bbp_theme_before_topic_author_details' ); ?>

				<?php bbp_topic_author_link( array( 'sep' => '<br />', 'show_role' => true ) ); ?>

				<?php if ( bbp_is_user_keymaster() ) : ?>

					<?php do_action( 'bbp_theme_before_topic_author_admin_details' ); ?>

					<div class="bbp-topic-ip"><?php bbp_author_ip( bbp_get_topic_id() ); ?></div>

					<?php do_action( 'bbp_theme_after_topic_author_admin_details' ); ?>

				<?php endif; ?>

				<?php do_action( 'bbp_theme_after_topic_author_details' ); ?>

			</div><!-- .bbp-topic-author -->

			<div class="bbp-topic-content">

				<?php do_action( 'bbp_theme_before_topic_content' ); ?>

				<p class="topic-meta"><a id="post-<?php bbp_reply_id(); ?>" href="<?php bbp_reply_url(); ?>" title="<?php bbp_reply_title(); ?>"><?php bbp_topic_post_date(); ?></a>

				<?php bbp_topic_content(); ?>

				<?php do_action( 'bbp_theme_after_topic_content' ); ?>



			<div class="bbp-meta">

				<?php do_action( 'bbp_theme_before_topic_admin_links' ); ?>

				<?php bbp_topic_admin_links(); ?>

				<?php do_action( 'bbp_theme_after_topic_admin_links' ); ?>

			</div><!-- .bbp-meta -->

			</div><!-- .bbp-topic-content -->

		</div><!-- #post-<?php bbp_topic_id(); ?> -->

	</li><!-- .bbp-body -->

</ul><!-- #bbp-topic-<?php bbp_topic_id(); ?>-lead -->

<?php do_action( 'bbp_template_after_lead_topic' ); ?>
