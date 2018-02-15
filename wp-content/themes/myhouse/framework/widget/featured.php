<?php

// Creating the widget 
class featured_post_widget extends WP_Widget {

function __construct() {

parent::__construct(
// Base ID of your widget
'featured_post_widget', 

// Widget name will appear in UI
esc_html__('NK Featured Posts', 'myhouse'), 

// Widget description
array( 'description' => esc_html__('Listing Featured Posts', 'myhouse' ), ) 
);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );
// before and after widget arguments are defined by themes
echo $args['before_widget'];
if ( ! empty( $title ) ):
?>
	<div class="heading">
		<i class="fa fa-comments"></i>
		<h5><?php echo esc_html($title);?></h5>
	</div>
<?php
endif;

// This is where you run the code and display the output
?>

<!-- POPULAR POSTS WIDGET -->
<div class="featured-posts">
<ul>
	<?php 
		$arr = array('post_type' => 'post', 'posts_per_page' => $instance['count'], 'orderby' => 'comment_count');
		$query = new WP_Query($arr);
		while($query->have_posts()) : $query->the_post();
	?>
	<li>
		<?php
			if(has_post_thumbnail()){
				the_post_thumbnail( array(50,50, 'bfi_thumb'=>true ) );
		?>
		<?php
			}else{
		?>
		<img alt="<?php esc_html(the_title()); ?>" src="<?php echo esc_url('http://placehold.it/40x50')?>" />
		<?php } ?>
		<span class="title"><a href="<?php esc_url(the_permalink()); ?>"><?php esc_attr(the_title());?></a></span>
		<span class="date"><?php esc_attr(the_time('F d, Y')); ?></span>
	</li>
	
<?php endwhile; ?>
<?php wp_reset_postdata(); ?>
</ul>
</div><!-- //POPULAR POSTS WIDGET -->

<?php

echo $args['after_widget'];
}
		
// Widget Backend 
public function form( $instance ) {

if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = esc_html__('FEATURED POSTS', 'myhouse' );
}
if ( isset( $instance[ 'count' ] ) ) {
$count = $instance[ 'count' ];
}
else {
$count = 5;
}

// Widget admin form
?>
<p>
<label for="<?php echo esc_html($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'myhouse'); ?></label> 
<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_html($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_html( $title ); ?>" />
</p>
<p>
<label for="<?php echo esc_html($this->get_field_id( 'count' )); ?>"><?php esc_html_e( 'Number of posts:', 'myhouse'); ?></label> 
<input class="widefat" id="<?php echo esc_html($this->get_field_id( 'count' )); ?>" name="<?php echo esc_html($this->get_field_name( 'count' )); ?>" type="text" value="<?php echo esc_html( $count ); ?>" />
</p>
<?php 
}
	
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
$instance['count'] = ( ! empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';
return $instance;
}
} // Class wpb_widget ends here

// Register and load the widget
function myhouse_load_widget2() {
	register_widget( 'featured_post_widget' );
}
add_action( 'widgets_init', 'myhouse_load_widget2' );
?>