<?php get_header(); ?>
<!-- ================================ -->
<!-- ========== START BLOG ========== -->
<!-- ================================ -->
<!-- ================================ -->
<!-- ================================ -->
<section class="sectionPadding" id="blog">
	<div class="blogContent">
		<div class="container">
			<div class="row">
 
				<div class="col-sm-8">
					<?php 
					if(have_posts()) :
						while(have_posts()) : the_post(); 
						?>
						<?php get_template_part( 'content', ( post_type_supports( get_post_type(), 'post-formats' ) ? get_post_format() : get_post_type() ) ); ?>

						<?php endwhile; ?>
					
					<?php else: ?>
					<div class="not-found">
						<h1><?php esc_html_e('Nothing Found Here!','myhouse'); ?></h1>	
					</div>
					<?php endif; ?>
					
					<!-- Article Pagination -->
					<div class="article-pagination">
						<?php myhouse_pagination($prev = '<i class="fa fa-angle-left"></i>', $next = '<i class="fa fa-angle-right"></i>', $pages=''); ?>
					</div>
				</div><!-- end col-sm-8 -->
				<?php get_sidebar(); ?>
			</div><!-- end row -->
		</div><!-- end container -->
	</div><!-- end bloContent -->
</section>
<!-- ========== END BLOG ========== -->
<!-- ================================ -->
<!-- ================================ -->




<?php get_footer(); ?>