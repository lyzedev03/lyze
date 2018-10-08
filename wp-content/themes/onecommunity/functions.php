<?php

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

// Localization Support
load_theme_textdomain( 'onecommunity', get_template_directory().'/lang' );

$locale = get_locale();
$locale_file = get_template_directory()."/lang/$locale.php";
if ( is_readable($locale_file) )
    require_once($locale_file);

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * Used to set the width of images and content. Should be equal to the width the theme
 * is designed for, generally via the style.css stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 800;
}


function theme_setup() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	add_theme_support( 'title-tag' );

	add_theme_support( 'custom-logo', array(
	'height'      => 93,
	'width'       => 296,
	'flex-height' => true,
	'flex-width'  => true,
	) );


	if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'my-thumbnail', 480, 320, true );
	add_image_size( 'tile-1', 700, 700, true );
	add_image_size( 'tile-2', 400, 400, true );
	}

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

}
add_action( 'after_setup_theme', 'theme_setup' );


function theme_enqueue_styles() {

	wp_register_style( 'responsive', get_template_directory_uri() . '/css/responsive.css', array() );
	wp_register_style( 'LiveSearch', get_template_directory_uri() . '/css/search.css', array() );
 if ( get_theme_mod( 'DD_color_scheme' ) ) :
	wp_register_style( 'ColorScheme', get_template_directory_uri() . '/css/color-scheme-' . get_theme_mod( 'DD_color_scheme' ) . '.css', array() );
 endif;
	wp_register_style( 'myStyle', get_template_directory_uri() . '/myStyle.css', array() );
	wp_enqueue_style( 'main-style', get_stylesheet_uri() );
	wp_enqueue_style( 'responsive' );
	wp_enqueue_style( 'LiveSearch' );
	wp_enqueue_style( 'ColorScheme' );
	wp_enqueue_style( 'myStyle' );

}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );






$counter = 0;

function dd_theme_blog_comments( $comment, $args, $depth ) {
	global $counter; // Make counter variable global so we can use it inside this function.
	$counter++;
	$GLOBALS['comment'] = $comment;


	if ( 'pingback' == $comment->comment_type )
		return false;

	if ( 1 == $depth )
		$avatar_size = 60;
	else
		$avatar_size = 50;
	?>


	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
	<div class="comment-body" id="comment-<?php comment_ID(); ?>">

		<div class="comment-avatar-box">
			<div class="avb">
				<a href="<?php echo get_comment_author_url(); ?>" rel="nofollow">
					<?php if ( $comment->user_id ) : ?>
						<?php echo bp_core_fetch_avatar( array( 'item_id' => $comment->user_id, 'width' => $avatar_size, 'height' => $avatar_size, 'email' => $comment->comment_author_email ) ); ?>
					<?php else : ?>
						<?php echo get_avatar( $comment, $avatar_size ); ?>
					<?php endif; ?>
				</a>
			</div>
		</div>

		<div class="comment-content">
			<div class="comment-meta">
				<p>
					<?php
						/* translators: 1: comment author url, 2: comment author name, 3: comment permalink, 4: comment date/timestamp*/
						printf( __( '<a href="%1$s" rel="nofollow">%2$s</a> said on <a href="%3$s"><span class="time-since">%4$s</span></a>', 'onecommunity' ), get_comment_author_url(), get_comment_author(), get_comment_link(), get_comment_date() );
					?>
				</p>
			</div>

			<div class="comment-entry">
				<?php if ( $comment->comment_approved == '0' ) : ?>
				 	<em class="moderate"><?php _e( 'Your comment is awaiting moderation.', 'onecommunity' ); ?></em>
				<?php endif; ?>

				<?php comment_text(); ?>
			</div>

			<div class="comment-options">
					<?php if ( comments_open() ) : ?>
						<?php comment_reply_link( array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ); ?>
					<?php endif; ?>

					<?php if ( current_user_can( 'edit_comment', $comment->comment_ID ) ) : ?>
						<?php printf( '<a class="comment-edit-link" href="%1$s" title="%2$s">%3$s</a> ', get_edit_comment_link( $comment->comment_ID ), esc_attr__( 'Edit comment', 'onecommunity' ), __( 'Edit', 'onecommunity' ) ); ?>
					<?php endif; ?>

			</div>

		</div><!-- comment-content -->

<div class="comment-counter" id="comment-counter-<?php echo $counter; ?>"><a href="#comment-<?php comment_ID(); ?>"><?php echo $counter; ?></a></div>
<div class="clear"> </div>
	</div><!-- comment-body -->

<?php
}




function dd_theme_activity_secondary_avatars( $action, $activity ) {
	switch ( $activity->component ) {
		case 'groups' :
		case 'friends' :
			// Only insert avatar if one exists
			if ( $secondary_avatar = bp_get_activity_secondary_avatar() ) {
				$reverse_content = strrev( $action );
				$position        = strpos( $reverse_content, 'a<' );
				$action          = substr_replace( $action, $secondary_avatar, -$position - 2, 0 );
			}
			break;
	}

	return $action;
}
add_filter( 'bp_get_activity_action_pre_meta', 'dd_theme_activity_secondary_avatars', 10, 2 );




function dd_theme_comment_form( $default_labels ) {

	$commenter = wp_get_current_commenter();
	$req       = get_option( 'require_name_email' );
	$aria_req  = ( $req ? " aria-required='true'" : '' );
	$fields    =  array(
		'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name', 'onecommunity' ) . ( $req ? '<span class="required"> *</span>' : '' ) . '</label> ' .
		            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
		'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email', 'onecommunity' ) . ( $req ? '<span class="required"> *</span>' : '' ) . '</label> ' .
		            '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>',
		'url'    => '<p class="comment-form-url"><label for="url">' . __( 'Website', 'onecommunity' ) . '</label>' .
		            '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>',
	);

	$new_labels = array(
		'comment_field'  => '<p class="form-textarea"><textarea name="comment" id="comment" cols="60" rows="10" aria-required="true"></textarea></p>',
		'fields'         => apply_filters( 'comment_form_default_fields', $fields ),
		'logged_in_as'   => '',
		'must_log_in'    => '<p class="alert">' . sprintf( __( 'You must be <a href="%1$s">logged in</a> to post a comment.', 'onecommunity' ), wp_login_url( get_permalink() ) )	. '</p>',
		'id_submit' => 'comment-submit',
		'title_reply'    => __( 'Leave a reply', 'onecommunity' )
	);

	return apply_filters( 'dd_theme_comment_form', array_merge( $default_labels, $new_labels ) );
}
add_filter( 'comment_form_defaults', 'dd_theme_comment_form', 10 );



function dd_theme_before_comment_form() {
?>

	<div class="comment-content standard-form">
<?php
}
add_action( 'comment_form_top', 'dd_theme_before_comment_form' );


/**
 * Closes tags opened in dd_theme_before_comment_form().
 *
 * @see dd_theme_before_comment_form()
 * @see comment_form()
 * @since BuddyPress (1.5)
 */
function dd_theme_after_comment_form() {
?>

	</div><!-- .comment-content standard-form -->

<?php
}
add_action( 'comment_form', 'dd_theme_after_comment_form' );






/**
 * Adds a hidden "redirect_to" input field to the sidebar login form.
 *
 * @since BuddyPress (1.5)
 */
function dd_theme_sidebar_login_redirect_to() {
	$redirect_to = !empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '';
	$redirect_to = apply_filters( 'bp_no_access_redirect', $redirect_to ); ?>

	<input type="hidden" name="redirect_to" value="<?php echo esc_attr( $redirect_to ); ?>" />

<?php
}
add_action( 'bp_sidebar_login_form', 'dd_theme_sidebar_login_redirect_to' );



/**
 * Display navigation to next/previous pages when applicable
 *
 * @global WP_Query $wp_query
 * @param string $nav_id DOM ID for this navigation
 * @since BuddyPress (1.5)
 */
function dd_theme_content_nav( $nav_id ) {
	global $wp_query;

	if ( !empty( $wp_query->max_num_pages ) && $wp_query->max_num_pages > 1 ) : ?>

		<div id="<?php echo $nav_id; ?>" class="navigation">
			<div class="alignleft"><?php next_posts_link( __( '&larr; Previous Entries', 'onecommunity' ) ); ?></div>
			<div class="alignright"><?php previous_posts_link( __( 'Next Entries &rarr;', 'onecommunity' ) ); ?></div>
		</div><!-- #<?php echo $nav_id; ?> -->

	<?php endif;
}


/**
 * Adds the no-js class to the body tag.
 *
 * This function ensures that the <body> element will have the 'no-js' class by default. If you're
 * using JavaScript for some visual functionality in your theme, and you want to provide noscript
 * support, apply those styles to body.no-js.
 *
 * The no-js class is removed by the JavaScript created in dd_theme_remove_nojs_body_class().
 *
 * @package BuddyPress
 * @since BuddyPress (1.5).1
 * @see dd_theme_remove_nojs_body_class()
 */
function dd_theme_add_nojs_body_class( $classes ) {
	$classes[] = 'no-js';
	return array_unique( $classes );
}
add_filter( 'bp_get_the_body_class', 'dd_theme_add_nojs_body_class' );

/**
 * Dynamically removes the no-js class from the <body> element.
 *
 * By default, the no-js class is added to the body (see dd_theme_add_no_js_body_class()). The
 * JavaScript in this function is loaded into the <body> element immediately after the <body> tag
 * (note that it's hooked to bp_before_header), and uses JavaScript to switch the 'no-js' body class
 * to 'js'. If your theme has styles that should only apply for JavaScript-enabled users, apply them
 * to body.js.
 *
 * This technique is borrowed from WordPress, wp-admin/admin-header.php.
 *
 * @package BuddyPress
 * @since BuddyPress (1.5).1
 * @see dd_theme_add_nojs_body_class()
 */
function dd_theme_remove_nojs_body_class() {
?><script type="text/javascript">//<![CDATA[
(function(){var c=document.body.className;c=c.replace(/no-js/,'js');document.body.className=c;})();
//]]></script>
<?php
}
add_action( 'bp_before_header', 'dd_theme_remove_nojs_body_class' );


function load_fonts() {
    wp_register_style('OpenSans', '//fonts.googleapis.com/css?family=Open+Sans:400,700,400italic');
    wp_enqueue_style( 'OpenSans');
    wp_register_style('Quicksand', '//fonts.googleapis.com/css?family=Quicksand:300,700');
    wp_enqueue_style( 'Quicksand');
}
add_action('wp_print_styles', 'load_fonts');


function add_scripts(){
  if (!is_admin()) {
   wp_enqueue_script('jquery');
   wp_enqueue_script('jquery-masonry');
   wp_enqueue_script('jQFunctions',get_template_directory_uri().'/js/jQFunctions.js',false,'1.0',false);
  }
}
add_action('init','add_scripts');



if (function_exists('register_sidebar')) {


	register_sidebar(array(
		'name' => 'Sidebar - Frontpage',
		'id'   => 'sidebar-frontpage',
		'description'   => 'This is a widgetized area visible on the frontpage.',
		'before_widget' => '<div class="sidebar-box %2$s widget"  id="%1$s">',
		'after_widget'  => '</div><!--sidebar-box-child ends--></div><!--sidebar-box ends--><div class="clear"></div>',
		'before_title'  => '<div class="sidebar-title">',
		'after_title'   => '</div><div class="sidebar-box-child">'
	));


	register_sidebar(array(
		'name' => 'Frontpage Slider (Logged Out)',
		'id'   => 'frontpage-slider-logged-out',
		'description'   => 'This is a widgetized area for slider.',
		'before_widget' => '<div class="slider-box %2$s widget" id="%1$s">',
		'after_widget'  => '</div><!--slider-box ends-->',
		'before_title'  => '',
		'after_title'   => ''
	));


	register_sidebar(array(
		'name' => 'Frontpage Slider (Logged In)',
		'id'   => 'frontpage-slider-logged-in',
		'description'   => 'This is a widgetized area for slider.',
		'before_widget' => '<div class="slider-box %2$s widget" id="%1$s">',
		'after_widget'  => '</div><!--slider-box ends-->',
		'before_title'  => '',
		'after_title'   => ''
	));


	register_sidebar(array(
		'name' => 'Sidebar - Blog',
		'id'   => 'sidebar-blog',
		'description'   => 'This is a widgetized area visible on the blog pages.',
		'before_widget' => '<div class="sidebar-box %2$s widget"  id="%1$s">',
		'after_widget'  => '</div><!--sidebar-box-child ends--></div><!--sidebar-box ends--><div class="clear"></div>',
		'before_title'  => '<div class="sidebar-title">',
		'after_title'   => '</div><div class="sidebar-box-child">'
	));

	register_sidebar(array(
		'name' => 'Sidebar - Single Post',
		'id'   => 'sidebar-single',
		'description'   => 'This is a widgetized area visible on the single post.',
		'before_widget' => '<div class="sidebar-box %2$s widget"  id="%1$s">',
		'after_widget'  => '</div><!--sidebar-box-child ends--></div><!--sidebar-box ends--><div class="clear"></div>',
		'before_title'  => '<div class="sidebar-title">',
		'after_title'   => '</div><div class="sidebar-box-child">'
	));


	register_sidebar(array(
		'name' => 'Sidebar - Contact',
		'id'   => 'sidebar-contact',
		'description'   => 'This is a widgetized area visible on the contact form page.',
		'before_widget' => '<div class="sidebar-box %2$s"  id="%1$s">',
		'after_widget'  => '</div><!--sidebar-box-child ends--></div><!--sidebar-box ends--><div class="clear"></div>',
		'before_title'  => '<div class="sidebar-title">',
		'after_title'   => '</div><div class="sidebar-box-child">'
	));


	register_sidebar(array(
		'name' => 'Sidebar - Pages',
		'id'   => 'sidebar-pages',
		'description'   => 'This is a widgetized area visible on the pages.',
		'before_widget' => '<div class="sidebar-box %2$s widget"  id="%1$s">',
		'after_widget'  => '</div><!--sidebar-box-child ends--></div><!--sidebar-box ends--><div class="clear"></div>',
		'before_title'  => '<div class="sidebar-title">',
		'after_title'   => '</div><div class="sidebar-box-child">'
	));


}




/////////////////////////////////////////////////////////////////////////////////
// BLOG CATEGORIES
/////////////////////////////////////////////////////////////////////////////////
class DDBlogCategories extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'DDBlogCategories',
'Blog Categories Widget',
array( 'description' => 'Widget displays blog categories in 2 columns.', )
);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );

// before and after widget arguments are defined by themes
echo $args['before_widget'];
if ( ! empty( $title ) )
echo $args['before_title'] . $title . $args['after_title'];

// This is where you run the code and display the output

$cats = explode("<br />",wp_list_categories('title_li=&echo=0&depth=1&style=none'));
$cat_n = count($cats) - 1;
$cat_left = '';
$cat_right = '';
for ($i=0;$i<$cat_n;$i++):
if ($i<$cat_n/2):
$cat_left = $cat_left.'<li>'.$cats[$i].'</li>';
elseif ($i>=$cat_n/2):
$cat_right = $cat_right.'<li>'.$cats[$i].'</li>';
endif;
endfor;
?>


	<ul id="blog-categories-left">
	<?php echo $cat_left;?>
	</ul>
	<ul id="blog-categories-right">
	<?php echo $cat_right;?>
	</ul>

<?php
echo $args['after_widget'];

}

// Widget Backend
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = 'Blog Categories';
}

// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>

<?php
}



// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
return $instance;

}
} // Class DDBlogCategories ends here

// Register and load the widget
function wp_load_DDBlogCategories() {
	register_widget( 'DDBlogCategories' );
}
add_action( 'widgets_init', 'wp_load_DDBlogCategories' );
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////



/////////////////////////////////////////////////////////////////////////////////
// WP LOGIN
/////////////////////////////////////////////////////////////////////////////////
class My_Login extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'My_Login',
'Login Widget',
array( 'description' => 'Widget displays a login form.', )
);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {

// before and after widget arguments are defined by themes
echo $args['before_widget'];


// This is where you run the code and display the output
?>

<div class="sidebar-box-child">	

<?php if ( !is_user_logged_in() ) : ?>
<div id="shortcode-login">

	<div id="shortcode-login-title"><?php _e('Log In', 'onecommunity'); ?></div>
	<div id="shortcode-login-desc"><?php _e('Login to your account and check new messages.', 'onecommunity'); ?></div>

		<?php do_action( 'bp_before_sidebar_login_form' ) ?>

		<form name="login-form" id="shortcode-login-form" action="<?php echo site_url( 'wp-login.php', 'login_post' ) ?>" method="post">
			<label><?php _e( 'Username', 'onecommunity' ) ?>:<br />
			<input type="text" name="log" id="shortcode-user-login" class="input" value="<?php if ( isset( $user_login) ) echo esc_attr(stripslashes($user_login)); ?>" tabindex="97" /></label>

			<label><?php _e( 'Password', 'onecommunity' ) ?>:<br />
			<input type="password" name="pwd" id="shortcode-user-pass" class="input" value="" tabindex="98" /></label>

			<div class="forgetmenot">
			<div><label><input name="rememberme" type="checkbox" id="shortcode-rememberme" value="forever" tabindex="99" /> <?php _e( 'Remember Me', 'onecommunity' ) ?></label></div>
			<a href="<?php echo home_url(); ?>/<?php _e( 'recovery', 'onecommunity' ); ?>" class="shortcode-password-recovery"><?php _e( 'Password Recovery', 'onecommunity' ); ?></a>
			</div>

			<?php do_action( 'bp_sidebar_login_form' ) ?>
			<input type="submit" name="wp-submit" id="shortcode-login-submit" value="<?php _e( 'Log In', 'onecommunity' ); ?>" tabindex="100" />
		</form>

		<?php do_action( 'bp_after_sidebar_login_form' ) ?>

</div><!-- shortcode-login -->

<?php endif; ?>

<?php
echo $args['after_widget'];

}

// Widget Backend
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = 'Log In';
}

// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>

<?php
}



// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
return $instance;

}
} // Class My_Login ends here

// Register and load the widget
function wp_load_My_Login() {
	register_widget( 'My_Login' );
}
add_action( 'widgets_init', 'wp_load_My_Login' );
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////


/////////////////////////////////////////////////////////////////////////////////
// RECENT BLOG POST
/////////////////////////////////////////////////////////////////////////////////
class DDRecentBlogPosts extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'DDRecentBlogPosts',
'Recent Blog Posts',
array( 'description' => 'Widget displays recent blog posts with thumbnails', )
);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {

$title = apply_filters( 'widget_title', $instance['title'] );

if ( isset( $instance[ 'number_of_blog_posts' ] ) ) {
$number_of_blog_posts = apply_filters( 'number_of_blog_posts', $instance['number_of_blog_posts'] );
}
else {
$number_of_blog_posts = '3';
}



// before and after widget arguments are defined by themes
echo $args['before_widget'];
if ( ! empty( $title ) )
echo $args['before_title'] . $title . $args['after_title'];

// This is where you run the code and display the output

$wp_query = '';
$paged = '';
$temp = $wp_query;
$wp_query= null;
$wp_query = new WP_Query();
$wp_query->query('posts_per_page=' . $number_of_blog_posts . ''.'&paged='.$paged);
while ($wp_query->have_posts()) : $wp_query->the_post();
?>

	<div class="recent-post">
         <div class="recent-post-thumb"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a></div>
       	 <div class="recent-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		 <div class="recent-post-bottom"><div class="recent-post-time"><?php the_time('F j, Y') ?></div></div></div>
	</div>

<?php endwhile; // end of loop

echo $args['after_widget'];

}

// Widget Backend
public function form( $instance ) {

if ( isset( $instance[ 'title' ] ) ) {
	$title = $instance[ 'title' ];
}
else {
	$title = 'Recent posts';
}

if ( isset( $instance[ 'number_of_blog_posts' ] ) ) {
	$number_of_blog_posts = $instance[ 'number_of_blog_posts' ];
}
else {
	$number_of_blog_posts = '3';
}

// Widget admin form
?>

<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>

<p>
<label for="<?php echo $this->get_field_id( 'number_of_blog_posts' ); ?>">Number of posts (1, 2, 3, 4 ...)</label>
<input class="widefat" id="<?php echo $this->get_field_id( 'number_of_blog_posts' ); ?>" name="<?php echo $this->get_field_name( 'number_of_blog_posts' ); ?>" type="text" value="<?php echo esc_attr( $number_of_blog_posts ); ?>" />
</p>
<?php
}



// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
$instance['number_of_blog_posts'] = ( ! empty( $new_instance['number_of_blog_posts'] ) ) ? strip_tags( $new_instance['number_of_blog_posts'] ) : '';
return $instance;

}
} // Class DDRecentBlogPosts ends here

// Register and load the widget
function wp_load_DDRecentBlogPosts() {
	register_widget( 'DDRecentBlogPosts' );
}
add_action( 'widgets_init', 'wp_load_DDRecentBlogPosts' );
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////



/////////////////////////////////////////////////////////////////////////////////
// RECENT FORUMS TOPICS
/////////////////////////////////////////////////////////////////////////////////
class DDRecentTopics extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'DDRecentTopics',
'Recent Forum Topics Widget',
array( 'description' => 'Widget displays recent forum topics', )
);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );
$number_of_topics = apply_filters( 'number_of_topics', $instance['number_of_topics'] );

// before and after widget arguments are defined by themes
echo $args['before_widget'];
if ( ! empty( $title ) )
echo $args['before_title'] . $title . $args['after_title'];

// This is where you run the code and display the output

	if ( bbp_has_topics( array( 'author' => 0, 'show_stickies' => false, 'order' => 'DESC', 'post_parent' => 'any', 'paged' => 1, 'posts_per_page' => $number_of_topics ) ) ) :
		bbp_get_template_part( 'loop', 'mytopics' );
	else :
		bbp_get_template_part( 'feedback', 'no-topics' );
	endif;

echo $args['after_widget'];

}

// Widget Backend
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
$number_of_topics = $instance[ 'number_of_topics' ];
}
else {
$title = 'On the Forums';
$number_of_topics = '4';
}

// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>

<p>
<label for="<?php echo $this->get_field_id( 'number_of_topics' ); ?>">Number of topics (1, 2, 3, 4 ...)</label>
<input class="widefat" id="<?php echo $this->get_field_id( 'number_of_topics' ); ?>" name="<?php echo $this->get_field_name( 'number_of_topics' ); ?>" type="text" value="<?php echo esc_attr( $number_of_topics ); ?>" />
</p>
<?php
}



// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
$instance['number_of_topics'] = ( ! empty( $new_instance['number_of_topics'] ) ) ? strip_tags( $new_instance['number_of_topics'] ) : '';
return $instance;

}
} // Class DDRecentTopics ends here

// Register and load the widget
function wp_load_DDRecentTopics() {
	register_widget( 'DDRecentTopics' );
}
add_action( 'widgets_init', 'wp_load_DDRecentTopics' );
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////







add_action( 'init', 'register_menus' );
function register_menus() {
    register_nav_menus(
        array(
                'primary-menu' => 'Header'
        )
        );

	register_nav_menus(
	    array(
	        'mobile-menu' => 'Mobile Menu'
	    )
	);
}





function avatar_thumbnail_size(){
 define ( 'BP_AVATAR_THUMB_WIDTH', 100 );
 define ( 'BP_AVATAR_THUMB_HEIGHT', 100 );
 define( 'BP_AVATAR_FULL_WIDTH', '400');
 define( 'BP_AVATAR_FULL_HEIGHT', '400' );
 define ( 'BP_AVATAR_ORIGINAL_MAX_FILESIZE', 6000000 );
}
add_action('bp_init', 'avatar_thumbnail_size', 2);



function rtmedia_main_template_include($template, $new_rt_template){
global $wp_query;
$wp_query->is_page = true;
return bp_get_template_part('rtmedia');
}
add_filter('rtmedia_main_template_include', 'rtmedia_main_template_include', 20, 2);


function bp_excerpt_group_description( $description ) {
$length = 80;
$description = substr($description,0,$length);
return strip_tags($description);
}
add_filter( 'bp_get_group_description_excerpt', 'bp_excerpt_group_description');



function DD_login_enqueue_style() {
	wp_enqueue_style( 'WP-Login', get_template_directory_uri() . '/css/wp-login.css', false );
}
add_action( 'login_enqueue_scripts', 'DD_login_enqueue_style', 10 );



// WOOCOMMERCE
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
add_action('woocommerce_before_main_content', create_function('', 'echo "<div id=\"content\">";'), 10);
add_action('woocommerce_after_main_content', create_function('', 'echo "</div>";'), 10);
remove_action( 'woocommerce_before_main_content',
    'woocommerce_breadcrumb', 20, 0);

add_theme_support( 'woocommerce' );

add_filter( 'bp_get_the_topic_post_content', 'do_shortcode' );
add_filter( 'bp_get_group_description', 'do_shortcode' );



function DD_the_post_thumbnail_caption() {
  global $post;

  $thumbnail_id = get_post_thumbnail_id($post->ID);
  $thumbnail_image = get_posts(array('p' => $thumbnail_id, 'post_type' => 'attachment'));

  if ($thumbnail_image && isset($thumbnail_image[0])) {
    echo '<span>'.$thumbnail_image[0]->post_excerpt.'</span>';
  }
}


function bbp_enable_visual_editor( $args = array() ) {
    $args['tinymce'] = true;
    return $args;
}
add_filter( 'bbp_after_get_the_content_parse_args', 'bbp_enable_visual_editor' );



add_action( 'customize_register' , 'DD_theme_options' );
function DD_theme_options( $wp_customize ) {

//////////////////////////////////////////////////////////////////

$wp_customize->add_setting( 'DD_logo_topspace' , array(
    'default' => '40px',
) );

$wp_customize->add_control( 'DD_logo_topspace', array(
    'type'     => 'text',
    'priority' => 10,
    'section'  => 'title_tagline',
    'settings' => 'DD_logo_topspace',
    'label'    => 'Top spacing of logo',
) );


//////////////////////////////////////////////////////////////////

$wp_customize->add_section( 'DD_registration_section' , array(
    'title'       => 'Registration',
    'priority'    => 31,
) );

$wp_customize->add_setting( 'DD_registration_disable' , array(
    'sanitize_callback' => 'esc_url_raw',
) );

$wp_customize->add_control( 'DD_registration_disable', array(
    'type'     => 'checkbox',
    'priority' => 1,
    'section'  => 'DD_registration_section',
    'settings'  => 'DD_registration_disable',
    'label'    => 'Disable `Complete Sign Up` button.',
) );


$wp_customize->add_setting( 'DD_registration_disable_title' , array(
    'default' => 'Registration Disabled',
    'sanitize_callback' => 'esc_attr',
) );

$wp_customize->add_control( 'DD_registration_disable_title', array(
    'type'     => 'text',
    'priority' => 2,
    'section'  => 'DD_registration_section',
    'settings'  => 'DD_registration_disable_title',
    'label'    => 'Change `Registration Disabled` button',
) );

//////////////////////////////////////////////////////////////////

$wp_customize->add_section( 'DD_color_scheme_section' , array(
    'title'       => 'Color scheme',
    'priority'    => 31,
) );

$wp_customize->add_setting( 'DD_color_scheme' , array(
    'sanitize_callback' => 'esc_attr',
) );

$wp_customize->add_control( 'DD_color_scheme',
array(
		'label'    => 'Change color scheme.',
		'section'  => 'DD_color_scheme_section',
	    'settings'  => 'DD_color_scheme',
		'type'     => 'radio',
		'choices'  => array(
			'0'  => 'None',
			'1' => 'Red',
			'2' => 'Slate Gray',
			'3' => 'Pink',
			'4' => 'Light Green',
			'5' => 'Blue - Air Force',
			'6' => 'Medium Spring Green',
			'7' => 'Blue',
			'8' => 'Light Blue',
		),
) );
//////////////////////////////////////////////////////////////////


$wp_customize->add_section( 'DD_tile_section' , array(
    'title'       => 'Tile menu',
    'priority'    => 30,
    'description' => 'Customize tile menu',
) );


$wp_customize->add_setting( 'DD_tile_groups_title' , array(
    'default' => 'GROUPS',
    'sanitize_callback' => 'esc_attr',
) );

$wp_customize->add_control( 'DD_tile_groups_title', array(
    'type'     => 'text',
    'priority' => 10,
    'section'  => 'DD_tile_section',
    'settings'  => 'DD_tile_groups_title',
    'label'    => '`Groups` title',
) );


$wp_customize->add_setting( 'DD_tile_groups_link' , array(
    'default' => 'groups',
    'sanitize_callback' => 'esc_attr',
) );

$wp_customize->add_control( 'DD_tile_groups_link', array(
    'type'     => 'text',
    'priority' => 10,
    'section'  => 'DD_tile_section',
    'settings'  => 'DD_tile_groups_link',
    'label'    => '`Groups` link',
) );

$wp_customize->add_setting( 'DD_tile_groups_icon' , array(
    'sanitize_callback' => 'esc_url_raw',
) );

$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'DD_tile_groups_icon', array(
    'label'    => 'Groups Tile Icon (.png)',
    'priority' => 10,
    'section'  => 'DD_tile_section',
    'settings'  => 'DD_tile_groups_icon',
    'settings' => 'DD_tile_groups_icon',
) ) );



$wp_customize->add_setting( 'DD_tile_forum_title' , array(
    'default' => 'FORUM',
    'sanitize_callback' => 'esc_attr',
) );

$wp_customize->add_control( 'DD_tile_forum_title', array(
    'type'     => 'text',
    'priority' => 11,
    'section'  => 'DD_tile_section',
    'settings'  => 'DD_tile_forum_title',
    'label'    => '`Forum` title',
) );

$wp_customize->add_setting( 'DD_tile_forum_link' , array(
    'default' => 'forum',
    'sanitize_callback' => 'esc_attr',
) );

$wp_customize->add_control( 'DD_tile_forum_link', array(
    'type'     => 'text',
    'priority' => 11,
    'section'  => 'DD_tile_section',
    'settings'  => 'DD_tile_forum_link',
    'label'    => '`Forum` link',
) );

$wp_customize->add_setting( 'DD_tile_forum_icon' , array(
    'sanitize_callback' => 'esc_url_raw',
) );

$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'DD_tile_forum_icon', array(
    'label'    => 'Forum Tile Icon (.png)',
    'priority' => 11,
    'section'  => 'DD_tile_section',
    'settings' => 'DD_tile_forum_icon',
) ) );


$wp_customize->add_setting( 'DD_tile_blog_title' , array(
    'default' => 'BLOG',
    'sanitize_callback' => 'esc_attr',
) );

$wp_customize->add_control( 'DD_tile_blog_title', array(
    'type'     => 'text',
    'priority' => 12,
    'section'  => 'DD_tile_section',
    'settings'  => 'DD_tile_blog_title',
    'label'    => '`Blog` title',
) );

$wp_customize->add_setting( 'DD_tile_blog_link' , array(
    'default' => 'blog',
    'sanitize_callback' => 'esc_attr',
) );

$wp_customize->add_control( 'DD_tile_blog_link', array(
    'type'     => 'text',
    'priority' => 12,
    'section'  => 'DD_tile_section',
    'settings'  => 'DD_tile_blog_link',
    'label'    => '`Blog` link',
) );

$wp_customize->add_setting( 'DD_tile_blog_icon' , array(
    'sanitize_callback' => 'esc_url_raw',
) );

$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'DD_tile_blog_icon', array(
    'label'    => 'Blog Tile Icon (.png)',
    'priority' => 12,
    'section'  => 'DD_tile_section',
    'settings' => 'DD_tile_blog_icon',
) ) );




$wp_customize->add_setting( 'DD_tile_members_title' , array(
    'default' => 'MEMBERS',
    'sanitize_callback' => 'esc_attr',
) );

$wp_customize->add_control( 'DD_tile_members_title', array(
    'type'     => 'text',
    'priority' => 13,
    'section'  => 'DD_tile_section',
    'settings'  => 'DD_tile_members_title',
    'label'    => '`Members` title',
) );

$wp_customize->add_setting( 'DD_tile_members_link' , array(
    'default' => 'members',
    'sanitize_callback' => 'esc_attr',
) );

$wp_customize->add_control( 'DD_tile_members_link', array(
    'type'     => 'text',
    'priority' => 13,
    'section'  => 'DD_tile_section',
    'settings'  => 'DD_tile_members_link',
    'label'    => '`Members` link',
) );

$wp_customize->add_setting( 'DD_tile_members_icon' , array(
    'sanitize_callback' => 'esc_url_raw',
) );

$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'DD_tile_members_icon', array(
    'label'    => 'Members Tile Icon (.png)',
    'priority' => 13,
    'section'  => 'DD_tile_section',
    'settings' => 'DD_tile_members_icon',
) ) );



$wp_customize->add_setting( 'DD_tile_activity_title' , array(
    'default' => 'ACTIVITY',
    'sanitize_callback' => 'esc_attr',
) );

$wp_customize->add_control( 'DD_tile_activity_title', array(
    'type'     => 'text',
    'priority' => 14,
    'section'  => 'DD_tile_section',
    'settings'  => 'DD_tile_activity_title',
    'label'    => '`Activity` title',
) );

$wp_customize->add_setting( 'DD_tile_activity_link' , array(
    'default' => 'activity',
    'sanitize_callback' => 'esc_attr',
) );

$wp_customize->add_control( 'DD_tile_activity_link', array(
    'type'     => 'text',
    'priority' => 14,
    'section'  => 'DD_tile_section',
    'settings'  => 'DD_tile_activity_link',
    'label'    => '`Activity` link',
) );

$wp_customize->add_setting( 'DD_tile_activity_icon' , array(
    'sanitize_callback' => 'esc_url_raw',
) );

$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'DD_tile_activity_icon', array(
    'label'    => 'Activity Tile Icon (.png)',
    'priority' => 14,
    'section'  => 'DD_tile_section',
    'settings' => 'DD_tile_activity_icon',
) ) );



$wp_customize->add_setting( 'DD_tile_about-us_title' , array(
    'default' => 'ABOUT US',
    'sanitize_callback' => 'esc_attr',
) );

$wp_customize->add_control( 'DD_tile_about-us_title', array(
    'type'     => 'text',
    'priority' => 15,
    'section'  => 'DD_tile_section',
    'settings'  => 'DD_tile_about-us_title',
    'label'    => '`About Us` title',
) );

$wp_customize->add_setting( 'DD_tile_about-us_link' , array(
    'default' => 'about-us',
    'sanitize_callback' => 'esc_attr',
) );

$wp_customize->add_control( 'DD_tile_about-us_link', array(
    'type'     => 'text',
    'priority' => 15,
    'section'  => 'DD_tile_section',
    'settings'  => 'DD_tile_about-us_link',
    'label'    => '`About Us` link',
) );

$wp_customize->add_setting( 'DD_tile_about-us_icon' , array(
    'sanitize_callback' => 'esc_url_raw',
) );

$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'DD_tile_about-us_icon', array(
    'label'    => 'About Us Tile Icon (.png)',
    'priority' => 15,
    'section'  => 'DD_tile_section',
    'settings'  => 'DD_tile_about-us_icon',
) ) );

//////////////////////////////////////////////////////////////////////////////////////////////////////
$wp_customize->add_section( 'DD_footer' , array(
    'title'       => 'Footer',
    'priority'    => 31,
) );

$wp_customize->add_setting( 'DD_copyright' , array(
    'default' => 'All rights reserved by OneCommunity',
    'sanitize_callback' => 'esc_attr',
) );

$wp_customize->add_control( 'DD_copyright', array(
    'type'     => 'text',
    'priority' => 1,
    'section'  => 'DD_footer',
    'settings'  => 'DD_copyright',
    'label'    => 'Change `All rights reserved by OneCommunity`.',
) );


}
//////////////////////////////////////////////////////////////////////////////////////////////////////



/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see //tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1 for parent theme Xphoria for publication on ThemeForest
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    //opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       //github.com/TGMPA/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 *
 * Depending on your implementation, you may want to change the include call:
 *
 * Parent Theme:
 * require_once get_template_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Child Theme:
 * require_once get_stylesheet_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Plugin:
 * require_once dirname( __FILE__ ) . '/path/to/class-tgm-plugin-activation.php';
 */
require_once get_template_directory() . '/classTgmPluginActivation.php';

add_action( 'tgmpa_register', 'onecommunity_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variables passed to the `tgmpa()` function should be:
 * - an array of plugin arrays;
 * - optionally a configuration array.
 * If you are not changing anything in the configuration array, you can remove the array and remove the
 * variable from the function call: `tgmpa( $plugins );`.
 * In that case, the TGMPA default settings will be used.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function onecommunity_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */

	$plugins = array(

		// This is an example of how to include a plugin bundled with a theme.


		array(
			'name'               => 'OneCommunity Shortcodes', // The plugin name.
			'slug'               => 'onecommunity-shortcodes', // The plugin slug (typically the folder name).
			'source'   	     => get_stylesheet_directory() . '/plugins/onecommunity-shortcodes.zip', // The plugin source
			'required'           => true, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '1.1.2', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		),



		array(
			'name'               => 'Revolution Slider', // The plugin name.
			'slug'               => 'revslider', // The plugin slug (typically the folder name).
			'source'             => get_template_directory() . '/plugins/revslider.zip', // The plugin source.
			'required'           => false, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '5.4.8', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		),


		array(
			'name'               => 'WPBakery Page Builder', // The plugin name.
			'slug'               => 'js_composer', // The plugin slug (typically the folder name).
			'source'   	     => get_stylesheet_directory() . '/plugins/js_composer.zip', // The plugin source
			'required'           => true, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '5.5.4', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		),


		array(
			'name'               => 'Ajax Search Pro', // The plugin name.
			'slug'               => 'ajax-search-pro', // The plugin slug (typically the folder name).
			'source'   	     => get_stylesheet_directory() . '/plugins/ajax-search-pro.zip', // The plugin source
			'required'           => false, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '4.13.4', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		),


	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'onecommunity',             // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.

		/*
		'strings'      => array(
			'page_title'                      => __( 'Install Required Plugins', 'onecommunity' ),
			'menu_title'                      => __( 'Install Plugins', 'onecommunity' ),
			/* translators: %s: plugin name. * /
			'installing'                      => __( 'Installing Plugin: %s', 'onecommunity' ),
			/* translators: %s: plugin name. * /
			'updating'                        => __( 'Updating Plugin: %s', 'onecommunity' ),
			'oops'                            => __( 'Something went wrong with the plugin API.', 'onecommunity' ),
			'notice_can_install_required'     => _n_noop(
				/* translators: 1: plugin name(s). * /
				'This theme requires the following plugin: %1$s.',
				'This theme requires the following plugins: %1$s.',
				'onecommunity'
			),
			'notice_can_install_recommended'  => _n_noop(
				/* translators: 1: plugin name(s). * /
				'This theme recommends the following plugin: %1$s.',
				'This theme recommends the following plugins: %1$s.',
				'onecommunity'
			),
			'notice_ask_to_update'            => _n_noop(
				/* translators: 1: plugin name(s). * /
				'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
				'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
				'onecommunity'
			),
			'notice_ask_to_update_maybe'      => _n_noop(
				/* translators: 1: plugin name(s). * /
				'There is an update available for: %1$s.',
				'There are updates available for the following plugins: %1$s.',
				'onecommunity'
			),
			'notice_can_activate_required'    => _n_noop(
				/* translators: 1: plugin name(s). * /
				'The following required plugin is currently inactive: %1$s.',
				'The following required plugins are currently inactive: %1$s.',
				'onecommunity'
			),
			'notice_can_activate_recommended' => _n_noop(
				/* translators: 1: plugin name(s). * /
				'The following recommended plugin is currently inactive: %1$s.',
				'The following recommended plugins are currently inactive: %1$s.',
				'onecommunity'
			),
			'install_link'                    => _n_noop(
				'Begin installing plugin',
				'Begin installing plugins',
				'onecommunity'
			),
			'update_link' 					  => _n_noop(
				'Begin updating plugin',
				'Begin updating plugins',
				'onecommunity'
			),
			'activate_link'                   => _n_noop(
				'Begin activating plugin',
				'Begin activating plugins',
				'onecommunity'
			),
			'return'                          => __( 'Return to Required Plugins Installer', 'onecommunity' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'onecommunity' ),
			'activated_successfully'          => __( 'The following plugin was activated successfully:', 'onecommunity' ),
			/* translators: 1: plugin name. * /
			'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'onecommunity' ),
			/* translators: 1: plugin name. * /
			'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'onecommunity' ),
			/* translators: 1: dashboard link. * /
			'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'onecommunity' ),
			'dismiss'                         => __( 'Dismiss this notice', 'onecommunity' ),
			'notice_cannot_install_activate'  => __( 'There are one or more required or recommended plugins to install, update or activate.', 'onecommunity' ),
			'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'onecommunity' ),

			'nag_type'                        => '', // Determines admin notice type - can only be one of the typical WP notice classes, such as 'updated', 'update-nag', 'notice-warning', 'notice-info' or 'error'. Some of which may not work as expected in older WP versions.
		),
		*/
	);

	tgmpa( $plugins, $config );
}

function vc_disable_online_update() {
vc_set_as_theme();
}


add_filter('protected_title_format', 'ntwb_remove_protected_title');
function ntwb_remove_protected_title($title) {
	return '%s';
}
add_filter('private_title_format', 'ntwb_remove_private_title');
function ntwb_remove_private_title($title) {
	return '%s';
}


add_filter('body_class','my_class_names');
function my_class_names($classes) {
    if (! ( is_user_logged_in() ) ) {
        $classes[] = 'logged-out';
    }
    return $classes;
}

?>