<?php

// Creating the widget 
class recent_post_widget extends WP_Widget {

function __construct() {

parent::__construct(
// Base ID of your widget
'recent_post_widget', 

// Widget name will appear in UI
esc_html__('NK Recent Posts', 'myhouse'), 

// Widget description
array( 'description' => esc_html__('Listing Recent Posts', 'myhouse' ), ) 
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
?>

<div class="recent-news clearfix">
	<?php 
			
			$arr = array('post_type' => 'post', 'posts_per_page' => $instance['count']);
			$query = new WP_Query($arr);
			while($query->have_posts()) : $query->the_post();
		?>

	<a href="<?php the_permalink(); ?>" class="post">
	<?php if(has_post_thumbnail()){ ?>
		<?php
		
				$img = vibermusic_thumbnail_url('');
			
		?>
	
		<img src="<?php echo esc_url(bfi_thumb($img, array('width'=>60, 'height'=> 60))); ?>" alt="<?php esc_html(the_title()); ?>" class="img-responsive">
		<?php } ?>
		<h5><?php esc_html(the_title()); ?></h5>
		<p><?php esc_attr(the_time('d F, Y')); ?></p>
	</a>
<?php endwhile; ?>
		<?php wp_reset_postdata(); ?>
	
</div>


<?php

echo $args['after_widget'];
}
		
// Widget Backend 
public function form( $instance ) {

if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = esc_html__('Recent Posts', 'myhouse' );
//$count = 4;
}
if ( isset( $instance[ 'count' ] ) ) {
$count = $instance[ 'count' ];
}
else {
$count = 5;
//$count = 4;
}

// Widget admin form
?>
<p>
<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'myhouse'); ?></label> 
<input class="widefat" id="<?php echo esc_html($this->get_field_id( 'title' )); ?>" name="<?php echo esc_html($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_html( $title ); ?>" />
</p>
<p>
<label for="<?php echo esc_attr($this->get_field_id( 'count' )); ?>"><?php esc_html_e( 'Number of posts:', 'myhouse'); ?></label> 
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
function myhouse_load_widget5() {
	register_widget( 'recent_post_widget' );
}
add_action( 'widgets_init', 'myhouse_load_widget5' );
?>