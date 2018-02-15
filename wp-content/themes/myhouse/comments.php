<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains comments and the comment form.
/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() )
    return;
?>

<div class="comment-container">
	<div class="row">
		<div class="col-sm-12">
			<!-- ============== COMMENTS ============= -->
			<ul class="comments clearfix">
				<?php wp_list_comments('callback=myhouse_theme_comment'); ?>
			</ul><!--end comments -->
			<?php
			// Are there comments to navigate through?
			if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
				?>
				<footer class="navigation comment-navigation" role="navigation">
					<div class="previous"><?php previous_comments_link( esc_html_e( 'Older Comments', 'myhouse' ) ); ?></div>
					<div class="next right"><?php next_comments_link( esc_html_e( 'Newer Comments', 'myhouse' ) ); ?></div>
				</footer><!-- .comment-navigation -->
			<?php endif; // Check for comment navigation ?>

			<?php if ( ! comments_open() && get_comments_number() ) : ?>
				<p class="no-comments"><?php esc_html_e( 'Comments are closed.' , 'myhouse' ); ?></p>
			<?php endif; ?>
		</div><!--end col-sm-12 -->
	</div><!--end row -->	
</div><!--end comment-container -->

<?php
$aria_req = ( $req ? " aria-required='true'" : '' );
$comment_args = array(
	'title_reply'=> esc_html__('Leave a Reply','myhouse'),
	'fields' => apply_filters( 'comment_form_default_fields', 
	array(
		'author' => '<div class="row"><div class="col-sm-6"><input type="text" name="author" placeholder="'.esc_html__('Your full name *', 'myhouse').'" id="name" value="' . esc_attr( $commenter['comment_author'] ) . '" ' . esc_attr($aria_req) . ' /></div></div>',
		'email' => '<div class="col-sm-6"><input id="mail" name="email"   placeholder="'.esc_html__('Your e-mail address *', 'myhouse').'" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" ' . esc_attr($aria_req) . ' /></div></div>',
		'url' => '<input id="website" name="url"  placeholder="'.esc_html__('Website', 'myhouse').'" type="text" value="' . esc_url( $commenter['comment_author_url'] ) . '"  />'
	)),
	'comment_field' => '<textarea   rows="5" id="comment" placeholder="'.esc_html__('Write your comment here *', 'myhouse').'"  name="comment"'. esc_attr($aria_req) .'></textarea>',
	'label_submit' => 'POST COMMENT',
	'comment_notes_after' => '',
);
?>
<div class="comment-form-theme">
	<h4><?php esc_html_e('Leave a comment:', 'myhouse'); ?></h4>
	<div class="comment-respond">
		<?php global $post; ?>
		<?php if('open' == $post->comment_status){ ?>
			<?php comment_form($comment_args); ?>
		<?php } ?>
	</div><!--end comment-respond -->
</div><!--end comment-form-theme -->

