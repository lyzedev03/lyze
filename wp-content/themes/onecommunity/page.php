<?php get_header(); ?>

	<div id="content">

		<div class="page"role="main">

			<h5><?php the_title(); ?></h5>

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>


				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<div class="text">

					<?php
					if ( has_post_thumbnail() ) { ?>
						<div class="thumbnail">
						<?php the_post_thumbnail('full'); ?>
						</div>
					<?php } else {
					// no thumbnail
					}
					?>
					<div class="entry">

						<?php the_content( __('Read more','onecommunity') ); ?>

						<?php wp_link_pages( array( 'before' => '<div class="page-link"><p>' . __( 'Pages: ', 'onecommunity' ), 'after' => '</p></div>', 'next_or_number' => 'number' ) ); ?>

					</div>
					</div>

				</div>

			<?php endwhile; endif; ?>

		</div><!-- .page -->


<?php comments_template(); ?>

	</div><!-- #content -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>