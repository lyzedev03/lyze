<?php do_action( 'bp_before_groups_loop' ); ?>
<?php $nonce = wp_create_nonce("onecommunity_bp_groups_listing"); ?>
<div class="shortcode-bp-groups-tabs-container col-6">
<div class="object-nav-container">
<div id="object-nav">
            <ul class="tabs-nav">
                <li class="nav-one current" data-tab="popular" data-tab-per-page="12" data-tab-page="1" data-nonce="<?php echo $nonce; ?>"><?php _e('Popular', 'onecommunity'); ?></li>
                <li class="nav-two" data-tab="active" data-tab-per-page="12" data-tab-page="1" data-nonce="<?php echo $nonce; ?>"><?php _e('Active', 'onecommunity'); ?></li>
                <li class="nav-three" data-tab="alphabetical" data-tab-per-page="12" data-tab-page="1" data-nonce="<?php echo $nonce; ?>"><?php _e('Alphabetical', 'onecommunity'); ?></li>
                <li class="nav-four" data-tab="newest" data-tab-per-page="12" data-tab-page="1" data-nonce="<?php echo $nonce; ?>"><?php _e('Newest', 'onecommunity'); ?></li>
            </ul>
</div>
</div>

    <?php if ( is_user_logged_in() && bp_user_can_create_groups() ) : ?><a class="button" id="create-group-button" href="<?php echo trailingslashit( bp_get_root_domain() . '/' . bp_get_groups_root_slug() . '/create' ); ?>"><?php _e( 'Create a Group', 'buddypress' ); ?></a><div class="clear"></div><?php endif; ?>

<div class="list-wrap">
 

<?php if ( bp_has_groups( 'type=popular&max=false&per_page=12' ) ) : ?>
 
<ul>
     <?php while ( bp_groups() ) : bp_the_group(); ?>
<li <?php bp_group_class(); ?>>
       <div class="group-box">
    <div class="group-box-image-container">
        <a class="group-box-image" href="<?php bp_group_permalink() ?>"><?php bp_group_avatar( 'type=full' ) ?></a>
    </div>
    <div class="group-box-bottom">
    <div class="group-box-title"><a href="<?php bp_group_permalink() ?>"><?php $grouptitle = bp_get_group_name(); $getlength = strlen($grouptitle); $thelength = 20; echo mb_substr($grouptitle, 0, $thelength, 'UTF-8'); if ($getlength > $thelength) echo "..."; ?></a></div>
    <div class="group-box-details"><?php _e('Active', 'onecommunity'); ?> <span class="activity" data-livestamp="<?php bp_core_iso8601_date( bp_get_group_last_active( 0, array( 'relative' => false ) ) ); ?>"><?php printf( __( 'active %s', 'buddypress' ), bp_get_group_last_active() ); ?></span>
    <span class="group-box-details-members"><?php bp_group_member_count(); ?></span></div>
    </div>
        </div><!--group-box ends-->
</li>
      <?php endwhile; ?>
</ul>

<?php do_action( 'bp_after_groups_loop' ) ?>

<div class="clear"></div>
<div class="load-more-groups" data-tab="popular" data-tab-per-page="12" data-tab-page="1" data-nonce="<?php echo $nonce; ?>"><span><?php _e('Load More', 'onecommunity'); ?></span></div>

 
<?php else: ?>
 <ul id="popular">
    <div id="message" class="info" style="width:50%">
        <p><?php _e( 'There were no groups found.', 'buddypress' ) ?></p>
    </div><br />
</ul>
<?php endif; ?>

 
</div> <!-- List Wrap -->
</div><!-- shortcode-bp-groups-tabs-container -->
 
 
<?php do_action( 'bp_after_groups_loop' ); ?>