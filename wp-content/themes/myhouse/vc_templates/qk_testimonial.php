<?php
extract(shortcode_atts(array(
    'order' => ''
), $atts));
$order = intval( $order );
$order = $order <= 0 ? -1 : $order;
$args = array('post_type'=>'testimonial','posts_per_page' => $order);
$testimonial = new WP_Query($args);
if( $testimonial->have_posts() ):
	$i = 0;
	$total = $testimonial->found_posts;
?>
<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
 	<ol class="carousel-indicators">
	    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
	    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
	    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
  	</ol>
	  <!-- Wrapper for slides -->
	<div class="carousel-inner" role="listbox">
	<?php while( $testimonial->have_posts()) : $testimonial->the_post();
		$name = get_post_meta( get_the_ID(), '_cmb_name', true );
	?>
	    <div class="item <?php if( $i == 0 ){echo esc_html_e('active','myhouse');}?>">
	      <div class="carousel-caption">
	      	<div class="sectionTitle">
				<h2><?php esc_attr(the_title());?></h2>
				<div class="underline">
					<span class="line" ></span>
				</div><!--end underline -->
			</div><!--end sectionTitle -->

			<div class="testimonialPane">
				<p><?php the_excerpt();?></p>
			</div><!-- end testimonialPane -->
			<div class="author">
				<img src="<?php echo esc_url( get_post_meta( get_the_ID(), '_cmb_avatar', true ) );?>" alt="avatar <?php echo esc_attr($name);?>">
				<p><?php echo esc_html($name);?></p>
				<h5><?php echo get_post_meta( get_the_ID(), '_cmb_job', true );?></h5>
			</div>
	      </div>
	    </div>
	<?php $i++; endwhile; wp_reset_postdata();?>
    </div>
</div>
<?php endif;?>